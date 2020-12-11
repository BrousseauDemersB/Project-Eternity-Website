<?php
	include $_SERVER['DOCUMENT_ROOT'] . "/Default Include Without Session.php";
    include $_SERVER['DOCUMENT_ROOT'] . "/Admin/Ajax PHP/Vertical Menu/Helper.php";
	sec_session_start(false);

if (LoginCheck("Admin"))
{
    echo
    "<script type='text/javascript' src='$JavascriptWebsiteRoot/Admin/Javascript/Vertical Menu.js'></script>";
?>
    <table id="TableVerticalMenu" class="TableAdminContent" style="width:100%">
        <tr>
            <th>
                IndexMenu
            </th>
            <th>
                IndexParent
            </th>
            <th>
                Name
            </th>
            <th>
                Link
            </th>
            <th>
                Color
            </th>
            <th>
                OpenNewPage
            </th>
            <th>
                Save changes
            </th>
            <th>
                Delete
            </th>
        </tr>
		<?php
			$Db = new DatabaseHandler();
			$sql = "SELECT * FROM VerticalMenu ORDER BY IndexMenu;";
		
			foreach ($Db->Query($sql) as $row)
			{
            	echo RenderVerticalMenu($row[0], $row[1], $row[2], $row[3], $row[4], $row[5]);
			}
		?>
    </table>
    <br/>
    <form name="registration_form" method="post" enctype="multipart/form-data">
        Index Menu: <input type='text' name='IndexMenu' id='IndexMenu' />
        Index Parent: <input type='text' name='IndexParent' id='IndexParent' />
        Name: <input type='text' name='Name' id='Name' />
        Link: <input type='text' name='Link' id='Link' />
        Color: <input type='text' name='Color' id='Color' />
		Open New Page: <input type='checkbox' name='OpenNewPage' id='OpenNewPage'><br/><br/>
        
        <input type="button"
               value="Create new entry"
               onclick="return CreateVerticalMenuEntry(this.form);" /> 
    </form>
<?php
    echo
    "<script type='text/javascript' src='$JavascriptWebsiteRoot/Admin/Javascript/Init Vertical Menu.js'></script>";
}
else
{
    ShowConnectionAccessRightsError();
}
?>