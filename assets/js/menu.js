function initial_menu() {
    $("#menu_login").attr({
        'current_page' : $("#menu .selected").attr('id')
    });

    $("#menu li").click(click_menu);
    //li

    $("#menu button.register").click(click_register);
    //reg btn

    $("#menu button.login").click(click_login);

    $("#menu_login .facebook").click(fb_login);
    
    $("#menu_login .google_plus").click(google_login);
}

function click_login(event) {
    var id = $("#menu_login input.id").val();
    var pw = $("#menu_login input.password").val();
    var base_url = "http://merry.ee.ncku.edu.tw/~smart0eddie/cur/member/login/";
    var URL = base_url + "connect.php";

    var check = check_login_data(id, pw);

    if (check.check) {
        $.post(URL, {
            'id' : id,
            'pw' : pw
        }, function(result) {
            console.log(result);
            //if login success do something
            if (result.result == "success") {
                login_mod(result);

            }//success
            if (result.msg) {
                alert(result.msg);
            }
        });
    } else {
        $("#menu form .hint").text("");
        $.each(check.errmsg, function() {
            console.log(this.id, this.msg);
        });
    }//else
    event.preventDefault();

}//login

function click_logout(event) {
    var base_url = "http://merry.ee.ncku.edu.tw/~smart0eddie/cur/member/login/";
    var URL = base_url + "logout.php";

    $.post(URL, {
    }, function(result) {
        console.log(result);
        //if login success do something
        if (result.result == "success") {
            logout_mod();
        }//success
        if (result.msg) {
            alert(result.msg);
        }
    });

    event.preventDefault();
}//logout

function click_register(event) {
    console.log("reg");

    if ( typeof logo_mode == 'function') {
        logo_mode("register");
    }//logo

    event.preventDefault();
}//register

function click_menu() {
    var window_h = $(window).height();
    var id = $(this).attr('id');
    var tran_y;

    switch(id) {
        case 'menu_discuss' :
        case 'menu_help':
        case 'menu_aboutus':
            $(".movement_display_mode_wrapper, #issue_search_wrapper").stop().animate({
                "top" : "-100%"
            });
            break;
        case 'menu_issue':
            $("#issue_search_wrapper").stop().animate({
                "top" : "0%"
            });
            $(".movement_display_mode_wrapper").stop().animate({
                "top" : "-100%"
            });
            $("#h_layout").stop().animate({
                "left" : "0%"
            });
            break;
        case 'menu_login':
            if ($("#menu .selected").attr('id') != "menu_login") {
                $(this).attr({
                    'current_page' : $("#menu .selected").attr('id')
                });
            }
            break;
        default :
            // movement and other
            $(".movement_display_mode_wrapper ").stop().animate({
                "top" : "0"
            });
            $("#issue_search_wrapper").stop().animate({
                "top" : "-100%"
            });
            break;
    }//switch

    $("#menu .selected").removeClass("selected");
    $(this).addClass("selected");
    tran_y = verticle_layout() * window_h;

    /*if (id != 'menu_login') {
     window.location.hash = "";
     window.location.hash = id.substring(5);
     }*/

    $("#v_layout").stop().animate({
        "top" : tran_y
    });

}//click_menu

function check_login_data(id, pw) {
    var check = true;
    var errmsg = Array();

    if (!id.length) {
        errmsg.push({
            id : "id",
            msg : "請輸入ID"
        });
        check = false;
    } else if (!pw.length) {
        check = false;
        errmsg.push({
            id : "password",
            msg : "請輸入密碼"
        });
    }

    return {
        "check" : check,
        "errmsg" : errmsg
    };
}//check_login_data

function set_menu_size() {
    var ratio = get_scale_ratio();

    console.log("menu ratio" + ratio);

    $("#menu").css({
        "height" : 55 * ratio / 1.6 + 'px',
        "line-height" : 55 * ratio / 1.6 + 'px',
        "top" : 22 * ratio / 1.6 + 'px',
        "width" : 880 * ratio / 1.6 + 'px',
        "font-size" : 1.92 * ratio / 1.6 + 'em'
    });
    $(".menu_l").css({
        "left" : Math.ceil((-26) * ratio / 1.6) + 'px',
        "border-width" : 27.5 * ratio / 1.6 + 'px 0 ' + 28.5 * ratio / 1.6 + 'px ' + 27.5 * ratio / 1.6 + 'px'
    });
    $(".menu_r").css({
        "right" : (-25) * ratio / 1.6 + 'px',
        "border-width" : 27.5 * ratio / 1.6 + 'px 0 ' + 28.5 * ratio / 1.6 + 'px ' + 27.5 * ratio / 1.6 + 'px'
    });
    $("#menu .menu_icon ").css({
        "left" : 30 * ratio / 1.6 + 'px',
        "width" : 72 * ratio / 1.6 + 'px'
    });
    $("#menu_login .menu_icon ").css({
        "left" : "-6%",
        "width" : "112%"
    });
    $("#menu .menu_icon > img").css({
        "height" : 61 * ratio / 1.6 + 'px'
    });
    $("#menu_login .menu_icon > img").css({
        "height" : 335 * ratio / 1.6 + 'px'
    });
    $("#menu_login form").css({
        "height" : 135 * ratio / 1.6 + 'px',
        "bottom" : 118 * ratio / 1.6 + 'px'
    });
    $("#menu_login .other_account button").css({
        "height" : 35 * ratio / 1.6 + 'px'
    });

}//set menu size

function menu_ratio() {
    var window_w = $(window).width();
    var template_w = 2048;
    var window_h = $(window).height();
    var template_h = 1280;
    var ratio = 1;

    return window_w / template_w;
}//menu ratio
