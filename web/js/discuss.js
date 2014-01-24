function initial_discuss() {

    //initial
    topic_list();
    // fwh_edit ��k�䪺�d���q��ݮ�DATA
    set_wrapper_size();
    set_discuss_size();
    hash_decode();
    // discuss_article("低碳VS.非核家園核四議題攻防");

    //event
    $("#newtopic").click(function() {
        $("#discuss_reply_wrapper").fadeOut();
        $("#new_article_wrapper").fadeIn();
    });

    $("#discuss_new_cancel").click(function() {
        $("#discuss_reply_wrapper").fadeIn();
        $("#new_article_wrapper").fadeOut();
    });

    $("#discuss .back_to_issue").click(function() {
        $("#menu_issue").trigger('click');
    });

    $(window).resize(function() {
        set_discuss_size();
    });

    //fwh_edit discuss comment submit
    $("#discuss .reply_submit").click(function() {
        var text = $("#discuss .reply_textarea").val().toString();
        var regex = /[\n\s]+/g
        if (text.replace(regex, "").replace("\n", "").length < 5) {
            alert("Please enter more than 5 character");
            return;
        }//tooo short
        console.log(text);
        var topicID = $(".discuss_list.selected").attr("topic_id");
        var topicName = $(".discuss_list.selected > p").text();
        var base_url = "";
        var url = base_url + "http://merry.ee.ncku.edu.tw/~smart0eddie/cur/codeigniter/index.php/discuss/senddiscusscomment";
        $.post(url, {
            "comment" : text,
            "title" : topicName,
            "topicID" : topicID
        }, function(response) {
            if (response.state == "success") {
                alert(response.state);
                $("#discuss_reply_wrapper > .reply_content").append(discuss_reply_html(text, response.username, response.date, 0, 0, response.reply_id));
                $(".reply_textarea").val("");
            }//success
            else if (response.state == "unsigned") {
                alert("請先登入");
            } else {
                $(discuss_reply_html(text, "DEMO")).appendTo("#discuss_reply_wrapper > .reply_content").hide().fadeIn();
                //alert(response.msg);
            }
            //fail
        });
        //ajax
    });
    //reply

    //fwh_edit new topic submit
    $("#discuss_new_submit").click(function() {
        var new_topic = $("#article_topic_type").val().toString();
        var first_comment = $(".article_edit > .article_edit_type").val().toString();
        var base_url = "http://merry.ee.ncku.edu.tw/~smart0eddie/cur/codeigniter/index.php/discuss/newtopic";
        var url = base_url + "";
        var regex = /[\n\s]+/g
        if (new_topic.replace(regex, "").replace("\n", "").length < 5) {
            alert("Topic should be more than 5 character");
            return;
        }//tooo short
        else if (first_comment.replace(regex, "").replace("\n", "").length < 5) {
            alert("Your comment is too short!");
            return;
        }//tooo short
        else {
            $.post(url, {
                "new_topic" : new_topic,
                "first_comment" : first_comment
            }, function(response) {

                if (response.state == "unsigned") {
                    alert("請先登入");
                    logout_mod();
                    $("#menu_login").trigger("click");
                    $("#menu").css("z-index", "150");
                }//unsigned
                else if (response.state == "success") {
                    var a_id = response.articleID;
                    list_html = discuss_list_html(a_id, new_topic, 1, 0);
                    $(list_html).prependTo("ul.discuss_list_wrapper").hide().fadeIn().click(discuss_article_click).trigger("click");
                    set_discuss_list_size();
                }
            });
            //ajax
        }
        //char more than 5
    });
    //add discuss topic

}//initial discuss

function discuss_comment_like(commentid) {
}

function discuss_reply_html(text, user_id, date, agree, disagree, reply_id) {
    var html = "";
    agree = agree || 0;
    disagree = disagree || 0;
    date = date || "";
    reply_id = reply_id || "";
    user_id = user_id || "Demo";

    html += '<div class="reply_content" reply_id = "' + reply_id + '">';
    html += '<div class = "title"><div class="reply_username"><p>';
    html += user_id + '</p></div>';
    html += '<div class="agree_number rate_number"><p class="rate_number">';
    html += agree + '</p><img src="./img/discuss/agree-icon.png" class="agree_icon rate_icon"></div>';
    html += '<div class="disagree_number rate_number"><p class="rate_number ">';
    html += disagree + '</p><img src="./img/discuss/disagree-icon.png" class="disgree_icon rate_icon"></div></div>';
    html += '<div class="reply_user_content"><p>';
    html += text + '</p> </div> </div><!--reply-->';

    return html;
}//reply html

//fwh_edit �����D�ت�li tag
function discuss_list_html(id, name, isNew, firstSelect) {
    var html = "";
    if (firstSelect == "1") {
        html += '<li class="discuss_list selected" topic_id="' + id + '">';
    } else {
        html += '<li class="discuss_list" topic_id="' + id + '">';
    }
    html += '<p>' + name + '</p>';
    if (isNew == "1") {
        html += '<img class="new_icon" src="./img/discuss/new-icon.png">';
    }
    html += '<div class = "discuss_triangle"></div></a><div class="dummy_bk"></div></li>';
    return html;
}

//fwh_edit
function topic_list() {
    var base_url = "";
    var url = base_url + "http://merry.ee.ncku.edu.tw/~smart0eddie/cur/codeigniter/index.php/discuss/getdistopic";
    var firstSelected = 1;
    //test "select";
    var firstNew = 1;
    //test "new"
    $.post(url, {}, function(response) {

        set_discuss_size();

        $.each(response, function(i, data) {
            //return;
            $("#discuss_list_wrapper > .discuss_list_wrapper").append(discuss_list_html(response[i].discuss_topic_id, response[i].discuss_topic_name, firstNew, firstSelected));

            //discuss_reply_html();
            firstSelected = 0;
            firstNew = 0;
        });

        var firstTopic = $(".discuss_list.selected").children("p").text();
        discuss_article(firstTopic);
        set_discuss_list_size();

        $(".discuss_list").click(discuss_article_click);

    });

    //set_discuss_size();
}

function discuss_article(titleName) {
    //return;
    var base_url = "";
    var url = base_url + "http://merry.ee.ncku.edu.tw/~smart0eddie/cur/codeigniter/index.php/discuss/popdiscommentbyname";
    $.post(url, {
        "name" : titleName
    }, function(response) {
        $.each(response, function(i, data) {
            //return;
            $("#discuss_reply_wrapper > .reply_content").append(discuss_reply_html(response[i].comment, response[i].userName, response[i].uptime, response[i].like, response[i].dislike, response[i].id));
            //discuss_reply_html();

        });
        //each

        $("#discuss_reply_wrapper div.rate_number").click(function() {
            //alert("click");
            var url = "http://merry.ee.ncku.edu.tw/~smart0eddie/cur/codeigniter/index.php/discuss/dlike";
            var d_url = "http://merry.ee.ncku.edu.tw/~smart0eddie/cur/codeigniter/index.php/discuss/ddislike";
            var commentid = $(this).parents().eq(1).attr('reply_id');
            var $obj = $(this);
            var rate = $obj.hasClass("agree_number") ? "agree" : "disagree";
            //alert(rate);

            if (rate == "agree") {
                $.post(url, {
                    "commentID" : commentid,
                    "dm" : "1",
                }, function(response) {
                    // alert("here");
                    if (response.state == "success") {
                        $obj.find("p").text(response.likeUpdated);
                    } else if (response.state == "disliketolike") {
                        //alert("favor change");
                        $obj.find("p").text(response.likeUpdated);
                        $obj.siblings('.disagree_number.rate_number').find("p").text(response.dislikeUpdated);
                    } else {
                        //alert(response.state);
                        //alert(response.likeUpdated);
                        //alert(response.msg);
                    }
                });
            } else {
                $.post(d_url, {
                    "commentID" : commentid,
                    "dm" : "1",
                }, function(response) {
                    //alert("here");
                    if (response.state == "success") {
                        $obj.find("p").text(response.dislikeUpdated);
                        alert(response.dislikeUpdated);
                    } else if (response.state == "liketodislike") {
                        //	alert("favor change");
                        $obj.find("p").text(response.dislikeUpdated);
                        $obj.siblings('.agree_number.rate_number').find("p").text(response.likeUpdated);
                    } else {
                        //  alert(response.state);
                        //alert(response.msg);
                    }
                });

            }//else
        });

    });
}//discuss article

function discuss_article_click() {

    var title = $(this).children("p").text();
    //alert(title);
    var reply_title = "Topic " + title;
    $(".discuss_list.selected").removeClass("selected");
    $(this).addClass("selected");

    $(".reply_topic").children("p").text(reply_title);

    $(".reply_content > .reply_content").remove();
    discuss_article(title);
    $("#new_article_wrapper").fadeOut();
    $("#discuss_reply_wrapper").fadeIn();

}//article click

function set_discuss_size() {
    var ratio = get_scale_ratio();
    var window_w = $(window).width();
    var window_h = $(window).height();
    var tran_x = $("#discuss").css("left");
    tran_x = parseInt(tran_x.substring(0, tran_x.indexOf('px')));

    $("#newtopic").css({
        "width" : 150 * ratio + 'px'
    });
    $("#discuss .icon_btn").css({
        "width" : 28 * ratio + 'px'
    });

    $(".article_edit_type").css({
        "height" : 300 * ratio + 'px',
        "margin-top" : 60 * ratio + 'px'
    });
    $("#discuss_new_button .button, #discuss_cancel_button .button").css({
        "height" : 37.5 * ratio + 'px',
        "width" : 175 * ratio + 'px'
    });

    $("#discuss_new_button, #discuss_cancel_button, #discuss .back_to_issue, #newtopic").css("font-size", 12.8 * ratio + 'px');
    $("#discuss .reply_icon_area").css("font-size", 16 * ratio + 'px');

    //if (tran_x > 0) {
    $("#discuss_l_wrapper").css({
        "width" : window_w * 0.3005 + 'px',
        "left" : window_w * 0.0875 - tran_x + 'px'
    });
    $("#discuss_topic_wrapper").css({
        "width" : window_w * 0.3786 + 'px'
    });
    $("#discuss_topic_wrapper .dummy_bk").css({
        "width" : window_w + 'px'
    });

    $("#discuss_r_wrapper").css({
        "width" : window_w * 0.52 + 'px',
        "left" : window_w * 0.4656 - tran_x + 'px'
    });

    $("#discuss_list_wrapper ").css({
        "width" : window_w * 1 + 'px'
    });
    $("ul.discuss_list_wrapper ").css({
        "width" : window_w * 0.3005 + 'px'
    });

    set_discuss_list_size();
    /*}//if
     else{
     $("#discuss_r_wrapper").css({
     "width" : "53.8%",
     "left" : "46.5%"
     });
     $("#discuss_topic_wrapper").css({
     "width" : "100%"
     });
     $("#discuss_l_wrapper").css({
     "width" : "46.5%",
     "left" : 0
     });
     }//else*/

}//discuss size

function set_discuss_list_size() {
    var ratio = get_scale_ratio();
    var window_w = $(window).width();
    var tran_x = $("#discuss").css("left");
    tran_x = parseInt(tran_x.substring(0, tran_x.indexOf('px')));

    $(".discuss_list .dummy_bk").css({
        "width" : window_w + 'px',
        "height" : (30 * ratio + 15.5 * ratio + 15.5 * ratio) + 'px'
    });
    $(".discuss_list").css({
        "padding" : 15.5 * ratio + 'px 0',
        "margin" : 17 * ratio + 'px 0 0 ' + 0 * ratio + 'px ',
        "height" : 30 * ratio + 'px'
    });
    $(".discuss_list .discuss_triangle").css({
        "border-width" : 30 * ratio + 'px ' + 30 * ratio + 'px ' + 30 * ratio + 'px 0'
    });

    $(".reply_content .reply_content").css({
        "margin" : 17 * ratio + "px 0 0 " + 21 * ratio + "px",
        "border-bottom-width" : 3 * ratio + "px",
        "padding-bottom" : 25 * ratio + "px"
    });
    $(".reply_content .title ").css({
        "height" : 57 * ratio + "px"
    });
    $(".reply_user_content").css({
        "top" : 23 * ratio + "px"
    });
    $(".reply_user_content p ").css({
        "margin" : 21 * ratio + "px 0 0"
    });
    $(".reply_content div.rate_number").css({
        "width" : 28 * ratio + "px"
    });
}//discuss list
