<?php
    include $_SERVER['DOCUMENT_ROOT'] . "/Default Include.php"; 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  	<head>
    	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    	<title>Admin</title>
  	</head>
  	<body>
        <?php
            if (LoginCheck("Admin"))
            {
                echo "<link rel='stylesheet' type='text/css' href='$JavascriptWebsiteRoot/Admin/CSS/Tab.css'>";
                
                $FinalAdminPagesFolder = $_SERVER['DOCUMENT_ROOT'] . "/Admin/Admin pages";
                $ArrayAdminPage = array();
                foreach (new DirectoryIterator($FinalAdminPagesFolder) as $fileInfo)
                {
                    if ($fileInfo->IsDir() || $fileInfo == "adminfunctions.php")
                        continue;
                    
                    $Extension = "." . $fileInfo->getExtension();
            
                    switch($Extension)
                    {
                       case ".html":
                       case ".php":
                            $FileName = $fileInfo->getBasename($Extension);
                            array_push($ArrayAdminPage, array(utf8_encode($FileName), $Extension));
                          break;
                    }
                }

                echo
                "<ul id='AdminContent' class='tabs'></ul>

                <script type='text/javascript' src='$JavascriptWebsiteRoot/Admin/Javascript/Init Tab.js'></script>
                <script type='text/javascript' src='$JavascriptWebsiteRoot/Admin/Javascript/Tab.js'></script>";

                $First = 1;
                foreach ($ArrayAdminPage as $Value)
                {
                    echo "<script type='text/javascript'>CreateTab('$Value[0]', '$Value[1]', " . $First . ");</script>\n";
                    $First = 0;
                }
            }
            else
            {
                ShowConnectionAccessRightsError($JavascriptWebsiteRoot);
            }
        ?>
	</body>
</html>

