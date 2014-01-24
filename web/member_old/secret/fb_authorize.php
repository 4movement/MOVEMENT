<?php 

$app_id = "454265571317115";
$app_secret = "4a24ad917e4419a9c0307ead6057b0ea";
$my_url = "http://merry.ee.ncku.edu.tw/~wnd2cyc/swd/429v1/fb_authorize.php";


session_start();

$code = $_REQUEST["code"];

if(empty($code)){
  $_SESSION['state'] = md5(uniqid(rand(), TRUE)); // CSRF protection
  $dialog_url = "https://www.facebook.com/dialog/oauth?client_id=".$app_id.
    		"&redirect_uri=".urlencode($my_url).
		"&state=".$_SESSION['state'].
		"&scope=user_birthday,read_stream,,user_status,user_website,email";
  header("Location:".$dialog_url);
}

if( $_SESSION['state'] && ($_SESSION['state'] === $_REQUEST['state']) ){
  $token_url = "https://graph.facebook.com/oauth/access_token?".
    		"client_id=".$app_id.
		"&redirect_uri=".urlencode($my_url).
		"&client_secret=".$app_secret.
		"&code=".$code;
  $response = file_get_contents($token_url);
  $params = null;
  parse_str($response, $params);
  $_SESSION['access_token'] = $params['access_token'];
  $graph_url = "https://graph.facebook.com/me?access_token=".$params['access_token'];
  $user = json_decode(file_get_contents($graph_url));

  $fb_uid = $user->id;
  $fb_name = $user->name;
  $fb_email = $user->email;

  

  require_once("./db_conf.php");
  $result = mysql_query("SELECT * FROM z_SL_users WHERE fb_uid='$fb_uid'");
  $count = mysql_num_rows($result);
  $row = mysql_fetch_assoc($result);


  
  if( $count==1 ){
    $_SESSION['username'] = $row['username'];
    header("location:./");
  }
  else{
    header("location:./fb_signup.php?uid=$fb_uid");
  }
}
else{
  echo("The state does not match. You may be a victim of CSRF.");
}









?>
