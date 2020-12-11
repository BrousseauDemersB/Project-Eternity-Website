<?php
    include $_SERVER['DOCUMENT_ROOT'] . "/Default Connection Include.php";
    sec_session_start(false);
    
    if (LoginCheck("Admin") && isset($_POST['RightID'], $_POST['Username'], $_POST['UserID']))
    {
        $Db = new DatabaseHandler();
        
        // Sanitize and validate the data passed in
        $RightID = filter_input(INPUT_POST, 'RightID', FILTER_SANITIZE_STRING);
        $Username = filter_input(INPUT_POST, 'Username', FILTER_SANITIZE_STRING);
        $UserID = filter_input(INPUT_POST, 'UserID', FILTER_SANITIZE_STRING);
        
        // Insert the new user into the database 
        if ($insert_stmt = $Db->Prepare("UPDATE Users SET RightID = ?, Username = ? WHERE UserID = ?"))
        {
            if (!$insert_stmt->execute(array($RightID, $Username, $UserID)))
            {
                print_r($insert_stmt->errorInfo());
            }
            else
            {
                echo $Db->LastInsertId();
            }
        }
    }
    else
    {
        echo "Invalid parameters";
    }
?>