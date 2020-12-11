<?php
    include $_SERVER['DOCUMENT_ROOT'] . "/Default Include Without Session.php";
    include $_SERVER['DOCUMENT_ROOT'] . "/Admin/Ajax PHP/Home Menu/Helper.php";
    sec_session_start(false);
    
if (LoginCheck("Admin"))
{
    echo
    "<script type='text/javascript' src='$JavascriptWebsiteRoot/Admin/Javascript/Home Menu.js'></script>";
    ?>
    <table id="TableHomeMenu" class="TableAdminContent" style="width:100%">
        <tr>
            <th>
                Position
            </th>
            <th>
                Text
            </th>
            <th>
                File Path
            </th>
            <th>
                Colspan
            </th>
            <th>
                Rowspan
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
            $sql = "SELECT * FROM HomeMenu ORDER BY Position;";
            
            foreach ($Db->Query($sql) as $row)
            {
                echo RenderHomeMenu($row[0], $row[1], $row[2], $row[3], $row[4]);
            }
        ?>
	</table>
    <br/>
    <form name="registration_form" method="post" enctype="multipart/form-data">
        Position: <input type='text' name='Position' id='Position' />
        Text: <input type='text' name='Text' id='Text' />
        File Path: <input type='text' name='FilePath' id='FilePath' />
        Colspan: <input type='text' name='Colspan' id='Colspan' />
        Rowspan: <input type='text' name='Rowspan' id='Rowspan' />
        
        <input type="button" 
               value="Create new entry"
               onclick="return CreateHomeMenuEntry(this.form);" /> 
    </form>
<?php
    echo
    "<script type='text/javascript' src='$JavascriptWebsiteRoot/Admin/Javascript/Init Home Menu.js'></script>";
}
else
{
    ShowConnectionAccessRightsError();
}
?>