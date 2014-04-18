function initial_register() {
    
    //function declare
    var phone_checkbox = function() {
        var test = document.getElementById("phone_certificate_reg").checked;
        console.log(test + " phone");
        if (test) {
            //console.log("ck");
            $("#register_wrapper2 .general").fadeOut("slow");
            $("#register_wrapper2 .vip").fadeIn("slow");
        } else {
            //console.log("cn");
            $("#register_wrapper2 .general").fadeIn("slow");
            $("#register_wrapper2 .vip").fadeOut("slow");
        }
        return test;
    };
    //phone check box

    var contract_checkbox = function() {
        var test = document.getElementById("confirm_contract_reg").checked;
        console.log(test + " contract");
        if (test) {
            $("#register_data .submit").removeAttr("disabled");
        } else {
            $("#register_data .submit").attr("disabled", "disabled");
        }
        return test;
    };
    // contract check box

    var check_register_data = function(id, pw, pwcheck, email, phone) {
        var checkemail = /^[^@^\s]+@[^\.@^\s]+(\.[^\.@^\s]+)+$/;

        var check = true;
        var errmsg = Array();

        if (id.length <= 3) {
            errmsg.push({
                id : "id",
                msg : "請輸入4字以上帳號"
            });
            check = false;
        }
        if (pw.length <= 3) {
            check = false;
            errmsg.push({
                id : "password",
                msg : "請輸入4字以上密碼"
            });
        }
        if (pwcheck != pw) {
            check = false;
            errmsg.push({
                id : "repeat_password",
                msg : "確認密碼與密碼不同"
            });
        }
        if (!checkemail.test(email)) {
            check = false;
            errmsg.push({
                id : "mail",
                msg : "E-mail格式不正確"
            });
        }

        return {
            "check" : check,
            "errmsg" : errmsg
        };
    };
    // check register data

    //function declare

    //initial
    phone_checkbox();
    contract_checkbox();
    set_register_size();
    //initial

    //event
    $("#phone_certificate_reg").change(phone_checkbox);
    $("#confirm_contract_reg").change(contract_checkbox);
    
    $(".confirm_contract span.a").click(function(){
        $("#contract").fadeIn();
    });
    $("#contract button").click(function(){
        $("#contract").fadeOut();
    });

    $("#register_data .submit").click(function(event) {
        var base_url = "http://movement.ee.ncku.edu.tw/register/";
        var URL = base_url + "register.php";
        var id = $("#register_data input[name = 'id']").val();
        var pw = $("#register_data input[name = 'password']").val();
        var pwcheck = $("#register_data input[name = 'repeat_password']").val();
        var username = $("#register_data input[name = 'real_name']").val() || id;
        var nickname = $("#register_data input[name = 'nick']").val() || id;
        var email = $("#register_data input[name = 'email']").val();
        var phone = $("#register_data input[name = 'phone']").val();

        var check = check_register_data(id, pw, pwcheck, email, phone);

        if (check.check) {
            $("#menu form .hint").text("");
            $.post(URL, {
                'id' : id,
                'pw' : pw,
                'pwcheck' : pwcheck,
                'username' : username,
                'nickname' : nickname,
                'email' : email,
                'phone' : phone
            }, function(result) {
                console.log(result);
                if (result.result == "success") {
                    login_mod(result.member_data);
                }//if success

                if (result.msg) {
                    alert(result.msg);
                }
            });
            //temp

        } else {
            $("#register_data ul.input_title .hint").text("");
            $.each(check.errmsg, function() {
                console.log(this.id, this.msg);
                $("#register_data ul.input_title ." + this.id + " .hint").text(this.msg);
            });
        }

        event.preventDefault();
    });
    //submit
    //register with other account
    $(".other_account .facebook").click(function() {
        fb_login();
    });
    //fb register
    $(".other_account .google_plus").click(function() {
        google_login();
    });
    //google register
    $(".other_account .twitter").click(function() {
        twitter_login();
    });
    //twitter register
}

function set_register_size() {
    var ratio = get_scale_ratio();

    $("#register_wrapper2").css({
        "height" : 1016 * ratio / 1.6 + 'px',
        "width" : 1362 * ratio / 1.6 + 'px',
        /*"left" : 99 * ratio / 1.6 + 'px',
         "top" : 54 * ratio / 1.6 + 'px',/**/
        "box-shadow" : "0 0 " + 10 * ratio / 1.6 + 'px ' + 3 * ratio / 1.6 + 'px ' + "rgba(220,220,220,0.7)",
        "font-size" : ratio / 1.6 + 'em'
    });
    $("#register_data label").css({
        "height" : 37 * ratio / 1.6 + 'px',
        "width" : 235 * ratio / 1.6 + 'px'
    });
    $("#register_data span.checkbox").css({
        "height" : 24 * ratio / 1.6 + 'px',
        "width" : 24 * ratio / 1.6 + 'px',
        "box-shadow" : "0 0 " + 3 * ratio / 1.6 + 'px ' + 3 * ratio / 1.6 + 'px ' + "rgba(180, 180, 180, 0.8) inset"
    });
    $("#register_data div.checkbox.text").css({
        "left" : 30 * ratio / 1.6 + 'px'
    });
}//set_register_size
