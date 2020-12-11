<?php
    include $_SERVER['DOCUMENT_ROOT'] . "/Default Connection Include.php";
    sec_session_start(false);

    if (LoginCheck("Admin"))
    {
        // Get real path for our folder
        $rootPath = realpath($_SERVER['DOCUMENT_ROOT'] . "/Public/");

        $ZIPPath = $_SERVER['DOCUMENT_ROOT'] . "/ZIP/Export.zip";
        $DirPath = dirname($ZIPPath);
        if (!is_dir($DirPath))
        {
            mkdir($DirPath, 0777, true); // true for recursive create
        }
        // Initialize archive object
        $zip = new ZipArchive();
        $zip->open($ZIPPath, ZipArchive::CREATE | ZipArchive::OVERWRITE);

        // Create recursive directory iterator
        /** @var SplFileInfo[] $files */
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($rootPath),
            RecursiveIteratorIterator::LEAVES_ONLY
        );

        foreach ($files as $name => $file)
        {
            // Skip directories (they would be added automatically)
            if (!$file->isDir())
            {
                // Get real and relative path for current file
                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, strlen($rootPath) + 1);

                // Add current file to archive
                $zip->addFile($filePath, $relativePath);
            }
        }

        // Zip archive will be created only after closing object
        if (!$zip->close())
        {
			echo $zip->getStatusString();
        }
    }
?>
