@extends('app')

@section('content')
    <div class="block header-block header-with-bg">
        <div class="row header-with-icon">
            <h2>
                <span><img src="{{url('images/ic_good_service.svg')}}"/></span>
                @lang('goods.goods_and_services')
         <span class="wiki-link"><a href="/help/works"><img src="{{url('images/ic_link.svg')}}"/></a></span>
            </h2>
        </div>
    </div>

    <div class="push-up-block  wide-header row">

        <div class="columns medium-6 small-12">
            <div class="header-description">
                <div class="big-header">
                    <div class="number big-amount">{{$totalGoods}}</div>
                    {{--<div class="big-title">Goods/Services/Work</div>--}}
                    <div class="big-title">@lang('goods.goods_services')</div>
                </div>
                <p>
                    @lang('goods.goods_paragraph')
                </p>
            </div>
        </div>

        <div class="columns medium-6 small-12">
            <div class="chart-section-wrap">
                <div class="each-chart-section">
                    <div class="section-header section-header-services clearfix">
                        <form>
                            <label>
                                {{--<select id="select-goods-year">--}}
                                    {{--@include('selectYear')--}}
                                {{--</select>--}}
                                <p class="inner-title"><span>@lang('general.top_5') </span> <span class="indicator">@lang('goods.goods_slash_services')</span></p>
                                <input type="hidden" id="select-year-goods">
                                <select id="select-goods">
                                    <option value="amount" selected>@lang('general.based_on_value')</option>
                                    <option value="count">@lang('general.based_on_count')</option>
                                </select>
                                {{--<div><input type="text" id="goods-range" value=""/></div>--}}
                            </label>
                        </form>
                        <div id="goods-slider"></div>
                        {{--<ul class="breadcrumbs right-content">--}}
                            {{--<p>@lang('general.top_5') &nbsp;<span href="#"--}}
                                                                  {{--class="indicator">@lang('goods.goods_slash_services')</span>--}}
                            {{--</p>--}}
                        {{--</ul>--}}
                    </div>
                    <div class="disabled-text">@lang('general.click_on_label_or_graph')</div>
                    <div class="chart-wrap default-view header-chart">
                        <div id="barChart-goods"></div>
                        <div class="loader-text">
                            <div class="text">@lang('general.fetching_data')
                                <span>
                                    <div class="dot dot1"></div>
                                    <div class="dot dot2"></div>
                                    <div class="dot dot3"></div>
                                    <div class="dot dot4"></div>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row table-wrapper">
        {{--<a target="_blank" class="export" href="/csv/download/goods">@lang('general.export_as_csv')</a>--}}
        <table id="table_id" class="hover responsive custom-table display persist-area">
            <thead class="persist-header">
            <tr>
                <th>@lang('general.name')</th>
                <th>@lang('goods.cpv_code')</th>
                <th>@lang('general.scheme')</th>
            </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
@endsection
@section('script')
    <script src="{{url('js/vendorChart.min.js')}}"></script>
    <script src="{{url('js/responsive-tables.min.js')}}"></script>
    <script src="{{url('js/customChart.min.js')}}"></script>
    <script>
        var makeTable = $('#table_id').DataTable({
            "language": {
                'searchPlaceholder':  "@lang('homepage.search')"  ,
                "lengthMenu": "Show _MENU_ Tenders"
            },
            "processing": true,
            "serverSide": true,
            "ajax": '/api/goods',
//            "ajaxDataProp": '',
//            "columns": [
//                {'data': 'good'},
//                {'data': 'cpv_value'},
//                {'data': 'scheme'}
//            ],
            "fnDrawCallback": function () {
                createLinks();
                updateTables();
            }
        });

        var createLinks = function () {

            $('#table_id tbody tr').each(function () {
                $(this).css('cursor', 'pointer');
                $(this).click(function () {
                    var goodName = $(this).find("td:first").text();
                    return window.location.assign(window.location.origin + "/goods/" + goodName);
                });

            });
        };

    </script>
    <script src="{{url('js/fixedHeader.min.js')}}"></script>
    <script src="{{url('js/customChart.js')}}"></script>
    <script>
        $(document).ready(function () {
            if ($(window).width() > 768) {
                new $.fn.dataTable.FixedHeader(makeTable);
            }
        });
    </script>
    <script>
        var route = '{{ route("filter") }}';
        var goodsAndServices = '{!! $goodsAndServices  !!}';
        var total = 0;
        var newGoodsAndServices = JSON.parse(goodsAndServices);

        var makeCharts = function () {
            var widthOfParent = $('.chart-wrap').width() - 12;
            createSlider(route, 'goods', widthOfParent, "barChart-goods", "goods","#goods-slider");
            createBarChartProcuring(JSON.parse(goodsAndServices), "barChart-goods", "goods", widthOfParent, 'amount');
        };

        makeCharts();

        $(window).resize(function () {
            $("#goods-slider").empty();
            makeCharts();
        });

    </script>
@endsection