function initial_about() {

    set_wrapper_size();    
    set_about_size();
    hash_decode();    

    //get script
    $.getScript("js/jquery.adipoli.js", function() {
        //set pic black to color
        $('.s_char').adipoli({
            'startEffect' : 'normal+',
            'hoverEffect' : 'popout+'
        });
    });
    //get script

    $(".char_block").hover(function() {
        var id = $(this).attr('id');
        id = "#s_" + id.replace('_', "") + " .s_char";
        console.log(id);
        $(id).trigger('mouseenter');
        
    }, function() {
        var id = $(this).attr('id');
        id = "#s_" + id.replace('_', "") + " .s_char";
        $(id).trigger('mouseleave');
    });

    $("#s_char1 ").hover(function() {
        $("#char_interface_cover").css("top", "-93.25%");
        $("#hello1").stop().animate({
            "opacity" : "1"
        }, 1000);

    }, function() {
        document.getElementById("char_interface_cover").removeAttribute('style');
        $("#hello1").stop().animate({
            "opacity" : "0"
        }, 500);
    });
    $("#s_char2").hover(function() {
        $("#char_interface_cover").css("top", "-93.25%");
        $("#hello2").stop().animate({
            "opacity" : "1"
        }, 1000);
    }, function() {
        document.getElementById("char_interface_cover").removeAttribute('style');
        $("#hello2").stop().animate({
            "opacity" : "0"
        }, 500);
    });
    $("#s_char3").hover(function() {
        $("#char_code_cover").css("top", "-93.25%");
        $("#hello3").stop().animate({
            "opacity" : "1"
        }, 1000);
    }, function() {
        document.getElementById("char_code_cover").removeAttribute('style');
        $("#hello3").stop().animate({
            "opacity" : "0"
        }, 500);
    });
    $("#s_char4").hover(function() {
        $("#char_code_cover").css("top", "-93.25%");
        $("#hello4").stop().animate({
            "opacity" : "1"
        }, 1000);
    }, function() {
        document.getElementById("char_code_cover").removeAttribute('style');
        $("#hello4").stop().animate({
            "opacity" : "0"
        }, 500);
    });
    $("#s_char5").hover(function() {
        $("#char_code_cover").css("top", "-93.25%");
        $("#hello5").stop().animate({
            "opacity" : "1"
        }, 1000);
    }, function() {
        document.getElementById("char_code_cover").removeAttribute('style');
        $("#hello5").stop().animate({
            "opacity" : "0"
        }, 500);
    });
    $("#s_char6").hover(function() {
        $("#char_market_cover").css("top", "-93.25%");
        $("#hello6").stop().animate({
            "opacity" : "1"
        }, 1000);
    }, function() {
        document.getElementById("char_market_cover").removeAttribute('style');
        $("#hello6").stop().animate({
            "opacity" : "0"
        }, 500);
    });
}//initial

function set_about_size() {
    var ratio = 1;

    ratio = get_scale_ratio();

    $(".char_info").css({
        "height" : 112 * ratio + 'px',
        "width" : 135 * ratio + 'px'
    });

    $("#about_album").css({
        "height" : 70 * ratio + 'px',
        "width" : 530 * ratio + 'px'
    });

    $(".s_char img").css({
        "height" : 70 * ratio + 'px',
        "width" : 70 * ratio + 'px'
    });   

}//set about size

