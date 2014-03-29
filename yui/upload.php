<?
if(!empty($_FILES["uploadImage"])) {
  	// get file name
	$filename = basename($_FILES['uploadImage']['name']);
		
	// get extension
  	$ext = substr($filename, strrpos($filename, '.') + 1);
  		
  	// check for jpg only
  	if ($ext == "jpg" || $ext == "jpeg" || $ext == "png") {
      		// generate unique file name
  		$newName = 'images/'.time().'.'.$ext;
		
  		// upload files
        	if ((move_uploaded_file($_FILES['uploadImage']['tmp_name'], $newName))) {
			
        		// get height and width for image uploaded
        		list($width, $height) = getimagesize($newName);
        		
        		// return json data
           		echo '{"image" : "'.$newName.'", "height" : "'.$height.'", "width" : "'.$width.'" }';
        	}
        	else {
        	    echo $_FILES['uploadImage']['tmp_name'];
           		echo '{"error" : "An error occurred while moving the files"}';
        	}
  	} 
  	else {
     		echo '{"error" : "Invalid image format"}';
  	}
}	
?>
