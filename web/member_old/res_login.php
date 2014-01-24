<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<?php session_start(); ?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <script>
            function checkidpw() {
                var id = document.getElementById('id');
                var pw = document.getElementById('pw');
                if (id.value == '') {
                    alert('請輸入帳號');
                    id.focus();
                    return false;
                }
                if (pw.value == '') {
                    alert('請輸入密碼');
                    pw.focus();
                    return false;
                }
            }

        </script>

        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

       

    </head>
    
    <form name="form" method="post" action="connect.php" onsubmit="return checkidpw();">
        <span>帳號：</span>
        <input type="text" name="id" id="id"/>
        <br/>
        <span>密碼：</span>
        <input type="password" name="pw" id="pw" maxlength="20" />
        <br/>
        <input type="submit" name="submit" value="登入" />
        <a href="register.php">申請帳號</a>
    </form>

    <a href="FB_auth_check.php">FB_login.php</a>

    <div id = "test">
        FB test
    </div>
    
     <script>
            $("#test").click(function(){
            	<?
            		$_SESSION['state'] = md5(uniqid(rand()));
            	?>
            	var state="<? echo $_SESSION['state']; ?>";
            	
            	window.open("https://www.facebook.com/dialog/oauth?client_id=357084021063217&"+
            				"redirect_uri=http://merry.ee.ncku.edu.tw/~smart0eddie/mem/FB_login.php&state="+state+
		    				"&response_type=code&scope=user_website,email",'FB_logining...', config='height=200,width=200');
            /*$.get("https://www.facebook.com/dialog/oauth?client_id=357084021063217&redirect_uri=google.com",function(response){
                console.log(response);
            });*/
            
            /*$.get(https://graph.facebook.com/oauth/access_token?
            client_id=357084021063217
            &redirect_uri=""
            &client_secret=fcd49d763817498f868a050c30900d13
            &code={code-parameter}(),function(result){
                console.log(result);
            })*/
            });
            
            function catch_value(code, error){
                if(error=="user_denied"){
					
				}
            	else if(code){//有值
            		
            		console.log(code + "123");
					if(1){
						//state===echo $_REQUEST['state'];
						var base_url = "";
						var url = base_url + "FB_login.php";
						
            			console.log(code + "456");
						$.post(url,{
							code:code,
							step:"2"
							},function(data){
								console.log("AJAX OK");
								console.log(code);
								console.log("AJAX OK");
								alert(data);

								
							}
						);
						
           			}
           		}
           	}
            </script>

</html>
