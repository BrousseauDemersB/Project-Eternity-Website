<?php
    include $_SERVER['DOCUMENT_ROOT'] . "/Default Connection Include.php";
    sec_session_start(false);
    
    if (LoginCheck("Admin") && isset($_POST['UserID']))
    {
        $UserID = $_POST["UserID"];

        $Db = new DatabaseHandler();
        $Db->Delete("Users", "UserID='$UserID'");
        echo "1";
    }
    else
    {
        echo "Invalid parameters";
    }
?>