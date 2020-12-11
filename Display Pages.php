<html>
	<head>
	 	<title>
	 		GUIs
	 	</title>
	</head>
	<body>
		<?php
			include $_SERVER['DOCUMENT_ROOT'] . "/Header.php";
            include $_SERVER['DOCUMENT_ROOT'] . "/Display Page Helper.php";
		?>
        <section>
            <div class="VerticalMenu">
                <?php
                    include $_SERVER['DOCUMENT_ROOT'] . "/Vertical Menu.php";
                ?>
            </div>
            <div class="contenu">
                <?php
                    function RenderOptions(Array $Options, string $SelectedValue)
                    {
                        foreach ($Options as $Option)
                        {
                            $Extra = "";
                            if ($Option==$SelectedValue)
                            {
                                $Extra = ' selected="selected"';
                            }
                            echo "<option value='$Option'$Extra>$Option</option>";
                        }
                    }

                    $OrderBy = "Alphabetical";
                    $ModsFilter = "*";
                    $PagesFilter = "*";

                    if (isset($_GET["OrderBy"]))
                    {
                        $OrderBy = $_GET["OrderBy"];
                    }
                    if (isset($_GET["ModsFilter"]))
                    {
                        $ModsFilter = $_GET["ModsFilter"];
                    }
                    if (isset($_GET["PagesFilter"]))
                    {
                        $PagesFilter = $_GET["PagesFilter"];
                    }
                ?>
                <select id='OrderBy' style='display: block;width:200px;' onchange='ChoosePagesFilter()'>
                    <?php RenderOptions(Array("Alphabetical", "Mods"), $OrderBy);?>
                </select>
                <select id='Mods Filter' style='display: block;width:200px;' onchange='ChoosePagesFilter()'>
                    <?php RenderOptions(Array("*", "Core", "Deathmatch"), $ModsFilter);?>
                </select>
                <select id='Pages Filter' style='display: block;width:200px;' onchange='ChoosePagesFilter()'>
                    <?php RenderOptions(Array("*", "GUIs", "Code"), $PagesFilter);?>
                </select>
                <?php
                    DisplayPages($OrderBy, $ModsFilter, $PagesFilter);
                ?>
            </div>
        </section>
	 	<?php
        echo
            "<script type='text/javascript' src='$JavascriptWebsiteRoot/Javascript/Pages filter.js'></script>
            <script type='text/javascript' src='$JavascriptWebsiteRoot/Javascript/Init Pages filter.js'></script>";
	 	?>
		
		<?php 
			include $_SERVER['DOCUMENT_ROOT'] . "/Footer.php";
		?>
	</body>
</html>
