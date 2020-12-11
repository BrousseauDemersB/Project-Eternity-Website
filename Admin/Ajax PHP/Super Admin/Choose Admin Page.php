<?php
	$FinalFolder = $_SERVER['DOCUMENT_ROOT'] . "/Admin/Admin pages/" . $_POST["AdminPageName"];
	echo file_get_contents($FinalFolder);
?>
