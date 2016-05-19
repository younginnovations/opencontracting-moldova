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
            $(".multiple-search-wrap").removeClass("position");
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
            $(".multiple-search-wrap").toggleClass("position");
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
        }, 200);

        $(".toggle--on").parents(".custom-switch-wrap").find(".json-view").show();
        $(".toggle--on").parents(".custom-switch-wrap").find(".table-view").hide();
        $(".toggle--off").parents(".custom-switch-wrap").find(".json-view").hide();
        $(".toggle--off").parents(".custom-switch-wrap").find(".table-view").show();
    });

   /* ------  toggle expand and collapse button ----- */

    $(".expand-btn").on("click",function(){
        $(".expand-btn").hide();
        $(".collapse-btn").show();
        expand();
    });

    $(".collapse-btn").on("click",function(){
        $(".collapse-btn").hide();
        $(".expand-btn").show();
        collapse();
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
    /*js for modal*/

// When the user clicks the button, open the modal
    $("#myBtn").click(function(){
        $("#myModal").css("display","block");
    });

// When the user clicks on <span> (x), close the modal
    $(".close").click(function(){
        $("#myModal").css("display","none");
    });

    $(".alert .close").click(function(){
        $("#subscribeModal").css("display","none");
    });

// When the user clicks anywhere outside of the modal, close it
    $(window).click(function(event) {
        if (event.target.id === 'subscribeModal') {
            $("#subscribeModal").css("display","none");
        }
    });

    /* ------------ sticky header in tables ---------------- */

/*    function UpdateTableHeaders() {
        if($(window).width() > 768){
            $(".persist-area").each(function() {

                var el             = $(this),
                    offset         = el.offset(),
                    scrollTop      = $(window).scrollTop(),
                    floatingHeader = $(".floatingHeader", this)

                if ((scrollTop > offset.top) && (scrollTop < offset.top + el.height())) {
                    floatingHeader.css({
                        "visibility": "visible"
                    });
                    var clonedHeader = $(".floatingHeader");
                    var realHeader = clonedHeader.siblings('.persist-header');
                    $('th', realHeader).each(function(index) {
                        $('th', clonedHeader).eq(index).css('width', $(this).outerWidth());
                    });
                } else {
                    floatingHeader.css({
                        "visibility": "hidden"
                    });
                };
            });
        }
    }

// DOM Ready
    $(function() {
        var clonedHeaderRow;

        $(".persist-area").each(function() {
            clonedHeaderRow = $(".persist-header", this);
            clonedHeaderRow
                .before(clonedHeaderRow.clone())
                .css("width", clonedHeaderRow.width())
                .addClass("floatingHeader");
        });

        $(window)
            .scroll(UpdateTableHeaders)
            .trigger("scroll");

    });*/

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

  /* ------  script for json table  ----- */
    $(".jTable .main-title").each(function(){
        $(this).parent().addClass("main-title-wrap");
    })

   /* make table in tab full width*/

    $(".custom-table").css("width","100%");

    /* ------------ end of sticky header for table --------------- */

    $(window).resize(function(){
        headerElementsAlign();
        tabResponsive();
        menuDisappear();
        var tableWidth = $("#table_id_wrapper").width();
        $(".persit-header").width(tableWidth);
        $(".custom-table").width(tableWidth);
    });
});
