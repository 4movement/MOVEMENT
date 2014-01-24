<?
	$code=$_REQUEST["code"];
	$FB_result = array();

	$FB_result["code"]=$code;

	$get_accesstoken_url = "https://graph.facebook.com/oauth/access_token?client_id=357084021063217".
	"&redirect_uri=http://merry.ee.ncku.edu.tw/~smart0eddie/mem/FB_login.php".
	"&client_secret=fcd49d763817498f868a050c30900d13".
	"&code=".$code;
	
	//抓資訊
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $get_accesstoken_url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HEADER, false);
	$response = curl_exec($ch);
	
	$FB_result["response"]=$response;
	curl_close($ch);

	//$response = file_get_contents($get_accesstoken_url);

	parse_str($response);
	$_SESSION['access_token'] = $access_token;
	$graph_url = "https://graph.facebook.com/me?access_token=".$access_token;

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $graph_url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HEADER, false);
	$graph_response = curl_exec($ch);
	curl_close($ch);
	$user = json_decode($graph_response);

	//$user = json_decode(file_get_contents($graph_url));
	$FB_id = $user->id;
	
	$FB_result["FB_id1"]=$FB_id;
	include("mysql_connect.php");

	$sql = "select * from mem_db where FB_id = '$FB_id'";
	$result = mysql_query($sql);

	if($row = mysql_fetch_array($result)){

		$_SESSION['id'] = $row['id'];
		$_SESSION['check_login'] = 1;
		//紀錄登入次數
		$row[times]++;
		$times = "update mem_db set times='$row[times]' where id= '$row[id]'";
		mysql_query($times);
		$TW_times=date("Y-m-d H:i:s", mktime(date('H'), date('i')+36, date('s'), date('m'), date('d'), date('Y')));
		$time_query="update mem_db set last_login_time='$TW_times' where id='$row[id]'";
		mysql_query($time_query);
		
		$FB_result["state"]="true";
		
		if($row[verify]==0){
			$FB_result["verify"]="false";
		}
		echo json_encode($FB_result);
        return;
	}
	else{
		$FB_result["state"]="false";
		$FB_result["FB"]=$FB_id;
		echo json_encode($FB_result);
		return;
	}
?>
