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
                                <div class="name address">Address:</div>
                                <div class="value">{{ $agencyData->buyer['address']['streetAddress'] }} </div>
                            </div>
                        @endif
                        @if(!empty($agencyData->buyer['contactPoint']['email']))
                            <div class="name-value-wrap">
                                <div class="name email">Email:</div>
                                <div class="value">{{ $agencyData->buyer['contactPoint']['email'] }} </div>
                            </div>
                        @endif
                        @if(!empty($agencyData->buyer['contactPoint']['telephone']))
                            <div class="name-value-wrap">
                                <div class="name phone">Phone:</div>
                                <div class="value">{{ $agencyData->buyer['contactPoint']['telephone'] }} </div>
                            </div>
                        @endif
                        @if(!empty($agencyData->buyer['contactPoint']['faxNumber']))
                            <div class="name-value-wrap">
                                <div class="name fax">Fax:</div>
                                <div class="value">{{ $agencyData->buyer['contactPoint']['faxNumber'] }} </div>
                            </div>
                        @endif
                        @if(!empty($agencyData->buyer['contactPoint']['url']))
                            <div class="name-value-wrap">
                                <div class="name url">Url:</div>
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
                                <li><span href="#" class="indicator tender">Tenders</span> &nbsp; published</li>
                                <li> &nbsp; vs. &nbsp;</li>
                                <li><span href="#" class="indicator contracts">Contracts</span> &nbsp; issued</li>
                            </ul>
                        </div>
                        <div class="chart-wrap default-view" data-equalizer-watch="equal-chart-wrap">
                            <div id="linechart-homepage"></div>
                            <div class="loader-text">
                                <div class="text">Fetching data
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
                            <h3>Contract value</h3>
                        </div>
                        <div class="chart-wrap default-view" data-equalizer-watch="equal-chart-wrap">
                            <div id="barChart-amount"></div>
                            <div class="loader-text">
                                <div class="text">Fetching data
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
                        <div class="section-header clearfix" data-equalizer-watch="equal-header">
                            <h3>Top 5 contractors</h3>
                        </div>
                        <div class="chart-wrap default-view default-barChart" data-equalizer-watch="equal-chart-wrap">
                            <div class="filter-section">
                                <form>
                                    <label>
                                        <span class="inner-title">Showing contractors</span>
                                        <select id="select-contractor-year">
                                            @include('selectYear')
                                        </select>
                                        <select id="select-contractor" data-for="agency" data="{{ $procuringAgency }}">
                                            <option value="amount" selected>Based on value</option>
                                            <option value="count">Based on count</option>
                                        </select>
                                    </label>
                                </form>
                            </div>
                            <div class="disabled-text">Click on label or graph bar to view in detail.</div>
                            <div id="barChart-contractors"></div>
                            <div class="loader-text">
                                <div class="text">Fetching data
                                     <span>
                                    <div class="dot dot1"></div>
                                    <div class="dot dot2"></div>
                                    <div class="dot dot3"></div>
                                    <div class="dot dot4"></div>
                                </span>
                                </div>
                            </div>
                            <a href="{{route('contracts.contractorIndex')}}" class="anchor">View all contractors <span>  &rarr; </span></a>
                        </div>
                        {{--<button class="button yellow-button hvr-sweep-to-right">test the button</button>--}}
                    </div>
                </div>

                <div class="medium-6 small-12 columns">
                    <div class="each-chart-section">
                        <div class="section-header clearfix" data-equalizer-watch="equal-header">
                            <h3>Top 5 Goods and Services procured</h3>
                        </div>
                        <div class="chart-wrap default-view default-barChart" data-equalizer-watch="equal-chart-wrap">
                            <div class="filter-section">
                                <form>
                                    <label>
                                        <span class="inner-title">Showing goods / services</span>
                                        <select id="select-goods-year">
                                            @include('selectYear')
                                        </select>
                                        <select id="select-goods" data-for="agency" data="{{ $procuringAgency }}">
                                            <option value="amount" selected>Based on value</option>
                                            <option value="count">Based on count</option>
                                        </select>
                                    </label>
                                </form>
                            </div>
                            <div class="disabled-text">Click on label or graph bar to view in detail.</div>
                            <div id="barChart-goods"></div>
                            <div class="loader-text">
                                <div class="text">Fetching data
                                     <span>
                                    <div class="dot dot1"></div>
                                    <div class="dot dot2"></div>
                                    <div class="dot dot3"></div>
                                    <div class="dot dot4"></div>
                                </span>
                                </div>
                            </div>
                            <a href="{{ route('goods.index') }}" class="anchor">View all goods / services <span>  &rarr; </span></a>
                        </div>
                    </div>
                </div>
            </div>


        </div>

    </div>
    <div class="row table-wrapper">
        <a target="_blank" class="export" href="{{route('agencyDetail.export',['name'=>$procuringAgency])}}">Export as
            CSV</a>
        <table id="table_id" class="responsive hover custom-table persist-area">
            <thead class="persist-header">
            <th class="contract-number">Contract number</th>
            <th class="hide">Contract ID</th>
            <th>Goods and services contracted</th>
            <th>Contract status</th>
            <th class="long-th">Contract start date</th>
            <th class="long-th">Contract end date</th>
            <th>Amount</th>
            </thead>
            <tbody>
            @forelse($procuringAgencyDetail as $tender)
                @foreach($tender['contracts'] as $key => $agency)
                    <tr>
                        <td>{{ getContractInfo($agency['title'],'id') }}</td>
                        <td class="hide">{{ $agency['id'] }}</td>
                        <td>{{ ($tender['awards'][$key]['items'])?$tender['awards'][$key]['items'][0]['classification']['description']:'-' }}</td>
                        <td>{{ $agency['status'] }}</td>
                        <td class="dt">{{ $agency['dateSigned'] }}</td>
                        <td class="dt">{{ $agency['period']['endDate'] }}</td>
                        <td>{{ number_format($agency['value']['amount']) }}</td>
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
    <script src="{{url('js/customChart.min.js')}}"></script>
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

        var makeCharts = function () {
            var widthofParent = $('.chart-wrap').width();
            createLineChart(JSON.parse(trends), widthofParent);
            createBarChartContract(JSON.parse(amountTrend), "barChart-amount", widthofParent, 'amount');
            createBarChartProcuring(JSON.parse(contractors), "barChart-contractors", "contracts/contractor", widthofParent, 'amount');
            createBarChartProcuring(JSON.parse(goodsAndServices), "barChart-goods", "goods", widthofParent, 'amount');
        };

        makeCharts();

        $(window).resize(function () {
            $("#linechart-homepage").empty();
            $("#barChart-amount").empty();
            makeCharts();
        });

    </script>
@endsection
