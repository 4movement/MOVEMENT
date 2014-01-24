<?php session_start(); ?>
<?
	
include("../mysql_connect.php");
		//驗證信
		srand((double)microtime()*1000000);
		$longstr = md5(uniqid(rand()));
		$ed = strlen($longstr)-8;
		$rat = rand(0,$ed);//0~24
		$finalstr = strtoupper(substr("$longstr",$rat,8));
		//產生信中快速認證連結
		$foremailid = $_SESSION['foremailid'];
		$chklink = "<a href = http://merry.ee.ncku.edu.tw/~smart0eddie/cur/member/register/verify.php?verify_id=$foremailid&finalstr=$finalstr>
		請點擊此認證</a>";
		$help = "<a href = http://merry.ee.ncku.edu.tw/~smart0eddie/cur/#help>
		請點擊此前往help專區</a>";
		//設定資料庫finalstr
		$setfinalstr = "update mem_db set finalstr = '$finalstr' where id = '$foremailid'";
		mysql_query($setfinalstr);

?>
