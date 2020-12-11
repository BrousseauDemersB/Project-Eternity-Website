<?php
    include $_SERVER['DOCUMENT_ROOT'] . "/Default Include Without Session.php";
    include $_SERVER['DOCUMENT_ROOT'] . "/Admin/Ajax PHP/Users/Helper.php";
    sec_session_start(false);

if (LoginCheck("Admin"))
{
    echo
    "<script type='text/javascript' src='$JavascriptWebsiteRoot/Admin/Javascript/Users.js'></script>
    <script type='text/javascript' src='$JavascriptWebsiteRoot/Connection/Javascript/sha512.js'></script>
	<link rel='stylesheet' type='text/css' href='$JavascriptWebsiteRoot/Admin/CSS/Users.css'>";
?>
    <table id="TableUsers" class="TableAdminContent" style="width:100%">
        <tr>
            <th>
                Rights
            </th>
            <th>
                Username
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
        
        $Data = GetRightChoices($Db);
        
        $sql = "SELECT R.RightName, U.Username, U.UserID FROM Users U JOIN Rights R ON U.RightID = R.RightID";

        foreach ($Db->Query($sql) as $row)
        {
            echo RenderUser($row[0], $row[1], $row[2], $Data);
        }
        ?>
    </table>
    <br/>
    <form name="registration_form" method="post" enctype="multipart/form-data">
        Username: <input type='text' name='Username' id='Username' />
        Password: <input type="password"name="Password" id="Password"/>
        Confirm password: <input type="password" name="ConfirmPassword" id="ConfirmPassword" />
        
        <input type="button" 
               value="Create new user" 
               onclick="return CreateNewUser(this.form,
                               this.form.Username,
                               this.form.Password,
                               this.form.ConfirmPassword);" /> 
    </form>
<?php
    echo
    "<script type='text/javascript' src='$JavascriptWebsiteRoot/Admin/Javascript/Init Users.js'></script>";
}
else
{
    ShowConnectionAccessRightsError();
}
?>