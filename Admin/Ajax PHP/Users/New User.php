<?php
    include $_SERVER['DOCUMENT_ROOT'] . "/Default Connection Include.php";
    include $_SERVER['DOCUMENT_ROOT'] . "/Admin/Ajax PHP/Users/Helper.php";
    sec_session_start(false);
    
    $error_msg = "";
    
    if (LoginCheck("Admin") && isset($_POST['Username'], $_POST['p']))
    {
        $Db = new DatabaseHandler();
        // Sanitize and validate the data passed in
        $Username = filter_input(INPUT_POST, 'Username', FILTER_SANITIZE_STRING);
    
        $Password = filter_input(INPUT_POST, 'p', FILTER_SANITIZE_STRING);
        if (strlen($Password) != 128)
        {
            // The hashed pwd should be 128 characters long.
            // If it's not, something really odd has happened
            $error_msg .= '<p class="error">Invalid password configuration.</p>';
        }
    
        // Username validity and password validity have been checked client side.
        // This should should be adequate as nobody gains any advantage from
        // breaking these rules.
        //
    
        // check existing Username
        $prep_stmt = "SELECT UserID FROM Users WHERE Username = ? LIMIT 1";
        $stmt = $Db->Prepare($prep_stmt);
    
        if ($stmt)
        {
            $stmt->execute(array($Username));
            $Result = $stmt->fetchALL(PDO::FETCH_OBJ);
            
            if (count($Result) == 1)
            {
                $error_msg .= '<p class="error">A user with this username already exists.</p>';
            }
        }
        else
        {
            $error_msg .= '<p class="error">Prepare failed</p>';
        }
    
        if (empty($error_msg))
        {
            // Create a random salt
            $RandomSalt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
    
            // Create salted password 
            $Password = hash('sha512', $Password . $RandomSalt);
    
            // Insert the new user into the database 
            if ($InsertStatement = $Db->Prepare("INSERT INTO Users (RightID, Username, Password, Salt) VALUES (1, ?, ?, ?)"))
            {
                if (!$InsertStatement->execute(array($Username, $Password, $RandomSalt)))
                {
                    print_r($InsertStatement->errorInfo());
                }
                else
                {
                    $LastID = $Db->LastInsertId();
                    $Data = GetRightChoices($Db);
                    $sql = "SELECT R.RightName, U.Username, U.UserID FROM Users U JOIN Rights R ON U.RightID = R.RightID WHERE U.UserID = $LastID";

                    foreach ($Db->Query($sql) as $row)
                    {
                        echo RenderUser($row[0], $row[1], $row[2], $Data);
                    }
                }
            }
        }
        else
        {
            return $error_msg;
        }
    }
    else
    {
        echo "Invalid parameters";
    }
?>