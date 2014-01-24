<?

// -------------------------------------------------------------------------------------
// Captcha Genie PHP Image Displaying Script.
// Copyright (c) 2010 Alexandru Marias. All rights reserved
// Web: http://www.captchagenie.com
// Phone: +40722486348
// ----------------------------------------------------------------

session_start();

include("configuration.php"); // Security functions

function RandomCode($CType, $min,$max) // Chose the turing code
{
// Choosing a random Security Code
Global $CSrc;  // CSrc contains the characters from which the Captcha Code will be generated

if ($CType == 0)
	{
	// letters and numbers
	$srclen = strlen($CSrc)-1;

	// Chose the length of the turing code
	$length = mt_rand($min,$max); // Between 4 and 8 chars

	$Code = '';

	// Fill the turing string with characters and numbers from $src
	for($i=0; $i<$length; $i++) 
		$Code .= substr($CSrc, mt_rand(0, $srclen), 1);
		
	$turing = $Code;
	}

if ($CType == 1)
	{
	// Math
	$Operand1 = mt_rand($min,$max);
	$Operand2 = mt_rand($min,$max);

	$Operation = mt_rand(1,2);
	
	if ($Operation == 1)
		{
		// Adition
		$Code = $Operand1 . ' + ' . $Operand2 . ' = ';
		$turing = $Operand1 + $Operand2;
		}

	if ($Operation == 2)
		{
		// Substraction
		if ($Operand1 < $Operand2)
			{
			$c = $Operand1;
			$Operand1 = $Operand2;
			$Operand2 = $c;
			}
		$Code = $Operand1 . ' - ' . $Operand2 . ' = ';
		$turing = $Operand1 - $Operand2;
		}
	}

// Put it in session
$_SESSION['turing_string'] = $turing; 

return $Code;

}

$turing = RandomCode($CType, $CMinSize,$CMaxSize);

                 
switch ($captcha_type) {
case 1:
    
if ($CFontUsed == 1 ) {
$i=0;
if ($handle = opendir($fonts_dir)) 
	{
    	while (false !== ($file = readdir($handle))) 
        	if ($file != "." && $file != "..") {
            	$fontl[$i] = $fonts_dir . '/' . $file;
		$i++;
        	}   
	closedir($handle);
    	}
$FontsNo=$i;

$fontno = mt_rand(0,$FontsNo-1);
$font = $fontl[$fontno];
}
	else $font = $CFontURL;
                 
/* initialize variables */

$length = strlen($turing);
$data = array();
$image_width = $image_height = 0;


/* build the data array of the characters, size, placement, etc. */

for($i=0; $i<$length; $i++) {

  $char = substr($turing, $i, 1);

  $size = mt_rand($CFontSizeMin, $CFontSizeMax);
  $angle = mt_rand($CFontRotMin, $CFontRotMax);

  $bbox = ImageTTFBBox( $size, $angle, $font, $char );

  $char_width = max($bbox[2], $bbox[4]) - min($bbox[0], $bbox[6]);
  $char_height = max($bbox[1], $bbox[3]) - min($bbox[7], $bbox[5]);

  $image_width += $char_width + $CFontPadding;
  $image_height = max($image_height, $char_height);

  $data[] = array(
    'char'    => $char,
    'size'    => $size,
    'angle'    => $angle,
    'height'  => $char_height,
    'width'    => $char_width,
  );
}

/* calculate the final image size, adding some padding */

$x_padding = 12;    

if ( $CSize == 1 )
	{
	$image_width += ($x_padding * 2);
	$image_height = ($image_height * 1.5) + 2;
	}
   else {
	$image_width = $CSizeWidth;
	$image_height = $CSizeHeight;
	}


/* build the image, and allocte the colors */

$im = ImageCreate($image_width, $image_height);
$cs = mt_rand(1,3);

if ($CBackgroundType == 2)
	{
	$r = hexdec(substr($CBackgroundColor,1,2));
	$g = hexdec(substr($CBackgroundColor,3,2));
	$b = hexdec(substr($CBackgroundColor,5,2));
	}

else
	{

$d1 = $d2 = $d3 = 0;
while ( ($d1<50) AND ($d2<50) AND ($d3<50) )
	{
	$r = mt_rand(200,255);
	$g = mt_rand(200,255);
	$b = mt_rand(200,255);

	$d1 = abs($r-$g);
	$d2 = abs($r-$b);
	$d3 = abs($g-$b);
	}     
	}

$color_bg    = ImageColorAllocate($im, $r, $g, $b );

$color_border  = ImageColorAllocate($im, round($r/2), round($g/2), round($b/2));

$color_line0  = ImageColorAllocate($im, round($r*0.85), round($g*0.85), round($b*0.85) );

$color_elipse0  = ImageColorAllocate($im, round($r*0.95), round($g*0.95), round($b*0.95) );
$color_elipse1  = ImageColorAllocate($im, round($r*0.90), round($g*0.90), round($b*0.90) );

	$d1 = mt_rand(0,50);
	$d2 = mt_rand(0,50);
	$d3 = mt_rand(0,50);

$color_line1  = ImageColorAllocate($im, $r-$d1, $g-$d2, $b-$d3 );

$d1 = $d2 = $d3 = 0;
while ( ($d1<100) AND ($d2<100) AND ($d3<100) )
	{
	$r = mt_rand(0,150);
	$g = mt_rand(0,150);
	$b = mt_rand(0,150);

	$d1 = abs($r-$g);
	$d2 = abs($r-$b);
	$d3 = abs($g-$b);
	}

switch ( $CFontColorType ) 
	{
	case 1 : $color_text    = ImageColorAllocate($im, $r, $g, $b );
		break;
	case 2 : $color_text    = ImageColorAllocate($im, 0, 0, 0 );
		break;
	case 3 : $color_text    = ImageColorAllocate($im, 255, 255, 255 );
		break;
	case 4 : 
		$color_text_r = hexdec(substr($CFontColor,1,2));
		$color_text_g = hexdec(substr($CFontColor,3,2));
		$color_text_b = hexdec(substr($CFontColor,5,2));
		$color_text    = ImageColorAllocate($im, $color_text_r, $color_text_g, $color_text_b );
		break;
	}

$noiset = mt_rand(1,2);
      
if ( $CBackgroundType == 1 )
	{

switch ($noiset) {
	case '1' :
		/* make the random background elipses */
	for($l=0; $l<10; $l++) {

  		$c = 'color_elipse' . ($l%2);

		$cx = mt_rand(0, $image_width);
  		$cy = mt_rand(0, $image_width);
  		$rx = mt_rand(10, $image_width);
  		$ry = mt_rand(10, $image_width);

		ImageFilledEllipse($im, $cx, $cy, $rx, $ry, $$c );
  		}; break;
	case '2' :
		/* make the random background lines */
		for($l=0; $l<10; $l++) {

		$c = 'color_line' . ($l%2);

 	  	$lx = mt_rand(0, $image_width+$image_height);
  		$lw = mt_rand(0,3);
  		if ($lx > $image_width) {
    		  $lx -= $image_width;
    		  ImageFilledRectangle($im, 0, $lx, $image_width-1, $lx+$lw, $c );
  		   } else ImageFilledRectangle($im, $lx, 0, $lx+$lw, $image_height-1, $c );
  		}; break;
	} // end switch  

	}

if ( $CBackgroundType == 0 )
	{
  	$image_data=getimagesize($CBackgroundFile);

  	$image_type=$image_data[2];

  	if($image_type==1) $img_src=imagecreatefromgif($CBackgroundFile);
  	elseif($image_type==2) $img_src=imagecreatefromjpeg($CBackgroundFile);
  	elseif($image_type==3) $img_src=imagecreatefrompng($CBackgroundFile);

		if ( $CBackgroundFillType == 1 ) {
					  imagesettile($im,$img_src);
					  imagefill($im,0,0,IMG_COLOR_TILED);
					}
		else imagecopyresampled($im,$img_src,0,0,0,0,$image_width,$image_height,$image_data[0],$image_data[1]);
	
	}
      
/* output each character */

$pos_x = $x_padding + ($CFontPadding / 2);
foreach($data as $d) {

  $pos_y = ( ( $image_height + $d['height'] ) / 2 );
  ImageTTFText($im, $d['size'], $d['angle'], $pos_x, $pos_y, $color_text, $font, $d['char'] );

  $pos_x += $d['width'] + $CFontPadding;

}

  //$sr = array('68', '101', '109', '111', '32', '86', '101', '114', '115', '105', '111', '110');

for ($i=0;$i<=count($sr);$i++)
  ImageTTFText($im, 12, 0, 10+ ($i*10), 10, $color_text, $font, chr($sr[$i]) );

if ($CNoise == 1)
	{
	
	$color_noise_r = hexdec(substr($CNoiseColor,1,2));
	$color_noise_g = hexdec(substr($CNoiseColor,3,2));
	$color_noise_b = hexdec(substr($CNoiseColor,5,2));
	$color_noise  = ImageColorAllocate($im, $color_noise_r, $color_noise_g, $color_noise_b);

	if ($CNoiseType == 0)
		$CNoiseType = mt_rand(1,4);

	for ($i=1;$i<10;$i++)
		switch ($CNoiseType)
			{
			case 1 : 
				// draw lines
				$direction = mt_rand(0,1);

				if ($direction == 0 ) 
					{
					// horizontal line
					$x1 = 0;
					$x2 = $image_width;
					$y1 = $y2 = mt_rand(0, $image_height);
					}

				if ($direction == 1 )
					{
					// vertical line
					$y1 = 0;
					$y2 = $image_height;
					$x1 = $x2 = mt_rand(0, $image_width);
					}
				
				imageline ($im, $x1, $y1, $x2, $y2, $color_noise );
			    break;
		       case 2 : 
		       		// draw circles
		       		$cx = mt_rand(0, $image_width);
				$cy = mt_rand(0, $image_height);
				$width = mt_rand(0, $image_width * 2);
				$height = mt_rand(0, $image_height * 2);
			    	imageellipse($im, $cx, $cy, $width, $height, $color_noise );
			    break;
			case 3 : 
				// draw triangles 
				$x1 = mt_rand(0, $image_width);
				$y1 = mt_rand(0, $image_height);

				$x2 = mt_rand(0, $image_width);
				$y2 = mt_rand(0, $image_height);

				$x3 = mt_rand(0, $image_width);
				$y4 = mt_rand(0, $image_height);

				imageline ($im, $x1, $y1, $x2, $y2, $color_noise );
				imageline ($im, $x2, $y2, $x3, $y3, $color_noise );
				imageline ($im, $x3, $y3, $x1, $y1, $color_noise );
			    break;
			case 4 : 
				// draw lines
				$x1 = mt_rand(0, $image_width);
				$y1 = mt_rand(0, $image_height);

				$x2 = mt_rand(0, $image_width);
				$y2 = mt_rand(0, $image_height);

				imageline ($im, $x1, $y1, $x2, $y2, $color_noise );
			    break;
			}
	

	}

/* a nice border */
      
ImageRectangle($im, 0, 0, $image_width-1, $image_height-1, $color_border);

/* display it */
  
switch ($output_type) {
 case 'jpeg':
  Header('Content-type: image/jpeg');
  ImageJPEG($im,NULL,100);
  break;

 case 'png':
 default:
  Header('Content-type: image/png');
  ImagePNG($im);
  break;
}
ImageDestroy($im);

break;

case 2:

break;

}

session_write_close();


 ?>
