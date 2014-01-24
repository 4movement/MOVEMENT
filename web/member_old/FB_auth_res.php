<? session_start(); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?
	$code = $_REQUEST['code'];
				
			$abc = "ABC";
			echo "<script type='text/javascript'>";
			echo "var a = '<?echo $response;?>';";
			echo "var abc = '<?echo $code;?>';";
			
			echo "console.log('hello');";
			echo "console.log(a);";
			echo "console.log(abc);";
			
			echo "</script>";
			
	$redirect_url = "http://merry.ee.ncku.edu.tw/~smart0eddie/mem/FB_auth_check.php";
	
	if($_GET["error_reason"]=="user_denied"){//使用者不同意APP
			header("Location:http://merry.ee.ncku.edu.tw/~smart0eddie/mem/login.php");
	}
	else if(empty($code)){
		$_SESSION['state'] = md5(uniqid(rand()));
		header("Location:https://www.facebook.com/dialog/oauth?
		    client_id=357084021063217
		    &redirect_uri=".urlencode($redirect_url).//使用者接觸FB的APP執行動作並到FB_auth_check確定使用者是否有確定或取消
		    "&state=".$_SESSION['state'].
		    "&response_type=code".
		    "&scope=user_website,email");
	}
	else{//使用者同意APP
		if($_SESSION['state']===$_REQUEST['state']){
			$register_url = "http://merry.ee.ncku.edu.tw/~smart0eddie/mem/FB_auth_check.php";
			$get_accesstoken_url = "https://graph.facebook.com/oauth/access_token?client_id=357084021063217".
				    "&redirect_uri=".urlencode($register_url).
				    "&client_secret=fcd49d763817498f868a050c30900d13".
				    "&code=".$code;
			//抓資訊
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $get_accesstoken_url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HEADER, false);
			$response = curl_exec($ch);
			curl_close($ch);
			
			//$response = file_get_contents($get_accesstoken_url);
			/*
			$abc = "ABC";
			echo "<script type='text/javascript'>";
			echo "var a = '<?echo $response;?>';";
			echo "var abc = '<?echo $code;?>';";
			
			echo "console.log('hello');";
			echo "console.log(a);";
			echo "console.log(abc);";
			
			echo "</script>";
			*/
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
				if($row[verify]==0){
					echo "<script type='text/javascript'>";
					echo "alert('您的帳號尚未認證，請至申請信箱開啟帳號以便使用更多功能，謝謝!');";
					echo "window.location.href = 'welcome.php';";
					echo "</script>";
				}
			}
			else{
				header("Location:http://merry.ee.ncku.edu.tw/~smart0eddie/mem/register.php?FB_id=$FB_id");
			}
			
	
		}
		else{
			echo "<script type='text/javascript'>";
			echo "alert('您無權限觀看此頁面');";
			echo "</script>";
		}
		
	}


?>
