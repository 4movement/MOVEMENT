// larry 20140426 marked
/*
function load_movement() {
    var base_url = "codeigniter/";
    var url = base_url + "index.php/api";
    var hash_id = movement_hash_decode();
    var data = {}
    if (hash_id) {
        data.movement_id = hash_id;
    }

    $.getJSON(url, data, function(result) {
        var gallery_html = new Array(2);
        gallery_html[0] = "";
        gallery_html[1] = "";

        var count = 0;
        $.each(result.now_pass, function(i, data) {
            gallery_html[0] += movement_thumb_data2html(data);
        });
        $.each(result.future, function(i, data) {
            gallery_html[1] += movement_thumb_data2html(data);
        });
        //data
        $(".gallery_line").each(function(i) {
            $(this).html(gallery_html[i % 2]);
        });

        initial_gallery();
        set_time_line();

        $(".movement_thumb_wrapper").click(function() {
            movement_detail_data($(this));
            movement_reply_load($(this));
        });
    });
    //get json
}//load
*/

function movement_thumb_data2html(data) {
    var id, name, category, city, intro, time, location, join, support, donate, dateStartYear, dateStartMonth, dateStartDay, pathToPhoto, host, post_account, post_time, contact_url, publisher, publisher_id;
    var html_string = "";

    id = data.id;
    name = data.name;
    category = data.category;
    city = data.city;
    intro = data.intro;
    time = data.time_start;
    location = data.location;
    join = data.joins;
    support = data.support;
    donate = data.donate;
    dateStartYear = data.dateStartYear;
    dateStartMonth = data.dateStartMonth;
    dateStartDay = data.dateStartDay;
    pathToPhoto = data.small_photo;
    post_account = data.host_account;
    host = data.host;
    post_time = data.post_time;
    contact_url = data.url;
    publisher = data.username;
    publisher_id = data.No;

    html_string += '<div class = "movement_thumb_wrapper lazy_load ' + movement_filter_text(category, dateStartYear, dateStartMonth, dateStartDay, post_time, join);
    html_string += '" movement_type = "' + category + '" movement_id = "' + id + '" join = "' + join + '" support = "' + support + '" donate = "' + donate;
    html_string += '" month =  "' + dateStartMonth + '" year = "' + dateStartYear + '">';
    html_string += '<div class = "movement_thumb">';
    html_string += '<div class = "loading_mask">Loading...</div>'
    html_string += '<ul class = "tag2"><li class = "tag2 now"><img class = "tag_icon2" src= "img/movement/button/tag-now.png" /></li>';
    html_string += '<li class = "tag2 new"><img class = "tag_icon2" src= "img/movement/button/tag-new.png" /></li>';
    html_string += '<li class = "tag2 hot"><img class = "tag_icon2" src= "img/movement/button/tag-hot.png" /></li></ul>';
    html_string += '<img class = "photo" src = "#" lazy = "http://' + pathToPhoto + '"/>';
    html_string += '<div class = "text">';
    html_string += '<div class = "date">' + dateStartMonth + " / " + dateStartDay + '</div>';
    html_string += '<div class = "name">' + name + '</div>';
    html_string += '<div class = "location">';
    html_string += '<img src ="img/movement/button/location.png" />';
    html_string += city + " " + location + '</div>';
    html_string += '<div class = "type">' + '<img class = "tag_icon" src="img/movement/button/tag-icon-mini.png"/>' + category + '</div>';
    html_string += '<div class = "intro">' + intro + '</div>';
    html_string += '<div class = "time">' + time + '</div>';
    html_string += '<div class = "publisher" uid = "' + publisher_id + '">' + publisher + '</div>';
    html_string += '<div class = "contact">';
    html_string += '<div><a href = "' + contact_url + '" target = "_blank">' + host + '<h1 class = link>Link</h1>' + '</a></div>';
    html_string += '</div></div></div></div><!--thumb-->';
    return html_string;
}//movement_thumb_data2html

function movement_filter_text(type, dateStartYear, dateStartMonth, dateStartDay, post_time, join) {
    var test = movement_filter_time(dateStartYear, dateStartMonth, dateStartDay, post_time, join);
    type = type.toLowerCase();

    var type_test = movement_filter_type(type);
    var nation_test = movement_filter_nation("");
    var time_test = movement_filter_time2(test);

    (type_test && nation_test && time_test) ? test += "display " : test += "";

    return test;
}

function movement_filter_type(type) {
    type = type.toLowerCase();
    var test = false;
    $("#movement_tag_wrapper .movement_tag_list.show .movement_tag.selected").each(function() {
        var type_check = $(this).attr("movement_type").toLowerCase();
        if (type_check == "all") {
            test = true;
        }
        test = test || (type.indexOf(type_check) >= 0);
    });
    return test;
}//display filter 1

function movement_filter_time(dateStartYear, dateStartMonth, dateStartDay, post_time, join) {
    var test = "";

    //Calculate the number of years since 1970/01/01:
    var minutes = 1000 * 60;
    var hours = minutes * 60;
    var days = hours * 24;
    var years = days * 365;
    var d = new Date();
    var t = d.getTime();
    //console.log("cur " + t);
    var event_d = new Date(parseInt(dateStartYear), parseInt(dateStartMonth) - 1, parseInt(dateStartDay));
    var event_t = event_d.getTime();
    //console.log("event " + event_t);
    //console.log("Y = " + dateStartYear + " M = " + dateStartMonth + " D = " + dateStartDay);
    //console.log("diff " + Math.abs(t - event_t) / days);

    var py = post_time.substr(0, 4);
    var pm = post_time.substr(5, 2);
    var pd = post_time.substr(8, 2);
    var post_d = new Date(parseInt(py), parseInt(pm) - 1, parseInt(pd));
    var post_t = post_d.getTime();

    if (Math.abs(t - event_t) <= days * 7) {//within 7 days
        test += "now ";
    }
    if (Math.abs(t - post_t) <= days * 7) {//within 7 days
        test += "new ";
    }
    if (join > (Math.random() * 10 - 5)) {//stub
        test += "hot ";
    }

    return test;
}//class filter

function movement_filter_time2(str) {
    str = str.toLowerCase();
    var test = false;
    $("#movement_tag_wrapper_time .movement_tag_list.show .movement_tag.selected").each(function() {
        var type_check = $(this).attr("movement_type").toLowerCase();
        if (type_check == "all") {
            test = true;
        }
        test = test || (str.indexOf(type_check) >= 0);
    });
    return test;
}//time filter

function movement_filter_nation(str) {
    str = str.toLowerCase();
    var test = false;
    $("#movement_tag_wrapper_nation .movement_tag_list.show .movement_tag.selected").each(function() {
        var type_check = $(this).attr("movement_type").toLowerCase();
        if (type_check == "all") {
            test = true;
        }
        test = test || (str.indexOf(type_check) >= 0);
    });
    test = true;
    //stab
    return test;
}//nation filter

function movement_filter() {
    $(".movement_thumb_wrapper").each(function() {
        var type_test = movement_filter_type($(this).attr("movement_type"));
        var nation_test = movement_filter_nation("");
        var time_test = movement_filter_time2($(this).attr("class"));
        (type_test && nation_test && time_test) ? $(this).addClass("display") : $(this).removeClass("display");
    });
}//movement filter

function movement_detail_data($obj) {
    var id, name, category, city, intro, time, location, join, support, donate, dateStartMonth, dateStartDay, pathToPhoto, publisher, publisher_id;
    id = $obj.attr('movement_id');
    name = $obj.find('.name').text();
    category = $obj.find('.type').text();
    intro = $obj.find('.intro').text();
    time = $obj.find('.time').text();
    location = $obj.find('.location').text();
    join = $obj.attr('join');
    support = $obj.attr('support');
    donate = $obj.attr('donate');
    date = $obj.find('.date').text();
    pathToPhoto = $obj.find('.photo').attr('src').replace("_s.jpg", "_b.jpg");
    contact = $obj.find('.contact').html();
    publisher = $obj.find('.publisher').text();
    publisher_id = $obj.find('.publisher').attr("uid");

    $(".movement_detail_wrapper").attr({
        movement_id : id
    });
    $(".movement_detail_wrapper .join_button").next().find(".number").text(join);
    $(".movement_detail_wrapper .support_button").next().find(".number").text(support);
    $(".movement_detail_wrapper .donate_button").next().find(".number").text(donate);
    $(".movement_detail_wrapper .icon > img, .movement_detail_wrapper .share_link img").attr("movement_id", id);
    $(".movement_detail .date").text(date);
    $(".movement_detail .name").text(name);
    $(".movement_detail .type").text(category);
    $(".movement_detail .location").text(location);
    $(".movement_detail .intro p").text(intro);
    $(".movement_detail .time span").text(time);
    $(".movement_detail .contact").html(contact);
    $(".movement_detail .photo").unbind("load").load(function() {
        $(".movement_detail_wrapper").fadeIn();
        $("#movement>.mask").fadeIn();
        set_movement_datail_size();
    });
    $(".movement_detail .photo").attr({
        src : "#"
    })
    $(".movement_detail .photo").attr({
        src : pathToPhoto
    })
    //get publisher info
    $(".movement_detail_wrapper .rate_button p.member_photo, .movement_publisher_data_wrapper .uid, .movement_publisher_data_wrapper .name").text(publisher).attr("uid",publisher_id);
    $.ajax({
        url: 'member/get_publisher_info.php',
        type: 'POST',
        dataType: 'json',
        data: {No: publisher_id},
        success: function(data){
            $(".movement_publisher_data_wrapper .mail").text(data.email);
            $(".movement_publisher_data_wrapper .birth").text(data.birth);
            $(".movement_publisher_data_wrapper .photo img").attr('src',data.photo);
            $(".member_photo img").attr('src',data.photo);
       }
  });
    
    $(".movement_detail_wrapper .rating_cur").css({
        "width" : Math.round(Math.random() * 100) + '%'
    });

}//movement_detail_data

function set_movement_datail_size() {

    var ratio = get_scale_ratio();

    $(".movement_discuss_block, .movement_reply textarea").css({
        "border-radius" : 5 * ratio + 'px'
    });
    $(".movement_discuss_block .reply_rate").css({
        "top" : 11 * ratio + 'px',
        "height" : 54 * ratio + 'px'
    });
    $(".movement_discuss_block .username").css({
        "top" : 5 * ratio + 'px',
        "height" : 20 * ratio + 'px'
    });
}//set_movement_datail_size

function initial_movement() {

    // larry 20140426
    //initial_gallery();
    //set_time_line();
    //load_movement();
    $(".movement_thumb_wrapper").click(function() {
        movement_detail_data($(this));
        movement_reply_load($(this));
    });


    set_wrapper_size();
    set_movement_size();
    hash_decode();
    //op_animate2();   
    //fwh_edit discuss_submit_comment
    $(".submit.button").click(movement_reply_submit);

    //event listener
    $(".movement_thumb_wrapper").click(function() {
        movement_detail_data($(this));
    });

    $("#movement>.mask").click(function() {
        $(".movement_detail_wrapper").fadeOut();
        $(this).fadeOut();
    });

    $("#movement_display_mode .list").click(function() {
        $("#movement_display_mode .gallery").removeClass("selected");
        $(this).addClass("selected");
        $("#movement_gallery_wrapper").stop().animate({
            "opacity" : 0
        });
        $("#movement_list_wrapper").fadeIn();
    });
    $("#movement_display_mode .gallery").click(function() {
        $("#movement_display_mode .list").removeClass("selected");
        $(this).addClass("selected");
        $("#movement_list_wrapper").fadeOut();
        $("#movement_gallery_wrapper").stop().animate({
            "opacity" : 1
        });
    });

    //tag
    $(".movement_display_mode.tag").hover(function() {
        $(".movement_display_mode.tag").attr("mouse_state", "mouseenter");
        var ratio = get_scale_ratio();
        $("#movement_tag_wrapper").animate({
            "width" : 300 * ratio + 'px'
        }, function() {
            if ($(".movement_display_mode.tag").attr("mouse_state") == "mouseenter") {
                $("#movement_tag_wrapper").stop().animate({
                    "height" : 395 * ratio + 'px'
                });
            }//if still mouse on
        }).addClass("hover");
    }, function() {
        $(".movement_display_mode.tag").attr("mouse_state", "mouseleave");
        var ratio = get_scale_ratio();
        $("#movement_tag_wrapper").stop().animate({
            "height" : 40 * ratio + 'px'
        }, function() {
            if ($(".movement_display_mode.tag").attr("mouse_state") == "mouseleave") {
                $("#movement_tag_wrapper").animate({
                    "width" : 200 * ratio + 'px'
                }).removeClass("hover");
            }//if still mouse off
        });
    });
    $(".movement_display_mode.nation").hover(function() {
        var ratio = get_scale_ratio();
        $("#movement_tag_wrapper_nation").stop().animate({
            "height" : 302 * ratio + 'px'
        });
    }, function() {
        var ratio = get_scale_ratio();
        $("#movement_tag_wrapper_nation").stop().animate({
            "height" : 0
        });
    });
    $(".movement_display_mode.time").hover(function() {
        var ratio = get_scale_ratio();
        $("#movement_tag_wrapper_time").stop().animate({
            "height" : 216 * ratio + 'px'
        });
    }, function() {
        var ratio = get_scale_ratio();
        $("#movement_tag_wrapper_time").stop().animate({
            "height" : 0
        });
    });
    //hover

    $(".movement_tag_list.show .movement_tag").click(function() {
        var n_index = $(this).index();
        var $parent_list = $(this).parent().parent();

        if ($(this).attr("movement_type") == "All") {
            $parent_list.find(".movement_tag_list.show .movement_tag").fadeOut(1000, function() {
                $parent_list.find(".movement_tag_list.show .movement_tag").removeClass("selected");
            });
            $parent_list.find(".movement_tag_list.hide .movement_tag").fadeIn(1000, function() {
                $parent_list.find(".movement_tag_list.hide .movement_tag").removeClass("selected");
            });
        } else {
            $parent_list.find(".movement_tag_list.show .movement_tag[movement_type ='All']").fadeOut(1000, function() {
                $(this).removeClass("selected");
            });
            $parent_list.find(".movement_tag_list.hide .movement_tag[movement_type ='All']").fadeIn(1000, function() {
                $(this).removeClass("selected");
            });
        }

        $(this).fadeOut(1000, function() {
            $(this).removeClass("selected");
            //reallign gallery
            movement_filter();
            $(".movement_thumb_wrapper:not(.display)").stop().animate({
                "opacity" : 0
            });
            $(".movement_thumb_wrapper.display").stop().animate({
                "opacity" : 1
            });
            initial_gallery();
            movement_month();
            lazy_movement();
            //check load
        });
        $parent_list.find(".movement_tag_list.hide .movement_tag").eq(n_index).fadeIn(1000, function() {
            $(this).removeClass("selected");
        });

    });
    $(".movement_tag_list.hide .movement_tag").click(function() {
        var n_index = $(this).index();
        var $parent_list = $(this).parent().parent();

        if ($(this).attr("movement_type") == "All") {
            $parent_list.find(".movement_tag_list.hide .movement_tag").fadeOut(1000, function() {
                $parent_list.find(".movement_tag_list.hide .movement_tag").addClass("selected");
            });
            $parent_list.find(".movement_tag_list.show .movement_tag").fadeIn(1000, function() {
                $parent_list.find(".movement_tag_list.show .movement_tag").addClass("selected");
            });
        }

        $(this).fadeOut(1000, function() {
            $(this).addClass("selected");
        });

        $parent_list.find(".movement_tag_list.show .movement_tag").eq(n_index).fadeIn(1000, function() {
            $(this).addClass("selected");
            var test = true;
            $parent_list.find(".movement_tag_list.show .movement_tag:not([movement_type ='All'])").each(function() {
                test = test && $(this).hasClass("selected");
            });
            if (test) {
                $parent_list.find(".movement_tag_list.hide .movement_tag[movement_type ='All']").fadeOut(1000, function() {
                    $(this).addClass("selected");
                });
                $parent_list.find(".movement_tag_list.show .movement_tag[movement_type ='All']").fadeIn(1000, function() {
                    $(this).addClass("selected");
                });
            }

            //reallign gallery
            movement_filter();
            $(".movement_thumb_wrapper:not(.display)").stop().animate({
                "opacity" : 0
            });
            $(".movement_thumb_wrapper.display").stop().animate({
                "opacity" : 1
            });
            initial_gallery();
            movement_month();
            lazy_movement();
            //check load
        });
    });

    $("#movement_tag_wrapper_time .movement_tag_list.show .movement_tag").unbind();
    $("#movement_tag_wrapper_time .movement_tag_list.hide .movement_tag").unbind().click(function() {
        var n_index = $(this).index();
        $("#movement_tag_wrapper_time .movement_tag_list.show .movement_tag.selected").fadeOut(1000, function() {
            $(this).removeClass("selected");
        })
        $("#movement_tag_wrapper_time .movement_tag_list.hide .movement_tag.selected").fadeIn(1000, function() {
            $(this).removeClass("selected");
        })
        $(this).fadeOut(function() {
            $(this).addClass("selected");
        });
        $("#movement_tag_wrapper_time .movement_tag_list.show .movement_tag").eq(n_index).fadeIn(1000, function() {
            $(this).addClass("selected");
            //reallign gallery
            movement_filter();
            $(".movement_thumb_wrapper:not(.display)").stop().animate({
                "opacity" : 0
            });
            $(".movement_thumb_wrapper.display").stop().animate({
                "opacity" : 1
            });
            initial_gallery();
            movement_month();
            lazy_movement();
            //check load
        });

    });
    //tag

    $(".movement_detail_wrapper .issue_button").click(function() {
        $(".movement_detail_wrapper,#movement>.mask ").fadeOut();
        $("#menu_issue").triggerHandler("click");
    });

    $(".movement_detail_wrapper div.join_button").click(function() {
        var $obj = $(".movement_detail_wrapper");

        var movementID = $obj.attr("movement_id");

        var url = "http://merry.ee.ncku.edu.tw/~smart0eddie/cur/codeigniter/index.php/api/joinmovement";
        $.post(url, {
            "movementID" : movementID
        }, function(response) {

            if (response.state == "unsigned") {
                alert("請先登入");
            } else if (response.state == "alreadyjoined") {
                //alert
            } else if (response.state == "success") {
                //alert
                console.log(response.joins);
                $obj.find(".join_button .number").text(response.joins);
                $(".movement_thumb_wrapper[movement_id = '" + movementID + "' ]").attr("join", response.joins);
            }

        });
        //ajax
    });

    $(".movement_detail_wrapper .rate_button").click(function() {
        var movementID = $(".movement_detail_wrapper").attr("movement_id");
        var url = "";
        $.post(url, {
            "movementID" : movementID
        }, function(response) {
            var $obj = $(".movement_publisher_data_wrapper");
            $obj.find(".photo img").attr("src", response.photo);
            $obj.find(".uid").text(response.uid);
            $obj.find(".name").text(response.name);
            $obj.find(".birth").text(response.birth);
            $obj.find(".mail a").attr("href", "mailto:" + response.mail).text(response.mail);
            $obj.find(".phone").text(response.phone);
            if (response.mail_validate) {
                $obj.find(".mail_v").addClass("selected");
            } else {
                $obj.find(".mail_v").removeClass("selected");
            }
            if (response.phone_validate) {
                $obj.find(".phone_v").addClass("selected");
            } else {
                $obj.find(".phone_v").removeClass("selected");
            }
            var list_html = '<li class = "title">Published Movement List</li>';
            $.each(response.list, function(i, v) {
                list_html += '<li class = "list" movement_id = "' + v.movement_id + '" >';
                list_html += '<div class = "date" >' + v.movement_date + '</div>';
                list_html += '<div class = "name" >' + v.movement_name + '</div> </li>';
            });
            $obj.find(".publish_movement_list").html(list_html);
            $obj.fadeIn();
        });
        //ajax
        $(".movement_publisher_data_wrapper").fadeIn();
    });

    $(".movement_publisher_data_wrapper .close").click(function() {
        $(".movement_publisher_data_wrapper").fadeOut();
    });
    //click

    $(".movement_detail_wrapper .share_link").click(function() {
        var id = $(this).attr("movement_id") || $(".movement_detail_wrapper").attr("movement_id");
        var share_target = $(this).attr("share");
        share(share_target, "movement", id);
    });

}//initial

function initial_gallery() {

    var ratio;

    ratio = get_scale_ratio();
    set_gallery_size();

    $("#movement_gallery .gallery_line").each(function(i) {
        var x_sum = Array(2);
        x_sum[0] = (30 * (i % 2) + Math.random() * 30 + Math.random() * 30) * ratio;
        x_sum[1] = (30 * (i % 2) + Math.random() * 10 + Math.random() * 50) * ratio;

        $(this).find(".movement_thumb_wrapper.display").each(function(j) {
            var img_w = $(this).find('.photo').width();
            img_w = img_w ? img_w : 375 * ratio;
            var img_h = $(this).find('.photo').height();
            $(this).stop().css({
                "width" : img_w + 'px',
                "top" : 10 * ratio + 310 * ratio * (j % 2) + 'px'
            });
            if (i % 2 == 0) {//current and past, on the right
                $(this).stop().animate({
                    "left" : x_sum[j % 2] + 'px'
                }).dequeue();
            }//end if
            else {//future on left
                $(this).stop().animate({
                    "right" : x_sum[j % 2] + 'px'
                }).dequeue();
            }//end else
            x_sum[j % 2] += img_w * (1 + (Math.random() * 1 - Math.random() * 1 + 7) / 30);
        });
    });
    //gallery line

    lazy_movement();
}//gallery

function lazy_movement() {
    var window_w = $(window).width();
    var count = parseInt($("#movement_gallery").attr('unload_photo')) || 0;

    $("#movement_gallery .gallery_line .movement_thumb_wrapper.display.lazy_load").each(function() {
        var left = $(this).offset().left;
        if (left < 0 && left >= -0.5 * window_w || left < 1.3 * window_w) {
            var $photo = $(this).find(".photo");
            count++;
            $(this).removeClass('lazy_load');
            $photo.attr('src', $photo.attr("lazy")).addClass('lazy_loading');
        }
    });

    $("#movement_gallery").attr({
        'unload_photo' : count
    });

    var hash_id = movement_hash_decode();
    $(".gallery_line .photo.lazy_loading").unbind("load").load(function() {
        unload_photo = parseInt($("#movement_gallery").attr('unload_photo')) - 1;
        $("#movement_gallery").attr({
            'unload_photo' : unload_photo
        });
        $(this).removeClass("lazy_loading").hide().fadeIn();
        $(this).parent().parent().addClass("lazy_loaded").find(".loading_mask").remove();
        // console.log(unload_photo);
        if (unload_photo == 0) {
            console.log("lazy loaded");
            resize_gallery("lazy");
            if ( typeof op_animate2 == 'function' && $("#op_wrapper").length) {
                op_animate2();
            }
            if (hash_id) {
                movement_hash(hash_id);
                window.location.hash = "";
            }
        }//set size
    });
}//lazy load

function movement_month(month, year) {
    if (!month || !year) {
        $("#movement_gallery .gallery_line.future .movement_thumb_wrapper.display").each(function() {
            if (!month && $(this).offset().left >= 0) {
                month = $(this).attr("month");
            }
            if (!year && $(this).offset().left >= 0) {
                year = $(this).attr("year");
            }
        });
        if (!month || !year) {
            $("#movement_gallery .gallery_line.past .movement_thumb_wrapper.display").each(function() {
                if (!month && $(this).offset().left >= 0) {
                    month = $(this).attr("month");
                }
                if (!year && $(this).offset().left >= 0) {
                    year = $(this).attr("year");
                }
            });
        }
    }
    month = parseInt(month);
    year = parseInt(year);

    $obj = $("#movement_month_list .selected");

    if ($obj.attr("month") != month) {
        $obj.removeClass("selected");
        $("#movement_month_list [month = '" + month + "']").addClass("selected");
    }//change month
    if ($obj.attr("year") != year) {
        $("#movement_month_list .month_list[month]").attr("year", year);
        $("#movement_month_list .month_list:first").attr("year", year + 1).find("span").text(year + 1);
        $("#movement_month_list .month_list:last").attr("year", year - 1).find("span").text(year - 1);
    }//change year
}//month

function resize_gallery(mode) {
    var ratio = get_scale_ratio();
    mode = (mode == "lazy") ? ".lazy_loaded" : "";
    set_gallery_size();

    //gallery line
    $("#movement_gallery .gallery_line").each(function(i) {
        var x_sum = Array(2);
        var temp;
        if (i % 2 == 0) {
            temp = $(this).find(".movement_thumb_wrapper.display").css("left") || "0px";
            temp = parseInt(temp.substring(0, temp.indexOf('px')));
            x_sum[0] = temp;
            temp = $(this).find(".movement_thumb_wrapper.display").first().next().css("left") || $(this).find(".movement_thumb_wrapper.display").css("left") || "0px";
            temp = parseInt(temp.substring(0, temp.indexOf('px')));
            x_sum[1] = temp;
        } else {
            temp = $(this).find(".movement_thumb_wrapper.display").css("right") || "30px";
            temp = parseInt(temp.substring(0, temp.indexOf('px')));
            x_sum[0] = temp;
            temp = $(this).find(".movement_thumb_wrapper.display").first().next().css("right") || $(this).find(".movement_thumb_wrapper.display").css("right") || "30px";
            temp = parseInt(temp.substring(0, temp.indexOf('px')));
            x_sum[1] = temp;
        }
        $(this).find(".movement_thumb_wrapper.display").each(function(j) {
            var img_w = $(this).find('.photo').width();
            img_w = img_w ? img_w : 375 * ratio;
            var img_h = $(this).find('.photo').height();
            $(this).css({
                "width" : img_w + 'px',
                "top" : 10 * ratio + 310 * ratio * (j % 2) + 'px'
            });
            if (mode == "" || mode == ".lazy_loaded" && ($(this).hasClass("lazy_loaded") || $(this).hasClass("lazy_load"))) {
                if (i % 2 == 0) {//current and past, on the right
                    $(this).stop().animate({
                        "left" : x_sum[j % 2] + 'px'
                    }).dequeue();
                }//end if
                else {//future on left
                    $(this).stop().animate({
                        "right" : x_sum[j % 2] + 'px'
                    }).dequeue();
                }//end else
            }//if
            x_sum[j % 2] += img_w * (1 + 7 / 30);

            $(this).removeClass("lazy_loaded");
        });
    });

}//gallery size

function set_gallery_size() {
    var window_w = $(window).width();
    var window_h = $(window).height();
    var tran_x = $("#movement").css("left");
    var ratio = get_scale_ratio();

    $("#movement_gallery").css({
        "width" : window_w + 'px',
        "left" : '-' + tran_x
    });

    $("#movement_calender .blkbar").css({
        "top" : -5 * ratio + 'px'
    });

    $("#movement_month_list .month_list .circle,#movement_calender .blkbar").css({
        "border-width" : 5 * ratio + 'px'
    })

    $("#movement_gallery > button").css({
        "width" : 73 * ratio + 'px'
    })
    $("#movement > .mask").css({
        "width" : window_w + 'px',
        "height" : window_h + 'px'
    })

    $(".movement_detail_wrapper .icon_list").css({
        "height" : 49 * ratio + 'px'
    });
    $(".movement_detail_wrapper .icon_list .text").css({
        "padding" : 8 * ratio + 'px 0 0 ' + 16 * ratio + 'px',
        "height" : 72 * ratio + 'px'
    });
    $(".movement_detail_wrapper .icon_list .unit").css({
        "margin" : 4 * ratio + 'px',
    });
    $(".movement_detail_wrapper .rating_wrapper").css({
        "width" : 125 * ratio + 'px'
    });
    $(".movement_detail_wrapper div.share_link").css({
        "height" : 80 * ratio + 'px'
    });
    $(".movement_discuss").css({
        "height" : 336 * ratio + 'px'
    });
    $(".movement_reply").css({
        "height" : 24 * ratio + 'px'
    });
    $(".movement_reply textarea").css({
        "width" : 356 * ratio + 'px'
    });
    set_movement_datail_size();

    $("#movement_display_mode_wrapper:not(.hover)").css({
        "width" : 200 * ratio + 'px',
        "height" : 40 * ratio + 'px',
        "left" : 192 * ratio + 'px'
    });
    $("#movement_display_mode_wrapper.hover").css({
        "width" : 300 * ratio + 'px',
        "height" : 40 * ratio + 'px',
        "left" : 192 * ratio + 'px'
    });
    $("#movement_display_mode").css({
        "width" : 200 * ratio + 'px',
        "height" : 40 * ratio + 'px'
    });
    $("#movement_tag_wrapper:not(.hover)").css({
        "width" : 200 * ratio + 'px',
        "top" : -4 * ratio + 'px',
        "height" : 40 * ratio + 'px'
    });
    $("#movement_tag_wrapper.hover").css({
        "width" : 300 * ratio + 'px',
        "top" : -4 * ratio + 'px',
        "height" : 40 * ratio + 'px'
    });
    $("#movement_tag_wrapper").css({
        "width" : 200 * ratio + 'px',
        "top" : -4 * ratio + 'px',
        "height" : 40 * ratio + 'px'
    });
    $("#movement_tag_wrapper_nation").css({
        "width" : 158 * ratio + 'px',
        "top" : -4 * ratio + 'px'
    });
    $("#movement_tag_wrapper_time").css({
        "width" : 118 * ratio + 'px',
        "top" : -4 * ratio + 'px'
    });
    $(".movement_tag").css({
        "margin" : '0 0 ' + 9 * ratio + 'px ' + 12 * ratio + 'px'
    });
    $(".movement_tag .selection").css({
        "width" : 14 * ratio + 'px'
    });
    $("#movement_tag_wrapper2, #movement_tag_wrapper_nation2, #movement_tag_wrapper_time2").css({
        "padding" : 63 * ratio + 'px 0 ' + 18 * ratio + 'px 0'
    });

    $(".movement_thumb_wrapper").css({
        "opacity" : 0
    });
    $(".movement_thumb_wrapper.display").css({
        "opacity" : 1
    });
    $(".movement_thumb .loading_mask").css({
        "line-height" : 250 * ratio + 'px'
    });

    $("#movement ul.tag2").css({
        "width" : 36 * ratio + 'px',
        "height" : 27 * ratio + 'px'
    });
    $("#movement_display_mode_wrapper2").css({
        "width" : 150 * ratio + 'px',
        "height" : 30 * ratio + 'px',
        "left" : 335 * ratio + 'px'
    });

}//set gallery size

function set_movement_size() {
    set_gallery_size();
    set_movement_datail_size();
    resize_gallery();
    lazy_movement();
}//set movement size

//movement_detail_discuss_js

function movement_reply_load($obj) {
    var id = $obj.attr('movement_id');

    var base_url = "codeigniter/index.php/discuss/";
    var url = base_url + "getMovementComment";
    $.post(url, {
        "movementID" : id
    }, function(response) {
        var r_html = "";
        $.each(response, function(i, r) {
            var data = {};
            data.reply_id = r.id;
            data.user_name = r.username;
            data.like = r.like;
            data.dislike = r.dislike;
            data.comment = r.comment;
            r_html += movement_reply_html(data);
        });

        $(".movement_discuss_content").html(r_html);
        set_movement_datail_size();

        $(".movement_discuss_block .reply_rate").click(function() {
            var $obj = $(this);
            var url = "codeigniter/index.php/discuss/";
            url += $obj.hasClass("agree") ? "dlike" : "ddislike";
            var id = $obj.parent().attr("reply_id");
            $.post(url, {
                "reply_id" : id,
                "dm" : 0
            }, function(response) {
                if (response.state == "success") {
                    $obj.hasClass("agree") ? $obj.find("span").text(response.likeUpdated) : $obj.find("span").text(response.dislikeUpdated);
                } else if (response.state == "disliketolike") {
                    //alert("favor change");
                    $obj.find("span").text(response.likeUpdated);
                    $obj.siblings('.disagree').find("span").text(response.dislikeUpdated);
                } else if (response.state == "liketodislike") {
                    //  alert("favor change");
                    $obj.find("span").text(response.dislikeUpdated);
                    $obj.siblings('.agree').find("span").text(response.likeUpdated);
                } else {
                    if (response.msg) {
                        alert(response.msg);
                    }
                }
            })
        });
    });
}//load reply

function movement_reply_submit() {
    if (localStorage["check_login"] == "false") {
        alert("請先登入");
        $("#menu_login").trigger("click");
        $("#menu").css("z-index", "150");
        return;
    }

    var moveID = $("div.movement_detail_wrapper").attr("movement_id");
    var comment = $(".movement_reply.movement_discuss_wrapper2 > textarea").val().toString();
    var regex = /[\n\s]+/g
    //alert(moveID);
    if (comment.replace(regex, "").replace("\n", "").length < 5) {
        alert("Please enter more than 5 character");
        return;
    }//tooo short
    var base_url = "codeigniter/index.php/discuss/";
    var url = base_url + "sendMovementComment";
    $.post(url, {
        "movementID" : moveID,
        "comment" : comment
    }, function(response) {
        if (response.state == "unsigned") {
            alert("請先登入2");
            logout_mod();
            $("#menu_login").trigger("click");
            $("#menu").css("z-index", "150");
        }//unsigned
        else if (response.state == "signedin") {
            $(".movement_reply.movement_discuss_wrapper2 > textarea").val("");

            var data = {};
            data.user_name = response.f_username || localStorage['user_name'] || "Demo";
            data.reply_id = response.f_cid;
            data.comment = comment;
            var r_html = movement_reply_html(data);
            console.log(r_html);
            if (r_html == "error") {
                alert("Oops, something went wrong, please try again later.");
            } else {
                $(r_html).prependTo(".movement_discuss_content").hide().fadeIn();
                set_movement_datail_size()
            }
        }
        //signed
    });
    //ajax

}//reply

function movement_reply_html(data) {
    var comment = data.comment || false;
    var reply_id = data.reply_id || false;
    var user_name = data.user_name || "Demo";
    var like = data.like || 0;
    var dislike = data.dislike || 0;

    if ((!comment) || (!reply_id)) {
        return "false"
    };

    var html = "";

    html += '<div class = "movement_discuss_block" reply_id = "' + reply_id + '">';
    html += '<div class = "username">' + user_name + '</div>';
    html += '<div class = "text">' + comment + '</div>';
    html += '<div class = "agree reply_rate"><span>' + like + '</span><img class="agree_icon" src="./img/discuss/agree-icon.png"/></div>';
    html += '<div class = "disagree reply_rate"><span>' + dislike + '</span><img class="disgree_icon" src="./img/discuss/disagree-icon.png"/></div>';
    html += '</div><!--movement_discuss_block-->';

    return html;

}//reply html

function movement_hash(id) {
    if ($(".movement_thumb_wrapper[movement_id = '" + id + "' ]").length) {
        $(".movement_thumb_wrapper[movement_id = '" + id + "' ]").trigger('click');
    } else {
        //load movement if not exist
    }
}//hash movement

function movement_hash_decode() {
    var hash_tag = window.location.hash.substring(1).toLowerCase();
    if (!isNaN(hash_tag)) {
        return parseInt(hash_tag, 10);
    }
}


$(document).ready(function(){
	// open or close issue data
	$(".op_issue_data_wrapper").click(function(){
		$(".issue_data_wrapper").toggle();
	});
	// close detail
	$("#detail_close").click(function(){
		$("#movement_list_detail").toggle();
	});
});
