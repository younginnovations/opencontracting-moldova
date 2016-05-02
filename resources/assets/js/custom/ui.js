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

  /* --------------------- js for modal -------------*/
    //var Modal = (function() {
    //
    //    var trigger = $qsa('.modal__trigger'); // what you click to activate the modal
    //    var modals = $qsa('.modal'); // the entire modal (takes up entire window)
    //    var modalsbg = $qsa('.modal__bg'); // the entire modal (takes up entire window)
    //    var content = $qsa('.modal__content'); // the inner content of the modal
    //    var closers = $qsa('.modal__close'); // an element used to close the modal
    //    var w = window;
    //    var isOpen = false;
    //    var contentDelay = 400; // duration after you click the button and wait for the content to show
    //    var len = trigger.length;
    //
    //    // make it easier for yourself by not having to type as much to select an element
    //    function $qsa(el) {
    //        return document.querySelectorAll(el);
    //    }
    //
    //    var getId = function(event) {
    //
    //        event.preventDefault();
    //        var self = this;
    //        // get the value of the data-modal attribute from the button
    //        var modalId = self.dataset.modal;
    //        var len = modalId.length;
    //        // remove the '#' from the string
    //        var modalIdTrimmed = modalId.substring(1, len);
    //        // select the modal we want to activate
    //        var modal = document.getElementById(modalIdTrimmed);
    //        // execute function that creates the temporary expanding div
    //        makeDiv(self, modal);
    //    };
    //
    //    var makeDiv = function(self, modal) {
    //
    //        var fakediv = document.getElementById('modal__temp');
    //
    //        /**
    //         * if there isn't a 'fakediv', create one and append it to the button that was
    //         * clicked. after that execute the function 'moveTrig' which handles the animations.
    //         */
    //
    //        if (fakediv === null) {
    //            var div = document.createElement('div');
    //            div.id = 'modal__temp';
    //            self.appendChild(div);
    //            moveTrig(self, modal, div);
    //        }
    //    };
    //
    //    var moveTrig = function(trig, modal, div) {
    //        var trigProps = trig.getBoundingClientRect();
    //        var m = modal;
    //        var mProps = m.querySelector('.modal__content').getBoundingClientRect();
    //        var transX, transY, scaleX, scaleY;
    //        var xc = w.innerWidth / 2;
    //        var yc = w.innerHeight / 2;
    //
    //        // this class increases z-index value so the button goes overtop the other buttons
    //        trig.classList.add('modal__trigger--active');
    //
    //        // these values are used for scale the temporary div to the same size as the modal
    //        scaleX = mProps.width / trigProps.width;
    //        scaleY = mProps.height / trigProps.height;
    //
    //        scaleX = scaleX.toFixed(3); // round to 3 decimal places
    //        scaleY = scaleY.toFixed(3);
    //
    //
    //        // these values are used to move the button to the center of the window
    //        transX = Math.round(xc - trigProps.left - trigProps.width / 2);
    //        transY = Math.round(yc - trigProps.top - trigProps.height / 2);
    //
    //        // if the modal is aligned to the top then move the button to the center-y of the modal instead of the window
    //        if (m.classList.contains('modal--align-top')) {
    //            transY = Math.round(mProps.height / 2 + mProps.top - trigProps.top - trigProps.height / 2);
    //        }
    //
    //
    //        // translate button to center of screen
    //        trig.style.transform = 'translate(' + transX + 'px, ' + transY + 'px)';
    //        trig.style.webkitTransform = 'translate(' + transX + 'px, ' + transY + 'px)';
    //        // expand temporary div to the same size as the modal
    //        div.style.transform = 'scale(' + scaleX + ',' + scaleY + ')';
    //        div.style.webkitTransform = 'scale(' + scaleX + ',' + scaleY + ')';
    //
    //
    //        window.setTimeout(function() {
    //            window.requestAnimationFrame(function() {
    //                open(m, div);
    //            });
    //        }, contentDelay);
    //
    //    };
    //
    //    var open = function(m, div) {
    //
    //        if (!isOpen) {
    //            // select the content inside the modal
    //            var content = m.querySelector('.modal__content');
    //            // reveal the modal
    //            m.classList.add('modal--active');
    //            // reveal the modal content
    //            content.classList.add('modal__content--active');
    //
    //            /**
    //             * when the modal content is finished transitioning, fadeout the temporary
    //             * expanding div so when the window resizes it isn't visible ( it doesn't
    //             * move with the window).
    //             */
    //
    //            content.addEventListener('transitionend', hideDiv, false);
    //
    //            isOpen = true;
    //        }
    //
    //        function hideDiv() {
    //            // fadeout div so that it can't be seen when the window is resized
    //            div.style.opacity = '0';
    //            content.removeEventListener('transitionend', hideDiv, false);
    //        }
    //    };
    //
    //    var close = function(event) {
    //
    //        event.preventDefault();
    //        event.stopImmediatePropagation();
    //
    //        var target = event.target;
    //        var div = document.getElementById('modal__temp');
    //
    //        /**
    //         * make sure the modal__bg or modal__close was clicked, we don't want to be able to click
    //         * inside the modal and have it close.
    //         */
    //
    //        if (isOpen && target.classList.contains('modal__bg') || target.classList.contains('modal__close')) {
    //            console.log("clicked close");
    //            // make the hidden div visible again and remove the transforms so it scales back to its original size
    //            div.style.opacity = '1';
    //            div.removeAttribute('style');
    //
    //            /**
    //             * iterate through the modals and modal contents and triggers to remove their active classes.
    //             * remove the inline css from the trigger to move it back into its original position.
    //             */
    //
    //            for (var i = 0; i < len; i++) {
    //                modals[i].classList.remove('modal--active');
    //                content[i].classList.remove('modal__content--active');
    //                trigger[i].style.transform = 'none';
    //                trigger[i].style.webkitTransform = 'none';
    //                trigger[i].classList.remove('modal__trigger--active');
    //            }
    //
    //            // when the temporary div is opacity:1 again, we want to remove it from the dom
    //            div.addEventListener('transitionend', removeDiv, false);
    //
    //            isOpen = false;
    //
    //        }
    //
    //        function removeDiv() {
    //            setTimeout(function() {
    //                window.requestAnimationFrame(function() {
    //                    // remove the temp div from the dom with a slight delay so the animation looks good
    //                    div.remove();
    //                });
    //            }, contentDelay - 50);
    //        }
    //
    //    };
    //
    //    var bindActions = function() {
    //        for (var i = 0; i < len; i++) {
    //            trigger[i].addEventListener('click', getId, false);
    //            //closers[i].addEventListener('click', close, false);
    //            modalsbg[i].addEventListener('click', close, false);
    //        }
    //    };
    //
    //    var init = function() {
    //        bindActions();
    //    };
    //
    //    return {
    //        init: init
    //    };
    //
    //}());
    //
    //Modal.init();

    /*js for modal*/

// When the user clicks the button, open the modal
    $("#myBtn").click(function(){
        $("#myModal").css("display","block");
    });

// When the user clicks on <span> (x), close the modal
    $(".close").click(function(){
        $("#myModal").css("display","none");
    });

// When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == $('#myModal')) {
            $("#myModal").css("display","none");
        }
    }

    /* ------------ sticky header in tables ---------------- */

    function UpdateTableHeaders() {
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

    });


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

  /* ------  script for json table  ----- */
    $(".jTable .main-title").each(function(){
        $(this).parent().addClass("main-title-wrap");
    })

    /* ------------ end of sticky header for table --------------- */

    $(window).resize(function(){
        headerElementsAlign();
        tabResponsive();
        menuDisappear();
        //fixHeader();
    });
});
