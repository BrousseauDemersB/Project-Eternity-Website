<?php
    include $_SERVER['DOCUMENT_ROOT'] . "/Default Connection Include.php";
    sec_session_start(false);

    if (LoginCheck("Admin"))
    {
        $tmpFilePath = $_FILES["SelectedFile"]['tmp_name'][0];
        $OutputFolder = $_SERVER['DOCUMENT_ROOT'] . "Public";

        //Delete the content of the Public folder before extracting to it.
        $it = new RecursiveDirectoryIterator($OutputFolder, RecursiveDirectoryIterator::SKIP_DOTS);
        $files = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::CHILD_FIRST);
        foreach($files as $file)
        {
            if ($file->isDir())
            {
                rmdir($file->getRealPath());
            }
            else
            {
                unlink($file->getRealPath());
            }
        }

        // Initialize archive object
        $zip = new ZipArchive();
        $zip->open($tmpFilePath);
        
        $zip->extractTo($OutputFolder);
        
        // Zip archive will be created only after closing object
        $zip->close();
    }
    else
    {
        ShowConnectionAccessRightsError($JavascriptWebsiteRoot);
    }
?>
