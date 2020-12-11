<?php
    include $_SERVER['DOCUMENT_ROOT'] . "/Default Connection Include.php";
    include $_SERVER['DOCUMENT_ROOT'] . "/Admin/Ajax PHP/Vertical Menu/Helper.php";
    sec_session_start(false);
 
    if (LoginCheck("Admin") && isset($_POST['IndexMenu'], $_POST['IndexParent'], $_POST['Name'], $_POST['Link'], $_POST['Color'], $_POST['OpenNewPage']))
    {
        
        $IndexMenu = (int)$_POST['IndexMenu'];
        $IndexParent = (int)$_POST['IndexParent'];
        $Name = filter_input(INPUT_POST, 'Name', FILTER_SANITIZE_STRING);
        $Link = filter_input(INPUT_POST, 'Link', FILTER_SANITIZE_STRING);
        $Color = filter_input(INPUT_POST, 'Color', FILTER_SANITIZE_STRING);
        $OpenNewPage = ($_POST['OpenNewPage'] === 'true');

        $Db = new DatabaseHandler();

        if ($InsertStatement = $Db->Prepare("INSERT INTO VerticalMenu (IndexMenu, IndexParent, Name, Link, Color, OpenNewPage)
                                                                VALUES (?, ?, ?, ?, ?, ?)"))
        {
            if (!$InsertStatement->execute(array($IndexMenu, $IndexParent, $Name, $Link, $Color, $OpenNewPage)))
            {
                print_r($InsertStatement->errorInfo());
            }
            else
            {
                echo RenderVerticalMenu($IndexMenu, $IndexParent, $Name, $Link, $Color, $OpenNewPage);
            }
        }
    }
    else
    {
        echo "Invalid parameters";
    }
?>