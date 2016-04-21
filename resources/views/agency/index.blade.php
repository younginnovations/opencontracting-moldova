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
                    <div class="number big-amount"></div>
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
                    <div class="chart-wrap">
                        <div id="barChart-procuring"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row table-wrapper">
        <table id="table_id" class="hover custom-table display">
            <thead>
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
    <script>
        $('#table_id').DataTable({
            "language": {
                'searchPlaceholder': "Search by procuring agency name",
                "lengthMenu": "Show _MENU_ Procuring agency"
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

    <script>
        var route = '{{ route("filter") }}';
        var procuringAgencies = '{!! $procuringAgency  !!}';
        var total = 0;
        var newProcuringAgencies = JSON.parse(procuringAgencies);
        console.log(newProcuringAgencies);
        for(var i = 0; i < newProcuringAgencies.length; i++){
            total +=newProcuringAgencies[i].value;
        }
        $(".number").html(Math.ceil(total));
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