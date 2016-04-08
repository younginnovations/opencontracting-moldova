$(document).ready(function(){
    $(".burger-menu").click(function () {
        $("#main-menu .menu").slideToggle(300);
        $(this).toggleClass("menu-on");
    });

    /* --------- make right and left section in header align properly --------- */

    var headerElementsAlign = function(){
        if($(window).width() > 640){
            var statusButtonWidth1 = $("#status").width(),
                statusButtonWidth = statusButtonWidth1 + 40;
            headerWidth = $("#status").parents(".row").width() - statusButtonWidth;
            $("#left-header").width(headerWidth);
        }
    };

    headerElementsAlign();
   /* -------- toggle filter section ------- */

    $(".show-filter").click(function(){
        $(".advance-search-wrap").slideToggle();
        $(".filter-toggler a").toggleClass("active");
    });

   /* remove tab layout in small device*/
    var tabResponsive = function () {
        if($(window).width() < 700){
            $(".tabs-content .tabs-panel").addClass("is-active");
        }else{
            $("#panel2").removeClass("is-active");
            $("#panel1-label").addClass("is-active");
        }
    }

    tabResponsive();

   /* --------  responsive navigation menu ------ */

    var menuDisappear = function(){
        if ($(window).width() < 768) {
            $(".main-content").removeClass("menu-on");
            $("#main-menu .menu").slideUp(300);
            $(".burger-menu").removeClass("menu-on");
        }
    }

    $(".main-content").click(function () {
        menuDisappear();
    });

    menuDisappear();

    $(window).resize(function(){
        headerElementsAlign();
        tabResponsive();
        menuDisappear();
    });
});
