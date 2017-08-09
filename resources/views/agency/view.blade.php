@extends('app')
@section('content')
    <div class="block header-block header-with-bg">
        <div class="row header-with-icon">
            <h2><span><img src="{{url('images/ic_agency.svg')}}"/></span>
                {{ $procuringAgency }}
            </h2>
            @if(!empty($agencyData->buyer['address']['streetAddress']) || !empty($agencyData->buyer['contactPoint']['email']) || !empty($agencyData->buyer['contactPoint']['telephone']) || !empty($agencyData->buyer['contactPoint']['faxNumber']) || !empty($agencyData->buyer['contactPoint']['url']))
                <div class="detail-info-wrap">
                    <div class="detail-anchor small-button grey-yellow-btn"><span>i</span>view info</div>

                    <div class="detail-info">
                        @if(!empty($agencyData->buyer['address']['streetAddress']))
                            <div class="name-value-wrap">
                                <div class="name address">@lang('agency.address'):</div>
                                <div class="value">{{ $agencyData->buyer['address']['streetAddress'] }} </div>
                            </div>
                        @endif
                        @if(!empty($agencyData->buyer['contactPoint']['email']))
                            <div class="name-value-wrap">
                                <div class="name email">@lang('agency.email'):</div>
                                <div class="value">{{ $agencyData->buyer['contactPoint']['email'] }} </div>
                            </div>
                        @endif
                        @if(!empty($agencyData->buyer['contactPoint']['telephone']))
                            <div class="name-value-wrap">
                                <div class="name phone">@lang('agency.phone'):</div>
                                <div class="value">{{ $agencyData->buyer['contactPoint']['telephone'] }} </div>
                            </div>
                        @endif
                        @if(!empty($agencyData->buyer['contactPoint']['faxNumber']))
                            <div class="name-value-wrap">
                                <div class="name fax">@lang('agency.fax'):</div>
                                <div class="value">{{ $agencyData->buyer['contactPoint']['faxNumber'] }} </div>
                            </div>
                        @endif
                        @if(!empty($agencyData->buyer['contactPoint']['url']))
                            <div class="name-value-wrap">
                                <div class="name url">@lang('agency.url'):</div>
                                <div class="value">{{ $agencyData->buyer['contactPoint']['url'] }} </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
    <div class="row chart-section-wrap push-up-block">
        <div class="inner-wrap clearfix" data-equalizer="equal-chart-wrap">

            <div data-equalizer="equal-header">
                <div class="medium-6 small-12 columns">
                    <div class="each-chart-section">
                        <div class="section-header clearfix" data-equalizer-watch="equal-header">
                            <ul class="breadcrumbs">
                                <li><span href="#" class="indicator tender">@lang('general.tenders')</span> &nbsp; @lang('agency.published')</li>
                                <li> &nbsp; vs. &nbsp;</li>
                                <li><span href="#" class="indicator contracts">@lang('general.contracts')</span> &nbsp; @lang('agency.issued')</li>
                            </ul>
                        </div>
                        <div class="chart-wrap default-view" data-equalizer-watch="equal-chart-wrap">
                            <div id="linechart-homepage"></div>
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

                <div class="medium-6 small-12 columns">
                    <div class="each-chart-section">
                        <div class="section-header clearfix" data-equalizer-watch="equal-header">
                            <h3>@lang('general.contract_value')</h3>
                        </div>
                        <div class="chart-wrap default-view" data-equalizer-watch="equal-chart-wrap">
                            <div id="barChart-amount"></div>
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

        <div class="inner-wrap clearfix" data-equalizer="equal-chart-wrap">
            <div data-equalizer="equal-header">
                <div class="medium-6 small-12 columns">
                    <div class="each-chart-section">
                        <div class="section-header section-header-home clearfix" data-equalizer-watch="equal-header">
                            <span class="icon contractor">icon</span>
                            <h3>@lang('agency.top_5_contractor')</h3>
                        </div>
                        <div class="chart-wrap default-view default-barChart" data-equalizer-watch="equal-chart-wrap">
                            <div class="filter-section">
                                <form>
                                    <label>
                                        <span class="inner-title">@lang('agency.showing_contractors')</span>
                                        {{--<select id="select-contractor-year">--}}
                                            {{--@include('selectYear')--}}
                                        {{--</select>--}}
                                        <input type="hidden" id="select-year-contractor">
                                        <select id="select-contractor" data-for="agency" data="{{ $procuringAgency }}">
                                            <option value="amount" selected>@lang('general.based_on_value')</option>
                                            <option value="count">@lang('general.based_on_count')</option>
                                        </select>
                                        {{--<div><input type="text" id="contractor-range" value=""/></div>--}}
                                    </label>
                                </form>
                                <div id="contractors-slider"></div>
                            </div>
                            <div class="disabled-text">@lang('general.click_on_label_or_graph')</div>
                            <div id="barChart-contractors"></div>
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
                            <a href="{{route('contracts.contractorIndex')}}" class="anchor">@lang('agency.view_all_contractor') <span>  &rarr; </span></a>
                        </div>
                        {{--<button class="button yellow-button hvr-sweep-to-right">test the button</button>--}}
                    </div>
                </div>

                <div class="medium-6 small-12 columns">
                    <div class="each-chart-section">
                        <div class="section-header section-header-home clearfix" data-equalizer-watch="equal-header">
                            <span class="icon goods-service">icon</span>
                            <h3>@lang('general.top_5_goods_&_services_procured')</h3>
                        </div>
                        <div class="chart-wrap default-view default-barChart" data-equalizer-watch="equal-chart-wrap">
                            <div class="filter-section">
                                <form>
                                    <label>
                                        <span class="inner-title">@lang('general.showing_goods_and_services')</span>
                                        {{--<select id="select-goods-year">--}}
                                            {{--@include('selectYear')--}}
                                        {{--</select>--}}
                                        <input type="hidden" id="select-year-goods">
                                        <select id="select-goods" data-for="agency" data="{{ $procuringAgency }}">
                                            <option value="amount" selected>@lang('general.based_on_value')</option>
                                            <option value="count">@lang('general.based_on_count')</option>
                                        </select>
                                        {{--<div><input type="text" id="goods-range" value=""/></div>--}}
                                    </label>
                                </form>
                                <div id="goods-slider"></div>
                            </div>
                            <div class="disabled-text">@lang('general.click_on_label_or_graph')</div>
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
                            <a href="{{ route('goods.index') }}" class="anchor">@lang('general.view_all_goods_services') <span>  &rarr; </span></a>
                        </div>
                    </div>
                </div>
            </div>


        </div>

    </div>
    <div class="row table-wrapper">
{{--        <a target="_blank" class="export" href="{{route('agencyDetail.export',['name'=>$procuringAgency])}}">@lang('general.export_as_csv')</a>--}}
        <table id="table_id" class="responsive hover custom-table persist-area">
            <thead class="persist-header">
            <th class="contract-number">@lang('general.contract_number')</th>
            <th class="hide">@lang('general.contract_id')</th>
            <th>@lang('general.goods_and_services_contracted')</th>
            <th>@lang('general.contract_status')</th>
            <th class="long-th">@lang('general.contract_start_date')</th>
            <th class="long-th">@lang('general.contract_end_date')</th>
            <th>@lang('general.amount') (MDL)</th>
            </thead>
            <tbody>
            @forelse($procuringAgencyDetail as $tender)
                @foreach($tender['contracts'] as $key => $agency)
                    <tr>
                        <td>{{ getContractInfo($agency['title'],'id') }}</td>
                        <td class="hide">{{ $agency['id'] }}</td>
                        <td>{{ ($tender['awards'][$key]['items'])?$tender['awards'][$key]['items'][0]['classification']['description']:'-' }}</td>
                        <td>{{ $agency['status'] }}</td>
                        <td class="dt">{{ $agency['dateSigned']->toDateTime()->format('c') }}</td>
                        <td class="dt">{{ $agency['period']['endDate'] }}</td>
                        <td class="numeric-data">{{ ($agency['value']['amount']) }}</td>
                    </tr>
                @endforeach
            @empty
            @endforelse

            </tbody>
        </table>
    </div>

@stop
@section('script')
    <script src="{{url('js/vendorChart.min.js')}}"></script>
    <script src="{{url('js/responsive-tables.min.js')}}"></script>
    <script src="{{url('js/customChart.js')}}"></script>
    <script>
        $(document).ready(function () {
            updateTables();
        });
    </script>
    <script src="{{url('js/responsive-tables.min.js')}}"></script>
    <script>

        var createLinks = function () {

            $('#table_id tbody tr').each(function () {
                $(this).css('cursor', 'pointer');
                $(this).click(function () {
                    var contractId = $(this).find("td:nth-child(2)").text();
                    return window.location.assign(window.location.origin + "/contracts/" + contractId);
                });

            });
        };

        var makeTable = $("#table_id").DataTable({
            "bFilter": false,
            "fnDrawCallback": function () {
                changeDateFormat();
                createLinks();
                if ($('#table_id tr').length < 10 && $('a.current').text() === "1") {
                    $('.dataTables_paginate').hide();
                } else {
                    $('.dataTables_paginate').show();
                }
            }
        });

        createLinks();
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
        var trends = '{!! $trends  !!}';
        var amountTrend = '{!! $amountTrend !!}';
        var contractors = '{!! $contractors  !!}';
        var goodsAndServices = '{!! $goodsAndServices  !!}';

        console.log(amountTrend);

        var makeCharts = function () {
            var widthofParent = $('.chart-wrap').width();
            createLineChart(JSON.parse(trends), widthofParent);
            createSlider(route, 'contractor', widthOfParent, "barChart-contractors", "contracts/contractor", "#contractors-slider");
            createSlider(route, 'goods', widthOfParent, "barChart-goods", "goods","#goods-slider");

            createBarChartContract(JSON.parse(amountTrend), "barChart-amount", widthofParent, 'amount');
            createBarChartProcuring(JSON.parse(contractors), "barChart-contractors", "contracts/contractor", widthofParent, 'amount');
            createBarChartProcuring(JSON.parse(goodsAndServices), "barChart-goods", "goods", widthofParent, 'amount');
        };

        makeCharts();

        $(window).resize(function () {
            $("#linechart-homepage").empty();
            $('#contractors-slider').empty();
            $('#goods-slider').empty();
            $("#barChart-amount").empty();
            makeCharts();
        });

    </script>
@endsection
