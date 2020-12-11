<?php
    include $_SERVER['DOCUMENT_ROOT'] . "/Default Include Without Session.php";
    sec_session_start(false);

    if (LoginCheck("Admin"))
    {
        echo "
            <script src='$JavascriptWebsiteRoot/Admin/Javascript/Get Progress Box.js'></script>
            <script src='$JavascriptWebsiteRoot/Admin/Javascript/Import - Export.js'></script>";
?>
            
        <input type='button' value='Export Website Content' onclick='ExportWebsiteContent();' />
        <input type='button' value='Import Website Content' onclick="document.getElementById('ZipUploader').click();"/>
        <input type="file" id="ZipUploader" onchange="ImportWebsiteContent();" accept='.zip' multiple='multiple' style="position: fixed; top: -100em"/>
<?php
    }
?>