<?

include("mysql_connect.php");

$publisher_id=$_POST['No'];


$sql="SELECT * FROM mem_db WHERE No='$publisher_id'";

if($result=mysql_query($sql)){
	$row=@mysql_fetch_array($result);

	$data=array();
	$data['email']=$row['email'];
	$data['birth']=$row['birth'];
	$data['photo']=$row['photo'];
	echo json_encode($data);

}else{
	echo json_encode('get_publiser_info.php fail');
}




?>