<?php session_start(); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
include("mysql_connect.php");
if($_SESSION['check_login']==1){
        echo '<a href="logout.php">登出</a><br>';
        //將會員資料顯示在畫面上
        $id = $_SESSION['id'];
        $sql = "SELECT * FROM mem_db where id = '$id'";
        $result = mysql_query($sql);
        $row = mysql_fetch_array($result);
        echo "Username: $row[username]<br>Nickname: $row[nickname]<br>";
		echo "登入次數 : $row[times]<br>";
		//echo $_SESSION['foremailid'];
}
else{
        echo "<script type='text/javascript'>";
		echo "alert('您無權限觀看此頁面');";
		echo "window.location.href = 'login.php';";
		echo "</script>";
}
?>
