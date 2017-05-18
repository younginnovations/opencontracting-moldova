var API = {
    post: function (url, data) {
        return $.ajax({
            url: url,
            data: data,
            type: "POST"
        });
    },
    get: function (url, data, async) {
        return $.ajax({
            url: url,
            data: data,
            async: (typeof async === 'undefined') ? true : async,
            type: "GET"
        });
    },
    delete: function (url, data) {
        return $.ajax({
            url: url,
            data: data,
            type: "DELETE"
        });
    }
};

var widthOfParent = $('.chart-wrap').width();

$('#select-contractor').change(function () {
    getTrendData(route, 'contractor', widthOfParent, "barChart-contractors", "contracts/contractor");

});

$('#select-agency').on("change", function () {

    getTrendData(route, 'agency', widthOfParent, "barChart-procuring", "procuring-agency");

});

$('#select-goods').change(function () {

    getTrendData(route, 'goods', widthOfParent, "barChart-goods", "goods");

});


function getTrendData(route, type, widthOfParent, definedId, url) {
    var val = $('#select-' + type).val();
    var dataFor = $('#select-' + type).attr('data-for');
    var param = $('#select-' + type).attr('data');
    var year = $('#select-' + type + '-year').val();

    var from = $("#select-year-" + type).attr('from');
    var to = $("#select-year-" + type).attr('to');

    var data = {filter: val, type: type, dataFor: dataFor, param: param, year: year, from: from, to: to};
    console.log(data);
    API.get(route, data).success(function (response) {
        $('#' + definedId).empty();
        createBarChartProcuring(JSON.parse(response), definedId, url, widthOfParent, val);
    });
}


function validateSubscriberEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

function subscribe() {
    var email = $('input[name="email"]').val();
    if (!validateSubscriberEmail(email)) {
        $("#subscribeModal").css("display", "block");
        $("#showMsg").html('Invalid email address.');
        return false;
    }
    var csrf = $('input[name="csrf_token"]').val();
    var data = {email: email, csrf_token: csrf};
    API.post(subscribeRoute, data).success(function (response) {
        console.log('true');
        $("#subscribeModal").css("display", "block");
        $("#showMsg").html(response.message);
    }).error(function (error) {
        $("#subscribeModal").css("display", "block");
        $("#showMsg").html(error.responseJSON.message);
    });
}

$('#subscribe').click(function () {
    subscribe();
});

$("#subscribe-form").submit(function (e) {

    subscribe();

    e.preventDefault();
    return false;
});


$(document).ready(function(){

    $(".burger-menu").click(function () {
        $("#main-menu .menu").slideToggle(300);
        $(".header-banner .main-menu-wrap").toggleClass("add-background");
        $(this).toggleClass("menu-on");
    });

   /* create animation effect for global search*/
    $('.search-button').click(function(){
        if($(window).width() > 1270){
            $(this).parent().toggleClass('open');
            $(".fixed-header .menu").toggleClass('toggle-visibility');
        }
        else{
            $(this).parent().toggleClass('open');
            $(".fixed-header .top-bar-left").toggleClass('toggle-visibility-small');
            $(".burger-menu-button").toggleClass('toggle-visibility-small');
        }
        $(".language-selector").toggleClass("toggle-visibility");

    });

    $(document).mouseup(function (e)
    {
        var container = $(".search,.advance-search-wrap,.language-selector");

        if (!container.is(e.target) // if the target of the click isn't the container...
            && container.has(e.target).length === 0) // ... nor a descendant of the container
        {
            container.removeClass('open');
            $(".fixed-header .menu").removeClass('toggle-visibility');
            $(".fixed-header .top-bar-left").removeClass('toggle-visibility-small');
            $(".burger-menu-button").removeClass('toggle-visibility-small');
            $(".language-selector").removeClass("toggle-visibility");

            //$(".advance-search-wrap").slideUp();
            //$(".filter-toggler a").removeClass("active");
            //$(".multiple-search-wrap").removeClass("position");
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
        toogleFilter();
    });

  /*  hide advance search when cancel is clicked*/

    $(".advance-search-wrap .cancel-btn").click(function(){
        $(".advance-search-wrap").slideUp();
        $(".filter-toggler a").removeClass("active");

        if($(window).width() > 768 ){
            $(".multiple-search-wrap").removeClass("position");
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
        if ($(window).width() > 1270) {
            $(".main-content").removeClass("menu-on");
            $("#main-menu .menu").slideUp(300);
            $(".burger-menu").removeClass("menu-on");
            $(".header-banner .fixed-header").removeClass("add-background");
        }
    }

    $(".main-content").click(function () {
        //menuDisappear();
    });

    menuDisappear();
    /*js for modal*/

// When the user clicks the button, open the modal
    $("#myBtn").click(function(){
        $("#myModal").css("display","block");
    });

    $("#showLoginModal").click(function(){
        console.log('here');
        $("#loginModal").css("display","block");
    });


// When the user clicks on <span> (x), close the modal
    $(".close").click(function(){
        $("#myModal").css("display","none");
    });

    $(".closeLoginModal").click(function(){
        $("#loginModal").css("display","none");
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


$(function() {

    $(window).on('wheel', function(e) {
        if($(".login-bar").length > 0) {
            var delta = e.originalEvent.deltaY;
            var element = $(".login-bar"),
                element_height = element.outerHeight();

            if (delta > 0) {
                $("#main-content").addClass("reduce-padding");
                $(".fixed-header").addClass("add-transform");
                element.addClass("disapper");
            }
            else {
                $("#main-content").removeClass("reduce-padding");
                $(".fixed-header").removeClass("add-transform");
                element.removeClass("disapper");
            }
        }
        else{
            return;
        }
    });
});

$(function(){
    $(".close-button").on("click", function(){
      $(this).parent().hide();
    });
});

if($(".login-bar").length > 0) {
    if($(window).width() > 640){
        $("#main-content").css("padding-top", "120px");
    }else{
        $("#main-content").css("padding-top", "110px");
    }
}

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

/* ------- shorten the text for small devices ------------ */

    var shorterText = function() {
        if ($(window).width() < 391) {
            $('.language-selector option:contains("English")').text('EN');
            $('.language-selector option:contains("Romanian")').text('RO');
        }else{
            $('.language-selector option:contains("EN")').text('English');
            $('.language-selector option:contains("RO")').text('Romanian');
        }
    }
    shorterText();

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
        shorterText();
        var tableWidth = $("#table_id_wrapper").width();
        $(".persit-header").width(tableWidth);
        $(".custom-table").width(tableWidth);
    });

    $('.advanced-filter__header').click(function(){
        toogleFilter();
    });

    function toogleFilter() {
        $('.advanced-filter__body').slideToggle("fast",function(){
        });

        $('.advanced-filter__header-btn img').toggleClass('rotate');
    }


    var handleFooterSpacing = function(){
        var filterHeaderHeight = $('.advanced-filter__header').outerHeight();
        var footerHeight = $('footer').outerHeight();
        var totalHeight = filterHeaderHeight + footerHeight;
        $('footer').css("marginBottom", filterHeaderHeight + "px");
        $('body').css("paddingBottom", totalHeight+ "px");
    }

    handleFooterSpacing();


    $(window).resize(function () {
        handleFooterSpacing();
    });

    //for select2 form
    $(".advanced-filter-form__name").select2();
    $(".advanced-filter-form__agency").select2();
});

//# sourceMappingURL=app.js.map
