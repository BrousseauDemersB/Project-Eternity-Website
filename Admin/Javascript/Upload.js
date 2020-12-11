var CreateNewFolder = function ()
{
    var FolderName = prompt("Enter a new folder name", "New folder");
    
    if (FolderName != null)
    {
        var data = new FormData();
        data.append('FolderName', FolderName);

        var xmlhttp;
        if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        }
        else {// code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }

        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {

                var NewOption= document.createElement("option");
                NewOption.value = FolderName;
                NewOption.innerHTML = FolderName;
                FolderChoice.appendChild(NewOption);

                if (xmlhttp.responseText != "")
                    ActiveThumbnailsContainer.innerHTML = xmlhttp.responseText;
            }
        };

        var url = JavascriptWebsiteRoot + "/Admin/Ajax PHP/Upload/Create Folder.php";
        xmlhttp.open('POST', url);
        xmlhttp.send(data);
    }
}
var RenameFolder = function ()
{
    if (FolderChoice.selectedIndex >= 0)
    {
        var FolderName = prompt("Enter a name", FolderChoice.value);

        if (FolderName != null)
        {
            var data = new FormData();
            data.append('FolderNameAncien', FolderChoice.value);
            data.append('FolderNameNouveau', FolderName);

            var xmlhttp;
            if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            }
            else {// code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }

            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    FolderChoice.options[ FolderChoice.selectedIndex ].value = FolderName;
                    FolderChoice.options[ FolderChoice.selectedIndex ].innerHTML = FolderName;

                    if (xmlhttp.responseText != "")
                        ActiveThumbnailsContainer.innerHTML = xmlhttp.responseText;
                }
            };

            var url = JavascriptWebsiteRoot + "/Admin/Ajax PHP/Upload/Rename Folder.php";
            xmlhttp.open('POST', url);
            xmlhttp.send(data);
        }
    }
}
var DeleteCurrentFolder = function ()
{
    if (FolderChoice.selectedIndex >= 0 && confirm("Do you really want to delete this folder?"))
    {
        var data = new FormData();
        data.append('FolderName', FolderChoice.value);

        var xmlhttp;
        if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        }
        else {// code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }

        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
            {
                FolderChoice.remove(FolderChoice.selectedIndex);
                ChoisirDossier();

                if (xmlhttp.responseText != "")
                    ActiveThumbnailsContainer.innerHTML = xmlhttp.responseText;
            }
        };

        var url = JavascriptWebsiteRoot + "/Admin/Ajax PHP/Upload/Delete Folder.php";
        xmlhttp.open('POST', url);
        xmlhttp.send(data);
    }
}

var ChooseFolder = function ()
{
    if (FolderChoice.selectedIndex >= 0)
    {
        var data = new FormData();
        data.append('FolderName', FolderChoice.value);

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
                var TumbnailsContainer = document.getElementById('Thumbnails');
                
                if(typeof(Worker) !== "undefined")
                {
                    if(typeof(w) == "undefined")
                    {
                        TumbnailsContainer.innerHTML = "";
                        w = new Worker(JavascriptWebsiteRoot + "/Admin/Javascript/Thumbnails Worker.js");
                        if (typeof UsingCKEditor != 'undefined')
                            w.postMessage([JavascriptWebsiteRoot, xmlhttp.responseText, UploadFolder + FolderChoice.value, true]);
                        else
                            w.postMessage([JavascriptWebsiteRoot, xmlhttp.responseText, UploadFolder + FolderChoice.value, false]);
                    }
                    w.onmessage = function(event)
                    {
                        if (event.data == "Dead")
                        {
                            w.terminate();
                            w = undefined;
                        }
                        else
                            TumbnailsContainer.innerHTML += event.data;
                    };
                }
                else
                {
                    window.alert("Sorry! No Web Worker support.");
                    var Output = "";
                    var res = xmlhttp.responseText.split(";");
                    for (i = 0; i < res.length; i++)
                    {
                        if (res[i] == '')
                            continue;

                        Output += CreateThumnail(JavascriptWebsiteRoot, res[i] , UploadFolder + FolderChoice.value, UsingCKEditor);
                    }
                    TumbnailsContainer.innerHTML = Output;
                }
            }
        };
        var url = JavascriptWebsiteRoot + "/Admin/Ajax PHP/Upload/Choose Folder.php";
        xmlhttp.open('POST', url);
        xmlhttp.send(data);
    }
}

var SelectImage = function (SelectedItem, ImageName)
{
    var nodes = SelectedItem.parentNode.childNodes;
    for(var i = 0; i < nodes.length; i++)
    {
         nodes[i].className = "Thumbnail";
    }
    SelectedItem.className = "Thumbnail Selected";
    SelectedImage = ImageName;
}

var ImageMouseEnter = function(Sender)
{
    var ActiveButton = Sender.getElementsByTagName("button")[0];
    ActiveButton.style.visibility = "visible";
}

var ImageMouseLeave = function(Sender)
{
    var ActiveButton = Sender.getElementsByTagName("button")[0];
    ActiveButton.style.visibility = "hidden";
}

var UploadImage = function ()
{
    var InputFile = document.getElementById('InputFile');
    
    if (InputFile.files.length === 0)
    {
        return;
    }

    InitUpload(InputFile);

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
            var FileName = InputFile.files[0].name;
            var UploadPath = JavascriptWebsiteRoot + UploadFolder + FolderChoice.value + '/';
            document.getElementById('ButtonSeeImage').href = UploadPath + FileName;
            document.getElementById('LabelImageName').innerHTML = FileName;
            document.getElementById('ButtonClose').setAttribute('onclick',"CloseForm(" + InputFile.id + ")");

            for (var i = 0; i < InputFile.files.length; i++)
            {
                var Output = CreateThumnail(JavascriptWebsiteRoot, InputFile.files[i].name , UploadFolder + FolderChoice.value, UsingCKEditor);
                ActiveThumbnailsContainer.innerHTML += Output;
            }

            if (xmlhttp.responseText != "")
                ActiveThumbnailsContainer.innerHTML = xmlhttp.responseText;
        }
    };

    HttpProgression(xmlhttp);

    var url = JavascriptWebsiteRoot + "/Admin/Ajax PHP/Upload/Upload Image.php";
    xmlhttp.open('POST', url);
    xmlhttp.send(data);
}

var InitUpload = function (_file)
{
    var UploadBox = GetUploadProgressBox(
        "<img id='Preview'/>" + 
        "<a id='ButtonSeeImage' href=''>Open Image</a>" + 
        "<button data-dismiss='modal' id='ButtonClose' onclick='CloseForm(this)'>Close</button>" + 
        "<label id='LabelImageName'>Image name</label>");
    UploadBox.style.visibility = "visible";
    
    document.body.appendChild(UploadBox);
    var Image = document.getElementById('Preview');

    Image.file = _file.files[0];

    var reader = new FileReader();
    reader.onload = (function (aImg)
    {
        return function (e)
        {
            aImg.src = e.target.result;
        };
    })(Image);
    reader.readAsDataURL(_file.files[0]);
}

var HttpProgression = function (xmlhttp)
{
    xmlhttp.upload.addEventListener('progress', function (e)
    {
        var ProgressValue = Math.ceil(e.loaded / e.total * 100);
        if (ProgressValue > 10)
        {
            var _progress = document.getElementById('Progress Bar');
            if (ProgressValue < 100)
            {
                _progress.style.width = ProgressValue + '%';
                _progress.innerHTML = ProgressValue + '%';
            }
            else
            {
                _progress.style.width = '100%';
                _progress.innerHTML = "Upload finished";
            }
        }
    }, false);
}

var CloseForm = function (_this)
{
    InputFile.parentNode.reset();
    _this.parentNode.parentNode.removeChild(_this.parentNode);
}

function DeleteImage(TagImage, ImageName)
{
    if (confirm("Do you really want to delete this image?"))
    {
        var data = new FormData();
        data.append('FolderName', FolderChoice.value);
        data.append('ImageName', ImageName);

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
                var TagToDelete = TagImage.parentNode.parentNode;
                TagToDelete.parentNode.removeChild(TagToDelete);

                if (xmlhttp.responseText != "")
                    ActiveThumbnailsContainer.innerHTML = xmlhttp.responseText;
            }
        }
        var url = JavascriptWebsiteRoot + "/Admin/Ajax PHP/Upload/Delete Image.php";
        xmlhttp.open('POST', url);
        xmlhttp.send(data);
    }
}

