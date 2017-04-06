@extends('app')

@section('content')
	<div class="block header-block header-with-bg">
		<div class="row header-with-icon">
			<h2>
				<span><img src="{{url('images/ic_tender.svg')}}"/></span>
				@lang('general.tenders')
				{{--<span class="wiki-link"><a href="https://github.com/egovmd/opencontracting/wiki/Tenders" target="_blank"><img src="{{url('images/ic_link.svg')}}"/></a></span>--}}
			</h2>
		</div>
	</div>

	<div class="push-up-block  wide-header row">

		<div class="columns medium-6 small-12">
			<div class="header-description">
				<div class="big-header">
					<div class="number"></div>
					<div class="big-title">@lang('tender.tenders_published')</div>
				</div>
				<p>
					@lang('tender.tender_paragraph')
				</p>
			</div>
		</div>

		<div class="columns medium-6 small-12">
			<div class="chart-section-wrap">
				<div class="each-chart-section">
					<div class="section-header clearfix">
						<ul class="breadcrumbs">
							<p><span href="#" class="indicator tender">@lang('general.tenders')</span> &nbsp; @lang('tender.published_over_years')
							</p>
						</ul>
					</div>
					<div class="chart-wrap default-view">
						<div id="header-linechart"></div>
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

	<div class="row table-wrapper">
		{{--<a target="_blank" class="export" href="/csv/download/tenders">@lang('general.export_as_csv')</a>--}}
		<table id="table_id" class="responsive hover custom-table display persist-area">
			<thead class="persist-header">
			<tr>
				<th class="tender-id">@lang('tender.tender_id')</th>
				<th>@lang('tender.tender_title')</th>
				<th class="tender-status">@lang('tender.tender_status')</th>
				<th>@lang('tender.procuring_agencies')</th>
				<th>@lang('tender.tender_start_date')</th>
				<th>@lang('tender.tender_end_date')</th>
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
                'searchPlaceholder': "@lang('tender.search_by_tender_title')",
                "lengthMenu": "Show _MENU_ Tenders"
            },
            "processing": true,
            "serverSide": true,
            "ajax": '/api/tenders',
            //"ajaxDataProp": '',
            "columns": [
                {'data': 'tender.id'},
                {'data': 'tender.title'},
                {'data': 'tender.status'},
                {'data': 'tender.procuringEntity.name'},
                {'data': 'tender.tenderPeriod.startDate.$date.$numberLong', 'className': 'dt',
					'render': function (value) {
                        return new Date(Number(value)).toISOString();
                    }
                },
                {'data': 'tender.tenderPeriod.endDate.$date.$numberLong', 'className': 'dt',
                    'render': function (value) {
                        return new Date(Number(value)).toISOString();
                    }
				}
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
	<script src="{{url('js/fixedHeader.min.js')}}"></script>
	<script>
        $(document).ready(function () {
            if ($(window).width() > 768) {
                new $.fn.dataTable.FixedHeader(makeTable);
            }
        });
	</script>

	<script>
        var route = '{{ route("filter") }}';
        var trends = '{!! $tendersTrends  !!}';
        var total = 0;
        var newTrends = JSON.parse(trends);
        for (var i = 0; i < newTrends.length; i++) {
            total += newTrends[i].chart2;
        }
        $(".number").html(total.toLocaleString());
        var makeCharts = function () {
            var widthOfParent = $('.chart-wrap').width();
            createLineChartONHeader(JSON.parse(trends), widthOfParent, "#B8E986");
        };

        makeCharts();

        $(window).resize(function () {
            $("#header-linechart").empty();
            makeCharts();
        });
	</script>
@endsection