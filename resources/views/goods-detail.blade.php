@extends('app')
@section('content')
    <div class="block header-block">
        <div class="row header-with-icon">
            <span><img src="{{url('images/ic_goods.png')}}"/></span>

            <h2> {{ $goods }}</h2>
        </div>
    </div>

    <div class="row medium-up-2 small-up-1">
        <div class="block name-value-wrap columns">
            <div class="name">
                Total contracts
            </div>
            <div class="value">
                {{ count($goodsDetail) }}
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
                        <h3>No. of contracts</h3>
                    </div>
                    <div class="chart-wrap" data-equalizer-watch="equal-chart-wrap">
                        <div id="linechart-rest"></div>
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
                                        <select id="select-contractor" data-for="goods" data="{{ $goods }}">
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
                </div>

                <div class="medium-6 small-12 columns each-chart-section">
                    <div class="section-header clearfix" data-equalizer-watch="equal-header">
                        <h3>Top 5 procuring agency</h3>

                        <div class="top-bar-right right-section">
                            <form>
                                <div>
                                    <label>
                                        <select id="select-agency" data-for="goods" data="{{ $goods }}">
                                            <option value="amount" selected>Based on value</option>
                                            <option value="count">Based on count</option>
                                        </select>
                                    </label>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="chart-wrap" data-equalizer-watch="equal-chart-wrap">
                        <div id="barChart-procuring"></div>
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
                <th>Contractor</th>
                <th width="150px">Contract start date</th>
                <th width="150px">Final end date</th>
                <th>Amount</th>
            </tr>

            @forelse($goodsDetail as $key => $goods)
                @if($key < 10)
                    <tr>
                        <td>{{ $goods['contractNumber'] }}</td>
                        <td>{{ $goods['participant']['fullName'] }}</td>
                        <td class="dt">{{ $goods['contractDate'] }}</td>
                        <td class="dt">{{ $goods['finalDate'] }}</td>
                        <td>{{ number_format($goods['amount']) }}</td>
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
        var contracts = '{!! $contractTrend  !!}';
        var amountTrend = '{!! $amountTrend !!}';
        var contractors = '{!! $contractors  !!}';
        var procuringAgency = '{!! $procuringAgency  !!}';

        var makeCharts = function () {
            var widthofParent = $('.chart-wrap').width();
            createLineChartRest(JSON.parse(contracts), widthofParent);
            createBarChartContract(JSON.parse(amountTrend), "barChart-amount");
            createBarChartProcuring(JSON.parse(contractors), "barChart-contractors", "contracts/contractor", widthofParent, 'amount');
            createBarChartProcuring(JSON.parse(procuringAgency), "barChart-procuring", "goods", widthofParent, 'amount');
        };

        makeCharts();

        $(window).resize(function () {
            $("#linechart-rest").empty();
            $("#barChart-amount").empty();
            makeCharts();
        });

    </script>
@endsection
