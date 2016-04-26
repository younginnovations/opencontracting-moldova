@extends('app')
@section('content')
    <div class="block header-block header-with-bg">
        <div class="row header-with-icon">
            <h2> <span><img src="{{url('images/ic_contractor.svg')}}"/></span>
             {{ $contractor }}</h2>
        </div>
    </div>


    <div class="row medium-up-2 small-up-1 push-up-block small-push-up-block">
        <div class="block name-value-wrap columns">
            <div class="name">
                Total contracts
            </div>
            <div class="value">
                {{ count($contractorDetail) }}
            </div>
        </div>

        <div class="block name-value-wrap columns">
            <div class="name">
                Total contract amount
            </div>
            <div class="value">
                {{number_format($totalAmount)}} leu
            </div>
        </div>
    </div>

    <div class="row chart-section-wrap">
        <div class="inner-wrap clearfix" data-equalizer="equal-chart-wrap">
            <div data-equalizer="equal-header">
                <div class="medium-6 small-12 columns">
                    <div class="each-chart-section">
                        <div class="section-header clearfix" data-equalizer-watch="equal-header">
                            <h3>No. of contracts</h3>
                        </div>
                        <div class="chart-wrap" data-equalizer-watch="equal-chart-wrap">
                            <div id="linechart-rest"></div>
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
                            <h3>Top 5 procuring agencies</h3>
                        </div>
                        <div class="chart-wrap" data-equalizer-watch="equal-chart-wrap">
                            <div class="filter-section">
                                <form>
                                    <div>
                                        <label>
                                            <span class="inner-title">Showing procuring agencies</span>
                                            <select id="select-agency" data-for="contractor" data="{{ $contractor }}">
                                                <option value="amount" selected>Based on value</option>
                                                <option value="count">Based on count</option>
                                            </select>
                                        </label>
                                    </div>
                                </form>
                            </div>

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
                            <a href="#" class="anchor">View all procuring agencies<span>  &rarr; </span></a>
                        </div>
                    </div>
                </div>

                <div class="medium-6 small-12 columns">
                    <div class="each-chart-section">

                        <div class="section-header clearfix" data-equalizer-watch="equal-header">
                            <h3>Top 5 Goods / Services procured</h3>
                        </div>
                        <div class="chart-wrap" data-equalizer-watch="equal-chart-wrap">
                            <div class="filter-section">
                                <form>
                                    <div>
                                        <label>
                                            <span class="inner-title">Showing goods / services</span>
                                            <select id="select-goods" data-for="contractor" data="{{ $contractor }}">
                                                <option value="amount" selected>Based on value</option>
                                                <option value="count">Based on count</option>
                                            </select>
                                        </label>
                                    </div>
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
        <table class="responsive hover custom-table">
            <tbody>
            <tr>
                <th>Contract number</th>
                <th>Goods and services contracted</th>
                <th width="150px">Contract start date</th>
                <th width="150px">Contract end date</th>
                <th>Amount</th>
            </tr>

            @forelse($contractorDetail as $key => $contract)
                @if($key < 10)
                    <tr>
                        <td>{{ $contract['contractNumber'] }}</td>
                        <td>{{ $contract['goods']['mdValue'] }}</td>
                        <td class="dt">{{ $contract['contractDate'] }}</td>
                        <td class="dt">{{ $contract['finalDate'] }}</td>
                        <td>{{ number_format($contract['amount']) }}</td>
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
        var contracts = '{!! $contractTrend  !!}';
        var amountTrend = '{!! $amountTrend !!}';
        var procuringAgencies = '{!! $procuringAgency  !!}';
        var goodsAndServices = '{!! $goodsAndServices  !!}';
        var widthofParent = $('.chart-wrap').width();

        var makeCharts = function () {
            var widthofParent = $('.chart-wrap').width();
            createLineChartRest(JSON.parse(contracts), widthofParent);
            createBarChartContract(JSON.parse(amountTrend), "barChart-amount");
            createBarChartProcuring(JSON.parse(procuringAgencies), "barChart-procuring", "procuring-agency", widthofParent, 'amount');
            createBarChartProcuring(JSON.parse(goodsAndServices), "barChart-goods", "goods", widthofParent, 'amount');
        };

        makeCharts();

        $(window).resize(function () {
            $("#linechart-rest").empty();
            $("#barChart-amount").empty();
            makeCharts();
        });

    </script>
@endsection
