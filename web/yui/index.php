<!DOCTYPE html>

<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.9.0/build/resize/assets/skins/sam/resize.css" />
		<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.9.0/build/imagecropper/assets/skins/sam/imagecropper.css" />
	</head>
		<body class="yui-skin-sam">
			<form action="upload.php" enctype="multipart/form-data" method="post" name="uploadForm" id="uploadForm">
				Image : <input type="file" name="uploadImage" id="uploadImage" />
				<input type="button" id="uploadButton" value="Upload"/>
			</form>
				<div id="imageContainer"></div>
			<div id="ac"></div>

		</body>

	
		<script type="text/javascript" src="http://yui.yahooapis.com/combo?2.5.2/build/yahoo-dom-event/yahoo-dom-event.js&2.5.2/build/dragdrop/dragdrop-min.js&2.5.2/build/element/element-beta-min.js&2.5.2/build/resize/resize-beta-min.js&2.5.2/build/imagecropper/imagecropper-beta-min.js&2.
		5.2/build/connection/connection-min.js&2.5.2/build/json/json-min.js"></script>
		<script type="text/javascript" src="js/vendor/jquery-1.9.1.min.js"></script>
		
		<script>
			
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
			function crop_submit(e){
				YAHOO.util.Event.preventDefault(e);
				YAHOO.util.Connect.setForm('CropForm', true);
				YAHOO.util.Connect.asyncRequest('POST', 'crop_submit.php', {
						success: function(o){
				            data = eval('(' + o.responseText + ')');
				            img6.setAttribute('src', data.img);
				            YAHOO.util.Dom.setStyle(img6, 'width', 'auto');
				            YAHOO.util.Dom.setStyle(img6, 'height', 'auto');
				            form6.parentNode.removeChild(form6);
							
						}
				});
			}
			// add listeners
			YAHOO.util.Event.on('crop_submit', 'click', crop_submit);
			*/
		</script>
		
</html>






