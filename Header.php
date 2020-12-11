<?php
        include $_SERVER['DOCUMENT_ROOT'] . "/Default Include.php";
?>
<header>
	<div id="titre_logo">
        <?php
            echo
            "<a href='/' target='_blank'><img height='139px' width='150px' alt='' /></a>";
        ?>
	</div>
	<div id="titre_principal">
		<h1>Project Eternity</h1>
	</div>
	<div class="menu">
		<ul>
			<li>
                <a href="#1">
                    <span>Quick menu</span>
                </a>
				<ul class="menuderoulant">
					<?php
						include $_SERVER['DOCUMENT_ROOT'] . "/Create Database.php";
						$Db = new DatabaseHandler();
						CreateDatabase($Db);

                        if (LoginCheck("Admin"))
                        {
                            echo
                            "<li>
                                <a href='$JavascriptWebsiteRoot/Admin/Admin%20homepage.php' style='border-left : 5px solid #AEAEAE'>
                                    <span>Admin</span>
                                </a>
                            </li>";
                        }
                        else
                        {
                            echo
                            "<li>
                                <a href='$JavascriptWebsiteRoot/Connection/Sign%20In.php' style='border-left : 5px solid #AEAEAE'>
                                    <span>Sign In</span>
                                </a>
                            </li>";
                        }
					?>
				</ul>
			</li>
		</ul>
	</div>
</header>
