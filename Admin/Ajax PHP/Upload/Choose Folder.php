<?php
    include $_SERVER['DOCUMENT_ROOT'] . "/Admin/Upload default include.php";
	$AdminPagesFolder = $UploadFolder . $_POST["FolderName"];
	$FinalFolder = $_SERVER['DOCUMENT_ROOT'] . "$AdminPagesFolder";
	$ArrayAdminPage = array();
	foreach (new DirectoryIterator($FinalFolder) as $fileInfo)
	{
		if ($fileInfo->IsDir() || $fileInfo->isDot())
			continue;

		$FileName = $fileInfo->getBasename();
		echo "$FileName;";
	}
?>
