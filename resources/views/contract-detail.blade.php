@extends('app')
@section('content')
    <div class="block header-block">
        <div class="row">
            <h2> {{ $contractor }}</h2>
        </div>
    </div>

    <div class="block">
        <div class="row medium-up-2 small-up-1">
            <div class="name-value-wrap columns">
                <div class="name">
                    Total contracts
                </div>
                <div class="value">
                    {{ count($contractorDetail) }}
                </div>
            </div>

            <div class="name-value-wrap columns">
                <div class="name">
                    Total contract amount
                </div>
                <div class="value">
                    {{number_format($totalAmount)}} leu
                </div>
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
                        <h3>Top 5 procuring agencies</h3>

                        <div class="top-bar-right right-section">
                            <form>
                                <div class="columns">
                                    <label>
                                        <select>
                                            <option value="husker">Based on value<</option>
                                            <option value="starbuck">Based on count<</option>
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

                <div class="medium-6 small-12 columns each-chart-section">
                    <div class="section-header clearfix" data-equalizer-watch="equal-header">
                        <h3>Top 5 Goods and Services procured</h3>

                        <div class="top-bar-right right-section">
                            <form>
                                <div class="columns">
                                    <label>
                                        <select>
                                            <option value="husker">Based on value<</option>
                                            <option value="starbuck">Based on count<</option>
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
                <th>Contract Number</th>
                <th>Goods</th>
                <th>Contract Date</th>
                <th>Final Date</th>
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
    <script src="{{url('js/customChart.min.js')}}"></script>
    <script>
        var contracts = '{!! $contractTrend  !!}';
        var amountTrend = '{!! $amountTrend !!}';
        var procuringAgencies = '{!! $procuringAgency  !!}';
        var goodsAndServices = '{!! $goodsAndServices  !!}';

        createLineChartRest(JSON.parse(contracts));
        createBarChartContract(JSON.parse(amountTrend), "barChart-amount");
        createBarChartProcuring(JSON.parse(procuringAgencies), "barChart-procuring", "procuring-agency");
        createBarChartProcuring(JSON.parse(goodsAndServices), "barChart-goods", "goods");

        $('.dt').each(function () {
            var dt = $(this).text().split(".");
            dt = dt[1] + '/' + dt[0] + '/' + dt[2];
            var formatted = moment(dt).format('ll');
            $(this).text(formatted);
        });

    </script>
@endsection
