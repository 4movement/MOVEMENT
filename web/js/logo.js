$(document).ready(function() {
    //events
    $("#logo_wrapper").hover(logo_mouseenter, logo_mouseleave);
    //events
})
//functions
function logo_mouseenter() {
    var ratio = get_scale_ratio();

    switch(logo_mode()) {
        case 'register':
            return;

        case 'member':
            console.log("mem mode");
            open_logo_mem();
            return;

        default:
            $("#logo_wrapper").stop(true).animate({
                "top" : 15 * ratio / 1.6 + 'px'
            }).transition({
                rotate : "0deg"
            });
            return;
    }//switch
}//mouse enter

function logo_mouseleave() {
    var ratio = get_scale_ratio();

    switch(logo_mode()) {
        case 'register':
            return;
        case 'member':
            return;
        default:
            $("#logo_wrapper").stop(true).transition({
                rotate : "-90deg"
            }).animate({
                "top" : -128 * ratio / 1.6 + 'px'
            });
            return;
    }//switch
}//mouse leave

function logo_mode(mode) {
    var logomode = $("#logo_wrapper").attr('logo_mode');
    var ratio = get_scale_ratio();
    var ani_time = 2000;

    logomode = mode || logomode || "normal";
    $("#logo_wrapper").attr('logo_mode', logomode);

    switch(mode) {
        case 'register':
            if (!$("#register_wrapper2").length) {
                if ($("#register_wrapper").hasClass("loading")) {
                    setTimeout(logo_mode('register'), 1000);
                    return;
                }

                console.log("reg reload");
                $("#register_wrapper").addClass("loading");

                var register_count = 2;
                $("#register_wrapper").load("register1.html #register_wrapper2", function(data) {
                    $("#register_wrapper2").hide();
                    register_count--;
                    if (!register_count) {
                        console.log("reg mode");
                        initial_register();
                        open_logo_reg();
                    }
                });
                $.getScript("js/register.js", function() {
                    register_count--;
                    if (!register_count) {
                        console.log("reg mode");
                        initial_register();
                        open_logo_reg();
                    }
                });
                return;
            }//else
            console.log("reg mode");
            open_logo_reg();
            return logomode;
        case 'member':
            return logomode;
        case'normal':
            console.log("nor mode" + ratio);
            close_logo();
            return logomode;
        default:
            return logomode;
    }//switch
}//logo mode

function open_logo_mem() {
    var ratio = get_scale_ratio();
    var ani_time = 2000;
    $("#mask").unbind('click.logo');
    $("#logo_wrapper").unbind('mouseenter').stop().animate({
        "left" : 99 * ratio / 1.6 + 'px',
        "top" : 54 * ratio / 1.6 + 'px'
    }, function() {
        $(this).css({
            "z-index" : 999
            //"transform-origin" : "center center"
        }).animate({
            "width" : 720 * ratio + 'px',
            "height" : 690 * ratio + 'px',
            "backgroundColor" : "transparent"
        }, ani_time, function() {
            $("#logo_wrapper").bind('mouseenter', logo_mouseenter);
        });
        //size and color
        $("#logo").stop().animate({
            "left" : 30 * ratio + 'px',
            "backgroundColor" : "black"
        }, ani_time / 3);
        //color
    }).transition({
        rotate : "0deg"
    });
    //position
    if ( typeof set_member_size == 'function') {
        set_member_size();
    }//member
    $("#member").fadeIn(ani_time);

    $("#mask").fadeIn(function() {
        $("#mask").bind("click.logo", function member_mask() {
            $("#mask").fadeOut().unbind('click.logo', member_mask);
            close_logo();
        });
    });

}//open member

function open_logo_reg() {
    var ratio = get_scale_ratio();
    var ani_time = 2000;
    $("#mask").unbind('click.logo');
    $("#logo_wrapper").stop().animate({
        "left" : 99 * ratio / 1.6 + 'px',
        "top" : 54 * ratio / 1.6 + 'px'
    }, function() {
        $(this).css({
            "z-index" : 999
            //"transform-origin" : "center center"
        }).animate({
            "width" : 1362 * ratio / 1.6 + 'px',
            "height" : 1016 * ratio / 1.6 + 'px',
            "backgroundColor" : "white"
        }, ani_time);
        //size and color
        $("#logo").stop().animate({
            "color" : "black",
            "backgroundColor" : "white"
        }, ani_time);
        //color
    }).transition({
        rotate : "0deg"
    });
    //position
    if ( typeof set_register_size == 'function') {
        set_register_size();
    }//register
    $("#register_wrapper2").fadeIn(ani_time);

    $("#mask").fadeIn(function() {
        $("#mask").bind("click.logo", function register_mask() {
            $("#mask").fadeOut().unbind('click.logo', register_mask);
            if ( typeof logo_mode == 'function') {
                logo_mode("normal");
            }//logo
        });
    });
}//open register

function close_logo() {
    var ratio = get_scale_ratio();
    var ani_time = 2000;

    $("#logo_wrapper").unbind();
    $("#logo_wrapper .wrapper2").fadeOut(ani_time, function() {
        //$("#logo_wrapper .wrapper2").remove();
    });
    $("#logo_wrapper").stop().animate({
        "height" : 192 * ratio / 1.6 + 'px',
        "width" : 192 * ratio / 1.6 + 'px',
        "backgroundColor" : "black"
    }, ani_time, function() {
        $(this).css({
            "z-index" : 90
            // "transform-origin" : "center center"
        }).transition({
            rotate : "-90deg"
        }).animate({
            "left" : 28 * ratio / 1.6 + 'px',
            "top" : -128 * ratio / 1.6 + 'px'
        }, function() {
            $("#logo_wrapper").hover(logo_mouseenter, logo_mouseleave);
        });
        //position
    });
    //size & color

    $("#logo_wrapper .wrapper2").fadeOut(ani_time);

    $("#logo").stop().animate({
        "left" : 0,
        "color" : "white",
        "backgroundColor" : "black"
    }, ani_time);
    //color

    $("#mask").fadeOut().unbind('click.logo');
}//close logo

function set_logo_size() {

    var ratio = get_scale_ratio();

    $("#logo").css({
        "width" : 192 * ratio / 1.6 + 'px',
        "height" : 192 * ratio / 1.6 + 'px',
        "font-size" : 2.5 * ratio / 1.6 + 'em',
        "line-height" : 70 * ratio / 1.6 + 'px'
    });

    $("footer").css({
        "font-size" : 0.8 * ratio + 'em'
    });

    switch(logo_mode()) {
        case 'register':
            $("#logo_wrapper").css({
                "width" : 1362 * ratio / 1.6 + 'px',
                "height" : 1016 * ratio / 1.6 + 'px',
                "left" : 99 * ratio / 1.6 + 'px',
                "top" : 54 * ratio / 1.6 + 'px',
                "transform-origin" : "center center",
                "transform" : "rotate(0deg)"
            });
            return;

        case 'member':
            if ($("#member").is(":visible")) {
                $("#logo_wrapper").css({
                    "width" : 720 * ratio + 'px',
                    "height" : 690 * ratio + 'px',
                    "left" : 99 * ratio / 1.6 + 'px',
                    "top" : 54 * ratio / 1.6 + 'px',
                    "z-index" : 999,
                    "background-color" : "transparent",
                    "transform-origin" : "center center",
                    "transform" : "rotate(0deg)"
                });

                $("#logo").css({
                    "left" : 30 * ratio + 'px',
                    "transform" : "rotate(0deg)"
                });
                return;
            }
        default:
            $("#logo_wrapper").css({
                "width" : 192 * ratio / 1.6 + 'px',
                "height" : 192 * ratio / 1.6 + 'px',
                "left" : 28 * ratio / 1.6 + 'px',
                "top" : -128 * ratio / 1.6 + 'px',
                "transform-origin" : "center center",
                "transform" : "rotate(-90deg)"
            });
            return;
    }//switch
}//set logo size

//functions
