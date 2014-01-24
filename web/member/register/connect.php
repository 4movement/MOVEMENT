<?php session_start(); ?>
<?php
include("../mysql_connect.php");
$id = $_POST["id"];
$pw = $_POST["pw"];


$sql = "select * from mem_db where id = '$id'";
$result = mysql_query($sql);
$row = @mysql_fetch_array($result);

$login_result = array();

if( md5($pw) == $row[pw] && $id == $row[id] /*&& $pw == $row[pw]*/){
        header('Content-Type: application/json; charset=utf-8');
		$_SESSION['No'] = $row['No'];        
		$_SESSION['id'] = $id;
		$_SESSION['check_login'] = 1;
		//紀錄登入次數
		$row[times]++;
		$times = "update mem_db set times='$row[times]' where id='$id'";
		mysql_query($times);
		$TW_times=date("Y-m-d H:i:s", mktime(date('H'), date('i')+36, date('s'), date('m'), date('d'), date('Y')));
		$time_query="update mem_db set last_login_time='$TW_times' where id='$id'";
		mysql_query($time_query);
		if($row[verify]==0){
			/*echo "<script type='text/javascript'>";
			echo "alert('您的帳號尚未認證，請至申請信箱開啟帳號以便使用更多功能，謝謝!');";
			echo "window.location.href = 'welcome.php';";
			echo "</script>";
            echo "Username: $row[username], Nickname: $row[nickname], 您好<br>";
            echo "登入次數 : $row[times]<br>";
            echo $_SESSION['foremailid'];*/
            
            $login_result["result"] = "success";
            $login_result["msg"] = "您的帳號尚未認證，請至申請信箱開啟帳號以便使用更多功能，謝謝!";
            
		}

		/*
		echo "<a href='logout.php'>登出</a></br>";
		if($_SESSION['check_login']==1){
			echo "ckeck success";
		}
		*/
			
        	$login_result["result"] = "success";
        	$login_result["msg"] = $row["username"] . " 您好, 歡迎回來!!";
			$login_result["No"] = $row[No];
		    $login_result["username"] = $row[username];
            $login_result["nickname"] = $row[nickname];
            $login_result["count"] = $row[times];
            echo json_encode($login_result);
            return;
}
else{		
		/*echo "<script type='text/javascript'>";
		echo "alert('輸入的帳號密碼有誤');";
		echo "window.location.href = 'login.php';";
		echo "</script>";*/
        
            $login_result["result"] = "fail";
            $login_result["msg"] = "輸入的帳號密碼有誤";
            echo json_encode($login_result);
            return;
		
}
?>
