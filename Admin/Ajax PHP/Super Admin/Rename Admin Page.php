<?php
$OldDir = $_SERVER['DOCUMENT_ROOT'] . "/Admin/Admin pages/" . $_POST["NomPageAdminOld"];
$NewDir = $_SERVER['DOCUMENT_ROOT'] . "/Admin/Admin pages/" . $_POST["NomPageAdminNew"];
rename($OldDir, $NewDir);
?>
