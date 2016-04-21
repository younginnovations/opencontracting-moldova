<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8"/>
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Moldova</title>
    <link href="{{url('css/vendors.min.css')}}" rel="stylesheet">
    {{--<link href="{{url('css/app.min.css')}}" rel="stylesheet">--}}
    <link href="{{url('css/app.css')}}" rel="stylesheet">


</head>

<body class="{{(\Request::segment(1) === "about" || \Request::segment(1) === "contact")?'one-pager':''}}">

<div class="title-bar burger-menu-button">
    <button class="burger-menu" type="button">
        <div class="burger"></div>
    </button>
</div>

@if(\Request::segment(1) === null)
    <div class="header-banner clearfix">
        @include("partials/main-menu")
        <div class="callout banner-section">
            <div class="row banner-inner">
                <p class="banner-text medium-4 small-12 columns">Search through
                    <span class="amount big-amount">{{ $totalContractAmount }} </span>
                    Leu
                    worth of contracts
                </p>
                <form action="{{ route('search') }}" method="get" class="search-form medium-8 small-12 columns
                ">
                    <input name="q" type="search"
                           placeholder="Type a contractor, procuring agency or goods & services ...">
                </form>
            </div>
        </div>
    </div>
@else
    @include("partials/main-menu")
@endif
<section id = "main-content" class="main-content">
    <div id="tooltip-wrap" class="hide">
        <p>
            <span id="value"></span>
        </p>
    </div>
    @yield('content')
</section>

<footer class="clearfix">
    <div class="row">
        <div class="top-bar-left">
            <div class="project-logo">
                <div class="first-section">MOLDOVA CONTRACT</div>
                <div class="second-section">DATA VISUALISATION</div>
            </div>
        </div>
    </div>
</footer>
<script src="{{url('js/vendors.min.js')}}"></script>
<script src="{{url('js/vendorChart.min.js')}}"></script>
<script src="{{url('js/customChart.min.js')}}"></script>
<script src="{{url('js/app.min.js')}}"></script>
<script>
    var changeDateFormat = function () {
        $('.dt').each(function () {
            var dt = $(this).text().split(".");
            if (dt[1]) {
                dt = dt[1] + '/' + dt[0] + '/' + dt[2];
                var formatted = moment(dt).format('ll');
                $(this).text(formatted);
            }

        });
    };

    var numericFormat = function () {
        $('.numeric-data').each(function () {
            if (parseInt($(this).text())) {
                var formatted = number_format($(this).text());
                $(this).text(formatted);
            }
        });
    }
    numericFormat();
    changeDateFormat();

</script>

@yield('script')
<script>
    $(document).foundation();
    (function () {
        [].slice.call(document.querySelectorAll('select.cs-select')).forEach(function (el) {
            new SelectFx(el);
        });
    })();
    /* -------- convert the amount to kilo and milllion --------- */


    $(".big-amount").each(function(){
        var formatted = number_format($(this).text());
        $(this).text(formatted);
    });
</script>
</body>

</html>
