<?php
    include $_SERVER['DOCUMENT_ROOT'] . "/Default Include.php"; 
 
    if (isset($_POST['Usager'], $_POST['p']))
    {
        $Usager = $_POST['Usager'];
        $Password = $_POST['p']; // The hashed password.
     
        $Return = Login($Usager, $Password);
        if ($Return == "Success")
        {
            // Login success 
            header("Location: $JavascriptWebsiteRoot/Connection/Protected Page.php");
        }
        else
        {
            // Login failed 
            header("Location: $JavascriptWebsiteRoot/Connection/Sign In.php?error=1&Return=$Return");
        }
    }
    else
    {
        // The correct POST variables were not sent to this page. 
        echo 'Invalid Request';
    }
?>