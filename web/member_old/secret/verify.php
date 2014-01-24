<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
require_once('./db_conf.php');
require_once('./aes_conf.php');

$aes = new CryptAES("1010011518423013","af955cd2a0626b2c7f0988f20598d96f");
$email = $aes->decrypt($_GET["code"]);
$email = trim($email);
$result = mysql_query("SELECT * FROM z_SL_users WHERE email='$email';");
$number = mysql_num_rows($result);

if( $number==1 ){
  $row = mysql_fetch_assoc($result);
  $username = $row['username'];
  $account_verify = $row['account_verify'];
  if( $account_verify=='N' ){
    //modify the account_verify in database to verify the account
    $result = mysql_query("UPDATE z_SL_users SET account_verify='Y' WHERE email='$email';");
    //direct to the page for creating user's own table
    header("location:./initial_user.php?username=$username");
  }
  else{
    echo '<script>
      alert("You had already verified your account.");
    location.href=\'./login.php\';
    </script>';	
  }
}
else{
  echo '<script>
    alert("verify fail");
  location.href=\'./login.php\';
  </script>';

}
?>
