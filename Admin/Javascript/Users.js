function CreateNewUser(form, Username, Password, ConfirmPassword)
{
     // Check each field has a value
    if (Username.value == '' || Password.value == ''  || ConfirmPassword.value == '')
	{
        alert('You must provide all the requested details. Please try again');
        return false;
    }
 
    // Check the username
    re = /^\w+$/; 
    if(!re.test(form.Username.value))
	{ 
        alert("Username must contain only letters, numbers and underscores. Please try again"); 
        form.Username.focus();
        return false; 
    }
 
    // Check that the password is sufficiently long (min 6 chars)
    // The check is duplicated below, but this is included to give more
    // specific guidance to the user
    if (Password.value.length < 6)
	{
        alert('Passwords must be at least 6 characters long.  Please try again');
        form.Password.focus();
        return false;
    }
 
    // At least one number, one lowercase and one uppercase letter 
    // At least six characters 
    var re = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/; 
    if (!re.test(Password.value))
	{
        alert('Passwords must contain at least one number, one lowercase and one uppercase letter.  Please try again');
        return false;
    }
 
    // Check password and confirmation are the same
    if (Password.value != ConfirmPassword.value)
    {
        alert('Your password and confirmation do not match. Please try again');
        form.Password.focus();
        return false;
    }
 
    // Create a new element input, this will be our hashed password field. 
    var p = document.createElement("input");
 
    // Add the new element to our form. 
    form.appendChild(p);
    p.name = "p";
    p.type = "hidden";
    p.value = hex_sha512(Password.value);
 
	var data = new FormData();
	data.append('Username', form.Username.value);
	data.append('p', hex_sha512(Password.value));

    // Make sure the plaintext password doesn't get sent. 
    Password.value = "";
    ConfirmPassword.value = "";
 
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
            TableUsers.children[0].innerHTML += xmlhttp.responseText;
		}
	};

	var url = JavascriptWebsiteRoot + "/Admin/Ajax PHP/Users/New User.php";
	xmlhttp.open('POST', url);
	xmlhttp.send(data);
}

function DeleteUser(Sender, UserID)
{
	if (confirm("Are you sure you want want to delete this user?"))
	{
		var data = new FormData();
		data.append('UserID', UserID);

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
					TableUsers.innerHTML = xmlhttp.responseText;
			}
		};

		var url = JavascriptWebsiteRoot + "/Admin/Ajax PHP/Users/Delete User.php";
		xmlhttp.open('POST', url);
		xmlhttp.send(data);
	}
}

function SaveUser(Sender, UserID)
{
    var Row = Sender.parentNode.parentNode;
    var RightID = Row.cells[0].children[0].value;
    var Username = Row.cells[1].children[0].value;
    
    var data = new FormData();
    data.append('RightID', RightID);
    data.append('Username', Username);
    data.append('UserID', UserID);

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
				TableUsers.innerHTML = xmlhttp.responseText;
            else
                window.alert("Save successful");
        }
    };

    var url = JavascriptWebsiteRoot + "/Admin/Ajax PHP/Users/Save User.php";
    xmlhttp.open('POST', url);
    xmlhttp.send(data);
}