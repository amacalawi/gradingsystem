$(window).scroll(function() {    
    var scroll = $(window).scrollTop();

    if (scroll >= 100) {
        $(".m-subheader, .m-content").addClass("fix");
    } else {
        $(".m-subheader, .m-content").removeClass("fix");
    }
});