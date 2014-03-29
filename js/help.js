function initial_help() {
    //initial
    set_wrapper_size();
    $("#help_book_wrapper").turn();
    set_help_size();
    hash_decode();

    //book
    $("#helpbook_nep_icon").click(function() {
        $("#help_book_wrapper").turn('next');
    });

    $("#helpbbok_prep_icon").click(function() {
        $("#help_book_wrapper").turn('previous');
    });

    $(".jump_page").click(function() {
        var page = $(this).attr('page');
        $("#help_book_wrapper").turn('page', page);
    });

    //event

}//initial help

function set_help_size() {
    var ratio = get_scale_ratio();

    $("#helpbook_cover").css({
        "border-radius" : 10 * ratio + 'px'
    });

    $(".help_book_tag, .help_book_tag_bar").css({
        "height" : 33.5 * ratio + 'px'
    });

    var book_w = $("#helpbook_cover").width() * 90 / 100;
    var book_h = $("#helpbook_cover").height() * 95.5 / 100;
    //console.log("r = " +ratio);
    //console.log("w = " + book_w + " h = " + book_h);
    $("#help_book_wrapper").turn('size', book_w, book_h);

}//set size
