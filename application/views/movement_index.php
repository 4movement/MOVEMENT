<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js">
<!--<![endif]-->
<head>
    <meta charset="utf-8">
    <title>Movement</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width">

    <link rel="shortcut icon" href="assets/img/favicon.jpg">

    <link rel = "stylesheet" href = "assets/css/normalize.css">
    <link rel = "stylesheet" href = "assets/css/main.css">
    <link rel = "stylesheet" href = "assets/css/font.css">
    <link rel = "stylesheet" href = "assets/css/about.css">
    <link rel = "stylesheet" href = "assets/css/adipoli.css">
    <link rel = "stylesheet" href = "assets/css/movement.css">
    <link rel = "stylesheet" href = "assets/css/menu.css">
    <link rel = "stylesheet" href = "assets/css/logo.css">
    <link rel = "stylesheet" href = "assets/css/about.css">
    <link rel = "stylesheet" href = "assets/css/adipoli.css">
    <link rel = "stylesheet" href = "assets/css/issue.css">
    <link rel = "stylesheet" href = "assets/css/help.css">
	
	<script src="assets/js/vendor/modernizr-2.6.2.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script type="text/javascript" src="http://yui.yahooapis.com/2.9.0/build/yuiloader/yuiloader-min.js"></script>
    <script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/jquery.transit.min.js"></script>
	<script src="assets/js/jquery.mousewheel.js"></script>
	<script src="assets/js/masonry.pkgd.min.js"></script>
	<script src="assets/js/scrollpagination.js"></script>   
	
	<script src="assets/js/about.js"></script>
    <script src="assets/js/logo.js"></script>
    <script src="assets/js/menu.js"></script>
    <script src="assets/js/main.js"></script>
	
	<script> //Masonry
		$('#container').masonry({
			columnWidth: 350,
			itemSelector: '.item',
			isFitWidth: true,
			
		});
	</script>
</head>
<body >

    <!-- map to the master branch, 3rd major div -->
    <div id = "layout_wrapper">
        <div id = "v_layout">
            <div id = "about_layout" class = "layout">
                
            </div>
            <div id = "movement_layout" class = "layout">
            
            </div>
            <div id = "h_layout" class="layout">
                <div id="issue_layout" class="layout">
                    
                </div>
                <div id = "photoWall_layout" class="layout">
                    
                </div>
            </div>
            <div id="discuss_layout" class="layout">
                
            </div>
            <div id="help_layout" class="layout">
                
            </div>
        </div>
    </div>

    <div id="image_cropper" class = "yui-skin-sam">
        <form action="upload.php" enctype="multipart/form-data" method="post" name="uploadForm" id="uploadForm">
            Image :
            <input type="file" name="uploadImage" id="uploadImage" />
            <input type="button" id="uploadButton" value="Upload"/>
            <input type="button" id="image_confirm" value="Done">
            <input type="button" id="image_cancel" value="Cancel">
        </form>
        <div id="imageContainer">
            
        </div>
    </div>

    <div id = "logo_wrapper">
        <div id="logo" class = "logo">
            <div class = "logo_tl">
            M
            </div>
            
            <div class = "logo_tc">
            O
            </div>
                
            <div class = "logo_tr">
            V
            </div>
                
            <div class = "logo_cl">
            E
            </div>
                
            <div class = "logo_cc">
            M
            </div>
                
            <div class = "logo_cr">
            E
            </div>
                
            <div class = "logo_bl">
            N
            </div>
                
            <div class = "logo_bc">
                <div>
                movement
                </div>
                    
                <div>
                in the world
                </div>
            </div>
                
            <div class = "logo_br">
            T
            </div>
        </div>  <!--div id="logo" class = "logo"-->
    </div> <!--div id = "logo_wrapper"-->

    <ul id = "menu">
		<li id = "menu_login" class = "menu" current_page = "menu_movement">
            <div class ="menu_l">
                
            </div>
                
            <div class = "text">
            sign in.
            </div>
                
            <div class = "menu_icon2">
                
            </div>
                
            <div class = "menu_icon">
                <img src="assets/img/menu/login-ba-sh.png"/>
                <form>
                    <div class="member_photo">
                        <img src="assets/img/user_images/thumb/default.png" class="member_photo" id="user_photo"/>
                        <p class="member_photo">
                            <p class="user_name">
                            Demo
                            </p>
                        </p>
                    </div>  <!--div class="member_photo"-->
                    <input type="text"  placeholder="ID NUMBER" class = "id"/>
                    <input type="password"  placeholder="PASSWORD" class = "password"/>
                    <button type="button" class = "login">
                    Sign in
                    </button>
                    <button type="button" class = "register">
                    Register
                    </button>
                    <div class = "other_account">
                        <h2>Sign in with :</h2>
                        <button type="button" class = "facebook"><img src = "assets/img/menu/fb-lo.png" />
                        </button>
                        <button type="button" class = "twitter"><img src = "assets/img/menu/tw-lo.png" />
                        </button>
                        <button type="button" class = "google_plus"><img src = "assets/img/menu/go-lo.png" />
                        </button>
                    </div> <!--div class = "other_account"-->
                </form>
            </div> <!--div class = "menu_icon"-->
        </li>
        <!--li id = "menu_login" class = "menu" current_page = "menu_movement"-->
        <li id = "menu_aboutus" class = "menu" onClick="_gaq.push(['_trackEvent', 'about', 'click']);" >
            <div class ="menu_l">
                
            </div>
                
            <div>
            about.
            </div>
                
            <div class = "menu_icon">
                <img src="assets/img/menu/about-icon.png"/>
            </div>
         
        </li>
            
        <li id = "menu_movement" class = "selected menu" onClick="_gaq.push(['_trackEvent', 'movement', 'click']);">
            <div class ="menu_l">
                
            </div>
                
            <div>
            movement.
            </div>
                
            <div class = "menu_icon">
                <img src="assets/img/menu/moveicon.png" />
            </div>
                

        </li>
            
        <li id = "menu_issue" class = "menu" onClick="_gaq.push(['_trackEvent', 'issue', 'click']);">
            <div class ="menu_l">
                
            </div>
                
            <div>
            issue.
            </div>
                
            <div class = "menu_icon">
                <img src="assets/img/menu/issue-icon.png"/>
            </div>
               
        </li>
            
            
        <li id = "menu_help" class = "menu" onClick="_gaq.push(['_trackEvent', 'help', 'click']);">
            <div class ="menu_l">
                
            </div>
                
            <div>
            help.
            </div>
                
            <div class = "menu_icon">
                <img src="assets/img/menu/helpicon.png"/>
            </div>

        </li>
    </ul> <!--ul id = "menu"-->
	
    <footer>
		<p>Copyright(c)2014 NCKU,Movement. All Rights Reserved.</p>
    </footer>
        
    <!--<img src = "img/login/lo-in04.jpg" class "design_template"/>-->

    <script type="text/javascript">
        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-40403508-1']);
        _gaq.push(['_trackPageview']);

        (function() {
            var ga = document.createElement('script');
            ga.type = 'text/javascript';
            ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(ga, s);
            })();
    </script>
    <script type="text/javascript">
        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-40579300-5']);
        _gaq.push(['_setDomainName', 'ee.ncku.edu.tw']);
        _gaq.push(['_setAllowLinker', true]);
        _gaq.push(['_trackPageview']);

        (function() {
            var ga = document.createElement('script');
            ga.type = 'text/javascript';
            ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0];
                s.parentNode.insertBefore(ga, s);
            })();
    </script>
</body>
</html>
