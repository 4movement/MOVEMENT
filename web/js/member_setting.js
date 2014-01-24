
$("#member_file").click(function() {
	$("#member_setting_mask").fadeIn();
	$("#member_setting_mask1").fadeIn();
});

$("#member_setting_mask").click(function() {
	$("#member_setting_mask").fadeOut();
	$("#member_setting_mask1").fadeOut();
});
$("#image_submit").click(function() {
	$("#member_setting_mask").fadeOut();
	$("#member_setting_mask1").fadeOut();
});
$("#member_user_photo").click(function() {
	$("#member_setting_mask").fadeIn();
	$("#member_setting_mask1").fadeIn();
});

			
			uploader = {
				carry: function(){
					// set form
					YAHOO.util.Connect.setForm('uploadForm', true);
					// upload image
					YAHOO.util.Connect.asyncRequest('POST', 'upload.php', {
						upload: function(o){
							// parse our json data
							var jsonData = YAHOO.lang.JSON.parse(o.responseText);
							
							// put image in our image container
							YAHOO.util.Dom.get('imageContainer').innerHTML = '<img id="yuiImg" src="' + jsonData.image + '" width="' + jsonData.width + '" height="' + jsonData.height + '" alt="" />';
							console.log(jsonData.image);
							// init our photoshop
							photoshop.init(jsonData.image); 
										
							// get first cropped image
							photoshop.getCroppedImage(jsonData.image);
							
						}
					});
				}
			};
			
			// add listeners
			YAHOO.util.Event.on('uploadButton', 'click', uploader.carry);
			photoshop = {
				image: null,
				crop: null,
				
				init: function(image){
					// set our image
					photoshop.image = image;
								
					// our image cropper from the uploaded image					
					photoshop.crop = new YAHOO.widget.ImageCropper('yuiImg');
					photoshop.crop.on('moveEvent', function() {
						// get updated coordinates
						photoshop.getCroppedImage(image);
					});
				},
				
				getCroppedImage: function(imgname){
					var coordinates = photoshop.getCoordinates();
					console.log("Ha NAME");
					console.log(imgname);
					
					//var url = 'crop.php?image=' + photoshop.image + '&cropStartX=' + coordinates.left +'&cropStartY=' + coordinates.top +'&cropWidth=' + coordinates.width +'&cropHeight=' + coordinates.height + '&crop=' + imgname;
					YAHOO.util.Dom.get('ac').innerHTML = "<div id='check'>Check</div>";	
					
					$("#check").click(
						function go(){
							
							var base_url = "";
							var url = base_url + "crop.php";
							$.get(url,{
								image:photoshop.image,
								cropStartX:coordinates.left,
								cropStartY:coordinates.top,
								cropWidth:coordinates.width,
								cropHeight:coordinates.height,
								crop:imgname,
								},function(data){
									console.log("AJAX OK");
									console.log(data);
								}
							);
						}
						
					)
						
						
					
					
			
				},
			
				getCoordinates: function(){
					return photoshop.crop.getCropCoords();
				}
			};
/*
function uploadImage(){
 // 檢查圖片格式
 	var f=document.getElementById("advImage").value;

    if (!/\.(gif|jpg|jpeg|png|JPG|PNG)$/ .test(f)){
        alert( "圖片類型必須是.jpeg,jpg,png中的一種" )
         return  false ;
    }
    // 利用ajaxFileUpload js插件上傳圖片 
    $.ajaxFileUpload({
    	url:"uploadPreviewImage.html",
        secureuri: false,
        fileElementId: "advImage",
        dataType: "json" ,
       
        success: function (data , status) {
              // 上傳成功後，直接跳出截圖框，使用imgAreaSelect插件 
            piso = $('#photo' ).imgAreaSelect({
                  x1: 0, y1: 0, x2:480 , y2: 520 ,onSelectEnd: preview,
            resizable: false ,
            instance: true ,
            persistent: true
            });
            // 這個方法是現實一個div，托住截圖框
            showCutImage();
             // 一些變量在頁面的隱藏input的設置 
            document.getElementById("photo").src = data.tempPath;
            document.getElementById( "currentPath").value = data.tempPath;
            
        },
        error: function (data, status, e) {
             // alert("圖片上傳失敗,請重新選擇圖片"); 
        }
    });
    return  false ;
}
// 截圖選中後調用方法，保存好起始坐標和寬高
function preview(img, selection)
    {
       
        $( '#x1' ).val(selection.x1);
        $( '#y1' ).val(selection.y1);
        $( '#x2' ).val(selection.x2);
        $( '#y2' ).val(selection.y2);
        $( '#w' ).val(selection.width);
        $( '#h' ).val(selection.height);
    }

*/
/**
 *
 * HTML5 Image uploader with Jcrop
 *
 * Licensed under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 * 
 * Copyright 2012, Script Tutorials
 * http://www.script-tutorials.com/
 */
/*
// convert bytes into friendly format
function bytesToSize(bytes) {
    var sizes = ['Bytes', 'KB', 'MB'];
    if (bytes == 0) return 'n/a';
    var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
    return (bytes / Math.pow(1024, i)).toFixed(1) + ' ' + sizes[i];
};

// check for selected crop region
function checkForm() {
    if (parseInt($('#w').val())) return true;
    alert('Please select a crop region and then press Upload');
    return false;
};

// update info by cropping (onChange and onSelect events handler)
function updateInfo(e) {
    $('#x1').val(e.x);
    $('#y1').val(e.y);
    $('#x2').val(e.x2);
    $('#y2').val(e.y2);
    $('#w').val(e.w);
    $('#h').val(e.h);
};

// clear info by cropping (onRelease event handler)
function clearInfo() {
    $('.info #w').val('');
    $('.info #h').val('');
};


function fileSelectHandler() {

    // get selected file
    var oFile = $('#member_file')[0].files[0];
console.log("AAA");
console.log(oFile);
console.log("AAA");

    // hide all errors
    $('.error').hide();

    // check for image type (jpg and png are allowed)
    var rFilter = /^(image\/jpeg|image\/png)$/i;
    if (! rFilter.test(oFile.type)) {
        $("#member_setting_mask").fadeOut();
        alert('Please select a valid image file (jpg and png are allowed)').show();
        return;
    }

    // check for file size
    if (oFile.size > 250 * 1024) {
        $("#member_setting_mask").fadeOut();
        alert('You have selected too big file, please select a one smaller image file').show();
        return;
    }

    // preview element
    var oImage = document.getElementById('preview');
	console.log("HELLO");
	console.log(oImage);
    // prepare HTML5 FileReader
    var oReader = new FileReader();
        oReader.onload = function(e) {

        // e.target.result contains the DataURL which we can use as a source of the image
        oImage.src = e.target.result;
        oImage.onload = function () { // onload event handler
			// display some basic image info
            var sResultFileSize = bytesToSize(oFile.size);
            $('#filesize').val(sResultFileSize);
            $('#filetype').val(oFile.type);
            $('#filedim').val(oImage.naturalWidth + ' x ' + oImage.naturalHeight);

            // Create variables (in this scope) to hold the Jcrop API and image size
            var jcrop_api, boundx, boundy;

            // destroy Jcrop if it is existed
            if (typeof jcrop_api != 'undefined') 
                jcrop_api.destroy();
            
            // initialize Jcrop
            $('#preview').Jcrop({
                minSize: [140, 160], // min crop size
                aspectRatio : 1, // keep aspect ratio 1:1
                bgFade: true, // use fade effect
                bgOpacity: .3, // fade opacity
                onChange: updateInfo,
                onSelect: updateInfo,
                onRelease: clearInfo
            }, function(){

                // use the Jcrop API to get the real image size
                var bounds = this.getBounds();
                boundx = bounds[0];
                boundy = bounds[1];

                // Store the Jcrop API in the jcrop_api variable
                jcrop_api = this;
            });
        };
    };

    // read selected file as DataURL
    oReader.readAsDataURL(oFile);
}

*/
