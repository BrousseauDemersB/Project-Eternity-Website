function GetUploadProgressBox(Extra)
{
    var ContentBox = document.createElement('div');
    ContentBox.setAttribute("id", "ContentBox");
    ContentBox.setAttribute("tabindex", "-1");
    ContentBox.setAttribute("role", "dialog");
    ContentBox.setAttribute("aria-labelledby", "myModalLabel");
    ContentBox.setAttribute("aria-hidden", "true");
    ContentBox.innerHTML =
		"<div class='progress' id='ProgressBarContainer'>" + 
			"<div class='progress bar' role='progressbar' style='width: 10%; height:100%' id='Progress Bar'>" + 
			"0%" + 
			"</div>" + 
		"</div>" +
        Extra;
    
    return ContentBox;
}