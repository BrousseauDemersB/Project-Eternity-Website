<?php
    include $_SERVER['DOCUMENT_ROOT'] . "/Default Include.php"; 
 
    if (LoginCheck())
    {
        $logged = 'in';
    }
    else
    {
        $logged = 'out';
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Sign In</title>
        <script type="text/JavaScript" src="Javascript/sha512.js"></script> 
        <script type="text/JavaScript" src="Javascript/forms.js"></script> 
    </head>
    <body>
        <?php
            if (isset($_GET['error']))
            {
                $Return = $_GET['Return'];
                
                echo "<p class='error'>$Return</p>";
            }
            echo "<form action='$JavascriptWebsiteRoot/Connection/Process Sign In.php' method='post' name='login_form'>";
        ?>                  
            Usager: <input type="text" name="Usager" />
            Mot de passe: <input type="password" 
                             name="MotDePasse" 
                             id="MotDePasse"/>
            <input type="button" 
                   value="Connexion" 
                   onclick="formhash(this.form, this.form.MotDePasse);" /> 
        </form>
 
<?php
        if (LoginCheck())
		{
			echo "<p>Connecté en tant que " . htmlentities($_SESSION['Username']) . "'.</p>";
            echo "<p>Voulez vous changer d'usager? <a href='$JavascriptWebsiteRoot/Connection/Sign Out.php'>Déconnexion</a>.</p>";
			echo "<p>Retournez à la page <a href='$JavascriptWebsiteRoot/Index.php'> d'accueil</a></p>";
			if ($_SESSION['AccessRights'] == 'Admin')
				echo "<a href='$JavascriptWebsiteRoot/Admin/Admin homepage.php'>Administrer</a>";
        }
		else
		{
			echo '<p>Disconnected.</p>';
        }
?>      
    </body>
</html>
