function load_image_cropper() {
    var yui_css1 = "http://yui.yahooapis.com/2.9.0/build/resize/assets/skins/sam/resize.css";
    var yui_css2 = "http://yui.yahooapis.com/2.9.0/build/imagecropper/assets/skins/sam/imagecropper.css";
    //var yui_url = ["http://yui.yahooapis.com/2.5.2/build/dragdrop/dragdrop-min.js",
    //"http://yui.yahooapis.com/2.5.2/build/element/element-beta-min.js",
    //"http://yui.yahooapis.com/2.5.2/build/resize/resize-beta-min.js",
    //"http://yui.yahooapis.com/2.5.2/build/imagecropper/imagecropper-beta-min.js",
    //"http://yui.yahooapis.com/2.5.2/build/connection/connection-min.js",
    //"http://yui.yahooapis.com/2.5.2/build/json/json-min.js"];
    //"http://yui.yahooapis.com/2.5.2/build/yahoo-dom-event/yahoo-dom-event.js"
    //var yui_count = yui_url.length;

    $("head").append($("<link rel='stylesheet' href='" + yui_css1 + "' type='text/css' media='screen' />"));
    $("head").append($("<link rel='stylesheet' href='" + yui_css2 + "' type='text/css' media='screen' />"));

    set_imgcrop_size();

    /*function yui_script_load_callback() {
     yui_count--;
     if (yui_count == 0) {
     console.log("image cropper ini");
     initial_image_cropper();
     }
     }//call back

     $.each(yui_url, function(i, url) {
     $.getScript(url, yui_script_load_callback);
     });*/

    var loader = new YAHOO.util.YUILoader({
        base : "",
        require : ["connection", "dom", "dragdrop", "element", "event", "imagecropper", "json", "resize"],
        loadOptional : false,
        combine : true,
        filter : "MIN",
        allowRollup : true,
        onSuccess : function() {
            console.log("img crop ini");
            initial_image_cropper();
        }
    });

    // Load the files using the insert() method.
    loader.insert();

}//load yui files

function set_imgcrop_size() {
    var ratio = get_scale_ratio();
    var window_w = $(window).width();
    var window_h = $(window).height();

    $("#image_cropper").css({
        "height" : 600 * ratio + 'px',
        "width" : 800 * ratio + 'px',
        "left" : (window_w - 800 * ratio) / 2 + 'px',
        "top" : (window_h - 600 * ratio - 29) / 2 + 'px'
    });

    $("#imageContainer").css({
        "height" : 600 * ratio + 'px',
        "width" : 800 * ratio + 'px'
    });
}

function crop_open(event, mode) {
    if (!mode) {
        return;
    }
    $("#mask").css({
        "z-index" : 1000
    });
    $("#image_cropper").fadeIn();
    if (mode != $("#image_cropper").attr("mode")) {
        $("#yuiImg").attr("src", "");
        $(".yui-crop-resize-mask").css({
            "background-image" : "url('')"
        });
    }
    console.log(mode);
    console.log($("#image_cropper").attr("mode"));

    $("#image_cropper").attr("mode", mode);
}

function crop_close(event) {
    $("#mask").css({
        "z-index" : 100
    });
    $("#image_cropper").fadeOut();
    if (event) {
        event.preventDefault();
    }
}

function initial_image_cropper() {
    var uploader = {
        carry : function() {
            // set form
            YAHOO.util.Connect.setForm('uploadForm', true);
            // upload image
            YAHOO.util.Connect.asyncRequest('POST', 'upload.php', {
                upload : function(o) {
                    // parse our json data
                    var jsonData = YAHOO.lang.JSON.parse(o.responseText);

                    // put image in our image container
                    YAHOO.util.Dom.get('imageContainer').innerHTML = "";
                    YAHOO.util.Dom.get('imageContainer').innerHTML = '<img id="yuiImg" src="' + jsonData.image + '" style =  width:' + jsonData.width + 'px;height:' + jsonData.height + 'px;" alt="" />';
                    console.log(jsonData.image);
                    // init our photoshop

                    $("#imageContainer img").unbind("load").load(function() {
                        photoshop.init(jsonData.image);

                        // get first cropped image
                        console.log(photoshop.img);
                        photoshop.getCroppedImage(jsonData.image);
                        $(".yui-crop-resize-mask").css({
                            "background-size" : photoshop.img.sw + 'px ' + photoshop.img.sh + 'px'
                        });
                        $("#yuiImg_wrap").css({
                            "position" : "absolute",
                            "left" : photoshop.img.shift.x + 'px',
                            "top" : photoshop.img.shift.y + 'px'
                        });
                    });

                }//upload
            });
        }//upload carry
    };

    // add listeners
    console.log("bind upload");
    YAHOO.util.Event.on('uploadButton', 'click', uploader.carry);
    $("#uploadImage").change(function() {
        $("#uploadButton").trigger('click');
    });
    $("#mask,#image_cancel").click(crop_close);

    var page_r = get_scale_ratio();
    var photoshop = {
        image : null,
        crop : null,
        cropBlock : {
            w : 225 * page_r,
            h : 225 * page_r
        },

        container : {
            $el : $("#imageContainer"),
            w : $("#imageContainer").width(),
            h : $("#imageContainer").height(),
            r : Math.round($("#imageContainer").width() / $("#imageContainer").height() * 100) / 100
        },
        img : {
            $el : $("#yuiImg"),
            w : $("#yuiImg").width(),
            h : $("#yuiImg").height(),
            sw : 0,
            sh : 0,
            r : Math.round($("#yuiImg").width() / $("#yuiImg").height() * 100) / 100,
            scale : 1,
            shift : {
                x : 0,
                y : 0
            }
        },

        init : function(image) {
            // set our image
            photoshop.image = image;

            photoshop.img.$el = $("#yuiImg");
            photoshop.img.w = $("#yuiImg").width();
            photoshop.img.h = $("#yuiImg").height();
            photoshop.img.r = Math.round($("#yuiImg").width() / $("#yuiImg").height() * 100) / 100;

            photoshop.container.w = $("#imageContainer").width();
            photoshop.container.h = $("#imageContainer").height();
            photoshop.container.r = Math.round($("#imageContainer").width() / $("#imageContainer").height() * 100) / 100;

            var page_r = get_scale_ratio();
            var mode = $("#image_cropper").attr("mode");

            switch(mode) {
                case 'movement':
                    photoshop.cropBlock.w = 450 * page_r;
                    photoshop.cropBlock.h = 300 * page_r;
                    break;
                case 'member':
                default:
                    photoshop.cropBlock.w = 225 * page_r;
                    photoshop.cropBlock.h = 225 * page_r;
                    break;
            }

            photoshop.imgFitSize();
            // our image cropper from the uploaded image
            photoshop.crop = new YAHOO.widget.ImageCropper('yuiImg', {
                ratio : true,
                initHeight : photoshop.cropBlock.h * photoshop.img.scale,
                initWidth : photoshop.cropBlock.w * photoshop.img.scale,
                initialXY : [0, 0]
            });

            //photoshop.crop.getResizeObject().dd.locked = true;
            //photoshop.crop.getResizeObject().subscribe('beforeResize',function(){return false});
            photoshop.crop.getResizeObject().beforeResize = function() {
                return false
            };

            photoshop.crop.on('moveEvent', function() {
                // get updated coordinates
                photoshop.getCroppedImage(image);
            });
            /*photoshop.crop.on('resizeEvent', function() {
             return false;
             });*/

        },

        getCroppedImage : function(imgname) {
            $("#image_confirm").unbind();
            $("#image_confirm").click(function go() {
                var base_url = "";
                var url = base_url + "crop.php";
                var coordinates = photoshop.getCoordinates();
                var scale = photoshop.img.scale;
                var shiftX = photoshop.img.shift.x;
                var shiftY = photoshop.img.shift.y;
                var mode = $("#image_cropper").attr("mode");
                console.log("crop upload");
                console.log(coordinates);
                console.log(photoshop.img);

                $.get(url, {
                    image : photoshop.image,
                    cropStartX : Math.round((coordinates.left ) / scale ),
                    cropStartY : Math.round((coordinates.top ) / scale ),
                    cropWidth : Math.round(coordinates.width / scale ),
                    cropHeight : Math.round(coordinates.height / scale ),
                    crop : imgname
                }, function(data) {
                    crop_close();
                    console.log(data);
                    var photo_target = ""
                    switch(mode) {
                        case 'movement':
                            photo_target = "#new_movement_photo";
                            break;
                        case 'member':
                        default:
                            photo_target = "#member_user_photo, #menu_login .member_photo";
                            break;
                    }//handle data
                    $(photo_target).attr('src', data);
                });
            })
        },

        getCoordinates : function() {
            return photoshop.crop.getCropCoords();
        },

        imgFitSize : function() {

            console.log(photoshop.img);
            console.log(photoshop.container);

            var $image = photoshop.img.$el;
            if (photoshop.img.w <= photoshop.container.w && photoshop.img.h <= photoshop.container.h) {//normal
                photoshop.img.sh = photoshop.img.h;
                photoshop.img.sw = photoshop.img.w;
                photoshop.img.scale = 1;
                photoshop.img.shift.x = (photoshop.container.w - photoshop.img.sw) / 2;
                photoshop.img.shift.y = (photoshop.container.h - photoshop.img.sh) / 2;
                if (photoshop.img.sw < photoshop.cropBlock.w) {
                    photoshop.cropBlock.h = photoshop.cropBlock.h / photoshop.cropBlock.w * photoshop.img.sw;
                    photoshop.cropBlock.w = photoshop.img.sw;
                } else if (photoshop.img.sh < photoshop.cropBlock.h) {
                    photoshop.cropBlock.w = photoshop.cropBlock.w / photoshop.cropBlock.h * photoshop.img.sh;
                    photoshop.cropBlock.h = photoshop.img.sh;
                }
            } else {//big img
                if (photoshop.container.r >= photoshop.img.r) {//窄
                    console.log("高");
                    photoshop.img.scale = Math.round((photoshop.container.h / photoshop.img.h) * 100) / 100;
                    photoshop.img.sh = photoshop.container.h;
                    photoshop.img.sw = photoshop.img.w * photoshop.img.scale;
                    photoshop.img.shift.x = (photoshop.container.w - photoshop.img.sw) / 2;
                    photoshop.img.shift.y = 0;
                    if (photoshop.img.sw < photoshop.cropBlock.w) {
                        photoshop.cropBlock.h = photoshop.cropBlock.h / photoshop.cropBlock.w * photoshop.img.sw;
                        photoshop.cropBlock.w = photoshop.img.sw;
                    }
                } else {//寬
                    console.log("寬");
                    photoshop.img.scale = Math.round((photoshop.container.w / photoshop.img.w) * 100) / 100;
                    photoshop.img.sh = photoshop.img.h * photoshop.img.scale;
                    photoshop.img.sw = photoshop.container.w;
                    photoshop.img.shift.x = 0;
                    photoshop.img.shift.y = (photoshop.container.h - photoshop.img.sh) / 2;
                    if (photoshop.img.sh < photoshop.cropBlock.h) {
                        photoshop.cropBlock.w = photoshop.cropBlock.w / photoshop.cropBlock.h * photoshop.img.sh;
                        photoshop.cropBlock.h = photoshop.img.sh;
                    }
                }
            }

            console.log("h = " + photoshop.img.sh + " w = " + photoshop.img.sw);
            $image.css({
                "height" : photoshop.img.sh + 'px',
                "width" : photoshop.img.sw + 'px'
            })
        }//img fit size
    };
}//mem_imagecrop
