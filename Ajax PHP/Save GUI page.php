<?php
if (isset($_POST['Content']))
{
    $FullPath = $_SERVER['DOCUMENT_ROOT'] . "/Public/Mods/". $_POST['PagePath'];
    $DirPath = dirname($FullPath);
    
    if (!is_dir($DirPath))
    {
        mkdir($DirPath, 0777, true); // true for recursive create
    }
	if ($fp = fopen($FullPath, "w"))
	{
		fputs($fp, $_POST['Content']);
		fclose($fp);
	}
    exit;
}
?>