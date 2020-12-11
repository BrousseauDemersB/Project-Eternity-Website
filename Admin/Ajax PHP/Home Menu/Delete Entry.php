<?php
    include $_SERVER['DOCUMENT_ROOT'] . "/Default Connection Include.php";
    sec_session_start(false);
 
    if (LoginCheck("Admin") && isset($_POST['OriginalPosition']))
    {
        $OriginalPosition = $_POST["OriginalPosition"];

        $Db = new DatabaseHandler();
        $Db->Delete("HomeMenu", "Position='$OriginalPosition'");
        echo "1";
    }
    else
    {
        echo "Invalid parameters";
    }
?>