$(document).ready(function(){
    $(".burger-menu").click(function () {
        $("#main-menu .menu").slideToggle(100);
        $(this).toggleClass("menu-on");
    });

    var headerElementsAlign = function(){
        var statusButtonWidth1 = $("#status").width(),
            statusButtonWidth = statusButtonWidth1 + 40;
        headerWidth = $("#status").parents(".row").width() - statusButtonWidth;
        $("#left-header").width(headerWidth);
    };

    headerElementsAlign();
   /* toggle filter section*/

    $(".show-filter").click(function(){
       /* $(this).removeClass('active');
        $(".hide-filter").addClass('active');*/
        $(".advance-search-wrap").slideToggle();
        $(".filter-toggler a").toggleClass("active");
    });

    /*$(".hide-filter").click(function(){
        $(this).removeClass('active');
        $(".show-filter").addClass('active');
        $(".advance-search-wrap").slideUp(300);
    });*/

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
        headerElementsAlign();
        windowResize.menuDisappear();
    });
});
