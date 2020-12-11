<?php
$dir = $_SERVER['DOCUMENT_ROOT'] . "/Admin/Admin pages/" . $_POST["AdminPageName"];
unlink($dir);
?>
