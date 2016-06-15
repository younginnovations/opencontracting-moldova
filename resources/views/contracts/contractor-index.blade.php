@extends('app')

@section('content')
    <div class="block header-block header-with-bg">
        <div class="row header-with-icon">
            <h2><span><img src="{{url('images/ic_contractor.svg')}}"/></span>

                @lang('contracts.contractors')</h2>
        </div>
    </div>

    <div class="push-up-block  wide-header row">

        <div class="columns medium-6 small-12">
            <div class="header-description">
                <div class="big-header">
 <div class="number big-amount">{!! count($contractors)  !!}</div>
                    <div class="big-title">@lang('general.contractors')</div>
                </div>
                <p>
                    @lang('contracts.contractor_index_paragraph')
                </p>
            </div>
        </div>

        <div class="columns medium-6 small-12">
            <div class="chart-section-wrap">
                <div class="each-chart-section">
                    <div class="section-header clearfix">
                        <form class="left-content">
                            <label>
                                <select id="select-contractor-year">
                                    @include('selectYear')
                                </select>
                                <select id="select-contractor">
                                    <option value="amount" selected>@lang('general.based_on_value')</option>
                                    <option value="count">@lang('general.based_on_count')</option>
                                </select>
                            </label>
                        </form>
                        <ul class="breadcrumbs right-content">
                            <p>@lang('general.top_5') &nbsp;<span href="#" class="indicator">@lang('contracts.contractors')</span>
                            </p>
                        </ul>
                    </div>
                    <div class="disabled-text">@lang('general.click_on_label_or_graph')</div>
                    <div class="chart-wrap default-view header-chart">
                        <div id="barChart-contractors"></div>
                        <div class="loader-text">
                            <div class="text">@lang('general.fetching_data')
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

    <div class="row table-wrapper ">
        <a target="_blank" class="export" href="/csv/download/contractors">@lang('general.export_as_csv')</a>
        <table id="table_id" class="responsive hover custom-table display persist-area">
            <thead class="persist-header">
            <tr>
                <th>@lang('general.name')</th>
                <th>@lang('general.tenders')</th>
                <th>@lang('general.scheme')</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
@endsection
@section('script')
    <script type="text/javascript" class="init">
        var makeTable = $('#table_id').DataTable({
            "language": {
                'searchPlaceholder': "@lang('contracts.search_by_contractors')",
                "lengthMenu": "Show _MENU_ Contractors"
            },
            "processing": true,
            "serverSide": true,
            "ajax": '/api/contactorData',
            "ajaxDataProp": '',
            "columns": [
                {'data': '_id'},
                {'data': 'count'},
                {'data': 'scheme'},
            ],
            "fnDrawCallback": function () {
                changeDateFormat();
                numericFormat();
                createLinks();
            }
        });

        var createLinks = function () {

            $('#table_id tbody tr').each(function () {
                $(this).css('cursor', 'pointer');
                $(this).click(function () {
                    var contractId = $(this).find("td:first").text();
                    return window.location.assign(window.location.origin + "/contracts/contractor/" + contractId);
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

    <script src="{{url('js/vendorChart.min.js')}}"></script>
    <script src="{{url('js/customChart.min.js')}}"></script>

    <script>
        var route = '{{ route("filter") }}';
        var contractors = '{!! $contractorsTrends  !!}';

        var makeCharts = function () {
            var widthOfParent = $('.chart-wrap').width();
            createBarChartProcuring(JSON.parse(contractors), "barChart-contractors", "contracts/contractor", widthOfParent, 'amount');
        };

        makeCharts();

        $(window).resize(function () {
            $("#linechart-homepage").empty();
            makeCharts();
        });

    </script>
@endsection
