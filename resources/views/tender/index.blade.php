@extends('app')

@section('content')
    <div class="block header-block header-with-bg">
        <div class="row header-with-icon">
            <h2><span><img src="{{url('images/ic_tender.svg')}}"/></span>
                Tenders</h2>
        </div>
    </div>

    <div class="push-up-block  wide-header row">

        <div class="columns medium-6 small-12">
            <div class="header-description">
                <div class="big-header">
                    <div class="number"></div>
                    <div class="big-title">Tenders published</div>
                </div>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Animi aspernatur, consequatur culpa dicta
                    dolorem dolores harum laboriosam, nam obcaecati odio possimus provident reprehenderit tempore.
                    Architecto atque consectetur delectus facere iure.
                </p>
            </div>
        </div>

        <div class="columns medium-6 small-12">
            <div class="chart-section-wrap">
                <div class="each-chart-section">
                    <div class="section-header clearfix">
                        <ul class="breadcrumbs">
                            <p><span href="#" class="indicator tender">Tenders</span> &nbsp; published over the years
                            </p>
                        </ul>
                    </div>
                    <div class="chart-wrap default-view">
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

    <div class="row table-wrapper">
        <a target="_blank" class="export" href="{{route('tender.export')}}">Export as CSV</a>
        <table id="table_id" class="responsive hover custom-table display persist-area">
            <thead class="persist-header">
            <tr>
                <th class="tender-id">Tender ID</th>
                <th>Tender Title</th>
                <th class="tender-status">Tender Status</th>
                <th>Procuring Agency</th>
                <th>Tender start date</th>
                <th>Tender end date</th>
            </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
@endsection
@section('script')
    <script src="{{url('js/vendorChart.min.js')}}"></script>
    <script src="{{url('js/responsive-tables.min.js')}}"></script>
    <script src="{{url('js/customChart.min.js')}}"></script>
    <script>
        $('#table_id').DataTable({
            "language": {
                'searchPlaceholder': "Search by tender title",
                "lengthMenu": "Show _MENU_ Tenders"
            },
            "processing": true,
            "serverSide": true,
            "ajax": '/api/tenders',
            "ajaxDataProp": '',
            "pagingType": "full_numbers",
            "columns": [
                {'data': 'tender.id'},
                {'data': 'tender.title'},
                {'data': 'tender.status'},
                {'data': 'tender.procuringAgency.name'},
                {'data': 'tender.tenderPeriod.startDate', 'className': 'dt'},
                {'data': 'tender.tenderPeriod.endDate', 'className': 'dt'},
            ],
            "fnDrawCallback": function () {
                changeDateFormat();
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
                    var tenderId = $(this).find("td:first").text();
                    return window.location.assign(window.location.origin + "/tenders/" + tenderId);
                });

            });
        };

    </script>

    <script>
        var route = '{{ route("filter") }}';
        var trends = '{!! $tendersTrends  !!}';
        var total = 0;
        var newTrends = JSON.parse(trends);
        for(var i = 0; i < newTrends.length; i++){
            total +=newTrends[i].chart2;
        }
        $(".number").html(total.toLocaleString());
        var makeCharts = function () {
            var widthOfParent = $('.chart-wrap').width();
            createLineChartONHeader(JSON.parse(trends), widthOfParent,"#B8E986");
        };

        makeCharts();

        $(window).resize(function () {
            $("#header-linechart").empty();
            makeCharts();
        });
    </script>
@endsection