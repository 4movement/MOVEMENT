<?php

session_start();

if( !empty($_SESSION['username']) )
  header("location:./");

if( $_POST['action']=='login' && $_POST['login_email']!=NULL && $_POST['login_password']!=NULL ){
  require_once("./db_conf.php");
  $login_email = trim($_POST['login_email']);
  $login_password = trim($_POST['login_password']);
  $login_password = md5($login_password);
  $result = mysql_query("SELECT * FROM z_SL_users WHERE email='$login_email' AND password='$login_password';");
  $count = mysql_num_rows($result);
  $row = mysql_fetch_assoc($result);
  if( $count==1 ){
    if( $row['account_verify']=='Y' ){
      $_SESSION['username'] = $row['username'];
      header("location:./");
    }
    else{
      echo '<script>
		alert("Unverified account!");
      		location.href="./login.php";
	</script>';
    }
  }
  else{
    echo '<script>
      		alert("NonValided email and password!");
    		location.href="./login.php";
	</script>';
  }
}

if( $_POST['action']=='signup' && $_POST['signup_username']!=NULL && $_POST['signup_email']!=NULL && $_POST['signup_password']!=NULL ){
  $signup_username = trim($_POST['signup_username']);
  $signup_email = trim($_POST['signup_email']);
  $signup_password = trim($_POST['signup_password']);
  $signup_password_md5 = md5($signup_password);
  $signup_time = date("Y-m-d H:i:s");
  require_once("./db_conf.php");
  require_once('./aes_conf.php');
  require_once('./PHPMailer_5.2.1/class.phpmailer.php');
  $result = mysql_query("SELECT * FROM z_SL_users WHERE email='$signup_email';");
  $count = mysql_num_rows($result);
  if( $count==0 ){
    $result = mysql_query("INSERT INTO z_SL_users SET username='$signup_username', email='$signup_email', password='$signup_password_md5', signup_time='$signup_time';");
    //建立轉碼物件
    $aes = new CryptAES("1010011518423013","af955cd2a0626b2c7f0988f20598d96f");
    //將email轉碼
    $s1 = $aes->encrypt($signup_email);
    //建立新物件 
    $mail= new PHPMailer();
    //設定使用SMTP方式寄信 
    $mail->IsSMTP();
    //設定SMTP需要驗證 
    $mail->SMTPAuth = true;
    //Gmail的SMTP主機需要使用SSL連線 
    $mail->SMTPSecure = "ssl"; 
    //Gamil的SMTP主機 
    $mail->Host = "smtp.gmail.com";
    //Gamil的SMTP主機的SMTP埠位為465埠。 
    $mail->Port = 465;
    //設定郵件編碼 
    $mail->CharSet = "UTF-8";
    //設定驗證帳號 
    $mail->Username = "secretlandteam@gmail.com";
    //設定驗證密碼 
    $mail->Password = "socialnetworkteam3";
    //設定寄件者信箱 
    $mail->From = 'wnd2cyc@gmail.com';
    //設定寄件者姓名 
    $mail->FromName = "Secret Land";
    //設定郵件標題 
    $mail->Subject = "Secret Land: Email Verification";
    //設定郵件內容為HTML 
    $mail->IsHTML(true);
    //設定收件者郵件及名稱 
    $mail->AddAddress($signup_email, $signup_username);
    //設定郵件內容 
    $mail->Body = "Welcome to Secret Land:<br/><br/>    
      You will have whole new experiences using this amazing social website.<br/><br/>
      Account: ".$signup_email."<br/>
      Password: ".$signup_password."<br/><br/>
      Please click the below link and verify your Secret Land account:<br/>
      <a href=\"http://merry.ee.ncku.edu.tw/~wnd2cyc/swd/502v2/verify.php?code=".$s1."\">Verify the account</a><br/><br/>
      Thank you<br/><br/>
      Secret Land, Best Regard<br/>";

    if( !$mail->Send() ){ 
      echo '<script>
	alert("Sign up fail");
      location.href="./login.php";
	</script>';
    } 
    else{ 
      echo '<script>
	alert("Sign up successfully.\nPlease check your email and verify your account.");
      location.href="./login.php";
      </script>';
    } 
  }
  else{
    echo '<script>
      alert("This email address has been used.");
    location.href="./login.php";
    </script>';
  }
}

?>


<html>

	<head>
		<meta charset="utf-8">
		<title>Secret Land</title>
		<style>
			@font-face{ font-family:Helvetica; src:url('./font/estre.ttf');}
			body{ margin: auto; background-image:url(./images/background.jpg); background-size:100%; }
			#page{ margin:0 auto; padding:0 0 40px 0; width:960px; }
			#header { height:90px; border-top:3px solid #000000; margin-top:8px; }
			#header div{ height:90px; }
			#SecretLand{ margin: 10px 0 0 0; float:left; position:relative; top:0; left:0; color:#333333; font-family: Helvetica; font-size:80px; word-spacing:25px; }
			#head_login{ margin-top:3px;	float:right; font-family: Helvetica; font-size: 16px; background-color: transparent; border: 0px; cursor: pointer; }
			#header dt{	float:right; margin-top:1px; }
			#head_newaccount{ margin-top:3px; float:right; font-family: Helvetica; font-size: 16px; background-color: transparent; border: 0px; cursor: pointer; }

			#menu{height:33px; border-top:1px solid #000000; border-bottom:1px solid #000000;}
			#menu button{ float:left; width:192px; height:33px; font-family: Helvetica;	font-size:20px;	background-color:transparent; border:0px; cursor: pointer; padding:0 0 0 0;}
			#menu #thispage{ background-color:#444;	color:White;}
			#menu button:hover{	background-color:#817d72; color:white;}

			footer{	width:960px; height:18px; float:left; margin:20px 0 20px 0;	border-bottom:3px solid #000000; }
			#bottom{ width:960px; float:left; }
			#bottom dl{	float:right; font-size:15px; font-family:Helvetica;	font-weight: bold; color:black;	margin:0 0 0 0; }
			#bottom dt{	font-family:Helvetica; display:inline; margin:0 0 0 0; word-spacing:0px; color:black; }
			#bottom dt a:link,#bottom dt a:visited{	color: black; text-decoration: none; }
			#bottom dt a:hover{	color:black; text-decoration: underline; }
			a:-webkit-any-link { color: -webkit-link; text-decoration: none; cursor: auto; }

			#content{  }
			#login{ height:210px; display:none; }
			#signup{ height:298px; display:none; }
			form{ margin:auto; padding:34px 0 0 316px; }
			.filling{ z-index:0; width:325px; outline:medium none;  margin:5px 0; padding:8px 0 8px 10px;  border-radius:9px; font-size:16px; border:0px solid white; box-shadow:6px 6px 25px 1px #777777; }
			#login_button{ width:160px; padding:6px 0; margin:10px 0 0 165px; float:center; background-image:-webkit-linear-gradient(#e98f4f,#e97818); color:white; font-weight:white; border:; border-radius:5px; box-shadow:3px 3px 25px 0px #777777; font-size:14px; }
			#facebook_login{ width:160px; padding:6px 0; margin:-32px 0 0 315px; float:center; background-image:-webkit-linear-gradient(#4a5f96,#223869); color:white; font-weight:white; border:; border-radius:5px; box-shadow:3px 3px 25px 0px #777777; font-size:14px; }
			#new_account{ color:#444; border:0; margin-left:31px; font-size:14px; font-family:Helvetica; background-color:transparent; cursor:pointer; }
			#new_account:hover{ text-decoration:underline; }
			#forget_password{ color:#444; border:0; font-size:14px; margin-left:10px; font-family:Helvetica; background-color:transparent; cursor:pointer; }
			#forget_password:hover{ text-decoration:underline; }
			#signup_button{ width:165px; padding:6px 0; margin:20px 0 0 85px; background-image:-webkit-linear-gradient(#e98f4f,#e97818); color:white; font-weight:white; border-radius:5px; box-shadow:3px 3px 25px 0px #777777; font-size:16px; }
			#remember_me{ color:#444; font-size:14px; font-family:Helvetica; }

			#feature{ font-family:"微軟正黑體"; height:463px; border-top:1px solid #444; }
			#feature h1{ font-size:24px; border-bottom:2px solid Black; margin:0 15px; padding:30px 0 0 0;  }
			#feature p{ padding:0 20px; text-align:left; }
			.explain{ width:320px; float:left; text-align:center; padding:25px 0 0 0; }
			#video_explain{ color:#89B600; }
			#postcard_explain{ color:#00B7A8; }
			#mymap_explain{ color:#E342B7; }

		</style>
	</head>

	<body>
		<div id="page">

			<div id="header">
				<a href="./" id='secretland'>Secret Land</a>
				<button id="head_newaccount">New Account</button>
				<dt>|</dt>  
				<button id="head_login">Sign In</button>  
			</div><!--/#header-->

			<div id="menu">
				<button onclick="javascript:self.location.href='./'">HOME</button>
				<button onclick="javascript:self.location.href='#'">SEARCH</button>
				<button onclick="javascript:self.location.href='#'">MY MAP</button>
				<button onclick="javascript:self.location.href='#'">POSTCARD</button>
				<button onclick="javascript:self.location.href='#'">TRIP</button>
			</div><!--/#menu-->

			<div id="content"><!--content-->
				<div id="login"><!--login-->
					<form action="login.php" method="post">
						<input class="filling" type="email" name="login_email" placeholder="Email" />
						<input class="filling" type="password" name="login_password" placeholder="Password" />
						<!--a><span id="forget_password">Forget Password?</span></a><br /-->
						<input type="hidden" name="action" value="login"/ >
						<button id="login_button" type="submit">Sign in</button>&nbsp;&nbsp;
						<!--input type="checkbox" name="remember_me" value="remember" /><span id="remember_me">Remember me</span-->
					</form>
						<button id="facebook_login" onclick="javascript:self.location.href='./fb_authorize.php'">Sign in with Facebook</button>
				</div><!--end of login-->

				<div id="signup"><!--signup-->
					<form action="login.php" method="post" onsubmit="return CheckSignUpDataCorrect()">
						<input class="filling" id="username" type="text" name="signup_username" maxlength="20" placeholder="Username" onchange="CheckInputNull(this)" onkeyup="CheckInputNull(this)" /><br />
						<input class="filling" id="email" type="text" name="signup_email" maxlength="50" placeholder="Email" onchange="CheckEmailType(this)" onkeyup="CheckEmailType(this)"/><br />
						<input class="filling" id="password" type="password" name="signup_password" maxlength="30" placeholder="Password" onkeyup="CheckInputNull(this)"/><br />
						<input class="filling" id="confirm_password" type="password" name="signup_confirm_password" maxlength="30" placeholder="Confirm Password" onkeyup="CheckConfirmPassword()" /><br />
						<input type="hidden" name="action" value="signup"/ >
						<button id="signup_button" type="submit">Sign Up</button>
					</form>
				</div><!--end of signup-->

				<div id="feature"><!--feature-->
					<div class="explain">
						<img src="images/login/VideoExplain.png" width="263" />
						<h1 id="video_explain">一分鐘了解Secret Land</h1>
						<p>專門為旅行愛好者設計，你可以在這分享與收藏相片，以及認識一同旅行的夥伴。</p>
					</div>

					<div class="explain">
						<img src="images/login/PostcardExplain.png" width="260" />
						<h1 id="postcard_explain">寄張明信片給朋友吧!</h1>
						<p>藉由Secret Land提供的服務，能將自己最喜歡景點轉為明信片，寄給你最想一同前往的朋友。</p>
					</div>
					<div class="explain">
						<img src="images/login/MyMapExplain.png" width="260"  />
						<h1 id="mymap_explain">擁有自己的世界地圖</h1>
						<p>在My Map裡，你能擁有屬於自己的世界地圖，這張地圖裡，收藏滿你最想去的地方。</p>
					</div>

				</div><!--end of feature-->

			</div><!--end of content-->


			<footer>
				<div id="bottom">
					<dl>
						<dt>CONTACT</dt>
						<dt>|</dt>
						<dt><a href="about.html">ABOUT</a></dt>
						<dt>|</dt>
						<dt> © All rights reserved by Secred Land</dt> 
					</dl>
				</div><!--end of bottom-->
			</footer>

		</div><!--end of page-->


<script src="./js/jquery.js"></script>
<script>

function CheckInputNull(a)
{
  var x = a.value;
  if( a.value != 0 )
  {
    $(document).ready(function(){$(a).css("background-color", "LightCyan"); });
    return true;
  }
  else
  {
    $(document).ready(function(){$(a).css("background-color", "White"); });
    return false;
  }
}

function CheckEmailType(a)
{
  var strEmail = a.value; 
  emailRule = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z]+$/;
  if( strEmail.length == 0 )
  {
    $(document).ready(function(){$(a).css("background-color", "White"); });
    return false;
  }
  else
  {
    if(strEmail.search(emailRule)!=-1)
    {
      $(document).ready(function(){$(a).css("background-color", "LightCyan"); });
      return true;
    }
    else
    {
      $(document).ready(function(){$(a).css("background-color", "Pink"); });
      return false;
    }
  }
}

function CheckConfirmPassword()
{
  var password = document.getElementById("password").value;
  var confirm_password = document.getElementById("confirm_password").value;

  if( confirm_password.length != 0 && password.length != 0 )
  {
    if( confirm_password != password )
    {
      $(document).ready(function(){$("#confirm_password").css("background-color", "Pink"); });
      return false;
    }
    else
    {
      $(document).ready(function(){$("#confirm_password").css("background-color", "LightCyan");});
      return true;
    }
  }
  else
  {
    $(document).ready(function(){$("#confirm_password").css("background-color", "White"); });
    return false;
  }

}

function CheckSignUpDataCorrect()
{
  var username = document.getElementById("username");
  var email = document.getElementById("email");
  var password = document.getElementById("password");

  if( CheckInputNull(username) && CheckEmailType(email) && CheckInputNull(password) && CheckConfirmPassword() )
    return true;
  else
    return false;

}



</script>

<script>
$(document).ready(function(){
  $("#login").show(400);
});
</script>


<script>
$(document).ready(function(){
  $("#head_newaccount").click(function(){
    $("#login").hide(400, function(){
      $("#signup").show(400, function(){
      });
    });
  });
});
</script>

<script>
$(document).ready(function(){
  $("#head_login").click(function(){
    $("#signup").hide(400, function(){
      $("#login").show(400, function(){
      });
    });
  });
});
</script>
	</body>

</html>
