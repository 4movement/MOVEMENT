function initial_issue(map_data, map_path) {
    set_wrapper_size();
    set_issue_size();
    hash_decode();

    $("#world_map").vectorMap({
        map : 'world_en',
        backgroundColor : null,
        color : '#ffffff',
        hoverOpacity : 0.7,
        selectedColor : '#666666',
        enableZoom : true,
        showTooltip : true,
        values : map_data,
        scaleColors : ['#C8EEFF', '#006491'],
        normalizeFunction : 'polynomial'
    });

    //listener
    $("#issue .down_button, #issue > .link_wrapper .discuss").click(function() {
        $("#menu_discuss").triggerHandler("click");
    });

    $("#issue .right_button, #issue > .link_wrapper .guest_board").click(function() {
        $("#h_layout").stop().animate({
            "left" : "-100%"
        });
        $("#issue_search_wrapper").stop().animate({
            "top" : "-100%"
        });
    });

    $('#world_map').bind('labelShow.jqvmap', function(event, label, code) {
        var $label = $(".issue_data");
        var unit_base = ["", "Thousand", "Million", "Billion", "Trillion"];
        var unit = 0;
        var data = map_data[code];
        var nation = label.text();
        if (nation.length > 7) {
            nation = nation.substring(0, 7);
        }

        data = parseInt(data);
        for (; data >= 100/*1000 && unit < 4*/; unit++) {
            //data /= 1000;
            data /= 10;
            //temp
        }
        data = Math.round(data * 10) / 10;

        unit = unit_base[unit];

        $label.find("span.location").text(nation);
        $label.find("span.number").text(data);

        $label.show();

        return false;
    });

    $('#world_map').bind('regionMouseOut.jqvmap', function(event, code, region) {
        $(".issue_data").hide();
    });

    $('#world_map').bind('mousemove', function(event, code, region) {
        var $label = $(".issue_data");
        var $map = $('#world_map');

        if ($label.is(':visible')) {
            var left = event.pageX - 15 - $label.width() - $map.offset().left;
            var top = event.pageY - 0 - $label.height() - $map.offset().top;

            if (left < 0) {
                left = event.pageX + 15 - $map.offset().left;
                $label.addClass("right");
            } else {
                $label.removeClass("right");
            }
            if (top < 0) {
                top = event.pageY + 0 - $map.offset().top - $label.height() * 0.72;
                $label.addClass("bottom");
            } else {
                $label.removeClass("bottom");
            }
            $label.css({
                left : left,
                top : top
            });
        }
    });

    function open_map_label() {
        $obj = $(this).parent();
        $obj.attr("mousestate", "mouseenter");
        $obj.find("div.location").stop().animate({
            "width" : "100%"
        }, function() {
            if ($obj.attr("mousestate") == "mouseenter") {
                $obj.find(" div.number ").stop().animate({
                    "height" : "72%"
                });
            }
        });
    }

    function close_map_label() {
        $obj = $(this).parent();
        $obj.attr("mousestate", "mouseleave");

        $obj.parent().find("div.number ").stop().animate({
            "height" : "0%"
        }, function() {
            if ($obj.attr("mousestate") == "mouseleave") {
                $obj.parent().find("div.location").stop().animate({
                    "width" : "0%"
                });
            }
        });
    }

}//initial

function initial_photoWall() {
    set_wrapper_size();
    set_photoWall_size();
    hash_decode();

    var $container = $('#photoWall_wrapper');
    $container.imagesLoaded(function() {
        $container.masonry({
            // options
            itemSelector : '.photo_wall',
            columnWidth : 250,
            cornerStampSelector : '#guestboard_upload_button',
            isResizable : true
        });
    });

    $("#guestboard_issue_tag").click(function() {
        $("#menu_issue").triggerHandler("click");
    });
    $("#guestboard_discussion_group").click(function() {
        $("#menu_discuss").triggerHandler("click");
    });
    return;
}

function set_issue_size() {
    var ratio = get_scale_ratio();
    var tran_x = ($(window).width() - $(".wrapper").width()) / 2;
    var tran_y = 0;
    //($(window).height() - $(".wrapper").height())
    var window_h = $(window).height();

    $("#issue > .link_wrapper ").css({
        "bottom" : 40 * ratio - tran_y + 'px',
        "height" : 60 * ratio + 'px',
        "right" : 40 * ratio - tran_x + 'px',
        "width" : 130 * ratio + 'px'
    });

    $("#issue .side_bar").css({
        "height" : $(".wrapper").height() + 'px',
        "right" : 0 - tran_x + 'px',
        "top" : -tran_y + 'px',
        "width" : 40 * ratio + 'px'
    });

    $(".issue_data .circle").css({
        "border-width" : 8 * ratio + 'px',
        "height" : 10 * ratio + 'px',
        "width" : 10 * ratio + 'px'
    });
    $(".issue_data.multi_nation .circle").css({
        "height" : 50 * ratio + 'px',
        "width" : 50 * ratio + 'px'
    });

    $("#issue_search_wrapper").css({
        "height" : 40 * ratio + 'px',
        "width" : 202 * ratio + 'px',
        "left" : 178 * ratio + 'px'
    });

}

function set_photoWall_size() {

}
