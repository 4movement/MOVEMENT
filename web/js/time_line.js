function set_time_line() {

    var element_class = ".movement_thumb_wrapper.display";
    $time_line_past = $(".gallery_line.past");
    $time_line_future = $(".gallery_line.future");
    var $time_line_wrapper = $("#movement_gallery");
    var time_line_shift = 0;

    movement_month();

    $time_line_wrapper.mousewheel(function(event, delta) {
        var tran_x = delta * 250;
        var wrapper_w = $time_line_wrapper.width();
        tran_x = (wrapper_w / 2 > Math.abs(tran_x)) ? tran_x : (tran_x > 0) ? wrapper_w / 2 : -wrapper_w / 2;
        move_time_line(tran_x);

        event.preventDefault();
    });

    $time_line_wrapper.children("button").click(function() {
        var delta = $(this).hasClass("left") ? 2 : -2;
        $time_line_wrapper.trigger("mousewheel", [delta]);
    });

    $time_line_wrapper.children("button").hover(function() {
        $(this).addClass("hover");
        var delta = $(this).hasClass("left") ? 1 : -1;
        var $obj = $(this);
        arrow_hover($obj, delta);
    }, function() {
        $(this).removeClass("hover");
    });

    $("#movement_month_list .month_list[month]").unbind("click").click(function(event) {
        var month_old = $("#movement_month_list .selected").attr("month");
        var month = $(this).attr("month");
        var month_text = ['', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
        month_old = parseInt(month_old);
        month = parseInt(month);
        var year = $(this).attr("year");
        var tran_x = 0;

        console.log(month);
        if ($time_line_wrapper.find(element_class + "[month='" + month_text[month] + "'][year='" + year + "']").length) {
            if (month >= month_old) {
                tran_x = $time_line_wrapper.find(element_class + "[month='" + month_text[month] + "'][year='" + year + "']").last().offset().left;
            } else {
                tran_x = $time_line_wrapper.find(element_class + "[month='" + month_text[month] + "'][year='" + year + "']").offset().left;
            }
        } else {
            var finish = false;
            while (!finish) {
                if (month >= month_old) {
                    month--;
                    if ($time_line_wrapper.find(element_class + "[month='" + month_text[month] + "'][year='" + year + "']").length) {
                        tran_x = $time_line_wrapper.find(element_class + "[month='" + month_text[month] + "'][year='" + year + "']").last().offset().left;
                        finish = true;
                    }
                    if (month < 1) {
                        finish = true;
                        $("#movement_month_list .month_list:last").click();
                    }
                } else {
                    month++;
                    if ($time_line_wrapper.find(element_class + "[month='" + month_text[month] + "'][year='" + year + "']").length) {
                        tran_x = $time_line_wrapper.find(element_class + "[month='" + month_text[month] + "'][year='" + year + "']").offset().left;
                        finish = true;
                    }
                    if (month > 12) {
                        finish = true;
                        $("#movement_month_list .month_list:first").click();
                    }
                }
            }//until found target
        }//else, target not found
        if (tran_x != 0) {
            move_time_line(-tran_x);
        }
        movement_month();
        event.preventDefault();
    });

    $("#movement_month_list .month_list:first").unbind("click").click(function(event) {
        var year = parseInt($(this).attr("year"));
        console.log(year);
        movement_month(1, year);
        $("#movement_month_list .month_list[month ='1']").click();
        event.preventDefault();
    });
    $("#movement_month_list .month_list:last").unbind("click").click(function(event) {

        var year = parseInt($(this).attr("year"));
        console.log(year);
        movement_month(1, year);
        $("#movement_month_list .month_list[month ='12']").click();
        event.preventDefault();
    });

    function arrow_hover($obj, delta) {
        if (!$obj.hasClass("hover")) {
            return;
        }
        $time_line_wrapper.trigger("mousewheel", [delta]);
        $obj.animate({
            "nothing" : "400"
        }, 400, function() {
            arrow_hover($obj, delta);
        });
    }//mouse on button

    function move_time_line(tran_x) {
        var reach_edge = false;
        var line_w = $time_line_wrapper.width();
        time_line_shift = $time_line_past.css("left");
        time_line_shift = parseInt(time_line_shift.substring(0, time_line_shift.indexOf('px')));

        //check edge
        if (!($time_line_past.find(element_class).length || $time_line_future.find(element_class).length))
            return;
        //no element
        else {
            if (tran_x > 0) {
                var leftmost = 0;
                var $element = $time_line_future.find(element_class).last();
                var $element2;
                var element_l = 0;
                var element2_l = 0;

                if ($element.length) {
                    //console.log("future");
                    element_l = $element.css("right")
                    element_l = -parseInt(element_l.substring(0, element_l.indexOf('px'))) - $element.width() + time_line_shift;
                    //console.log(element_l + " 01");
                    $element2 = $element.prev().length ? $element.prev() : $element;
                    element2_l = $element2.css("right")
                    element2_l = -parseInt(element2_l.substring(0, element2_l.indexOf('px'))) - $element2.width() + time_line_shift;
                    //console.log(element2_l + " 02");
                }//has future part
                else {
                    //console.log("past");
                    $element = $time_line_past.find(element_class).first();
                    element_l = $element.css("left");
                    element_l = parseInt(element_l.substring(0, element_l.indexOf('px'))) + time_line_shift;

                    $element2 = $element.next().length ? $element.next() : $element;
                    element2_l = $element2.css("left")
                    element2_l = parseInt(element2_l.substring(0, element2_l.indexOf('px'))) + time_line_shift;
                }//no future part

                leftmost = Math.min(leftmost, element_l, element2_l);
                //console.log("left" + leftmost);
                if (leftmost >= 0) {
                    reach_edge = true;
                }//if
                else if (leftmost + tran_x > 0) {
                    tran_x = -leftmost;
                }
                //else if
            }//move right
            else {
                var rightmost = 0;
                var $element = $time_line_past.find(element_class).last();
                var $element2;
                var element_r = 0;
                var element2_r = 0;

                if ($element != undefined) {
                    //console.log("past");
                    element_r = $element.css("left")
                    element_r = -parseInt(element_r.substring(0, element_r.indexOf('px'))) - $element.width() + line_w - time_line_shift;

                    $element2 = $element.prev().length ? $element.prev() : $element;
                    element2_r = $element2.css("left")
                    element2_r = -parseInt(element2_r.substring(0, element2_r.indexOf('px'))) - $element2.width() + line_w - time_line_shift;

                }//has past part
                else {
                    //console.log("future");
                    $element = $time_line_future.find(element_class).first();
                    element_r = $element.css("right");
                    element_r = parseInt(element_l.substring(0, element_l.indexOf('px'))) - time_line_shift;

                    $element2 = $element.next().length ? $element.next() : $element;
                    element2_r = $element2.css("right")
                    element2_r = parseInt(element2_r.substring(0, element2_r.indexOf('px'))) - time_line_shift;
                }//no past part

                rightmost = Math.min(rightmost, element_r, element2_r);

                if (rightmost >= 0) {
                    reach_edge = true;
                }//if
                else if (rightmost - tran_x > 0) {
                    tran_x = rightmost;
                }
                //else if
            }//move left
        }//end else
        //console.log( reach_edge + "" + tran_x);

        if (!reach_edge) {
            $time_line_past.find(element_class).stop().animate({
                "left" : "+=" + tran_x
            }, 500, "linear", function() {
                lazy_movement();
                movement_month();
            });
            $time_line_future.find(element_class).stop().animate({
                "right" : "-=" + tran_x
            }, 500, "linear", function() {
                lazy_movement();
                movement_month();
            });
            movement_month();
            //check load()
            //lazy_movement();
        }//if still have space to move
    };//move_time_line
}//start time_line
