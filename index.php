<html>
	<head>
		 <title>Accueil</title>
		 <link rel="stylesheet" href="CSS/Index.css">
	</head>
	
	<body>
		<?php
            include $_SERVER['DOCUMENT_ROOT'] . "/Header.php";
        ?>
		
		<table class="indexTable">
		
		<?php
            $sql = "SELECT * FROM HomeMenu ORDER BY Position;";
            
            echo "<tr>";
            $TotalWidth = 0;
            
            foreach ($Db->Query($sql) as $row)
            {
                $Text = $row["Text"];
                $FilePath = $JavascriptWebsiteRoot . $row["FilePath"];
                $Colspan = $row["Colspan"];
                $Rowspan = $row["Rowspan"];
                $TotalWidth += (int)$Colspan;
                
                echo
                "<td colspan='$Colspan' rowspan='$Rowspan' >
                    <a href='$FilePath'>
                        <img id='enseign' src='Images/$Text.png' alt='$Text'>
                    </a>
                </td>";
                if ($TotalWidth == 5)
                {
                    echo "</tr><tr>";
                    $TotalWidth = 0;
                }
            }
            
            echo "</tr>";
		?>
		</table>
		
		<?php
			include $_SERVER['DOCUMENT_ROOT'] . "/Footer.php";
        ?>
	</body>
</html>
