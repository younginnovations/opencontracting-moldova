@extends('app')
@section('content')
    <div class="block header-block">
        <div class="row header-with-icon">
            <span><img src="{{url('images/ic_procuringagency.png')}}"/></span>

            <h2> {{ $procuringAgency }}</h2>
        </div>
    </div>

    <div class="row medium-up-2 small-up-1">
        <div class="block name-value-wrap columns">
            <div class="name">
                Total contracts
            </div>
            <div class="value">
                {{ count($procuringAgencyDetail) }}
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
                <div class="medium-6 small-12 columns each-chart-section">
                    <div class="section-header clearfix" data-equalizer-watch="equal-header">
                        <ul class="breadcrumbs">
                            <li><span href="#" class="indicator tender">Tenders published</span></li>
                            <li><span href="#" class="indicator contracts">Contracts issued</span></li>
                        </ul>
                    </div>
                    <div class="chart-wrap" data-equalizer-watch="equal-chart-wrap">
                        <div id="linechart-homepage"></div>
                    </div>
                </div>
                <div class="medium-6 small-12 columns each-chart-section">
                    <div class="section-header clearfix" data-equalizer-watch="equal-header">
                        <h3>Contract value</h3>
                    </div>
                    <div class="chart-wrap" data-equalizer-watch="equal-chart-wrap">
                        <div id="barChart-amount"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="inner-wrap clearfix" data-equalizer="equal-chart-wrap">
            <div data-equalizer="equal-header">
                <div class="medium-6 small-12 columns each-chart-section">
                    <div class="section-header clearfix" data-equalizer-watch="equal-header">
                        <h3>Top 5 contractors</h3>

                        <div class="top-bar-right right-section">
                            <form>
                                <div>
                                    <label>
                                        <select id="select-contractor" data-for="agency" data="{{ $procuringAgency }}">
                                            <option value="amount" selected>Based on value</option>
                                            <option value="count">Based on count</option>
                                        </select>
                                    </label>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="chart-wrap" data-equalizer-watch="equal-chart-wrap">
                        <div id="barChart-contractors"></div>
                    </div>
                    {{--<button class="button yellow-button hvr-sweep-to-right">test the button</button>--}}
                </div>

                <div class="medium-6 small-12 columns each-chart-section">
                    <div class="section-header clearfix" data-equalizer-watch="equal-header">
                        <h3>Top 5 Goods and Services procured</h3>

                        <div class="top-bar-right right-section">
                            <form>
                                <div>
                                    <label>
                                        <select id="select-goods" data-for="agency" data="{{ $procuringAgency }}">
                                            <option value="amount" selected>Based on value</option>
                                            <option value="count">Based on count</option>
                                        </select>
                                    </label>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="chart-wrap" data-equalizer-watch="equal-chart-wrap">
                        <div id="barChart-goods"></div>
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
    <script src="{{url('js/customChart.min.js')}}"></script>
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
