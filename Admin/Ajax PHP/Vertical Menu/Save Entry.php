<?php
    include $_SERVER['DOCUMENT_ROOT'] . "/Default Connection Include.php";
    sec_session_start(false);
    
    if (LoginCheck("Admin") && isset($_POST['OriginalIndexMenu'], $_POST['OriginalIndexParent'], $_POST['IndexParent'], $_POST['Name'], $_POST['Link'], $_POST['Color'], $_POST['OpenNewPage']))
    {
        $Db = new DatabaseHandler();
        
        $OriginalIndexMenu = (int)$_POST['OriginalIndexMenu'];
        $OriginalIndexParent = (int)$_POST['OriginalIndexParent'];
        $IndexMenu = (int)$_POST['IndexMenu'];
        $IndexParent = (int)$_POST['IndexParent'];
        $Name = filter_input(INPUT_POST, 'Name', FILTER_SANITIZE_STRING);
        $Link = filter_input(INPUT_POST, 'Link', FILTER_SANITIZE_STRING);
        $Color = filter_input(INPUT_POST, 'Color', FILTER_SANITIZE_STRING);
        $OpenNewPage = ($_POST['OpenNewPage'] === 'true');
        
        // Insert the new user into the database 
        if ($insert_stmt = $Db->Prepare("UPDATE VerticalMenu
                                        SET IndexMenu = ?, IndexParent = ?, Name = ?, Link = ?, Color = ?, OpenNewPage = ?
                                        WHERE IndexMenu = ? AND IndexParent = ?"))
        {
            if (!$insert_stmt->execute(array($IndexMenu, $IndexParent, $Name, $Link, $Color, $OpenNewPage, $OriginalIndexMenu, $OriginalIndexParent)))
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