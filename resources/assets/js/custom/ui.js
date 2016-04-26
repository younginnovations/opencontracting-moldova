$(document).ready(function(){
    $(".burger-menu").click(function () {
        $("#main-menu .menu").slideToggle(300);
        $(".header-banner .fixed-header").toggleClass("add-background");
        $(this).toggleClass("menu-on");
    });

   /* create animation effect for global search*/
    $('.search-button').click(function(){
        if($(window).width() > 768){
            $(this).parent().toggleClass('open');
            $(".fixed-header .menu").toggleClass('toggle-visibility');
        }
        else{
            $(this).parent().toggleClass('open');
            $(".fixed-header .top-bar-left").toggleClass('toggle-visibility-small');
            $(".burger-menu-button").toggleClass('toggle-visibility-small');
        }

    });

    $(document).mouseup(function (e)
    {
        var container = $(".search,.filter-toggler,.advance-search-wrap");

        if (!container.is(e.target) // if the target of the click isn't the container...
            && container.has(e.target).length === 0) // ... nor a descendant of the container
        {
            container.removeClass('open');
            $(".fixed-header .menu").removeClass('toggle-visibility');
            $(".fixed-header .top-bar-left").removeClass('toggle-visibility-small');
            $(".burger-menu-button").removeClass('toggle-visibility-small');

            $(".advance-search-wrap").slideUp();
            $(".filter-toggler a").removeClass("active");
            $(".multiple-search-wrap .search-form").show();
        }
    });


   /* make background of navigation blue after scrolling image banner*/

    $(window).scroll(function() { // check if scroll event happened
        var heightOfBanner = $(".header-banner").outerHeight() - 68;
        if ($(document).scrollTop() > heightOfBanner) {
            $("header.top-bar").css("background-color", "#0046AE");
        } else {
            if ($(document).scrollTop() > 67) {
                $("header.top-bar").css("background-color", "rgba(0,66,177,0.8)");
            }else{
                $("header.top-bar").css("background-color", "transparent");
            }
        }
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
   /* toggle filter section*/

    $(".show-filter").click(function(){
        var element = $(this);
        $(".advance-search-wrap").slideToggle();
        $(".filter-toggler a").toggleClass("active");

        if($(window).width() > 768 ){
           $(".multiple-search-wrap .search-form").toggle();
        }

    });



    $('.toggle-switch').click(function(e) {
        var toggle = this;

        e.preventDefault();

        $(toggle).toggleClass('toggle--on')
            .toggleClass('toggle--off')
            .addClass('toggle--moving');

        setTimeout(function() {
            $(toggle).removeClass('toggle--moving');
        }, 200)
    });

   /* remove tab layout in small device*/
    var tabResponsive = function () {
        if($(window).width() < 775){
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

    /* ------------ sticky header in tables ---------------- */

  /*  var fixHeader = function(){
        if($(window).width() > 768){
            $(".persist-area").each(function() {

                var el             = $(this),
                    offset         = el.offset(),
                    scrollTop      = $(window).scrollTop() + 76,
                    elementHeight = el.height(),
                    elementWidth = el.width();

                if ((scrollTop > offset.top) && (scrollTop < offset.top + elementHeight)) {
                    $(".persist-header").addClass("floatingHeader");
                } else {
                    $(".persist-header").removeClass("floatingHeader");
                };

                $(".floatingHeader").width(elementWidth);
            });
        }
    }
    $(window).scroll(function(){
        fixHeader();
    });*/

    $('.chart-wrap').each(function(){
        var el = $(this).find('svg');
        if(el.length == 0){
            $(this).addClass('default-view');
            $(this).find(".filter-section").hide();
            $(this).find(".loader-text").show();
            $(".default-view").parents(".each-chart-section").css("height","400px");
        }
    });

    $(document).ready(function(){
        $('.chart-wrap').each(function() {
            var el = $(this).find('svg');
            if(el.length != 0) {
                $(this).removeClass('default-view');
                $(this).find(".filter-section").show();
                $(this).find(".loader-text").hide();
                $(".default-view").parents(".each-chart-section").css("height", "auto");
            }
        });
    });


    /* ------------ end of sticky header for table --------------- */

    $(window).resize(function(){
        headerElementsAlign();
        tabResponsive();
        menuDisappear();
        //fixHeader();
    });
});
