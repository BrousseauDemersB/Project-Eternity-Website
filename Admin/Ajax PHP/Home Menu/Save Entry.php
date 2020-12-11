<?php
    include $_SERVER['DOCUMENT_ROOT'] . "/Default Connection Include.php";
    sec_session_start(false);
    
    if (LoginCheck("Admin") && isset($_POST['OriginalPosition'], $_POST['Position'], $_POST['Text'], $_POST['FilePath'], $_POST['Colspan'], $_POST['Rowspan']))
    {
        $OriginalPosition = (int)$_POST['OriginalPosition'];
        $Position = (int)$_POST['Position'];
        $Text = filter_input(INPUT_POST, 'Text', FILTER_SANITIZE_STRING);
        $FilePath = filter_input(INPUT_POST, 'FilePath', FILTER_SANITIZE_STRING);
        $Colspan = (int)$_POST['Colspan'];
        $Rowspan = (int)$_POST['Rowspan'];
        
        $Db = new DatabaseHandler();
        
        if ($insert_stmt = $Db->Prepare("UPDATE HomeMenu
                                        SET Position = ?, Text = ?, FilePath = ?, Colspan = ?, Rowspan = ?
                                        WHERE Position = ?"))
        {
            if (!$insert_stmt->execute(array($Position, $Text, $FilePath, $Colspan, $Rowspan, $OriginalPosition)))
            {
                print_r($insert_stmt->errorInfo());
            }
            else
            {
                echo 1;
            }
        }
    }
    else
    {
        echo "Invalid parameters";
    }
?>