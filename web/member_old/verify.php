<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?

include("mysql_connect.php");

	$verify_id = $_GET["verify_id"];
	$finalstr = $_GET["finalstr"];

	$findid = "select * from mem_db where id = '$verify_id'";
	$result = mysql_query($findid);
	$row = mysql_fetch_array($result);
	
	if($row[finalstr]==$finalstr){
		$setverify = "update mem_db set verify = 1 where id = '$verify_id'";
		mysql_query($setverify);
		echo "<script type='text/javascript'>";
		echo "alert('您的帳號啟用成功，請重新登入');";
		echo "window.location.href = 'login.php';";
		echo "</script>";
	}
	else{
		echo "Fail";
	}




?>
