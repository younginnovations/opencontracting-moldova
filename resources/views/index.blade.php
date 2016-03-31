@extends('app')

@section('content')
    <div class="callout banner-section">
        <div class="row column text-center banner-inner">
            <p class="banner-text">Search through <span class="amount">{{ number_format($totalContractAmount) }} </span>
                Leu
                worth of contracts</p>

            <form class="search-form">
                <input type="search" placeholder="Type a contract name ...">
            </form>
        </div>
    </div>

    <div class="row chart-section-wrap">
        {{-- ----- div for each two chart starts ------- --}}

        <div class="inner-wrap clearfix" data-equalizer="equal-chart-wrap">
            <div data-equalizer="equal-header">

                <div class="medium-6 small-12 columns each-chart-section">
                    <div class="section-header clearfix" data-equalizer-watch="equal-header">
                        <ul class="breadcrumbs">
                            <li><span href="#" class="indicator tender">Tender</span></li>
                            <li><span href="#" class="indicator contracts">Contracts</span></li>
                        </ul>
                    </div>
                    <div class="chart-wrap" data-equalizer-watch="equal-chart-wrap">
                        <div id="linechart-homepage"></div>
                    </div>
                </div>

                <div class="medium-6 small-12 columns each-chart-section">
                    <div class="section-header clearfix" data-equalizer-watch="equal-header">
                        <h3>Top 5 procuring agencies</h3>

                        <div class="top-bar-right right-section">
                            <form>
                                <label>
                                    <select id="select-agency">
                                        <option value="amount">Based on value</option>
                                        <option value="count">Based on count</option>
                                    </select>
                                </label>
                            </form>
                        </div>
                    </div>
                    <div class="chart-wrap" data-equalizer-watch="equal-chart-wrap">
                        <div id="barChart-procuring"></div>
                    </div>
                </div>

            </div>
        </div>
        {{-- ----- div for each two chart ends ------- --}}

        <div class="inner-wrap clearfix" data-equalizer="equal-chart-wrap">
            <div data-equalizer="equal-header">

                <div class="medium-6 small-12 columns each-chart-section">
                    <div class="section-header clearfix" data-equalizer-watch="equal-header">
                        <h3>Top 5 contractors</h3>

                        <div class="top-bar-right right-section">
                            <form>
                                <label>
                                    <select id="select-contractor">
                                        <option value="amount">Based on value</option>
                                        <option value="count">Based on count</option>
                                    </select>
                                </label>
                            </form>
                        </div>
                    </div>

                    <div class="chart-wrap" data-equalizer-watch="equal-chart-wrap">
                        <div id="barChart-contractors"></div>
                    </div>
                </div>

                <div class="medium-6 small-12 columns each-chart-section">
                    <div class="section-header clearfix" data-equalizer-watch="equal-header">
                        <h3>Top 5 goods & services procured</h3>

                        <div class="top-bar-right right-section">
                            <form>
                                <label>
                                    <select id="select-goods">
                                        <option value="amount">Based on value</option>
                                        <option value="count">Based on count</option>
                                    </select>
                                </label>
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
        <table id="table_id" class="hover custom-table display">
        <thead>
            <tr>
                <th>Contract Number</th>
                <th>Goods</th>
                <th>Contract Date</th>
                <th>Final Date</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            </tbody>
        </table>
    </div>
@endsection

@section('script')
    <script type="text/javascript" class="init">
    $('#table_id').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": '/api/data',
        "ajaxDataProp": '',
        "columns": [
            { 'data': 'contractNumber'},
            { 'data': 'goods.mdValue'},
            { 'data': 'contractDate', 'className': 'dt'},
            { 'data': 'finalDate', 'className': 'dt'},
            { 'data': 'amount'}
        ],
        "fnDrawCallback": function() {
            changeDateFormat();
        }
        });

    </script>
    <script src="{{url('js/vendorChart.min.js')}}"></script>
    <script src="{{url('js/customChart.min.js')}}"></script>
    <script>

        var route ='{{ route("filter") }}';
        var trends = '{!! $trends  !!}';
        var procuringAgencies = '{!! $procuringAgency  !!}';
        var contractors = '{!! $contractors  !!}';
        var goodsAndServices = '{!! $goodsAndServices  !!}';

        createLineChart(JSON.parse(trends));
        createBarChartProcuring(JSON.parse(procuringAgencies), "barChart-procuring", "procuring-agency");
        createBarChartProcuring(JSON.parse(contractors), "barChart-contractors", "contractor");
        createBarChartProcuring(JSON.parse(goodsAndServices), "barChart-goods", "goods");

    </script>
@endsection
