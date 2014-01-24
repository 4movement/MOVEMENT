<?php session_start(); ?>
<?php
include("../mysql_connect.php");

$No = $_SESSION['No'];
$username = $_POST["username"];
$pw = $_POST["pw"];
$email = $_POST["email"];
$birth = $_POST["birth"];
$gender = $_POST["gender"];
$address = $_POST["address"];


$sql = "select * from mem_db where No = '$No'";
$result = mysql_query($sql);
$row = @mysql_fetch_array($result);


$modify = array();

if($No == $row[No]){
		
		$m_username = "update mem_db set username='$username' where No='$No'";
		mysql_query($m_username);
		$m_pw = "update mem_db set pw='$pw' where No='$No'";
		mysql_query($m_pw);
		$m_email = "update mem_db set email='$email' where No='$No'";
		mysql_query($m_email);
		$m_birth = "update mem_db set birth='$birth' where No='$No'";
		mysql_query($m_birth);
		$m_gender = "update mem_db set gender='$gender' where No='$No'";
		mysql_query($m_gender);
		$m_address = "update mem_db set address='$address' where No='$No'";
		mysql_query($m_address);
		
		$modify['username']=$username;
		$modify['pw']=$pw;
		$modify['email']=$email;
		$modify['birth']=$birth;
		$modify['gender']=$gender;
		$modify['address']=$address;
		
		echo json_encode($modify);
		return;
		
}
?>
