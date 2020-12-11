<?php
    include $_SERVER['DOCUMENT_ROOT'] . "/Default Connection Include.php";
    sec_session_start(false);
 
    if (LoginCheck("Admin") && isset($_POST['OriginalIndexMenu'], $_POST['OriginalIndexParent']))
    {
        $OriginalIndexMenu = $_POST["OriginalIndexMenu"];
        $OriginalIndexParent = $_POST["OriginalIndexParent"];

        $Db = new DatabaseHandler();
        $Db->Delete("VerticalMenu", "IndexMenu='$OriginalIndexMenu' AND IndexParent='$OriginalIndexParent'");
        echo "1";
    }
    else
    {
        echo "Invalid parameters";
    }
?>