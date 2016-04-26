@extends('app')

@section('content')
    <div class="block header-block header-with-bg">
        <div class="row header-with-icon">
            <h2> <span><img src="{{url('images/ic_contractor.svg')}}"/></span>
            Contracts</h2>
        </div>
    </div>

    <div class="push-up-block  wide-header row">

        <div class="columns medium-6 small-12">
            <div class="header-description">
                <div class="big-header">
                    <div class="number big-amount"> 8,312 </div>
                    <div class="big-title">Contract issued</div>
                </div>
                <p>
                    Tenders are to invite bids for a project, or to accept a formal offer such as a takeover bid. Tender usually refers to the process whereby governments and financial institutions invite bids for large projects that must be submitted within a finite deadline.
                </p>
            </div>
        </div>

        <div class="columns medium-6 small-12">
            <div class="chart-section-wrap">
                <div class="each-chart-section">
                    <div class="section-header clearfix">
                        <ul class="breadcrumbs right-content">
                            <p><span href="#" class="indicator contracts">Contracts</span> &nbsp; issued over the years</p>
                        </ul>
                    </div>
                    <div class="chart-wrap">
                        <div id="header-linechart"></div>
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

    <div class="row table-wrapper persist-area">
        <table id="table_id" class="responsive hover custom-table display">
            <thead class="persist-header">
            <tr>
                <th class="contract-number">Contract number</th>
                <th class="hide">Contract ID</th>
                <th>Goods and services contracted</th>
                <th width="150px">Contract start date</th>
                <th width="150px">Contract end date</th>
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
        $('#table_id').DataTable({
            "language": {
                'searchPlaceholder': "Search by goods",
                "lengthMenu": "Show _MENU_ Contracts"
            },
            "processing": true,
            "serverSide": true,
            "ajax": '/api/data',
            "ajaxDataProp": '',
            "columns": [
                {'data': 'contractNumber'},
                {'data': 'id', 'className': 'hide'},
                {'data': 'goods.mdValue', "defaultContent": "-"},
                {'data': 'contractDate', 'className': 'dt'},
                {'data': 'finalDate', 'className': 'dt'},
                {'data': 'amount', "className":'numeric-data' }
            ],
            "fnDrawCallback": function () {
                changeDateFormat();
                numericFormat();
                createLinks();
                updateTables();
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
    </script>
    <script src="{{url('js/vendorChart.min.js')}}"></script>
    <script src="{{url('js/customChart.min.js')}}"></script>
    <script>
        var route = '{{ route("filter") }}';
        var trends = '{!! $contractsTrends  !!}';
            var total = 0;
            var newTrends = JSON.parse(trends);
            for(var i = 0; i < newTrends.length; i++){
                total +=newTrends[i].chart2;
            }
            $(".number").html(total);
            var makeCharts = function () {
            var widthOfParent = $('.chart-wrap').width();
            createLineChartONHeader(JSON.parse(trends), widthOfParent, "#50E3C2");
        };

        makeCharts();

        $(window).resize(function () {
            $("#header-linechart").empty();
            makeCharts();
        });

    </script>
@endsection
