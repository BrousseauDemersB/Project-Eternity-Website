function CreateTab(Nom, Extension, First)
{	
	var NewLiElement = document.createElement("li");
	NewLiElement.className = 'TabsLi';
	
	var NewRadioElement = document.createElement("input");
	NewRadioElement.type = "radio";
	NewRadioElement.className = "tabsRadio";
	NewRadioElement.id = 'tab ' + Nom;
	NewRadioElement.setAttribute("name", "tabs");
	if (First == 1)
		NewRadioElement.setAttribute("checked", true);
	NewLiElement.appendChild(NewRadioElement);
	NewLiElement.innerHTML += "<label class='tabsLabel' for='tab " + Nom + "'> " + Nom + "</label>";
	
	var NewDivElement = document.createElement("div");
	NewDivElement.id = 'tab-content ' + Nom;
	NewDivElement.className = "tab-content";
	NewLiElement.appendChild(NewDivElement);
	
	AdminContent.appendChild(NewLiElement);
	
	var data = new FormData();
	data.append('AdminPageName', Nom);
	data.append('Extension', Extension);
	
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
			NewDivElement.innerHTML = xmlhttp.responseText;
			var Scripts = NewDivElement.getElementsByTagName('script');
			
			for(var i = Scripts.length - 1; i >= 0; --i)
			{
				CompilerJavascript(Scripts[i], NewDivElement);
			}
		}
	};
	var url = JavascriptWebsiteRoot + "/Admin/Ajax PHP/Compile Admin Page.php";
	xmlhttp.open('POST', url);
	xmlhttp.send(data);
}

function CompilerJavascript(ActiveScript, Container)
{
	var NewScript = document.createElement("script");
	
	if (ActiveScript.src != "")
		NewScript.src = ActiveScript.src;
		
	if (ActiveScript.innerHTML != "")
		NewScript.innerHTML = ActiveScript.innerHTML;
		
	Container.removeChild(ActiveScript);
	Container.appendChild(NewScript);
}