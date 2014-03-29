function op_animate() {
    var window_h = $(window).height();

    var ratio = get_scale_ratio();
    var logo_size_b = 502 * ratio;

    $("#op_wrapper2").css({
        "top" : (window_h - logo_size_b) / 2 + 'px',
        "height" : logo_size_b + 'px',
        "width" : logo_size_b + 'px'
    });

    $("#walker").css({
        "top" : (window_h - 237.6) / 2 + 'px'
    });

    $("#loading_mask").css({
        "background-color" : "orange",
        "z-index" : 99999
    }).show();

    walker_text(3);
}//op 1

function op_animate2() {
    var window_w = $(window).width();
    var window_h = $(window).height();

    var ratio = get_scale_ratio();
    var logo_size = 192 * ratio / 1.6;
    var logo_size_b = 502 * ratio;
    var time_tick = 150;

    $("#logo_wrapper").hide();
    $("#walker").fadeOut(600, function() {
        $("#loading_mask").hide();
    });
    $("#op_wrapper2").fadeIn(700, function() {

        $("#hand_wrapper").animate({
            //line
            "width" : "93%",
            "left" : "3.5%"
        }, 3.5 * time_tick, function() {
            //show hand(?)
            //return;
            $("#hand_wrapper").animate({
                "height" : "99%"
            }, 4 * time_tick, function() {
                //show logo
                $("#op_logo_wrapper").fadeIn(2 * time_tick, function() {
                    //hide hand, change color
                    $("#hand_wrapper").css("z-index", 1).fadeOut(4 * time_tick);
                    $("#op_wrapper").animate({
                        "backgroundColor" : "black"
                    }, 3 * time_tick, function() {
                        //wrapper shrink
                        $("#op_wrapper").animate({
                            "height" : logo_size_b + 'px',
                            "width" : logo_size_b + 'px',
                            "left" : (window_w - logo_size_b) / 2 + 'px',
                            "top" : (window_h - logo_size_b) / 2 + 'px'
                        }, 5 * time_tick, function() {
                            //;ogo shrink
                            $("#op_wrapper").transition({
                                rotate : "-90deg"
                            }, 3.7 * time_tick);
                            $("#op_wrapper").animate({
                                "height" : logo_size + 'px',
                                "width" : logo_size + 'px',
                                "left" : (window_w - logo_size) / 2 + 'px',
                                "top" : (window_h - logo_size) / 2 + 'px'
                            }, 3.7 * time_tick, function() {
                                //logo get into position
                                $("#op_wrapper").animate({
                                    "left" : 28 * ratio / 1.6 + 'px',
                                    "top" : -128 * ratio / 1.6 + 'px'
                                }, 4.5 * time_tick, function() {
                                    $("#logo_wrapper").show();
                                    $(this).remove();
                                });
                            }).dequeue();
                            $("#op_logo_wrapper,#op_wrapper2").animate({
                                "height" : logo_size + 'px',
                                "width" : logo_size + 'px',
                                "left" : 0,
                                "top" : 0
                            }, 3.7 * time_tick);
                            $("#op_logo_wrapper").animate({
                                "font-size" : ratio / 1.6 + "em"
                            }, 3.7 * time_tick).dequeue();
                            $("#op_logo").animate({
                                "line-height" : 70 * ratio / 1.6 + "px"
                            }, 3.7 * time_tick);
                        });
                        $("#op_logo_wrapper,#op_wrapper2").animate({
                            "height" : logo_size_b + 'px',
                            "width" : logo_size_b + 'px',
                            "left" : 0,
                            "top" : 0
                        }, 5 * time_tick);
                    });
                    $("#op_logo div").animate({
                        "color" : "white"
                    }, time_tick);
                });
                //show logo
            });
            //show hand(?)
        });
        //line
        //initial animate
    });
}//op2

function walker_text(counter) {
    if (!$("#walker:visible").length) {
        return;
    }
    $("#walker").animate({
        "nothing" : "250"
    }, 300, function() {
        var text_str = "Loading";
        for (var i = 0; i < counter; i++) {
            text_str += '.';
        }
        /*for(var i = 0; i < 6-counter; i++){
         text_str += ' ';
         }*/
        $("#walker div").text(text_str);
        walker_text((counter + 1) % 7);
    });
}
