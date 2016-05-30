<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8"/>
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Moldova</title>
    <link href="{{url('css/vendors.min.css')}}" rel="stylesheet">
    <link href="{{url('css/app.min.css')}}" rel="stylesheet">
    {{--<link href="{{url('css/app.css')}}" rel="stylesheet">--}}
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
                                        <select name="contractor" class="cs-select2 cs-skin-elastic">
                                            <option value="" disabled selected>Select a contractor</option>
                                            @forelse($contractTitles as $contractTitle)
                                                <option value="{{ $contractTitle['_id'][0] }}">{{ $contractTitle['_id'][0] }}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>
                                    <div class="form-group medium-4 columns end">
                                        <select name="agency" class="cs-select2 cs-skin-elastic">
                                            <option value="" disabled selected>Select a buyer</option>
                                            @forelse($procuringAgencies as $procuringAgency)
                                                <option value="{{ $procuringAgency[0] }}">{{ $procuringAgency[0] }}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>
                                    <div class="form-group medium-4 columns end">
                                        <select name="amount" class="cs-select2 cs-skin-elastic">
                                            <option value="" disabled selected>Select a range</option>
                                            <option value="0-10000">0-10000</option>
                                            <option value="10000-200000">10000-200000</option>
                                            <option value="200000-500000">200000-500000</option>
                                            <option value="500000-1000000">500000-1000000</option>
                                            <option value="1000000-Above">1000000-Above</option>
                                        </select>
                                    </div>
                                    <div class="form-group medium-4 columns end">
                                        <select name="startDate" class="cs-select2 cs-skin-elastic">
                                            @foreach(range(date('Y'), date('Y')-100) as $year)
                                                <option value="" disabled selected>Select a year</option>
                                                <option value="{{$year}}">{{$year}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group medium-4 columns end">
                                        <select name="endDate" class="cs-select2 cs-skin-elastic">
                                            @foreach(range(date('Y'), date('Y')-100) as $year)
                                                <option value="" disabled selected>Select a year</option>
                                                <option value="{{$year}}">{{$year}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="input-group-button medium-12 clearfix">
                                    <div class="medium-4 columns">
                                        <input type="submit" class="button yellow-button" value="Submit">
                                    </div>
                                    <div class="medium-4 columns end">
                                        <div class="button cancel-btn">Cancel</div>
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
<section id="main-content" class="main-content">
    <div id="tooltip-wrap" class="hide">
        <p>
            <span id="value"></span>
        </p>
    </div>
    <div id="tooltip-no-tip" class="hide">
        <p>
            <span id="value"></span>
        </p>
    </div>
    @yield('content')
    <div class="share-wrap">
        <div class="row">
            <div class="text-right sharing-title share-section">
                <ul class="social-share">
                    <li>
                        <span class="small-title">Share this <span>{{(\Request::segment(1) === "contracts")?'contract':'page'}}</span> in</span>
                    </li>
                    <li>
                        <div class="addthis_sharing_toolbox"></div>
                    </li>
                </ul>
            </div>
        </div>
    </div>

</section>

<div id="subscribeModal" class="modal alert">
    <!-- Modal content -->
    <div class="modal-content">
        <span class="close">×</span>

        <div class="modal__content">
            <i id="showMsg"></i>
        </div>
    </div>
</div>

<footer class="clearfix">
    <div class="row">
        <form class="right-content custom-form medium-5">
            <div class="form-group">
                <div class="suscribe-input">
                    <input class="form-control" required="true" type="text" name="email"
                           placeholder="Please enter email"/>
                </div>
                <input class="button subscribe form-control" type="button" id="subscribe" name="subscribe"
                       value="Subcribe"/>
            </div>
        </form>
        <div class="top-bar-left left-content">
            <div class="project-logo">
                <div class="first-section">MOLDOVA CONTRACT</div>
                <div class="second-section">DATA VISUALISATION</div>
            </div>
        </div>
    </div>
</footer>
<script>
    var subscribeRoute = '{{ route("subscriptions.add") }}';
</script>
<script src="{{url('js/vendors.min.js')}}"></script>
<script src="{{url('js/app.min.js')}}"></script>
<script type="text/javascript">var switchTo5x = true;</script>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5743e070a2fa5f67"></script>
<script type="text/javascript">
    var addthis_share = {
        title: "Moldova OCDS"
    }
</script>
{{--<script type="text/javascript">--}}
    {{--stLight.options({--}}
        {{--publisher: "edd8f686-154a-4ba0-a97f-a17a0410077d",--}}
        {{--doNotHash: false,--}}
        {{--doNotCopy: false,--}}
        {{--hashAddressBar: false--}}
    {{--});--}}
{{--</script>--}}
<script src="{{url('js/foundation-datepicker.js')}}"></script>
<link href="{{url('css/foundation-datepicker.css')}}" rel="stylesheet"/>
{{--<link href="//cdnjs.cloudflare.com/ajax/libs/foundicons/3.0.0/foundation-icons.css" rel="stylesheet">--}}
{{--<link href="//netdna.bootstrapcdn.com/font-awesome/3.0.2/css/font-awesome.css" rel="stylesheet">--}}
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/css/select2.min.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/js/select2.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $(".cs-select2").select2();
    });
</script>
<script>
    $(function () {
        $('#dp1').fdatepicker({
            format: 'dd-mm-yyyy',
            disableDblClickSelection: true
        });
        $('#dp2').fdatepicker({
            format: 'dd-mm-yyyy',
            disableDblClickSelection: true
        });
    });
</script>
<script>
    $(document).ready(function () {
        $(".custom-form").submit(function () {
            if ($("#dp1").val() == "") {
                $("#dp1").remove();
            }
            if ($("#dp2").val() == "") {
                $("#dp2").remove();
            }
        });
    });
</script>
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
<script src="{{url('js/foundation.min.js')}}"></script>
<script>
    $(document).foundation();
</script>
<script>
    (function () {
        [].slice.call(document.querySelectorAll('select.cs-select')).forEach(function (el) {
            new SelectFx(el);
        });
    })();
    /* -------- convert the amount to kilo and milllion --------- */
    $(".big-amount").each(function () {
        var formatted = number_format($(this).text());
        $(this).text(formatted);
    });
</script>
</body>

</html>
