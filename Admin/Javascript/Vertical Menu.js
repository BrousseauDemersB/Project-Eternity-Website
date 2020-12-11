function CreateVerticalMenuEntry(form)
{
     // Check each field has a value
    if (form.IndexMenu.value == '' || form.IndexParent.value == '' ||
		form.Name.value == '' || form.Link.value == '' || form.Color.value == '')
	{
        alert('You must provide all the requested details. Please try again');
        return false;
    }
   
	var data = new FormData();
	data.append('IndexMenu', form.IndexMenu.value);
	data.append('IndexParent', form.IndexParent.value);
	data.append('Name', form.Name.value);
	data.append('Link', form.Link.value);
	data.append('Color', form.Color.value);
	data.append('OpenNewPage', form.OpenNewPage.checked);

    // Reset Controls
    form.IndexMenu.value = "";
    form.IndexParent.value = "";
    form.Name.value = "";
    form.Link.value = "";
    form.Color.value = "";
    form.OpenNewPage.checked = false;
 
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
            TableVerticalMenu.children[0].innerHTML += xmlhttp.responseText;
		}
	};

	var url = JavascriptWebsiteRoot + "/Admin/Ajax PHP/Vertical Menu/New Entry.php";
	xmlhttp.open('POST', url);
	xmlhttp.send(data);
}

function DeleteVerticalMenuEntry(Sender, OriginalIndexMenu, OriginalIndexParent)
{
	if (confirm("Are you sure you want want to delete this entry?"))
	{
		var data = new FormData();
		data.append('OriginalIndexMenu', OriginalIndexMenu);
		data.append('OriginalIndexParent', OriginalIndexParent);

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
				Sender.parentNode.parentNode.parentNode.removeChild(Sender.parentNode.parentNode);
				
				if (xmlhttp.responseText != "1")
					TableVerticalMenu.innerHTML = xmlhttp.responseText;
			}
		};

		var url = JavascriptWebsiteRoot + "/Admin/Ajax PHP/Vertical Menu/Delete Entry.php";
		xmlhttp.open('POST', url);
		xmlhttp.send(data);
	}
}

function SaveVerticalMenuEntry(Sender, OriginalIndexMenu, OriginalIndexParent)
{
    var Row = Sender.parentNode.parentNode;
    var IndexMenu = Row.cells[0].children[0].value;
    var IndexParent = Row.cells[1].children[0].value;
    var Name = Row.cells[2].children[0].value;
    var Link = Row.cells[3].children[0].value;
    var Color = Row.cells[4].children[0].value;
    var OpenNewPage = Row.cells[5].children[0].checked;
    
     // Check each field has a value
    if (IndexMenu == '' || IndexParent == '' ||
		Name == '' || Link == '' || Color == '')
	{
        alert('You must provide all the requested details. Please try again');
        return false;
    }
    
    var data = new FormData();
    data.append('OriginalIndexMenu', OriginalIndexMenu);
    data.append('OriginalIndexParent', OriginalIndexParent);
    data.append('IndexMenu', IndexMenu);
    data.append('IndexParent', IndexParent);
    data.append('Name', Name);
    data.append('Link', Link);
    data.append('Color', Color);
    data.append('OpenNewPage', OpenNewPage);

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
			if (isNaN(parseInt(xmlhttp.responseText)))
				TableVerticalMenu.innerHTML = xmlhttp.responseText;
            else
                window.alert("Save successful");
        }
    };

    var url = JavascriptWebsiteRoot + "/Admin/Ajax PHP/Vertical Menu/Save Entry.php";
    xmlhttp.open('POST', url);
    xmlhttp.send(data);
}