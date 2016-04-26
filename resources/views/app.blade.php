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
                <div class="multiple-search-wrap medium-8 small-12 columns">
                    <form action="{{ route('search') }}" method="get" class="search-form">
                        <input name="q" type="search"
                               placeholder="Type a contractor, procuring agency or goods & services ...">
                    </form>
                    <div class="filter-wrap columns">
                        <div class="row">
                            <div class="filter-inner clearfix">
                     <span class="filter-toggler">
                        <a class="show-filter" id="home-show-filter">advance-filter</a>
                    </span>
                            </div>
                            <form action="{{ route('search') }}" method="get" class="custom-form advance-search-wrap">
                                <div class="form-inner clearfix">
                                    <div class="form-group medium-4 columns end">
                                        <select name="contractor" class="cs-select cs-skin-elastic">
                                            <option value="" disabled selected>Select a contractor</option>
                                            @forelse($contractTitles as $contractTitle)
                                                <option value="{{ $contractTitle['_id'] }}">{{ $contractTitle['_id'] }}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>
                                    <div class="form-group medium-4 columns end">
                                        <select name="agency" class="cs-select cs-skin-elastic">
                                            <option value="" disabled selected>Select a buyer</option>
                                            @forelse($procuringAgencies as $procuringAgency)
                                                <option value="{{ $procuringAgency[0] }}">{{ $procuringAgency[0] }}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>
                                    <div class="form-group medium-4 columns end">
                                        <select name="amount" class="cs-select cs-skin-elastic">
                                            <option value="" disabled selected>Select a range</option>
                                            <option value="0-10000">0-10000</option>
                                            <option value="10000-200000">10000-200000</option>
                                            <option value="200000-500000">200000-500000</option>
                                            <option value="500000-1000000">500000-1000000</option>
                                            <option value="1000000-Above">1000000-Above</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="input-group-button medium-12 clearfix">
                                    <div class="medium-4 columns">
                                        <input type="submit" class="button yellow-button" value="Submit">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

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
