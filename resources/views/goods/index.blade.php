@extends('app')

@section('content')
    <div class="block header-block header-with-bg">
        <div class="row header-with-icon">
            <h2><span><img src="{{url('images/ic_good_service.svg')}}"/></span>
            Goods and services</h2>
        </div>
    </div>

    <div class="push-up-block  wide-header row">

        <div class="columns medium-6 small-12">
            <div class="header-description">
                <div class="big-header">
                    <div class="number big-amount">8,132</div>
                    <div class="big-title">Goods / services</div>
                </div>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deserunt fugit maxime nam nesciunt qui quia quo ut velit. Ad blanditiis commodi cupiditate distinctio ducimus inventore perferendis repellat ut vitae? Quam?
                </p>
            </div>
        </div>

        <div class="columns medium-6 small-12">
            <div class="chart-section-wrap">
                <div class="each-chart-section">
                    <div class="section-header clearfix">
                        <form class="left-content">
                            <label>
                                <select id="select-goods">
                                    <option value="amount" selected>Based on value</option>
                                    <option value="count">Based on count</option>
                                </select>
                            </label>
                        </form>
                        <ul class="breadcrumbs right-content">
                            <p>Top 5 &nbsp;<span href="#" class="indicator">goods / services</span>
                            </p>
                        </ul>
                    </div>
                    <div class="disabled-text">Click on label or graph bar to view in detail.</div>
                    <div class="chart-wrap default-view header-chart">
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
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row table-wrapper">
        <a target="_blank" class="export" href="{{route('goods.export')}}">Export as CSV</a>
        <table id="table_id" class="hover responsive custom-table display persist-area">
            <thead class="persist-header">
            <tr>
                <th>Name</th>
                <th>CPV code</th>
                <th>Unit</th>
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
                'searchPlaceholder': "Search by tender title",
                "lengthMenu": "Show _MENU_ Tenders"
            },
            "processing": true,
            "serverSide": true,
            "ajax": '/api/goods',
            "ajaxDataProp": '',
            "pagingType": "full_numbers",
            "columns": [
                {'data': '_id'},
                {'data': 'cpv_value[0]'},
                {'data': 'unit.0'}
            ],
            "fnDrawCallback": function () {
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
                    var goodName = $(this).find("td:first").text();
                    return window.location.assign(window.location.origin + "/goods/" + goodName);
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
        var goodsAndServices = '{!! $goodsAndServices  !!}';
        var total = 0;
        var newGoodsAndServices = JSON.parse(goodsAndServices);

        for(var i = 0; i < newGoodsAndServices.length; i++){
            total +=newGoodsAndServices[i].value;
        }
        $(".number").html(Math.ceil(total).toLocaleString());
        var makeCharts = function () {
            var widthOfParent = $('.chart-wrap').width();
            createBarChartProcuring(JSON.parse(goodsAndServices), "barChart-goods", "goods", widthOfParent, 'amount');
        };

        makeCharts();

        $(window).resize(function () {
            makeCharts();
        });

    </script>
@endsection