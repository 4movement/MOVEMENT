<?php session_start(); ?>
<?php
include("mysql_connect.php");

$No = $_SESSION['No'];
$username = $_POST["username"];
$pw = $_POST["pw"];
$email = $_POST["email"];
$birth = $_POST["birth"];
$gender = $_POST["gender"];
$address = $_POST["address"];
$username_public = $_POST["username_public"];
$email_public = $_POST["email_public"];
$birth_public = $_POST["birth_public"];
$gender_public = $_POST["gender_public"];
$address_public = $_POST["address_public"];


$sql = "select * from mem_db where No = '$No'";
$result = mysql_query($sql);
$row = @mysql_fetch_array($result);


$modify = array();

if($No == $row[No]){
		
		$update_member_db = "UPDATE mem_db SET username='$username',
		pw='$pw',email='$email',birth='$birth',gender='$gender',
		address='$address',username_public='$username_public',
		email_public='$email_public',birth_public='$birth_public',
		gender_public='$gender_public',address_public='$address_public' WHERE No='$No'";
		mysql_query($update_member_db);
		
		$modify['username']=$username;
		$modify['pw']=$pw;
		$modify['email']=$email;
		$modify['birth']=$birth;
		$modify['gender']=$gender;
		$modify['address']=$address;
		$modify['username_public']=$username_public;
		$modify['email_public']=$email_public;
		$modify['birth_public']=$birth_public;
		$modify['gender_public']=$gender_public;
		$modify['address_public']=$address_public;
		
		echo json_encode($modify);
		return;
		
}
?>
