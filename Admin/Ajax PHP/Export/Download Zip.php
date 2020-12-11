<?php
    include $_SERVER['DOCUMENT_ROOT'] . "/Default Connection Include.php";
    sec_session_start(false);

    if (LoginCheck("Admin"))
    {
        $yourfile = $_SERVER['DOCUMENT_ROOT'] . "/ZIP/Export.zip";

        $file_name = basename($yourfile);

        header("Content-Type: application/zip");
        header("Content-Disposition: attachment; filename=$file_name");
        header("Content-Length: " . filesize($yourfile));

        readfile($yourfile);
        exit;
    }
?>