onmessage = function(e)
{
	var JavascriptWebsiteRoot = e.data[0];
	var Images = e.data[1].split(";");
	var Folder = e.data[2];
	var UsingCKEditor = e.data[3];
					
	for (i = 0; i < Images.length; i++)
	{
		if (Images[i] == '')
			continue;
		
		var Miniature = CreateThumnail(JavascriptWebsiteRoot, Images[i] , Folder, UsingCKEditor);
		postMessage(Miniature);
	}
	postMessage("Dead");
}

var CreateThumnail = function (JavascriptWebsiteRoot, ImageName, FolderPath, UsingCKEditor)
{
	var FullFolderPath = JavascriptWebsiteRoot + FolderPath + "/";
	
	var Output = "";
	Output += "<div class='Thumbnail'";
	if (typeof UsingCKEditor != 'undefined')
		Output += "onclick='SelectImage(this, \"" + FullFolderPath + ImageName + "\")'";
	Output += "onmouseover='ImageMouseEnter(this)'";
	Output += "onmouseout='ImageMouseLeave(this)'";
		
	Output += ">";
	if (typeof UsingCKEditor == 'undefined')
		Output += "<a href='" + FullFolderPath + ImageName + "'>";
	
	Output += "<img src='" + FullFolderPath + "Mini/" + ImageName + "' class='Miniature' alt='' />";
	if (typeof UsingCKEditor == 'undefined')
		Output += "</a>";
	
	Output += "<br />";
	Output += "<div>";
	Output += "<button class='close pull-right' style='visibility:hidden' onclick='DeleteImage(this, \"" + ImageName;
	Output += "\")'>&times;</button>";
	Output += "</div>";
	Output += "<br />";
	Output += "</div>";
    
	return Output;
}