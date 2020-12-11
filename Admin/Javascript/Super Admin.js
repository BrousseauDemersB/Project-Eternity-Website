var CreateNewAdminPage = function ()
{
	var AdminPageName = prompt("Enter a name for the new page", "New page.php");
    
    if (AdminPageName != null)
	{
		var Input = AdminPageName.split('.');
		if (Input.length != 2)
		{
			window.alert("Invalid file name");
			return;
		}
		var data = new FormData();
		data.append('AdminPageName', AdminPageName);

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
				CreateTab(Input[0], '.' + Input[1]);
				var NewOption= document.createElement("option");
				NewOption.value = AdminPageName;
				NewOption.innerHTML = AdminPageName;
				AdminPageChoice.appendChild(NewOption);
								
				if (xmlhttp.responseText != "")
					AdminPageEditor.innerHTML = xmlhttp.responseText;
		    }
		};

		var url = JavascriptWebsiteRoot + "/Admin/Ajax PHP/Super Admin/Create Admin Page.php";
		xmlhttp.open('POST', url);
		xmlhttp.send(data);
	}
}

var RenameAdminPage = function ()
{
    if (AdminPageChoice.selectedIndex >= 0)
	{
		var AdminPageName = prompt("Enter a name", AdminPageChoice.value);
		
		if (AdminPageName != null)
		{
			var Input = AdminPageName.split('.');
			if (Input.length != 2)
			{
			window.alert("Invalid file name");
				return;
			}
		
			var data = new FormData();
			data.append('AdminPageNameOld', AdminPageChoice.value);
			data.append('AdminPageNameNew', AdminPageName);

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
					var AdminPageNameAncien = AdminPageChoice.value.split('.')[0];
					var SelectedHeader = document.getElementById('Tab header ' + AdminPageNameAncien);
					var SelectedContent = document.getElementById('tab-content ' + AdminPageNameAncien);
					
					AdminPageChoice.options[ AdminPageChoice.selectedIndex ].value = AdminPageName;
					AdminPageChoice.options[ AdminPageChoice.selectedIndex ].innerHTML = AdminPageName;

					var AdminPageNameNouveau = Input[0];
					SelectedHeader.id = 'Tab header ' + AdminPageNameNouveau;
					SelectedHeader.innerHTML = AdminPageNameNouveau;
					SelectedHeader.onclick = ChangeTab.bind(SelectedHeader, AdminPageNameNouveau);
					SelectedContent.id = 'tab-content ' + AdminPageNameNouveau;
				
					if (xmlhttp.responseText != "")
						AdminPageEditor.innerHTML = xmlhttp.responseText;
				}
			};

			var url = JavascriptWebsiteRoot + "/Admin/Ajax PHP/Super Admin/Rename Admin Page.php";
			xmlhttp.open('POST', url);
			xmlhttp.send(data);
		}
	}
}
var DeleteAdminPage = function ()
{
    if (AdminPageChoice.selectedIndex >= 0 && confirm("Do you really want to delete this page?"))
	{
		var data = new FormData();
		data.append('AdminPageName', AdminPageChoice.value);

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
				var NomPage = AdminPageChoice.value.split('.')[0];
				var SelectedHeader = document.getElementById('Tab header ' + NomPage);
				var SelectedContent = document.getElementById('tab-content ' + NomPage);
				SelectedHeader.parentNode.removeChild(SelectedHeader);
				SelectedContent.parentNode.removeChild(SelectedContent);
				
				AdminPageChoice.remove(AdminPageChoice.selectedIndex);
				ChoisirPageAdmin();
				if (xmlhttp.responseText != "")
					AdminPageEditor.innerHTML = xmlhttp.responseText;
		    }
		};

		var url = JavascriptWebsiteRoot + "/Admin/Ajax PHP/Super Admin/Delete Admin Page.php";
		xmlhttp.open('POST', url);
		xmlhttp.send(data);
	}
}
var ChooseAdminPage = function ()
{
    if (AdminPageChoice.selectedIndex >= 0)
	{
		var data = new FormData();
		data.append('AdminPageName', AdminPageChoice.value);

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
		        AdminPageEditor.innerHTML = xmlhttp.responseText;
		    }
		};
		var url = JavascriptWebsiteRoot + "/Admin/Ajax PHP/Super Admin/Choose Admin Page.php";
		xmlhttp.open('POST', url);
		xmlhttp.send(data);
	}
}

var SaveAdminPage = function ()
{
    if (AdminPageChoice.selectedIndex >= 0)
	{
		var data = new FormData();
		data.append('AdminPageName', AdminPageChoice.value);
		data.append('AdminPageContent', AdminPageEditor.value);

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
				var ActiveAdminPage = document.getElementById('tab-content ' + AdminPageChoice.value.split('.')[0] + '');
				
				var ScriptsOld = ActiveAdminPage.getElementsByTagName('script');
				
				for(var i = 0; i < ScriptsOld.length; i++)
				{
					ActiveAdminPage.removeChild(ScriptsOld[i--]);
				}
				
				ActiveAdminPage.innerHTML = xmlhttp.responseText;
				
				var Scripts = ActiveAdminPage.getElementsByTagName('script');
				var CopyScript = [];
				
				//Make a copy of the scripts because CompileJavascript will change them.
				for(var i = 0; i < Scripts.length; i++)
				{
					CopyScript[i] = Scripts[i];
				}
				
				for(var i = 0; i < CopyScript.length; i++)
				{
					CompilerJavascript(CopyScript[i], ActiveAdminPage);
				}
		    }
			else if (xmlhttp.readyState == 4)
			{
				AdminPageEditor.innerHTML = xmlhttpxmlhttp.statusText;
			}
		};
		var url = JavascriptWebsiteRoot + "/Admin/Ajax PHP/Super Admin/Save Admin Page.php";
		xmlhttp.open('POST', url);
		xmlhttp.send(data);
	}
}