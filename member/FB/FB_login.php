<?
$code = $_REQUEST['code'];
$error = $_GET["error_reason"];
$step = $_REQUEST["step"];

if ($error) {
    echo "<script type='text/javascript'>";
    echo "opener.fb_login_data('" . json_encode($error) . "');";
    echo "self.close();";
    echo "</script>";
} else {

    $FB_result = array();

    //$FB_result["code"] = $code;

    $get_accesstoken_url = "https://graph.facebook.com/oauth/access_token?client_id=357084021063217" . "&redirect_uri=http://merry.ee.ncku.edu.tw/~smart0eddie/cur/member/FB/FB_login.php" . "&client_secret=fcd49d763817498f868a050c30900d13" . "&code=" . $code;

    //抓資訊
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $get_accesstoken_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    $response = curl_exec($ch);

    //$FB_result["response"] = $response;
    curl_close($ch);

    //$response = file_get_contents($get_accesstoken_url);

    parse_str($response);
    $_SESSION['access_token'] = $access_token;
    $graph_url = "https://graph.facebook.com/me?access_token=" . $access_token;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $graph_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    $graph_response = curl_exec($ch);
    curl_close($ch);
    $user = json_decode($graph_response);

    //$user = json_decode(file_get_contents($graph_url));
    $FB_id = $user -> id;
    $FB_name = $user -> name;
    $FB_email = $user -> email;
    //$FB_result["FB_id"] = $FB_id;
    $FB_result["username"] = $FB_name;
    $FB_result["email"] = $FB_email;
	$FB_photo = "https://graph.facebook.com/".$FB_id."/picture?width=300";
    include ("../mysql_connect.php");


    if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && isset($_SERVER['HTTP_VIA'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
	
	$checkFBid = "Select * From mem_db Where FB_id = '$FB_id'";
	$result = mysql_query($checkFBid);

	
    if ($row = mysql_fetch_array($result)) {
		
        //紀錄登入次數
        $row[times]++;
        $times = "update mem_db set times='$row[times]' where FB_id= '$row[FB_id]'";
        mysql_query($times);
        $TW_times = date("Y-m-d H:i:s", mktime(date('H'), date('i'), date('s'), date('m'), date('d'), date('Y')));
        $time_query = "update mem_db set last_login_time='$TW_times' where FB_id='$row[FB_id]'";
        mysql_query($time_query);
        $ip_query = "update mem_db set ip='$ip' where FB_id= '$row[FB_id]'";
        mysql_query($ip_query);
		/**/
        $photo = "update mem_db set photo='$FB_photo' where FB_id= '$row[FB_id]'";
        mysql_query($photo);
        /**/
        $photo=$row["photo"];
		$No=$row["No"];
		$FB_result["username"]=$row["username"];//資料庫裡的username
		$FB_result["email"]=$row["email"];//資料庫裡的email
		$FB_result["gender"]=$row["gender"];
		$FB_result["birth"]=$row["birth"];
		$FB_result["address"]=$row["address"];
        $FB_result["username_public"]=$row["username_public"];
        $FB_result["email_public"]=$row["email_public"];
        $FB_result["birth_public"]=$row["birth_public"];
        $FB_result["gender_public"]=$row["gender_public"];
        $FB_result["address_public"]=$row["address_public"];
        
		$FB_result["msg"] = $FB_name . " ,您好~ 歡迎回來!!";

    } else {
        $TW_times = date("Y-m-d H:i:s", mktime(date('H'), date('i'), date('s'), date('m'), date('d'), date('Y')));

        $sql = "INSERT INTO mem_db (username,email,FB_id,verify,ip,register_time,'photo') VALUES ('$FB_name','$FB_email','$FB_id','1','$ip','$TW_times','$FB_photo')";
        $result = mysql_query($sql);
        $FB_result["msg"] = $FB_name . " ,您好~ 謝謝您的註冊!!";
		$No=mysql_insert_id();
		$photo=0;

    }
    $_SESSION['check_login'] = 1;
    $_SESSION['No'] = $No;
    $FB_result['check_login'] = 1;
	$FB_result["photo"] = $FB_photo;
	$FB_result["No"] = $No;
		
	//$FB_result["state"] = "true";
    $output = json_encode($FB_result);
    echo "<script type='text/javascript'>";
    echo "opener.fb_login_data('$output');";
    echo "self.close();";
    echo "</script>";
}
?>
