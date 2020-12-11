<?php
    include $_SERVER['DOCUMENT_ROOT'] . "/Admin/Upload default include.php";
    function miniature( $imgSrc, $ImageName, $dir)
    {
        $MiniatureWidth = 50;
        $MiniatureHeight = 50;

        // quelle taille fait notre image ?
        $ImageWidth = imagesx($imgSrc);
        $ImageHeight = imagesy($imgSrc);

        // Création de l'image miniature en essayant de respecter le format portrait ou paysage
        if($ImageHeight > $ImageWidth)
        {
            // Resize to create miniature.
            $Mini = @ImageCreateTrueColor ($MiniatureHeight, $MiniatureWidth);
            ImageCopyResampled($Mini, $imgSrc, 0, 0, 0, 0, $MiniatureHeight, $MiniatureWidth, $ImageHeight, $ImageWidth);
        }
        else
        {
            // Resize to create miniature.
            $Mini = @ImageCreateTrueColor ($MiniatureWidth, $MiniatureHeight);
            ImageCopyResampled($Mini, $imgSrc, 0, 0, 0, 0, $MiniatureWidth, $MiniatureHeight, $ImageWidth, $ImageHeight);
        }
       
        // Save Miniature.
        imageJpeg($Mini, $dir . "Mini/$ImageName");

        return $ImageName;
    }

    $dir = $_SERVER['DOCUMENT_ROOT'] . $UploadFolder . $_POST["UploadPath"] . "/";
    $FileTagName = "SelectedFile";
    for($i = 0; $i < count($_FILES[$FileTagName]['name']); $i++)
    {
        //Get the temp file path
        $tmpFilePath = $_FILES[$FileTagName]['tmp_name'][$i];

        //Make sure we have a filepath
        if ($tmpFilePath != "")
        {
            //Setup our new file path
            $newFilePath = $dir . $_FILES[$FileTagName]['name'][$i];

            //Upload the file into the temp dir
            if(move_uploaded_file($tmpFilePath, $newFilePath))
            {
                switch($_FILES[$FileTagName]["type"][$i])
                {
                    case "image/jpeg":
                        $imgSrc = imagecreatefromjpeg($dir.$_FILES[$FileTagName]["name"][$i]);
                        break;
                    case "image/png":
                        $imgSrc = imagecreatefrompng($dir.$_FILES[$FileTagName]["name"][$i]);
                        break;
                    case "image/gif":
                        $imgSrc = imagecreatefromgif($dir.$_FILES[$FileTagName]["name"][$i]);
                        break;
                    default:
                        unset($imgSrc);
                        break;
                }
                miniature($imgSrc, $_FILES[$FileTagName]["name"][$i], $dir);
            }
        }
    }
?>