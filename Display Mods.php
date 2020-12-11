<html>
	<head>
	 	<title>
	 		Mods
	 	</title>
	</head>
	<body>
		<?php
			include $_SERVER['DOCUMENT_ROOT'] . "/Header.php";
		?>
        <section>
            <div class="VerticalMenu">
                <?php
                    include $_SERVER['DOCUMENT_ROOT'] . "/Vertical Menu.php";
                ?>
            </div>
            <div class="contenu">
                <table class="dimensionTable" id="Mods pages">
                    <tr>
                        <?php
                            $Count = 0;
                            foreach ($ArrayImageEnseignant = glob($_SERVER['DOCUMENT_ROOT'] . "/Public/Mods/*") as $FilePath)
                            {
                                $RelativeFilePath = str_replace($_SERVER['DOCUMENT_ROOT'] . "/Public", "", $FilePath);
                                $Name = basename($FilePath);
                                echo
                                "<td width=\"25%\">
                                    <div>$Name</div>
                                    <a href='Display Pages.php?ModsFilter=$Name'>";
                                
                                $ArrayImage = glob($_SERVER['DOCUMENT_ROOT'] . "/Public/Images/$Name.*");
                                if (count($ArrayImage) == 1)
                                {
                                    $ImageName = basename($ArrayImage[0]);
                                    $Filename = $JavascriptWebsiteRoot . "/Public/Images/$ImageName";
                                    echo "<img src='$Filename' alt='Photo profile' align='middle'>";
                                }
                                else
                                    echo "<img src='$JavascriptWebsiteRoot/Public/Images/photoProfileDefault.png' alt='Photo profile' align='middle'>";
                                
                                echo "</a></td>";
                                $Count++;
                                
                                if ($Count == 4)
                                {
                                    echo "</tr><tr>";
                                    $Count = 0;
                                }
                            }
                        ?>
                    </tr>
                </table>
                </div>
            </section>
		<?php 
			include $_SERVER['DOCUMENT_ROOT'] . "/Footer.php";
		?>
	</body>
</html>
