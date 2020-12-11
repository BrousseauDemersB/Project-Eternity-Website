<?php
    include $_SERVER['DOCUMENT_ROOT'] . "/Default Include Without Session.php";
    include $_SERVER['DOCUMENT_ROOT'] . "/Display Page Helper.php";

	if (isset($_POST['FilterChoice'])
	{
		echo implode(";", GetPagesInfo(GetFilterFromChoice($_POST['FilterChoice'])));
	}
?>
