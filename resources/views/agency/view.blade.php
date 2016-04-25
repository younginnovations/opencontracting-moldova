@extends('app')
@section('content')
    <div class="block header-block header-with-bg">
        <div class="row header-with-icon">
            <h2> <span><img src="{{url('images/ic_agency.svg')}}"/></span>
                {{ $procuringAgency }}
            </h2>
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
                        <div class="chart-wrap" data-equalizer-watch="equal-chart-wrap">
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
                        <div class="chart-wrap" data-equalizer-watch="equal-chart-wrap">
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
                        <div class="chart-wrap" data-equalizer-watch="equal-chart-wrap">
                            <div class="filter-section">
                                <form>
                                    <label>
                                        <span class="inner-title">Showing contractors</span>
                                        <select id="select-contractor" data-for="agency" data="{{ $procuringAgency }}">
                                            <option value="amount" selected>Based on value</option>
                                            <option value="count">Based on count</option>
                                        </select>
                                    </label>
                                </form>
                            </div>
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
                            <a href="#" class="anchor">View all contractors <span>  &rarr; </span></a>
                        </div>
                        {{--<button class="button yellow-button hvr-sweep-to-right">test the button</button>--}}
                    </div>
                </div>

                <div class="medium-6 small-12 columns">
                    <div class="each-chart-section">
                        <div class="section-header clearfix" data-equalizer-watch="equal-header">
                            <h3>Top 5 Goods and Services procured</h3>
                        </div>
                        <div class="chart-wrap" data-equalizer-watch="equal-chart-wrap">
                            <div class="filter-section">
                                <form>
                                    <label>
                                        <span class="inner-title">Showing goods / services</span>
                                        <select id="select-goods" data-for="agency" data="{{ $procuringAgency }}">
                                            <option value="amount" selected>Based on value</option>
                                            <option value="count">Based on count</option>
                                        </select>
                                    </label>
                                </form>
                            </div>
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
                            <a href="#" class="anchor">View all goods / services <span>  &rarr; </span></a>
                        </div>
                    </div>
                </div>
            </div>


        </div>

    </div>
    <div class="row table-wrapper">
        <table table id="table_id" class="responsive hover custom-table">

            <thead>
                <th>Contract number</th>
                <th>Goods and services contracted</th>
                <th width="150px">Contract start date</th>
                <th width="150px">Contract end date</th>
                <th>Amount</th>
            </thead>
            <tbody>
            @forelse($procuringAgencyDetail as $key => $agency)
                @if($key < 10)
                    <tr>
                        <td>{{ $agency['contractNumber'] }}</td>
                        <td>{{ $agency['goods']['mdValue'] }}</td>
                        <td class="dt">{{ $agency['contractDate'] }}</td>
                        <td class="dt">{{ $agency['finalDate'] }}</td>
                        <td>{{ number_format($agency['amount']) }}</td>
                    </tr>
                @endif
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
        $(document).ready(function(){
            updateTables();
        })
    </script>
    <script>
        var route = '{{ route("filter") }}';
        var trends = '{!! $trends  !!}';
        var amountTrend = '{!! $amountTrend !!}';
        var contractors = '{!! $contractors  !!}';
        var goodsAndServices = '{!! $goodsAndServices  !!}';
        console.log(trends);
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
