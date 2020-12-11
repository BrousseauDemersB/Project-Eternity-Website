<?php
    include $_SERVER['DOCUMENT_ROOT'] . "/Admin/Upload default include.php";
	$OldDir = $_SERVER['DOCUMENT_ROOT'] . $UploadFolder . $_POST["NomDossierAncien"];
	$NewDir = $_SERVER['DOCUMENT_ROOT'] . $UploadFolder . $_POST["NomDossierNouveau"];
	rename($OldDir, $NewDir);
?>
