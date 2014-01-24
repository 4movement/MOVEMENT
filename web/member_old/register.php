<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<head>
	<script>
		function check(){
			var id=document.getElementById('id');
			var pw=document.getElementById('pw');
			var pwcheck=document.getElementById('pwcheck');
			var username=document.getElementById('username');
			var nickname=document.getElementById('nickname');
			var email=document.getElementById('email');
			
			
			if(username.value==''){
				alert('請輸入真實姓名');	
				username.focus();	
				return false;
			}
			if(nickname.value==''){
				alert('請輸入暱稱');	
				nickname.focus();	
				return false;
			}
			checkemail = /^[^\s]+@[^\s]+\.[^\s]{2,3}$/;
			if(email.value==''){
				alert('請輸入email');	
				email.focus();	
				return false;
			}
			else if(!checkemail.test(email.value)){
				alert('輸入的email格式不對');
				email.focus();
				return false;
			}
			if(id.value==''){
				alert('請輸入帳號');	
				id.focus();	
				return false;
			}
			else if(id.value.length<=3){
				alert('帳號長度請大於3個字');
				id.focus();
				return false;
			}
			if(pw.value==''){
				alert('請輸入密碼');	
				pw.focus();	
				return false;
			}
			else if(pw.value.length<=3){
				alert('密碼請大於3個字');
				pw.focus();
				return false;
			}
			if(pwcheck.value==''){
				alert('請輸入確認密碼');	
				pwcheck.focus();	
				return false;
			}
			else if(pwcheck.value!=pw.value){
				alert('您的密碼與確認密碼不同');
				pw.focus();
				return false;
			}
			
		}
	</script>
	
	
	
</head>

<form name="form" method="post" action="register_new.php?<?php $FB_id = $_GET["FB_id"]; echo "FB_id=$FB_id";?>" onsubmit="return check();">
	真實姓名：<input type="text" name="username" id="username" maxlength="30"/> <br />
	暱稱：<input type="text" name="nickname" id="nickname" maxlength="30"/> <br />
	email：<input type="text" name="email" id="email" maxlength="50"/> <br />
	帳號：<input type="text" name="id" id="id" maxlength="20"/> <br />
	密碼：<input type="password" name="pw" id="pw" maxlength="30"/> <br />
	確認密碼：<input type="password" name="pwcheck" id="pwcheck" maxlength="30"/> <br />
	<img src="captcha/code.php" id="captcha">
	請輸入驗證碼：<input type="text" name="Turing" size="10" maxlength="3" /><br>
	<a href="#" onclick="document.getElementById('captcha').src = document.getElementById('captcha').src + '?' + (new Date()).getMilliseconds()">看不清楚嗎?按此重新整理圖片</a><br>

	<input type="submit" name="button" id="button" value="送出"/>
</form>
