@extends('app')

@section('content')
	<div class="block header-block header-with-bg">
		<div class="row header-with-icon">
			<h2>
				<span><img src="{{url('images/ic_agency.svg')}}"/></span>
				@lang('agency.procuring_agencies')
				<span class="wiki-link"><a href="/help/agencies"><img src="{{url('images/ic_link.svg')}}"/></a></span>

			</h2>
		</div>
	</div>

	<div class="push-up-block  wide-header row">

		<div class="columns medium-6 small-12">
			<div class="header-description">
				<div class="big-header">
					<div class="number big-amount">{{ $totalAgency }}</div>
					<div class="big-title">@lang('general.agencies')</div>
				</div>
				<p>
					@lang('agency.agency_paragraph')
				</p>
			</div>
		</div>

		<div class="columns medium-6 small-12">
			<div class="chart-section-wrap">
				<div class="each-chart-section">
					<div class="section-header section-header-services clearfix">
						<form>
							<label>
								{{--<select id="select-agency-year">--}}
									{{--@include('selectYear')--}}
								{{--</select>--}}
								{{--<ul class="breadcrumbs right-content">--}}
									{{--<p>@lang('general.top_5') &nbsp;<span href="#" class="indicator">@lang('agency.agencies')</span>--}}
									{{--</p>--}}
								{{--</ul>--}}
								<p class="inner-title"><span>@lang('general.top_5') </span> <span class="indicator">@lang('agency.agencies')</span></p>


								<input type="hidden" id="select-year-agency">
								<select id="select-agency">
									<option value="amount" selected>@lang('general.based_on_value')</option>
									<option value="count">@lang('general.based_on_count')</option>
								</select>
								{{--<div><input type="text" id="procuring-agency-range" value=""/></div>--}}
							</label>
						</form>
						<div id="procuring-agency-slider"></div>
					</div>
					<div class="disabled-text">@lang('general.click_on_label_or_graph')</div>
					<div class="chart-wrap default-view header-chart">
						<div id="barChart-procuring"></div>
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

	<div class="row table-wrapper persist-area">
		{{--<a target="_blank" class="export" href="/csv/download/agencies">@lang('general.export_as_csv')</a>--}}
		<table id="table_id" class="hover responsive custom-table display">
			<thead class="persist-header">
			<tr>
				<th>@lang('agency.procuring_agency_title')</th>
				<th>@lang('general.tenders')</th>
				<th>@lang('general.contracts')</th>
				<th>@lang('general.contract_value') (MDL)</th>
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
                'searchPlaceholder': "@lang('agency.search_by_procuring_agency_name')",
                "lengthMenu": "Show _MENU_ agency"
            },
            "processing": true,
            "serverSide": true,
            "ajax": '/api/procuring-agency',
//            "ajaxDataProp": '',
            "columns": [
                {'data': '_id'},
                {'data': 'tenders'},
                {'data': 'contracts_count'},
                {'data': 'contract_value', "className": 'numeric-data'}
            ],
            "fnDrawCallback": function () {
                numericFormat()
                createLinks();
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
	<script src="{{url('js/customChart.js')}}"></script>
	<script>
        $(document).ready(function () {
            if ($(window).width() > 768) {
                new $.fn.dataTable.FixedHeader(makeTable);
            }
        });
	</script>

	<script>
        var route = '{{ route("filter") }}';
        var procuringAgencies = '{!! $procuringAgency  !!}';
        var makeCharts = function () {
            var widthOfParent = $('.chart-wrap').width() - 12;
			createSlider(route, 'agency', widthOfParent, "barChart-procuring", "procuring-agency","#procuring-agency-slider");
			createBarChartProcuring(JSON.parse(procuringAgencies), "barChart-procuring", "procuring-agency", widthOfParent, 'amount');

		};

        makeCharts();

        $(window).resize(function () {
			$("#procuring-agency-slider").empty();
			makeCharts();
        });

	</script>
@endsection