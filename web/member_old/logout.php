<?php
session_start();
//將session清空
session_destroy();
	$login_result = array();
	$login_result["result"] = "success";
	$login_result["msg"] = "登出成功，歡迎再次光臨";

	header('Content-Type: application/json; charset=utf-8');
	echo json_encode($login_result);
	return;
?>
