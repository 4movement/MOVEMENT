<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php session_start(); ?>
<html>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	
	</head>
	
		<span>帳號：</span>
		<input type="text" name="id" id="id"/> 
	    <br/>
		<span>密碼：</span>
		<input type="password" name="pw" id="pw" maxlength="20" />
	    <br/>
		<input type="submit" id="submit" name="submit" value="登入" />
		<a href="register.php">申請帳號</a>
	
		<div id="msg"> </div>
	<a href="FB_auth_check.php">FB_login.php</a>
	
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script>
		function checkidpw(){
			var id=document.getElementById('id');
			var pw=document.getElementById('pw');
			if(id.value==''){
				alert('請輸入帳號');	
				id.focus();	
				return false;
			}
			if(pw.value==''){
				alert('請輸入密碼');	
				pw.focus();	
				return false;
			}
		}
	</script>
	
	<script type="text/javascript">
		$(document).ready(function () {
		  $('#submit').click(function (){
		         $.ajax({
		         url: 'connect.php',
		         cache: false,
		         dataType: 'html',
		             type:'post',
		         data : {
		         	id : $('#id').val(),pw : $('#pw').val()
		         	},
		         error: function(xhr) {
		           alert('Ajax request 發生錯誤');
		         },
		         success: function(response) {
		                   $('#msg').html(response);
		         }
		     });
		  });
		
		})

	</script>
	
	
	
	
</html>
