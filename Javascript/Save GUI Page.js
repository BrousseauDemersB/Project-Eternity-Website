function SaveModification()
{
    var Content = CKEDITOR.instances.editor1.getData();

    var data = new FormData();
    data.append('PagePath', PagePath);
    data.append('Content', Content);

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
                document.getElementById('editor1').innerHTML = xmlhttp.responseText;
            else
                alert("Save completed");
        }
    };

    var url = JavascriptWebsiteRoot + "/Ajax PHP/Save GUI page.php";
    xmlhttp.open('POST', url);
    xmlhttp.send(data);
}