<?
// get variables
$imgfile = $_GET['image'];
$cropStartX = $_GET['cropStartX'];
$cropStartY = $_GET['cropStartY'];
$cropW = $_GET['cropWidth'];
$cropH = $_GET['cropHeight'];
$crop = $_GET['crop'];

echo "<script>";
echo "console.log('hello');";
echo "console.log('$crop');";
echo "</script>";
// Create two images
$origimg = imagecreatefromjpeg($imgfile);
$cropimg = imagecreatetruecolor($cropW,$cropH);

// Get the original size
list($width, $height) = getimagesize($imgfile);

// Crop
imagecopyresized($cropimg, $origimg, 0, 0, $cropStartX, $cropStartY, $width, $height, $width, $height);
$ext = substr($crop, strrpos($crop, '.') + 1);
if($ext=="jpg" || $ext=="jpeg"){
	imagejpeg($cropimg, "images/".$crop);
}
else if($ext=="png"){
	header('Content-Type: image/png');
	imagepng($cropimg, "images/".$crop);	
}


/*
// force download nes image
header("Content-type: image/jpeg");
header('Content-Disposition: attachment; filename="'.$imgfile.'"');
imagejpeg($cropimg);
*/

// destroy the images
imagedestroy($cropimg);
imagedestroy($origimg);
?>
