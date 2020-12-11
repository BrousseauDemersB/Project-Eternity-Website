function CreateHomeMenuEntry(form)
{
     // Check each field has a value
    if (form.Position.value == '' || form.Text.value == '' ||
		form.FilePath.value == '' || form.Colspan.value == '' || form.Rowspan.value == '')
	{
        alert('You must provide all the requested details. Please try again');
        return false;
    }
   
	var data = new FormData();
	data.append('Position', form.Position.value);
	data.append('Text', form.Text.value);
	data.append('FilePath', form.FilePath.value);
	data.append('Colspan', form.Colspan.value);
	data.append('Rowspan', form.Rowspan.value);

    // Reset Controls
    form.Position.value = "";
    form.Text.value = "";
    form.FilePath.value = "";
    form.Colspan.value = "";
    form.Rowspan.value = "";
 
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
            TableHomeMenu.children[0].innerHTML += xmlhttp.responseText;
		}
	};

	var url = JavascriptWebsiteRoot + "/Admin/Ajax PHP/Home Menu/New Entry.php";
	xmlhttp.open('POST', url);
	xmlhttp.send(data);
}

function DeleteHomeMenuEntry(Sender, OriginalPosition)
{
	if (confirm("Are you sure you want want to delete this entry?"))
	{
		var data = new FormData();
		data.append('OriginalPosition', OriginalPosition);

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
					TableHomeMenu.innerHTML = xmlhttp.responseText;
			}
		};

		var url = JavascriptWebsiteRoot + "/Admin/Ajax PHP/Home Menu/Delete Entry.php";
		xmlhttp.open('POST', url);
		xmlhttp.send(data);
	}
}

function SaveHomeMenuEntry(Sender, OriginalPosition)
{
    var Row = Sender.parentNode.parentNode;
    var Position = Row.cells[0].children[0].value;
    var Text = Row.cells[1].children[0].value;
    var FilePath = Row.cells[2].children[0].value;
    var Colspan = Row.cells[3].children[0].value;
    var Rowspan = Row.cells[4].children[0].value;
    
     // Check each field has a value
    if (Position == '' || Text == '' ||
		FilePath == '' || Colspan == '' || Rowspan == '')
	{
        alert('You must provide all the requested details. Please try again');
        return false;
    }
   
	var data = new FormData();
	data.append('OriginalPosition', OriginalPosition);
	data.append('Position', Position);
	data.append('Text', Text);
	data.append('FilePath', FilePath);
	data.append('Colspan', Colspan);
	data.append('Rowspan', Rowspan);

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

    var url = JavascriptWebsiteRoot + "/Admin/Ajax PHP/Home Menu/Save Entry.php";
    xmlhttp.open('POST', url);
    xmlhttp.send(data);
}