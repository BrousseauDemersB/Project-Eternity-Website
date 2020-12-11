<?php
    include $_SERVER['DOCUMENT_ROOT'] . "/Admin/Upload default include.php";
	$dir = $_POST["FolderName"];
	mkdir( $_SERVER['DOCUMENT_ROOT'] . $UploadFolder . $dir);
	mkdir( $_SERVER['DOCUMENT_ROOT'] . $UploadFolder . $dir . "/Mini");
?>
