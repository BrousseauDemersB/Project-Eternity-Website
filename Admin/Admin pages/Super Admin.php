<?php
    include $_SERVER['DOCUMENT_ROOT'] . "/Default Include Without Session.php";
    sec_session_start(false);

if (LoginCheck("Admin"))
{
    echo "
	<script type='text/javascript' src='$JavascriptWebsiteRoot/Admin/Javascript/Super Admin.js'></script>";
?>
	<div>
		<select style="display: block;width:200px;" id="AdminPageChoice" size="5" onchange="ChooseAdminPage()">
			<?php 
				$FinalPageAdminFolder = $_SERVER['DOCUMENT_ROOT'] . "/Admin/Admin pages";
				foreach (new DirectoryIterator($FinalPageAdminFolder) as $fileInfo)
				{
					if ($fileInfo->isDot())
						continue;

					$FileName = $fileInfo->getBasename();
					echo "<option value='$FileName'>$FileName</option>";
				}
			?>
		</select>
		<input type='button' value='Create new page' onclick="CreateNewAdminPage()">
		<input type='button' value='Rename page' onclick="RenameAdminPage()">
		<input type='button' value='Delete selected page' onclick="DeleteAdminPage()">
	</div>
	<textarea id="AdminPageEditor" style="display: block;width:100%;height:700px;" >
	</textarea>
	<input type='button' value='Save' onclick="SaveAdminPage()">

<?php
    echo "
        <script type='text/javascript' src='$JavascriptWebsiteRoot/Admin/Javascript/Init Super Admin.js'></script>";
}
else
{
    ShowConnectionAccessRightsError();
}
?>