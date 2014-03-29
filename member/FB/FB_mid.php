<?php
	$_SESSION['state'] = md5(uniqid(rand()));
?>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script>
	var state = "<?php echo $_SESSION['state']; ?>";

	window.location.href = "https://www.facebook.com/dialog/oauth?client_id=357084021063217&"+"redirect_uri=http://merry.ee.ncku.edu.tw/~smart0eddie/cur/member/FB/FB_login.php&state="+state+	"&response_type=code&scope=user_website,email";
	
</script>
