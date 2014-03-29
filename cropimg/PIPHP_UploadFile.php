<?php // Plug-in 11: Upload File

// This is an executable example with additional code supplied
// To obtain just the plug-ins please click on the Download link
// You will need a jpg of under 100Kb on your PC for testing

echo <<<_END
<form method="post"  action="$_SERVER[PHP_SELF]"
     enctype="multipart/form-data">
<input  type="hidden"  name="flag" value="1" />
<input  type="file"    name="test" />
<input  type="submit" value="Upload" /></form>
_END;

if (isset($_POST['flag']))
{
   $result = PIPHP_UploadFile("test",
      array("image/jpeg", "image/pjpeg"), 100000);

   if ($result[0] == 0)
   {
      file_put_contents("test.jpg", $result[2]);
      echo "File received with the type '$result[1]' and saved ";
      echo "as <a href='test.jpg'>test.jpg</a><br />";
   }
   else
   {
      if ($result[0] == -2) echo "Wrong file type<br />";
      if ($result[0] == -3) echo "Maximum length exceeded<br />";
      if ($result[0] > 0)   echo "Error code: $result<br />";
      echo "File upload failed<br />";
   }
}

function PIPHP_UploadFile($name, $filetypes, $maxlen)
{
   // Plug-in 11: Upload File
   //
   // This plug-in saves an uploaded file to the hard disk
   // The arguments required are:
   //
   //    $name:      Name of form field used to upload file
   //    $filetypes: Array of Accepted mime types
   //    $maxlen:    Maximum allowable file size
   //
   // The plug-in returns a three-element array, the first of
   // which has one of the following numeric values:
   //     0 = Success
   //    -1 = Upload failed
   //    -2 = Wrong file type
   //    -3 = File too large
   //     1 = File exceeds upload_max_filesize defined in php.ini
   //     2 = File exceeds MAX_FILE_SIZE directive in HTML form
   //     3 = File was only partially uploaded
   //     4 = No file was uploaded
   //     6 = PHP is missing a temporary folder
   //     7 = Failed to write file to disk
   //     8 = File upload stopped by extension
   //
   // Upon success, the second element of the returned
   // array contains the uploaded file type and the third
   // the contents of the file.
   
   if (!isset($_FILES[$name]['name']))
      return array(-1, NULL, NULL);

   if (!in_array($_FILES[$name]['type'], $filetypes))
      return array(-2, NULL, NULL);
 
   if ($_FILES[$name]['size'] > $maxlen)
      return array(-3, NULL, NULL);

   if ($_FILES[$name]['error'] > 0)
      return array($_FILES[$name]['error'], NULL, NULL);
      
   $temp = file_get_contents($_FILES[$name]['tmp_name']);
   return array(0, $_FILES[$name]['type'], $temp);
}

?>
