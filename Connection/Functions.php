<?php 
function sec_session_start(bool $Regenarate)
{
    $session_name = 'sec_session_UserID';   // Set a custom session name
    $secure = SECURE;
    // This stops JavaScript being able to access the session UserID.
    $httponly = true;
    // Forces sessions to only use cookies.
    if (!ini_set('session.use_only_cookies', 1))
	{
        header("Location: error.php?err=Could not initiate a safe session (ini_set)");
        exit();
    }
    // Gets current cookies params.
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params($cookieParams["lifetime"],
        $cookieParams["path"], 
        $cookieParams["domain"], 
        $secure,
        $httponly);

    try
    {
        // Sets the session name to the one set above.
        session_name($session_name);
        session_start();            // Start the PHP session
        if ($Regenarate)
        {
            session_regenerate_ID(true);    // regenerated the session, delete the old one.
        }
    }
    catch (Exception $e)
    {
        // Unset all of the session variables.
        $_SESSION = array();
        // If it's desired to kill the session, also delete the session cookie.
        // Note: This will destroy the session, and not just the session data!
        if (ini_get("session.use_cookies"))
        {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
            );
        }

        // Finally, destroy the session.
        session_destroy();
    }
}
function Login(string $Username, string $Password)
{
    $Db = new DatabaseHandler();
    if ($stmt = $Db->Prepare("SELECT UserID, Password, Salt 
        FROM Users
		WHERE Username = ?
        LIMIT 1"))
	{
        $stmt->execute(array($Username));
        $Result = $stmt->fetchALL(PDO::FETCH_OBJ);
 
        if (count($Result) == 1)
		{
            $row = $Result[0];
            $UserID = $row->UserID;
            $SaltedPassword = $row->Password;
            $Salt = $row->Salt;
            
            // hash the password with the unique salt.
            $Password = hash('sha512', $Password . $Salt);
            // If the user exists we check if the account is locked
            // from too many login attempts 
            if (checkbrute($UserID, $Db))
			{
                // Account is locked 
                // Send an email to user saying their account is locked
                return "Account is locked";
            }
			else
			{
                // Check if the password in the database matches
                // the password the user submitted.
                if ($SaltedPassword == $Password)
				{      
					if ($stmt = $Db->prepare("SELECT R.RightName FROM `Users` U JOIN `Rights` R ON U.RightID = R.RightID WHERE U.UserID = ?"))
					{
                        $stmt->execute(array($UserID));
                        $Result = $stmt->fetchALL(PDO::FETCH_OBJ);
					
                        if (count($Result) == 1)
                        {
                            $row = $Result[0];
                            // Get the user-agent string of the user.
                            $UserBrowser = $_SERVER['HTTP_USER_AGENT'];
                            // XSS protection as we might print this value
                            $UserID = preg_replace("/[^0-9]+/", "", $UserID);
                            $_SESSION['UserID'] = $UserID;
                            // XSS protection as we might print this value
                            $Username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $Username);
                            $_SESSION['Username'] = $Username;
                            $_SESSION['AccessRights'] = $row->RightName;
                            $_SESSION['LoginString'] = hash('sha512', $Password . $UserBrowser);
                            
                            // Login successful.
                            return "Success";
                        }
					}
                    return "Wrong User configuration";
				}
				else
				{
                    // Password is not correct
                    // We record this attempt in the database
                    $now = time();
                    $Db->query("INSERT INTO FailedConnectionLogs(UserID, ConnectionDate)
                                    VALUES ('$UserID', '$now')");
                                    
                    return "Wrong Password";
                }
            }
        }
    }
    // No user exists.
    return "Unknown User";
}

function checkbrute(string $UserID, DatabaseHandler $Db)
{
    // Get timestamp of current time 
    $now = time();
 
    // All login attempts are counted from the past 2 hours. 
    $valUserID_attempts = $now - (2 * 60 * 60);
 
    if ($stmt = $Db->prepare("SELECT ConnectionDate 
									FROM FailedConnectionLogs 
									WHERE UserID = ? 
									AND ConnectionDate > '$valUserID_attempts'"))
    {
        $stmt->execute(array($UserID));
        $Result = $stmt->fetchALL(PDO::FETCH_OBJ);
 
        // If there have been more than 5 failed logins 
        if (count($Result) > 5)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}

function LoginCheck(string $RequiredRights = null)
{
    $Db = new DatabaseHandler();

    // No User yet, pretend to be admin.
    if (count($Db->Query("SELECT UserID, Password, Salt FROM Users LIMIT 1")) == 0)
    {
        $_SESSION['Username'] = 'No User yet';
        $_SESSION['AccessRights'] = 'Admin';
        return true;
    }
    
    $IsLoginValid = false;
    
    // Check if all session variables are set 
    if (isset($_SESSION['UserID'], $_SESSION['Username'], $_SESSION['LoginString']))
	{
        $UserID = $_SESSION['UserID'];
        $LoginString = $_SESSION['LoginString'];
        $Username = $_SESSION['Username'];

        // Get the user-agent string of the user.
        $UserBrowser = $_SERVER['HTTP_USER_AGENT'];
        
        if ($stmt = $Db->prepare("SELECT Password FROM Users WHERE UserID = ? LIMIT 1"))
		{ 
            $stmt->execute(array($UserID));
            $Result = $stmt->fetchALL(PDO::FETCH_OBJ);
 
            if (count($Result) == 1)
            {
                $row = $Result[0];
                $Password = $row->Password;
                $LoginCheck = hash('sha512', $Password . $UserBrowser);
 
                if ($LoginCheck == $LoginString)
				{// Logged In!!!! 
                    $IsLoginValid = true;
                }
				else
				{// Not logged in 
                }
            }
			else
			{// Not logged in 
            }
        }
		else
		{// Not logged in 
        }
    }
    
    if ($IsLoginValid)
    {
        if(!is_null($RequiredRights))
        {
            return isset($_SESSION['AccessRights']) && $_SESSION['AccessRights'] == $RequiredRights;
        }
        else
        {
            return true;
        }
    }
    
    return false;
}

function ShowConnectionAccessRightsError(string $JavascriptWebsiteRoot)
{
    echo
	"<p>
		<span class='error'>You don't have the rights to access this page.</span> You must <a href='$JavascriptWebsiteRoot/Connection/Sign In.php'>connect</a>.
	</p>";
}

function esc_url($url)
{
    if ('' == $url)
	{
        return $url;
    }
 
    $url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);
 
    $strip = array('%0d', '%0a', '%0D', '%0A');
    $url = (string) $url;
 
    $count = 1;
    while ($count)
	{
        $url = str_replace($strip, '', $url, $count);
    }
 
    $url = str_replace(';//', '://', $url);
 
    $url = htmlentities($url);
 
    $url = str_replace('&amp;', '&#038;', $url);
    $url = str_replace("'", '&#039;', $url);
 
    if ($url[0] !== '/')
	{
        // We're only interested in relative links from $_SERVER['PHP_SELF']
        return '';
    }
    else
    {
        return $url;
    }
}
