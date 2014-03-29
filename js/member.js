function initial_member() {
    
    //initial
    set_member_size();
    //load_yui();

    //events
    $("#member_user_photo").click(function(event) {
        crop_open(event, "member");
    });
    /*
    $("#member_setting button.submit").click(function(event) {
        console.log("submit member data");
        var url = "member/user_setting_update.php";
        $.post(url, {

        }, function(result) {
            console.log(result);
        });
        event.preventDefault();
    });
    */
    //-------
        //modify------
        $("#member .submit").click(function(event) {
        var url = "member/user_setting_update.php";
        var name = $("#member input[name = 'name']").val() || id;
        var pw = $("#member input[name = 'pw']").val();
        var email = $("#member input[name = 'email']").val();
        var birth = $("#member input[name = 'birth']").val();
        var gender = $("#member input[name = 'gender']:checked").val();
        var address = $("#member textarea[name = 'address']").val();
        var phone = $("#member input[name = 'phone']").val();
        var username_public = $("ul[id='member_list_form'] li:nth-child(1) img").attr('public');
        var email_public = $("ul[id='member_list_form'] li:nth-child(4) img").attr('public');
        var birth_public = $("ul[id='member_list_form'] li:nth-child(5) img").attr('public');
        var gender_public = $("ul[id='member_list_form'] li:nth-child(6) img").attr('public');
        var address_public = $("ul[id='member_list_form'] li:nth-child(7) img").attr('public');
    

        var check = check_modify_data(pw, email, birth);
		console.log("modify submit");
		//modify---
        if (check.check) {
            $.post(url, {
                'username' : name,
                'pw' : pw,
                'email' : email,
                'birth' : birth,
                'gender' : gender,
                'address' : address,
                'phone' : phone,
                'username_public' : name_public,
                'email_public' : email_public,
                'birth_public' : birth_public,
                'gender_public' : gender_public,
                'address_public' : address_public,
            }, function(result) {
            	/*
            	if(result.username){
            		
            	}
            	*/
            console.log(result);
    			alert("資料修改成功");
            })
            .fail(function(){
    			alert("資料修改失敗");
            });
        } 
		//-----
        event.preventDefault();
    });
        var check_modify_data = function(pw, email, birth) {
        var checkemail = /^[^@^\s]+@[^\.@^\s]+(\.[^\.@^\s]+)+$/;
		var checkbirth = /^\d{4}\-\d\d?\-\d\d?$/;
		
        var check = true;
        if (pw!="" && pw.length <= 3) {
            check = false;
            alert("請輸入4字以上密碼");
        }
        if (!checkemail.test(email)) {
            check = false;
            alert("E-mail格式不正確");
        }
		if(birth!="" && !birth.match(checkbirth)){
            check = false;
            alert("birth格式不正確(YYYY-MM-DD)");
		}
		
        return {
            "check" : check
        };
    };
    
    //-------

    $(".member_function_button2").click(function() {
        if (! $(this).hasClass('selected')) {
            var id = $(this).attr('id').replace("function_", "");
            $(".member_function_content_wrapper.selected").fadeOut("fast", function() {
                $(this).removeClass("selected");
            });
            $('#' + id).fadeIn("fast", function() {
                $(this).addClass("selected");
            });
            $(".member_function_button2.selected").removeClass("selected");
            $(this).addClass('selected');
        }
    });

    $("#preview_pic_brw").click(function(event) {
        crop_open(event, "movement");
    });

    $("#summit").unbind("click").click(function() {
        var base = "codeigniter/index.php/event/";
        var url = base + "newPost";

        var data = {};
        data.ne_name = $('#member_newpost_content input[name = "ne_name"]').val();
        data.ne_category = $('#member_newpost_content select[name = "ne_category"]').val();
        data.ne_city = $('#member_newpost_content input[name = "ne_city"]').val();
        data.ne_location = $('#member_newpost_content input[name = "ne_location"]').val();
        data.ne_date_start = $('#member_newpost_content input[name = "ne_date_start"]').val();
        data.ne_date_end = data.ne_date_start;
        data.ne_time_start = $('#member_newpost_content input[name = "ne_time_start"]').val();
        data.ne_time_end = data.ne_time_start;
        data.ne_host = $('#member_newpost_content input[name = "ne_host"]').val();
        data.ne_url = $('#member_newpost_content input[name = "ne_url"]').val();
        data.ne_No = window.localStorage['No'];
        if (data.ne_url.indexOf("http") < 0) {
            data.ne_url = "http://" + data.ne_url;
        }
        data.ne_intro = $('#member_newpost_content textarea[name = "ne_intro"]').val();
        data.userfile = $('#new_movement_photo').attr("src");

        console.log(data);

        $.post(url, data, function(result) {
            console.log(result);
            if (result.indexOf("success" >= 0)) {
                alert("新增成功");
                load_movement();
            }
        });

    });
    $('#member .setting_public_icon').click(function() {
        if($(this).attr('public')=="1"||$(this).attr('public')==""){
            $(this).attr('src', './img/member/unpublic-icon.png');
            $(this).attr('public', "0");
        }
        else if($(this).attr('public')=="0"){
            $(this).attr('src', './img/member/public-icon.png');
            $(this).attr('public', "1");
        }
    });

}

function set_member_size() {
    var ratio = get_scale_ratio();
    var window_w = $(window).width();

    $("#member").css({
        "font-size" : 1 * ratio + 'em'
    });

    $(".member_wrapper").css({
        "width" : 660 * ratio + 'px',
        "height" : 690 * ratio + 'px'
    });

    $(".member_funcion_list, .member_function_content, #member_setting_mask").css({
        "left" : 30 * ratio + 'px'
    });

    $("#member .orbk").css({
        "width" : 15 * ratio + 'px',
        "top" : 2.5 * ratio + 'px'
    });

    $("#member .member_list_icon").css({
        "width" : 120 * ratio + 'px'
    });

    $("#member_list").css({
        "width" : 190 * ratio + 'px'
    });

    $("#member_list_form .inputs2").css({
        "height" : 24 * ratio + 'px'
    });

    $("#member_address").css({
        "height" : 72 * ratio + 'px'
    });

    $("#member_certificate di").css({
        "font-size" : 14 * ratio + 'pt'
    });

    $("#member_setting .rating_wrapper").css({
        "width" : 120 * ratio + 'px'
    });

    $("#member_setting_mask1").css({
        "left" : (window_w - 500) / 2 + 'px'
    });

    $("#member_newpost").css({
        "height" : 690 * ratio + 'px',
        "width" : 485 * ratio + 'px'
    });

    $("#member_newpost p.chars").css({
        "top" : 23 * ratio + 'px',
        "width" : 188 * ratio + 'px'
    });

    $("#preview").css({
        "top" : 110
    });

    $("#member_newpost_content input, #member_newpost_content select, #member_newpost_content textarea").css({
        "min-width" : 265 * ratio + 'px',
        "max-width" : 265 * ratio + 'px',
        "left" : 195 * ratio + 'px'
    });

    $("#member_newpost_content textarea").css({
        "min-height" : 100 * ratio + 'px',
        "max-height" : 100 * ratio + 'px'
    });

    $("#preview_pic_brw").css({
        "width" : 265 * ratio + 'px',
        "height" : 165 * ratio + 'px',
        "left" : 197 * ratio + 'px',
        "top" : 500 * ratio + 'px'
    });

    $("#preview_pic_brw p").css({
        "top" : 70 * ratio + 'px'
    });

    $("#preview_info").css({
        "width" : 265 * ratio + 'px',
        "height" : 40 * ratio + 'px',
        "left" : 197 * ratio + 'px',
        "top" : 625 * ratio + 'px'
    });

    $("#summit").css({
        "width" : 90 * ratio + 'px',
        "left" : 25 * ratio + 'px',
        "top" : 630 * ratio + 'px'
    });

    $("#info_title").css({
        "top" : -15 * ratio + 'px',
        "right" : 15 * ratio + 'px'
    });

    $("#info_location").css({
        "width" : 12 * ratio + 'px'
    });

    $("#info_rigth").css({
        'top' : 12 * ratio + 'px',
        "right" : 12 * ratio + 'px'
    });

    $(".member_record_wrapper").css({
        "height" : 130 * ratio + 'px',
        'width' : 130 * ratio + 'px'
    });

}//set member size

