<!doctype html>
<html class="no-js" lang="{{getLocalLang()}}">

<head>
    <meta charset="utf-8"/>
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Moldova</title>
    <link rel="icon" type="image" href="{{url('images/moldova.ico')}}">
    {{--<link href="{{url('css/vendors.min.css')}}" rel="stylesheet">--}}
    <link href="{{url('css/vendors.css')}}" rel="stylesheet">
    {{--<link href="{{url('css/app.min.css')}}" rel="stylesheet">--}}
    <link href="{{url('css/app.css')}}" rel="stylesheet">

    {{--Commenting System--}}
    <link href="//cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.2/components/icon.min.css" rel="stylesheet">
    <link href="//cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.2/components/comment.min.css" rel="stylesheet">
    <link href="//cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.2/components/form.min.css" rel="stylesheet">
    <link href="//cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.2/components/button.min.css" rel="stylesheet">
    <link href="{{ asset('/vendor/laravelLikeComment/css/style.css') }}" rel="stylesheet">
</head>

<body class="{{(\Request::segment(1) === "about" || \Request::segment(1) === "contact")?'one-pager':''}}">

@if(\Request::segment(1) === null)
    <div class="header-banner clearfix">
        @include("partials/main-menu")
        <div class="callout banner-section">
            <div class="row banner-inner">
                <p class="banner-text medium-4 small-12 columns">@lang('homepage.search_through')
                    <span class="amount big-amount">{{ $totalContractAmount }} </span>
                    Leu
                    @lang('homepage.worth_of_contracts')
                </p>

                <div class="multiple-search-wrap medium-8 small-12 columns">
                    <form action="{{ route('search') }}" method="get" class="search-form">
                        <input name="q" type="search"
                               placeholder="@lang('homepage.type_a_contractor')" title= "@lang('homepage.type_a_contractor')">
                    </form>
                    <div class="filter-wrap columns">
                        <div class="row">
                            <div class="filter-inner clearfix">
                     <span class="filter-toggler">
                        <a class="show-filter" id="home-show-filter">@lang('general.advance-filter')</a>
                    </span>
                            </div>
                            <form action="{{ route('search') }}" method="get" class="custom-form advance-search-wrap">
                                <div class="form-inner clearfix">
                                    <div class="form-group medium-4 columns end">
                                        <select name="contractor" class="cs-select2 cs-skin-elastic">
                                            <option value="" disabled
                                                    selected>@lang('general.select_a_contractor')</option>
                                            @forelse($contractTitles as $contractTitle)
                                                <option value="{{ $contractTitle['_id'][0] }}">{{ $contractTitle['_id'][0] }}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>
                                    <div class="form-group medium-4 columns end">
                                        <select name="agency" class="cs-select2 cs-skin-elastic">
                                            <option value="" disabled selected>@lang('general.select_a_buyer')</option>
                                            @forelse($procuringAgencies as $procuringAgency)
                                                <option value="{{ $procuringAgency[0] }}">{{ $procuringAgency[0] }}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>
                                    <div class="form-group medium-4 columns end">
                                        <select name="amount" class="cs-select2 cs-skin-elastic">
                                            <option value="" disabled selected>@lang('general.select_a_range')</option>
                                            <option value="0-10000">0-10000</option>
                                            <option value="10000-200000">10000-200000</option>
                                            <option value="200000-500000">200000-500000</option>
                                            <option value="500000-1000000">500000-1000000</option>
                                            <option value="1000000-Above">1000000-@lang('general.above')</option>
                                        </select>
                                    </div>
                                    <div class="form-group medium-4 columns end">
                                        <select name="startDate" class="cs-select2 cs-skin-elastic">
                                            @foreach(range(date('Y'), 2012) as $year)

                                                <option value="" disabled
                                                        selected>@lang('general.select_a_year')</option>
                                                <option value="{{$year}}">{{$year}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group medium-4 columns end">
                                        <select name="endDate" class="cs-select2 cs-skin-elastic">
                                            @foreach(range(date('Y'), 2012) as $year)

                                                <option value="" disabled
                                                        selected>@lang('general.select_a_year')</option>
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
                                        <div class="button cancel-btn">@lang('general.cancel')</div>
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
            <div class="sharing-title share-section">

                <span class="download-json">
                    <a href="/multiple-file-api/releases.json" class="download-json-link">Download JSON</a>
                </span>
                <ul class="social-share">

                    <li>
                        <span class="small-title">@lang('general.share_this')
                            <span>{{(\Request::segment(1) === "contracts")?'contract':'page'}}</span> @lang('general.in')</span>
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
        <form id="subscribe-form" class="right-content custom-form medium-5">
            <div class="form-group">
                <div class="suscribe-input">
                    {{csrf_field()}}
                    <input class="form-control" id="subscriptionEmail" required="true" type="email" name="email"
                           placeholder="@lang('general.enter_your_email')"/>
                </div>
                <input class="button subscribe form-control" type="button" id="subscribe" name="subscribe"
                       value="@lang('general.subscribe')"/>
            </div>
        </form>
        <div class="top-bar-left left-content">
            <div class="project-logo">
                <div class="first-section">@lang('general.moldova_contract')</div>
                <div class="second-section">@lang('general.data_visualization')</div>
            </div>
        </div>
    </div>
</footer>
<script>
var subscribeRoute = '{{ route("newsletter.subscribeUser") }}';
</script>
<script src="{{url('js/vendors.min.js')}}"></script>

{{--<script src="{{url('js/app.min.js')}}"></script>--}}

<script src="{{url('js/app.js')}}"></script>
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
    var changeDateFormat = function () {
        $('.dt').each(function () {
            var dt = $(this).text().split("-");
            if (dt[1]) {
                dt[2] = dt[2].split('T');
                dt[2] = dt[2][0];
                dt = dt[0] + '/' + dt[1] + '/' + dt[2];
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

    $("#Language-select").change(function () {
        var lang = $(this).val();
        var route = window.location.origin + window.location.pathname;
        return window.location.replace(route + '?lang=' + lang);
    });
</script>
<script>
    (function (i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function () {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
        a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
    })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

    ga('create', 'UA-80010335-1', 'auto');
    ga('send', 'pageview');

</script>
</body>

</html>
