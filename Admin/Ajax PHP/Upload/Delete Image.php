<?php
    include $_SERVER['DOCUMENT_ROOT'] . "/Admin/Upload default include.php";
	unlink($_SERVER['DOCUMENT_ROOT'] . $UploadFolder . $_POST["FolderName"] . "/" . $_POST["NomImage"]);
	unlink($_SERVER['DOCUMENT_ROOT'] . $UploadFolder . $_POST["FolderName"] . "/mini/" . $_POST["NomImage"]);
?>
