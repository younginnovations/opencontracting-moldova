<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8"/>
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Moldova</title>
    <link href="{{url('css/vendors.min.css')}}" rel="stylesheet">
    <link href="{{url('css/app.min.css')}}" rel="stylesheet">
</head>

<body>

<div class="title-bar burger-menu-button">
    <button class="burger-menu" type="button">
        <div class="burger"></div>
    </button>
</div>

<header class="top-bar fixed-header">
    <div class="row">
        <div class="top-bar-left">
            <a href="{{ route('/') }}" class="project-logo">
                <div class="first-section">MOLDOVA CONTRACT</div>
                <div class="second-section">DATA VISUALISATION</div>
            </a>
        </div>

        <div class="top-bar-right" id="main-menu">
            <ul class="menu">
                <li><a href="{{ route('/') }}" class="{{ (\Request::segment(1) === null)?'active':'' }}">Home</a></li>
                <li><a href="#">About</a></li>
                <li><a href="{{ route('tenders.index') }}" class="{{ (Request::segment(1) === 'tenders')?'active':'' }}">Tenders</a>
                </li>
                <li><a href="{{ route('contracts') }}" class="{{ (Request::segment(1) === 'contracts')?'active':'' }}">Contracts</a>
                </li>
                <li><a href="{{ route('contracts') }}"
                       class="{{ (Request::segment(1) === 'procuring-agency')?'active':'' }}">Agencies</a></li>
                <li><a href="{{ route('contracts') }}"
                       class="{{ (Request::segment(1) === 'goods')?'active':'' }}">Goods</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
        </div>
    </div>
</header>
<div id="tooltip">
    <span id="name"></span>
</div>
<section class="main-content">
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
</script>
</body>

</html>
