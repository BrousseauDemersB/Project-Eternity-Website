<?php
    include $_SERVER['DOCUMENT_ROOT'] . "/Default Include.php";
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Connection</title>
        <link rel="stylesheet" href="styles/main.css" />
    </head>
    <body>
        <?php if (LoginCheck())
        {
            echo "<p>Welcome " . htmlentities($_SESSION['Username']) . " !</p>
            <p>
                This is a test page.
            </p>
            <p>Return to <a href='$JavascriptWebsiteRoot/index.php'>Index</a></p>";
        }
        else
        {
            echo
            "<p>
                <span class='error'>You are not authorized to access this page.</span> Please <a href='$JavascriptWebsiteRoot/index.php'>Sign In</a>.
            </p>";
        }
        ?>
    </body>
</html>
