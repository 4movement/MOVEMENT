$(document).ready(function() {
    initial();
});

function initial() {

    if ( typeof op_animate == 'function') {
        op_animate();
    }

    set_size();
    $(window).resize(function() {
        set_size();
    });
    $("body").keydown(key_handler);

    if ( typeof initial_menu == 'function') {
        initial_menu();
    }//menu

    var hash = hash_decode();
    window.onhashchange = hash_change;

    check_login();
    load_page();

}//initial

function set_size() {
    set_layout();
    set_wrapper_size();
	return false;//停止調整大小
	
    if ( typeof set_menu_size == 'function') {
        set_menu_size();
    }//menu

    if ( typeof set_logo_size == 'function') {
        set_logo_size();
    }//logo

    if ( typeof set_about_size == 'function') {
        set_about_size();
    }//about

    if ( typeof set_movement_size == 'function') {
        set_movement_size();
    }//movement

    if ( typeof set_issue_size == 'function') {
        set_issue_size();
    }//issue
    if ( typeof set_photoWall_size == 'function') {
        set_photoWall_size();
    }//photo wall

    if ( typeof set_discuss_size == 'function') {
        set_discuss_size();
    }//discuss

    if ( typeof set_help_size == 'function') {
        set_help_size();
    }//help

    if ( typeof set_member_size == 'function') {
        set_member_size();
    }//member

    if ( typeof set_register_size == 'function') {
        set_register_size();
    }//register

    if ( typeof set_imgcrop_size == 'function') {
        set_imgcrop_size();
    }//set_imgcrop_size

}//set size

function set_wrapper_size() {
    var window_w = $(window).width();
    var template_w = 1280;
    var window_h = $(window).height();
    var template_h = 800;
    var ratio = 1;
    var tran_x = 0;
    var tran_y = 0;

    ratio = get_scale_ratio();

    if (window_w / window_h <= template_w / template_h)//thin and tall window
    {
        /* */
        tran_x = 0;
        tran_y = (window_h - template_h * ratio) / 2;
        $(".wrapper").css({
            "width" : window_w + 'px',
            "height" : template_h * ratio + 'px',
            "left" : tran_x + 'px',
            "top" : tran_y + 'px',
            "font-size" : ratio + 'em'
        });
    }//end if
    else//wide window
    {
        tran_x = (window_w - template_w * ratio) / 2;
        tran_y = 0;
        $(".wrapper").css({
            "width" : template_w * ratio + 'px',
            "height" : window_h + 'px',
            "left" : tran_x + 'px',
            "top" : tran_y + 'px',
            "font-size" : ratio + 'em'
        });
    }//end else
    /* */

    $("#mask, #guestboard").css({
        "width" : window_w + 'px',
        "height" : window_h + 'px',
        "left" : 0,
        "top" : 0
    });

}//set wrapper size

function set_layout() {
    var window_w = $(window).width();
    var window_h = $(window).height();

    $(".layout").css({
        "width" : window_w,
        "height" : window_h
    });

    var tran_y = verticle_layout() * window_h;

    $("#v_layout").css({
        "width" : window_w,
        "top" : tran_y
    });
    $("#h_layout").css({
        "overflow" : "visible"
    });
}//layout

function verticle_layout(id) {
    switch(id || $("#menu .selected").attr('id')||"test_mode") {
        case 'test_mode':
            return 0;
        case 'menu_help':
            return -4;
        case 'menu_discuss' :
            return -3;
        case 'menu_issue':
            return -2;
        case 'menu_aboutus':
            return 0;
        case 'menu_login':
            return verticle_layout($("#menu_login").attr("current_page"));
        default:
            return -1;
        //movement and other
    }
}//v layout

function get_scale_ratio() {
    var window_w = $(window).width();
    var template_w = 1280;
    var window_h = $(window).height();
    var template_h = 800;

    if (window_w / window_h <= template_w / template_h)//thin and tall window
        return Math.round(window_w / template_w * 100) / 100;
    else//wide window
        return Math.round(window_h / template_h * 100) / 100;

}//menu ratio

function login_mod(member_data) {
    console.log("log in");
    console.log(member_data);
    member_data = member_data || {};
    window.localStorage['check_login'] = true;
	window.localStorage['No'] = member_data.No;
	
    if (member_data.msg) {
        alert(member_data.msg);
    }

    $("#menu_login div.text").text("sign out.");
    $("#menu_login button.login").removeClass('login').addClass('logout').unbind('click').bind('click', click_logout).text("Sign out");
    $("#menu_login button.register").unbind('click').bind('click', function member_data() {
        $("#logo_wrapper").trigger('mouseenter');
    }).text("My Data");
    $("#menu_login input").fadeOut();
    $("#menu_login .other_account").fadeOut();
    $("#menu_login div.member_photo").fadeIn();
    $("#menu").css("z-index", "90");

    $("#menu_login").removeClass('selected').unbind('click', click_menu);
    var cur_pg = $("#menu_login").attr('current_page');
    $("#" + cur_pg).addClass('selected');

    $("#register_wrapper2").fadeOut(function() {
        $("#register_wrapper2").remove();
    });

    if ($("#member").length) {
        console.log("member page exist");
        if ( typeof logo_mode == 'function') {
            logo_mode("member");
        }//logo
        set_member_data(member_data);
    }//if
    else {
        if ($("#member_wrapper").hasClass("loading")) {
            return;
        }

        console.log("member page reload");
        $("#member_wrapper").addClass("loading");

        var mem_count = 2;
        $("#member_wrapper").load("member_setting.html #member", function(data) {
            $("#member").hide();
            mem_count--;
            if (!mem_count) {
                console.log("mem ini");
                $("#member_wrapper").removeClass("loading");
                initial_member();
                set_member_data(member_data);
                if ( typeof logo_mode == 'function') {
                    logo_mode("member");
                }//logo
            }
        });
        $.getScript("js/member.js", function() {
            mem_count--;
            if (!mem_count) {
                console.log("mem ini");
                $("#member_wrapper").removeClass("loading");
                initial_member();
                set_member_data(member_data);
                if ( typeof logo_mode == 'function') {
                    logo_mode("member");
                }//logo
            }
        });
    }//else

    function set_member_data(data) {
        $("#member").data(data);
		
        if (data.photo) {
            $("#user_photo").attr("src", data.photo);
            $("#member_user_photo").attr("src", data.photo);
            $(".member_user_photo_s").attr("src", data.photo);
        } else {
            $("#user_photo").attr("src", "user_images/thumb/default.png");
            $("#member_user_photo").attr("src", "user_images/thumb/default.png");
            $(".member_user_photo_s").attr("src", "user_images/thumb/default.png");
        }

        if (data.username) {
            $(".user_name").text(data.username);
            $("input[name='name']").val(data.username);
        } else {
            $("input[name='name']").val("");
        }
        if (data.fblogin) {
            $("#member input[name='id']").attr("placeholder", "Sign in through FB").val("");
            $("#member input[name='pw']").attr("placeholder", "Sign in through FB").val("");
	        $('#member input[name="id"]').attr("disabled","disabled");
	        $('#member input[name="pw"]').attr("disabled","disabled");
        } else if(data.googlelogin) {
            $("#member input[name='id']").attr("placeholder", "Sign in through Google").val("");
            $("#member input[name='pw']").attr("placeholder", "Sign in through Google").val("");
	        $('#member input[name="id"]').attr("disabled","disabled");
	        $('#member input[name="pw"]').attr("disabled","disabled");
            
        } else {
            $("#member input[name='id']").attr("placeholder",data.id);
            $('#member input[name="id"]').attr("disabled","disabled");
            $("#member input[name='pw']").attr("placeholder", "Change New Password?");
            
        }
        if (data.email) {
            $("#member input[name='email']").val(data.email);
        } else {
            $("#member input[name='email']").val("");
        }
        if (data.gender) {
        	if(data.gender=="M"){
	            $("#member input[name='gender'][value='M']").attr('checked',true);
        	}
        	else if(data.gender=="F"){
	            $("#member input[name='gender'][value='F']").attr('checked',true);    		
        	}
        } else {
        }
        if (data.birth) {
            $("#member input[name='birth']").val(data.birth);
        } else {
            $("#member input[name='birth']").val("");
        }
        if(data.address){
            $("#member textarea[name='address']").val(data.address);
        	
        } else {
            $("#member textarea[name='address']").val("");
        }
        
        $("ul[id='member_list_form'] li:nth-child(1) img").attr('public',data.username_public);
        if(data.username_public=='0'){
            $("ul[id='member_list_form'] li:nth-child(1) img").attr('src','./img/member/unpublic-icon.png');
        }else if(data.username_public=='1'){
            $("ul[id='member_list_form'] li:nth-child(1) img").attr('src','./img/member/public-icon.png');
        }
        $("ul[id='member_list_form'] li:nth-child(4) img").attr('public',data.email_public);
        if(data.email_public=='0'){
            $("ul[id='member_list_form'] li:nth-child(4) img").attr('src','./img/member/unpublic-icon.png');
        }else if(data.email_public=='1'){
            $("ul[id='member_list_form'] li:nth-child(4) img").attr('src','./img/member/public-icon.png');
        }
        $("ul[id='member_list_form'] li:nth-child(5) img").attr('public',data.birth_public);
        if(data.birth_public=='0'){
            $("ul[id='member_list_form'] li:nth-child(5) img").attr('src','./img/member/unpublic-icon.png');
        }else if(data.birth_public=='1'){
            $("ul[id='member_list_form'] li:nth-child(5) img").attr('src','./img/member/public-icon.png');
        }
        $("ul[id='member_list_form'] li:nth-child(6) img").attr('public',data.gender_public);
        if(data.gender_public=='0'){
            $("ul[id='member_list_form'] li:nth-child(6) img").attr('src','./img/member/unpublic-icon.png');
        }else if(data.gender_public=='1'){
            $("ul[id='member_list_form'] li:nth-child(6) img").attr('src','./img/member/public-icon.png');
        }
        $("ul[id='member_list_form'] li:nth-child(7) img").attr('public',data.address_public);
        if(data.address_public=='0'){
            $("ul[id='member_list_form'] li:nth-child(7) img").attr('src','./img/member/unpublic-icon.png');
        }else if(data.address_public=='1'){
            $("ul[id='member_list_form'] li:nth-child(7) img").attr('src','./img/member/public-icon.png');
        }
        //modify the information
    }//set member information

}//log in

function logout_mod() {
    console.log("log out");
    window.localStorage['check_login'] = false;
    window.sessionStorage.clear();

    $("#menu_login div.text").text("sign in.");
    $("#menu_login button.logout").removeClass('logout').addClass('login').unbind('click').bind('click', click_login).text("Sign in");
    $("#menu_login button.register").unbind('click').bind('click', click_register).text("Register");
    $("#menu_login input").fadeIn();
    $("#menu_login .other_account").fadeIn();
    $("#menu_login div.member_photo").fadeOut();
    $("#menu").css("z-index", "90");
    
    $("#menu_login").bind('click', click_menu);

    $("#member").fadeOut(function() {
        $("#member").remove();
    });

    if ( typeof logo_mode == 'function') {
        logo_mode("normal");
    }//logo

    if (!$("#register_wrapper2").length) {
        if ($("#register_wrapper").hasClass("loading")) {
            return;
        }

        console.log("reg reload");
        $("#register_wrapper").addClass("loading");

        var register_count = 2;
        $("#register_wrapper").load("register1.html #register_wrapper2", function(data) {
            $("#register_wrapper2").hide();
            register_count--;
            if (!register_count) {
                console.log("reg ini");
                $("#register_wrapper").removeClass("loading");
                initial_register();
            }
        });
        $.getScript("js/register.js", function() {
            register_count--;
            if (!register_count) {
                console.log("reg ini");
                $("#register_wrapper").removeClass("loading");
                initial_register();
            }
        });
    }//else
}//log out

function load_page() {
    // larry 20140419 marked: this goes to 
    // http://localhost:8888/MOVEMENT/movement.html
    // movement.html needs to be first defined in controller,
    // then javascript can access.
    /*
    $("#movement_layout").load("movement.html .wrapper", function() {
        console.log("movement ini");
        initial_movement();
    });
    */

    var about_count = 3;

    // larry 20140419 marked
    // refer to the above movement.html
    /*
    $("#about_layout").load("about_us.html .wrapper", function() {
        about_count--;
        if (!about_count) {
            console.log("about_us ini");
            initial_about();
        }
    });
    */

    $.getScript("js/about.js", function() {
        about_count--;
        if (!about_count) {
            console.log("about_us ini");
            initial_about();
        }
    });
    $.getScript("js/jquery.adipoli.js", function() {
        about_count--;
        if (!about_count) {
            console.log("about_us ini");
            initial_about();
        }
    });

    var discuss_count = 2;
    $("#discuss_layout").load("discuss.html .wrapper", function() {
        discuss_count--;
        if (!discuss_count) {
            console.log("discuss ini");
            initial_discuss();
        }
    });
    $.getScript("js/discuss.js", function() {
        discuss_count--;
        if (!discuss_count) {
            console.log("discuss ini");
            initial_discuss();
        }
    });

    var issue_count = 4;
    var photoWall_count = 4;
    var map_data = {};
    var map_path = {};
    $("#issue_layout").load("issue.html .wrapper", function() {
        issue_count--;
        if (!issue_count) {
            console.log("issue ini");
            initial_issue(map_data, map_path);
        }
    });
    $("#photoWall_layout").load("guestboard.html .wrapper", function() {
        photoWall_count--;
        if (!photoWall_count) {
            console.log("photo wall ini")
            initial_photoWall();
        }
    });
    $.getScript("js/issue.js", function() {
        issue_count--;
        if (!issue_count) {
            console.log("issue ini")
            initial_issue(map_data, map_path);
        }

        photoWall_count--;
        if (!photoWall_count) {
            console.log("guest book ini");
            initial_photoWall();
        }
    });
    $.getScript("js/jqvmap/jquery.vmap.js", function() {
        $.getScript("js/jqvmap/maps/jquery.vmap.world.js", function(result) {
            issue_count--;
            map_path = result;
            if (!issue_count) {
                console.log("issue ini");
                initial_issue(map_data, map_path);
            }
        });
    });
    $.getJSON("js/jqvmap/data/jqvmap_sampledata.json", function(result) {
        issue_count--;
        map_data = result;
        if (!issue_count) {
            console.log("issue ini");
            initial_issue(map_data, map_path);
        }
    });
    $.getScript("js/jquery.masonry.min.js", function() {
        photoWall_count--;
        if (!photoWall_count) {
            console.log("guest book ini");
            initial_photoWall();
        }
    });
    $.getScript("js/imagesloaded.pkgd.min.js", function() {
        photoWall_count--;
        if (!photoWall_count) {
            console.log("guest book ini");
            initial_photoWall();
        }
    });

    var help_count = 3;
    $("#help_layout").load("help.html .wrapper", function() {
        help_count--;
        if (help_count <= 0) {
            console.log("help ini")
            initial_help();
        }
    });
    $.getScript("js/help.js", function() {
        help_count--;
        if (help_count <= 0) {
            console.log("help ini")
            initial_help();
        }
    });
    $.getScript("js/turn.js", function() {
        help_count--;
        if (help_count <= 0) {
            console.log("help ini")
            initial_help();
        }
    });

    $("#logo_wrapper").append("<div id = 'register_wrapper' ></div>");
    $("#logo_wrapper").append("<div id = 'member_wrapper' ></div>");

    var reg_count = 2;
    $("#register_wrapper").load("register1.html #register_wrapper2", function(data) {
        $("#register_wrapper2").hide();
        reg_count--;
        if (!reg_count) {
            console.log("reg ini");
            initial_register();
        }
    });
    $.getScript("js/register.js", function() {
        reg_count--;
        if (!reg_count) {
            console.log("reg ini");
            initial_register();
        }
    });

    if ( typeof load_image_cropper == "function") {
        load_image_cropper();
    }
}//load page

function check_login() {
    var base_url = "http://merry.ee.ncku.edu.tw/~smart0eddie/cur/member/login/";
    var URL = base_url + "check_login.php";
    $.post(URL, {}, function(data) {
        console.log(data);
        var member_data = {};
        member_data.login = (data.OK == "true") ? true : false;
        //console.log(data.OK);
        //console.log(member_data + member_data.login);
        if (member_data.login) {
        	data.photo = window.sessionStorage.photo;
            login_mod(data);
        }//if already loged in
        else {
            logout_mod();
        }//else

    });
    if (window.localStorage['check_login'] != "undefined") {
        console.log("login?  " + window.localStorage['check_login']);
        return (window.localStorage['check_login'] == "true");
    }
}//check login

function fb_login() {
    window.open("http://merry.ee.ncku.edu.tw/~smart0eddie/cur/member/FB/FB_mid.php", 'FB login', config = 'height=650,width=650 ,scrollbars=1,resizable=0');
}//fb login

function google_login() {
    window.open("http://merry.ee.ncku.edu.tw/~smart0eddie/cur/member/Google/Google_mid.php", 'Google+ login', config = 'height=650,width=650 ,scrollbars=1,resizable=0');
}//google login

function fb_login_data(data) {
    data = JSON.parse(data);
    console.log(data);
    if (data.check_login) {
        data.fblogin = true;
        window.sessionStorage.photo = data.photo;
        login_mod(data);
        console.log("FB login msg");
        $('#member input[name="id"]').attr("disabled","disabled");
        $('#member input[name="pw"]').attr("disabled","disabled");
    } else {
        if (data.errmsg) {
            alert(data.errmsg);
        }
        logout_mod();
    }
}//fb login
function google_login_data(data) {
    data = JSON.parse(data);
    console.log(data);
    if (data.check_login) {
        data.googlelogin = true;
        window.sessionStorage.photo = data.photo;
        login_mod(data);
        console.log("Google login msg");
        $('#member input[name="id"]').attr("disabled","disabled");
        $('#member input[name="pw"]').attr("disabled","disabled");
    } else {
        if (data.errmsg) {
            alert(data.errmsg);
        }
        logout_mod();
    }
}//fb login

function hash_change(event) {
    if (window.location.hash) {
        event.preventDefault();
        var hash_id = hash_decode();
        if (hash_id) {

        }
    }//if has hash
}//hash change

function hash_decode() {
    if (window.location.hash && window.location.hash.length > 1) {
        window.scrollTo(0, 0);
        var hash_tag = window.location.hash.substring(1).toLowerCase();
        console.log(hash_tag);
        switch(hash_tag) {
            case 'about':
            case 'about us':
            case 'about_us':
                $("#menu_aboutus").trigger('click');
                break;
            case 'home':
            case 'movement':
                $("#menu_movement").trigger('click');
                break;
            case 'issue':
            case 'map':
                $("#menu_issue").trigger('click');
                break;
            case 'discuss':
            case 'article':
                $("#menu_discuss").trigger('click');
                break;
            case 'help':
            case 'manual':
                $("#menu_help").trigger('click');
                break;
            case 'photo wall':
            case 'photo_wall':
            case 'photowall':
            case 'guest board':
            case 'guest_board':
            case 'guestboard':
                $("#menu_issue").trigger('click');
                $("#issue .guest_board").trigger('click');
                break;
            default:
                if (!isNaN(hash_tag)) {
                    movement_hash(parseInt(hash_tag, 10));
                }
                break;
                window.location.hash = "";
        }//switch
    }//if has hash

}//decode hash

function share(target, type, id) {
    var url = "";
    var base_url = "merry.ee.ncku.edu.tw/~smart0eddie/cur/";
    var hash_tag = "%23";

    switch(type) {
        case 'movement':
            hash_tag += id;
            break;
        case 'home':
        default:
            hash_tag += "movement";
            break;
    }

    switch(target) {
        case 'fb':
            url = "https://www.facebook.com/sharer/sharer.php?u=" + base_url + hash_tag;
            break;
        default:
            break;
    }

    console.log(url);
    window.open(url, 'sharer', 'width=626,height=436');

}//share

function key_handler(event) {
    var key = event.which;

    switch(key) {
        case 37:
            if (($("#menu_movement").hasClass("selected") || $("#menu_login").attr("current_page") == "menu_movement") && $(".movement_display_mode.gallery").hasClass("selected")) {
                $("#movement_gallery").trigger("mousewheel", [1]);
            }
            if (($("#menu_help").hasClass("selected") || $("#menu_login").attr("current_page") == "menu_help")) {
                $("#helpbbok_prep_icon").click();
            }
            if (!$("input:focus, textarea:focus").length) {
                event.preventDefault();
            }//prevent jump block
            //left arrow
            break;
        case 39:
            if (($("#menu_movement").hasClass("selected") || $("#menu_login").attr("current_page") == "menu_movement") && $(".movement_display_mode.gallery").hasClass("selected")) {
                $("#movement_gallery").trigger("mousewheel", [-1]);
            }
            if (($("#menu_help").hasClass("selected") || $("#menu_login").attr("current_page") == "menu_help")) {
                $("#helpbook_nep_icon").click();
            }
            if (!$("input:focus, textarea:focus").length) {
                event.preventDefault();
            }//prevent jump block
            //right arrow
            break;
        case 32:
        //space
        case 38:
        //up arrow
        case 33:
            if (($("#menu_help").hasClass("selected") || $("#menu_login").attr("current_page") == "menu_help")) {
                $("#helpbbok_prep_icon").click();
                event.preventDefault();
                break;
            }
        //pg up
        case 40:
        //down arrow
        case 34:
            //pg down
            if (($("#menu_help").hasClass("selected") || $("#menu_login").attr("current_page") == "menu_help")) {
                $("#helpbook_nep_icon").click();
                event.preventDefault();
                break;
            }

            if (!$("input:focus, textarea:focus").length) {
                event.preventDefault();
            }//prevent jump block
            break;
        default:
            break;
    }//key
}//key down
