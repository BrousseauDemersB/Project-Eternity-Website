<?php
    include $_SERVER['DOCUMENT_ROOT'] . "/Default Connection Include.php";
    include $_SERVER['DOCUMENT_ROOT'] . "/Admin/Ajax PHP/Home Menu/Helper.php";
    sec_session_start(false);
 
    if (LoginCheck("Admin") && isset($_POST['Position'], $_POST['Text'], $_POST['FilePath'], $_POST['Colspan'], $_POST['Rowspan']))
    {
        $Position = (int)$_POST['Position'];
        $Text = filter_input(INPUT_POST, 'Text', FILTER_SANITIZE_STRING);
        $FilePath = filter_input(INPUT_POST, 'FilePath', FILTER_SANITIZE_STRING);
        $Colspan = (int)$_POST['Colspan'];
        $Rowspan = (int)$_POST['Rowspan'];

        $Db = new DatabaseHandler();

        if ($InsertStatement = $Db->Prepare("INSERT INTO `HomeMenu` (Position, Text, FilePath, Colspan, Rowspan)
                                                                VALUES (?, ?, ?, ?, ?)"))
        {
            if (!$InsertStatement->execute(array($Position, $Text, $FilePath, $Colspan, $Rowspan)))
            {
                print_r($InsertStatement->errorInfo());
            }
            else
            {
                echo RenderHomeMenu($Position, $Text, $FilePath, $Colspan, $Rowspan);
            }
        }
    }
    else
    {
        echo "Invalid parameters";
    }
?>