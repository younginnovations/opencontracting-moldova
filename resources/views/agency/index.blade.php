@extends('app')

@section('content')
    <div class="block header-block header-with-bg">
        <div class="row header-with-icon">
            <h2>  <span><img src="{{url('images/ic_agency.svg')}}"/></span>
           Procuring Agencies</h2>
        </div>
    </div>

    <div class="push-up-block  wide-header row">

        <div class="columns medium-6 small-12">
            <div class="header-description">
                <div class="big-header">
                    <div class="number big-amount">{{ $totalAgency }}</div>
                    <div class="big-title">Agencies</div>
                </div>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Animi aspernatur, consequatur culpa dicta dolorem dolores harum laboriosam, nam obcaecati odio possimus provident reprehenderit tempore. Architecto atque consectetur delectus facere iure.
                </p>
            </div>
        </div>

        <div class="columns medium-6 small-12">
            <div class="chart-section-wrap">
                <div class="each-chart-section">
                    <div class="section-header clearfix">
                        <form class="left-content">
                            <label>
                                <select id="select-agency">
                                    <option value="amount" selected>Based on value</option>
                                    <option value="count">Based on count</option>
                                </select>
                            </label>
                        </form>
                        <ul class="breadcrumbs right-content">
                            <p>Top 5 &nbsp;<span href="#" class="indicator">agencies</span>
                            </p>
                        </ul>
                    </div>
                    <div class="disabled-text">Click on label or graph bar to view in detail.</div>
                    <div class="chart-wrap default-view header-chart">
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
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row table-wrapper persist-area">
        <a target="_blank" class="export" href="{{route('agency.export')}}">Export as CSV</a>
        <table id="table_id" class="hover responsive custom-table display">
            <thead class="persist-header">
                <tr>
                    <th>Procuring Agency Title</th>
                    <th>Tenders</th>
                    <th>Contracts</th>
                    <th>Contract value</th>
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
        var makeTable = $('#table_id').DataTable({
            "language": {
                'searchPlaceholder': "Search by procuring agency name",
                "lengthMenu": "Show _MENU_ agency"
            },
            "processing": true,
            "serverSide": true,
            "ajax": '/api/procuring-agency',
            "ajaxDataProp": '',
            "columns": [
                {'data': 'buyer'},
                {'data': 'tender'},
                {'data': 'contract'},
                {'data': 'contract_value', "className": 'numeric-data'}
            ],
            "fnDrawCallback": function () {
                createLinks();
                if ($('#table_id tr').length < 11) {
                    $('.dataTables_paginate').hide();
                } else {
                    $('.dataTables_paginate').show();
                }
                updateTables();
            }
        });

        var createLinks = function () {

            $('#table_id tbody tr').each(function () {
                $(this).css('cursor', 'pointer');
                $(this).click(function () {
                    var agencyId = $(this).find("td:first").text();
                    return window.location.assign(window.location.origin + "/procuring-agency/" + agencyId);
                });

            });
        };

    </script>
    <script src="{{url('js/fixedHeader.min.js')}}"></script>
    <script>
        $(document).ready(function() {
            if($(window).width() > 768){
                new $.fn.dataTable.FixedHeader( makeTable );
            }
        });
    </script>

    <script>
        var route = '{{ route("filter") }}';
        var procuringAgencies = '{!! $procuringAgency  !!}';
        var total = 0;
//        var newProcuringAgencies = JSON.parse(procuringAgencies);
//        console.log(newProcuringAgencies);
//        for(var i = 0; i < newProcuringAgencies.length; i++){
//            total +=newProcuringAgencies[i].value;
//        }
//        $(".number").html(Math.ceil(total));
        var makeCharts = function () {
            var widthOfParent = $('.chart-wrap').width();
            createBarChartProcuring(JSON.parse(procuringAgencies), "barChart-procuring", "procuring-agency", widthOfParent, 'amount');

        };

        makeCharts();

        $(window).resize(function () {
            makeCharts();
        });

    </script>
@endsection