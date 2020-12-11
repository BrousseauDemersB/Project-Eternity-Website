<?php
	$FinalFolder = $_SERVER['DOCUMENT_ROOT'] . "/Admin/Admin pages/" . $_POST["AdminPageName"];
	file_put_contents($FinalFolder, html_entity_decode($_POST["AdminPageContent"]));
	include $FinalFolder;
?>
