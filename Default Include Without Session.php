<?php
    header('Content-Type: text/html; charset=utf-8');
    setlocale(LC_ALL, 'fr_CA');
    include $_SERVER['DOCUMENT_ROOT'] . "/Default Connection Include.php";

    $protocol    = empty($_SERVER['HTTPS']) ? 'http' : 'https';
    $port        = $_SERVER['SERVER_PORT'];
    $disp_port   = ($protocol == 'http' && $port == 80 || $protocol == 'https' && $port == 443) ? '' : ":$port";
    $domain      = $_SERVER['SERVER_NAME'];
    $JavascriptWebsiteRoot = "${protocol}://${domain}${disp_port}";

    echo
    "<link rel='stylesheet' href='$JavascriptWebsiteRoot/CSS/Template Page.css'>
    <script type='text/javascript' script-name='wire-one' src='http://use.edgefonts.net/wire-one.js'></script>
    <script src='$JavascriptWebsiteRoot/javascript/jquery-1.11.2.min.js'></script>
    <script type='text/javascript'>
        var JavascriptWebsiteRoot = '$JavascriptWebsiteRoot';
    </script>";
?>
