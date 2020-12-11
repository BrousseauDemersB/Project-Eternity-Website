var ExportWebsiteContent = function ()
{
    var data = new FormData();

    var xmlhttp;
    if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    }
    else {// code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange = function ()
    {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
            if (xmlhttp.responseText != "")
                window.alert(xmlhttp.responseText);
            else
            {
                var iframe = document.createElement('iframe');
                iframe.style.display='none';
                iframe.src = JavascriptWebsiteRoot + "/Admin/Ajax PHP/Export/Download Zip.php";
                document.body.appendChild(iframe);
            }
        }
    };

    var url = JavascriptWebsiteRoot + "/Admin/Ajax PHP/Export/Create Zip.php";
    xmlhttp.open('POST', url);
    xmlhttp.send(data);
}

var CloseForm = function (_this)
{
    _this.parentNode.parentNode.removeChild(_this.parentNode);
}

var ImportWebsiteContent = function ()
{
    var UploadBox = GetUploadProgressBox(
    "<button data-dismiss='modal' id='ButtonClose' onclick='CloseForm(this)'>Close</button>");
    
    document.body.appendChild(UploadBox);
    
    var InputFile = document.getElementById('ZipUploader');
    
    if (InputFile.files.length !== 1)
    {
        return;
    }

    var data = new FormData();
    for (var i = 0; i < InputFile.files.length; i++)
        data.append('SelectedFile[]', InputFile.files[i]);

    data.append('UploadPath', FolderChoice.value);

    var xmlhttp;
    if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    }
    else {// code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange = function ()
    {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
            if (xmlhttp.responseText != "")
                window.alert(xmlhttp.responseText);
            else
                window.alert("Upload completed");
        }
    };

    var url = JavascriptWebsiteRoot + "/Admin/Ajax PHP/Export/Import Zip.php";
    xmlhttp.open('POST', url);
    xmlhttp.send(data);
}
