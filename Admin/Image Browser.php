<?php
    include $_SERVER['DOCUMENT_ROOT'] . "/Default Include Without Session.php";
    include $_SERVER['DOCUMENT_ROOT'] . "/Admin/Upload default include.php";
    sec_session_start(false);

if (LoginCheck("Admin"))
{
    echo "
	<link rel='stylesheet' type='text/css' href='$JavascriptWebsiteRoot/Admin/CSS/Upload.css'>
	<script type='text/javascript' src='$JavascriptWebsiteRoot/Admin/Javascript/Upload.js'></script>
	<script type='text/javascript' src='$JavascriptWebsiteRoot/Admin/Javascript/Get Progress Box.js'></script>
	<script type='text/javascript' src='$JavascriptWebsiteRoot/Admin/Javascript/Thumbnails Worker.js'></script>
	<script type='text/javascript'>
        var UploadFolder = '$UploadFolder';
    </script>";
?>
<style>
	.Miniature
	{
		width: 50px;
		height: 50px;
	}
	.Thumbnail
	{
		display: inline-block;
		padding: 1px 5px;
	}
</style>

    <div>
        <select style="display: block;width:200px;" id="FolderChoice" size="5" onchange="ChooseFolder()">
<?php
			if (isset($UsingCKEditor))
				echo '<script type="text/javascript">var UsingCKEditor = true;</script>';

			$FinalUploadFolder = $_SERVER['DOCUMENT_ROOT'] . $UploadFolder ;
			foreach (new DirectoryIterator($FinalUploadFolder) as $fileInfo)
			{
				if (!$fileInfo->IsDir() || $fileInfo->isDot())
					continue;

				$FileName = $fileInfo->getBasename();
				echo "<option value='$FileName'>$FileName</option>";
			}
?>
		</select>
		<input type='button' value='Create new folder' onclick='CreateNewFolder()'>
		<input type='button' value='Rename current folder' onclick='RenameFolder()'>
		<input type='button' value='Delete current folder' onclick='DeleteCurrentFolder()'>
	</div>

	<br />
	<div id='Images'>
		<form  method='post' enctype='multipart/form-data'>
			Choisir image:  <input type='file' id='InputFile' accept='image/*' multiple='multiple'>
							<input type='button' value='Send' onclick='UploadImage()'>
							<input type='hidden' name='MAX_FILE_SIZE' value='2097153'>

		</form>
		<br />
		<div id='Thumbnails' style='width:100%;'>
		</div>
	</div>
<?php
	echo "<script type='text/javascript' src='$JavascriptWebsiteRoot/Admin/Javascript/Init Upload.js'></script>";
?>
<?php
}
else
{
    ShowConnectionAccessRightsError($JavascriptWebsiteRoot);
}
?>
