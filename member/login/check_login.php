<?php
session_start();
header("Access-Control-Allow-Origin: *");

$member_data = array();
header('Content-type: application/json');
// 將未登入者，導向至登入頁
if ( empty($_SESSION["No"]) || $_SESSION["check_login"]!=1){
	$member_data["OK"]="false";
	echo json_encode($member_data);
    return;
}
else{
	include("../mysql_connect.php");
	
	$No = $_SESSION["No"];
	
	$sql="SELECT * FROM mem_db WHERE No='$No'";
	$result=mysql_query($sql);
	$row=@mysql_fetch_array($result);
	
	if($No==$row["No"]){
		if(!empty($row["FB_id"])){//用FB登入的
			//$member_data["photo"]="https://graph.facebook.com/".$row["FB_id"]."/picture?width=300";
			$member_data["fblogin"]=true;
		}
		else if(!empty($row["Google_id"])){//用Google登入的
			//$member_data["photo"]= $photo;
			$member_data["googlelogin"]=true;
		}
		else{//一般登入的
			//$member_data["photo"]=$row["photo"];
			$member_data["fblogin"]=false;
			$member_data["googlelogin"]=false;
			$member_data["id"] = $row["id"];
		}
		$member_data["OK"]="true";
		$member_data["No"]=$row["No"];
		$member_data["username"]=$row["username"];//資料庫裡的username
		$member_data["email"]=$row["email"];//資料庫裡的email
		$member_data["gender"]=$row["gender"];
		if($row["birth"]!="0000-00-00"){
			$member_data["birth"]=$row["birth"];
		}
		$member_data["address"]=$row["address"];
		$member_data["username_public"] = $row["username_public"];
		$member_data["email_public"] = $row["email_public"];
		$member_data["birth_public"] = $row["birth_public"];
		$member_data["gender_public"] = $row["gender_public"];
		$member_data["address_public"] = $row["address_public"];

		
		
	}
	echo json_encode($member_data);
    return;
}
?>
