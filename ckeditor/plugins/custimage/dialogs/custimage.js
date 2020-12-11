﻿CKEDITOR.dialog.add("custimageDialog",function(b)
{
    return{
        title:"Image Properties",
        minWidth:400,
        minHeight:200,
        contents:[
        {
            id:"tab-basic",
            label:"Basic Settings",
            elements:[
            {
                type:"text",
                id:"src",
                label:"Source",
                validate:CKEDITOR.dialog.validate.notEmpty("Image source field cannot be empty")
            },
            {
                type:"text",id:"alt",label:"Alternative"
            }]
        }],
        onShow:function()
        {
            CKEDITOR.dialog.getCurrent().hide();
            window.open(JavascriptWebsiteRoot + "/ckeditor/plugins/custimage/dialogs/ImageUploader.php","ImageBrowser","menubar=1,resizable=1,width=950,height=580").focus()
        },
        onOk:function()
        {
            var a=b.document.createElement("img");
            a.setAttribute("src",this.getValueOf("tab-basic","src"));
            a.setAttribute("alt",this.getValueOf("tab-basic","alt"));
            b.insertElement(a)
        }
    }
});