@extends('app')

@section('content')
    <div class="row chart-section-wrap">
        {{-- ----- div for each two chart starts ------- --}}

        <div class="inner-wrap clearfix" data-equalizer="equal-chart-wrap">
            <div data-equalizer="equal-header">

                <div class="medium-6 small-12 columns">
                    <div class="each-chart-section">
                        <div class="section-header clearfix" data-equalizer-watch="equal-header">
                            <ul class="breadcrumbs">
                                <li><span hre   f =  "#" class="indicator tender">Tenders</span> &nbsp; published</li>
                                <li> &nbsp; vs. &nbsp;</li>
                                <li><span href="#" class="indicators">Contracts</span> &nbsp; issued</li>
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
                            <h3>Top 5 procuring agencies</h3>
                        </div>
                        <div class="chart-wrap default-view default-barChart" data-equalizer-watch="equal-chart-wrap">
                            <div class="filter-section">
                                <form>
                                    <label>
                                        <span class="inner-title">Showing procuring agencies</span>
                                        <select id="select-agency-year">
                                            @include('selectYear')
                                        </select>

                                        <select id="select-agency">
                                            <option value="amount" selected>Based on value</option>
                                            <option value="count">Based on count</option>
                                        </select>

                                    </label>
                                </form>
                            </div>
                            <div class="disabled-text">Click on label or graph bar to view in detail.</div>
                            <div id="barChart-procuring"></div>
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
                            <a href="{{ route('procuring-agency.index') }}" class="anchor">View all procuring agencies <span>  &rarr; </span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- ----- div for each two chart ends ------- --}}

        <div class="inner-wrap clearfix" data-equalizer="equal-chart-wrap">
            <div data-equalizer="equal-header">

                <div class="medium-6 small-12 columns ">
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

                                        <select id="select-contractor">
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
                            <a href="{{ route('contracts.contractorIndex') }}" class="anchor">View all contractors <span>  &rarr; </span></a>
                        </div>
                    </div>
                </div>

                <div class="medium-6 small-12 columns ">
                    <div class="each-chart-section">
                        <div class="section-header clearfix" data-equalizer-watch="equal-header">
                            <h3>Top 5 goods & services procured</h3>
                        </div>

                        <div class="chart-wrap default-view default-barChart" data-equalizer-watch="equal-chart-wrap">
                            <div class="filter-section">
                                <form>
                                    <label>
                                        <span class="inner-title">Showing goods / services</span>

                                        <select id="select-goods-year">
                                            @include('selectYear')
                                        </select>

                                        <select id="select-goods">
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

    <div class="row table-wrapper persist-area">
        <a target="_blank" class="export" href="{{route('home.export')}}">Export as CSV</a>
        <table id="table_id" class="responsive hover custom-table display">
            <thead class="persist-header">
            <tr>
                <th class="contract-number">Contract number</th>
                <th class="hide">Contract ID</th>
                <th>Goods and services contracted</th>
                <th class="long-th">Contract start date</th>
                <th class="long-th">Contract end date</th>
                <th>Amount</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
@endsection

@section('script')
    <script src="{{url('js/responsive-tables.min.js')}}"></script>
    <script type="text/javascript" class="init">

       var makeTable = $('#table_id').DataTable({
               "language": {
                   'searchPlaceholder': "Search by goods / services",
                   "lengthMenu": "Show _MENU_ Contracts"
               },
               "processing": true,
               "serverSide": true,
               "ajax": '/api/data',
               "ajaxDataProp": '',
               "columns": [
                   {'data': 'contractNumber'},
                   {'data': 'id', 'className': 'hide'},
                   {'data': 'goods', "defaultContent": "-"},
                   {'data': 'contractDate', 'className': 'dt'},
                   {'data': 'finalDate', 'className': 'dt'},
                   {'data': 'amount', "className": 'numeric-data'}
               ],
               "fnDrawCallback": function () {
                   changeDateFormat();
                   numericFormat();
                   createLinks();
                   updateTables();
                   if ($('#table_id tr').length < 10) {
                       $('.dataTables_paginate').hide();
                   } else {
                       $('.dataTables_paginate').show();
                   }
               }
           });
        var createLinks = function () {

            $('#table_id tbody tr').each(function () {
                $(this).css('cursor', 'pointer');
                $(this).click(function () {
                    var contractId = $(this).find("td:nth-child(2)").text();
                    return window.location.assign(window.location.origin + "/contracts/" + contractId);
                });

            });
        };
//updateTables();
    </script>
    <script src="{{url('js/vendorChart.min.js')}}"></script>
    <script src="{{url('js/fixedHeader.min.js')}}"></script>
    <script>
        $(document).ready(function() {
            if($(window).width() > 768){
                new $.fn.dataTable.FixedHeader( makeTable );
            }

            $(window).resize(function(){
                new $.fn.dataTable.FixedHeader( makeTable );
            });
        });
    </script>
    <script src="{{url('js/customChart.min.js')}}"></script>
    <script>
        var route = '{{ route("filter") }}';
        var trends = '{!! $trends  !!}';
        var procuringAgencies = '{!! $procuringAgency  !!}';
        var contractors = '{!! $contractors  !!}';
        var goodsAndServices = '{!! $goodsAndServices  !!}';

        var makeCharts = function () {
            var widthOfParent = $('.chart-wrap').width();
            createLineChart(JSON.parse(trends), widthOfParent);
            createBarChartProcuring(JSON.parse(procuringAgencies), "barChart-procuring", "procuring-agency", widthOfParent, 'amount');
            createBarChartProcuring(JSON.parse(contractors), "barChart-contractors", "contracts/contractor", widthOfParent, 'amount');
            createBarChartProcuring(JSON.parse(goodsAndServices), "barChart-goods", "goods", widthOfParent, 'amount');
        };

        makeCharts();

        $(window).resize(function () {
            $("#linechart-homepage").empty();
            makeCharts();
        });

    </script>
@endsection
