<?php
    include $_SERVER['DOCUMENT_ROOT'] . "/Admin/Upload default include.php";
	$dir = $_SERVER['DOCUMENT_ROOT'] . $UploadFolder . $_POST["FolderName"];
	$it = new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS);
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
	rmdir($dir);
?>
