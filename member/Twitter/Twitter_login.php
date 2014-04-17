<?
$code = $_REQUEST['code'];
if ($code!=200) {
    echo "<script type='text/javascript'>";
    echo "opener.Twitter_login_data('" . json_encode($error) . "');";
    echo "self.close();";
    echo "</script>";
} else {
	
	$client_id = "1568080434.apps.googleusercontent.com";
	$client_secret = "PuebLoAyOkCGS2INgpiDSEeQl3iIwtmvD37u04fwo";
	$redirect_uri = "http://movement.ee.ncku.edu.tw/member/Twitter/Twitter_login.php";
	
    $Google_result = array();

    $get_accesstoken_url = "https://accounts.google.com/o/oauth2/token";
	$token_post = array(
	    "code" => $code,
	    "client_id" => $client_id,
	    "client_secret" => $client_secret,
	    "redirect_uri" => $redirect_uri,
	    "grant_type" => "authorization_code"
	);

    //抓資訊
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_URL, $get_accesstoken_url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $token_post);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    $auth = json_decode($response);
	
	$access_token = $auth->access_token;
	
	$_SESSION['access_token'] = $access_token;

	
    $get_url = "https://www.googleapis.com/oauth2/v1/userinfo?access_token=" . $access_token;
    

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $get_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //curl_setopt($ch, CURLOPT_HEADER, array('Authorization: Bearer' . $access_token ));
    $get_response = curl_exec($ch);
    curl_close($ch);
    $user = json_decode($get_response);
	
	
    $Google_id = $user->id;
    $Google_name = $user->name;
    $Google_email = $user->email;
	$Google_photo = $user->picture;
    $Google_result["username"] = $Google_name;
    $Google_result["email"] = $Google_email;
    include ("../mysql_connect.php");
	

    if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && isset($_SERVER['HTTP_VIA'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
	
	$checkGoogleid = "Select * From mem_db Where Google_id = '$Google_id'";
	$result = mysql_query($checkGoogleid);

	
    if ($row = mysql_fetch_array($result)) {
		
        //紀錄登入次數
        $row[times]++;
        $times = "update mem_db set times='$row[times]' where Google_id= '$row[Google_id]'";
        mysql_query($times);
        $TW_times = date("Y-m-d H:i:s", mktime(date('H'), date('i'), date('s'), date('m'), date('d'), date('Y')));
        $time_query = "update mem_db set last_login_time='$TW_times' where Google_id='$row[Google_id]'";
        mysql_query($time_query);
        $ip_query = "update mem_db set ip='$ip' where Google_id= '$row[Google_id]'";
        mysql_query($ip_query);
		$photo=$row["photo"];
		$No=$row["No"];
		$Google_result["username"]=$row["username"];//資料庫裡的username
		$Google_result["email"]=$row["email"];//資料庫裡的email
		$Google_result["gender"]=$row["gender"];
		$Google_result["birth"]=$row["birth"];
		$Google_result["address"]=$row["address"];
		
		$Google_result["msg"] = $Google_name . " ,您好~ 歡迎回來!!";

    } else {
        $TW_times = date("Y-m-d H:i:s", mktime(date('H'), date('i'), date('s'), date('m'), date('d'), date('Y')));

        $sql = "INSERT INTO mem_db (username,email,Google_id,verify,ip,register_time) VALUES ('$Google_name','$Google_email','$Google_id','1','$ip','$TW_times')";
        $result = mysql_query($sql);
		$Google_result["msg"] = $Google_name . " ,您好~ 謝謝您的註冊!!";
		$No=mysql_insert_id();
		$photo=0;

    }
    $_SESSION['check_login'] = 1;
    $_SESSION['No'] = $No;
    $Google_result['check_login'] = 1;
	$Google_result["photo"] = $Google_photo;
	$Google_result["No"] = $No;
		
	//$Google_result["state"] = "true";
    $output = json_encode($Google_result);
    echo "<script type='text/javascript'>";
    echo "opener.google_login_data('$output');";
    echo "self.close();";
    echo "</script>";
}
?>
