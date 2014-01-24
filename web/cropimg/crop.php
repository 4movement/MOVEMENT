<?
	require_once('PIPHP_ImageCrop.php');

    $json_str=json_decode($_POST['data']);

    $x=$json_str->x1;
    $y=$json_str->y1;
    $scale=$json_str->scale;
    $cropWidth=$json_str->cropWidth;
    $cropHeight=$json_str->cropHeight;
    $path=$json_str->path;
    $filename=$json_str->name;
    $tofilename=iconv("utf-8","gb2312",$filename);

    $realX=$x/$scale;
    $realY=$y/$scale;
    $realWidth=$cropWidth/$scale;
    $realHeight=$cropHeight/$scale;
    $cropedImage=PIPHP_ImageCrop('http://'.$_SERVER['SERVER_NAME'].'/'.$path, $realX, $realY, $realWidth, $realHeight);
    $targetDir='avatar/';
    $targetFile=$targetDir.$tofilename;

    imagejpeg($cropedImage,$_SERVER['DOCUMENT_ROOT'].$targetFile);
    echo $targetDir.$filename.'?'. time() ;
?>
