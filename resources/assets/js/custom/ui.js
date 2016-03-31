$(document).ready(function(){
    $(".burger-menu").click(function () {
        $("#main-menu .menu").slideToggle(100);
        $(this).toggleClass("menu-on");
    });

    var windowResize = {
        menuDisappear: function () {
            if ($(window).width() < 639) {
                $(this).removeClass("menu-on");

                $(".main-content").click(function () {
                    $("#main-menu .menu").slideUp(100);
                    $(".burger-menu").removeClass("menu-on");
                });
            }else {
                $( ".main-content" ).unbind();
            }
        }
    }

    windowResize.menuDisappear();

    $(window).resize(function(){
        windowResize.menuDisappear();
    });
});
