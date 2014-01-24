<?
	require_once("PIPHP_UploadFile.php");
	
		echo "<script>";
		echo "console.log('test');";
		echo "</script>";

	$response=array(
		"message"=>"未知上傳錯誤", 
		"path"=>"",
		"code"=>-4, //0成功-1不成功
		"width"=>400, 
		"height"=>400, 
		"scale"=>1, //比例尺
		"name"=>""
	);

	if(!empty($_FILES)){
		$name="picture";
		$uploadFile="http://merry.ee.ncku.edu.tw/~smart0eddie/swd_ex11/cropimg/uploads/";
		$maxLen=9*1024*1024;
		$result=PIPHP_UploadFIle($name,$uploadFile,$maxLen);
		
		$response["code"]=$result[0];
		
		//簡單回報成功情況
		if($result[0]==0){
			$response["message"]="上傳成功";
			//$response["message"]=$result[2];
			$response["path"]=$result[1];
			$response["name"]=$result[2];
			
			//得到圖像高度寬度
			$fileName=iconv("utf-8", "gb2312", $result[2]);
			list($width,$height)=getimagesize($_SERVER["DOCUMENT_ROOT"].$uploadFile.$fileName);
			$response["width"]=$width;
			$response["height"]=$height;	
		}
		else{
			switch($result[0]){
				case -1: $response["message"]="上傳失敗"; break;
				case -2: $response["message"]="副檔名有誤"; break;
				case -3: $response["message"]="檔案大小太大"; break;
				default: $response["message"]="錯誤代碼:$result[0]"; break;
			}
		}
	}
	else{
		$response["message"]="上傳文件出現錯誤";
	}
	$json_str=json_encode($response);
	echo $json_str;

?>
