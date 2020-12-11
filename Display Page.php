<html>
	<head>
	 	<title>
		<?php
            if (isset($_GET["PagePath"]))
                echo basename($_GET["PagePath"], ".html");
            else
                echo "Page not found";
		?>
	 	</title>
	</head>
	<body>
		<?php
			include $_SERVER['DOCUMENT_ROOT'] . "/Header.php";
            $AllowModification = false;
            
            if (LoginCheck("Admin"))
            {
                echo "<script src='$JavascriptWebsiteRoot/Javascript/Save GUI Page.js'></script>";
                echo "<script src='$JavascriptWebsiteRoot/ckeditor/ckeditor.js'></script>";
                $AllowModification = true;
            }
		?>
        <section>
            <div class="VerticalMenu">
                <?php
                    include $_SERVER['DOCUMENT_ROOT'] . "/Vertical Menu.php";
                ?>
            </div>
            <div class="contenu">
<?php
				if ($AllowModification)
					echo '<div id="editor1" contenteditable="true">';
				else
					echo '<div id="editor1">';
					
				if (isset($_GET["PagePath"]))
				{
					$FilePath = $_SERVER['DOCUMENT_ROOT'] . "/Public/Mods/" . $_GET["PagePath"];
					if (!file_exists($FilePath))
					{
						echo "Page not found";
					}
					else
						include $FilePath;
				}
                echo '</div>';
?>
<?php
            if ($AllowModification)
                echo '<input type="button" value="Sauvegarde" onclick="SaveModification();" />';
?>
            </div>
        </section>
<?php
        if ($AllowModification && isset($_GET["PagePath"]))
        {
            echo "<script>var PagePath = '" . $_GET["PagePath"] . "';</script>";
        }
        
        include $_SERVER['DOCUMENT_ROOT'] . "/Footer.php";
?>
        <script>document.getElementById('editor1').style.position = 'static';</script>
	</body>
</html>