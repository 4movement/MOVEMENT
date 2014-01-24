<?
// get variables
$imgfile = $_GET['image'];
$cropStartX = $_GET['cropStartX'];
$cropStartY = $_GET['cropStartY'];
$cropW = $_GET['cropWidth'];
$cropH = $_GET['cropHeight'];
$crop = $_GET['crop'];

// Create two images
$origimg = imagecreatefromjpeg($imgfile);
$cropimg = imagecreatetruecolor($cropW, $cropH);

// Get the original size
list($width, $height) = getimagesize($imgfile);

// Crop
imagecopyresized($cropimg, $origimg, 0, 0, $cropStartX, $cropStartY, $width, $height, $width, $height);
$dest = "photo_temp/cropped_photo/";
$crop = $dest.substr($crop, strrpos($crop, '/') + 1);
$ext = substr($crop, strrpos($crop, '.') + 1);
if ($ext == "jpg" || $ext == "jpeg") {
    imagejpeg($cropimg, $crop);
} else if ($ext == "png") {
    imagepng($cropimg, $crop);
}

echo $crop;

imagedestroy($cropimg);
imagedestroy($origimg);
?>
