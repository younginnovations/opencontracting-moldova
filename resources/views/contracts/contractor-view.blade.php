@extends('app')
@section('content')
	<div class="block header-block header-with-bg {{ ((isset($companyData) && sizeof($companyData)>0) || $blacklist || sizeof($courtCases)>0 )?'':'block-header--small' }}">
		<div class="row header-with-icon">
			<h2><span><img src="{{url('images/ic_contractor.svg')}}"/></span>
				{{ $contractor }}
			</h2>
		</div>

	</div>
	@if((isset($companyData) && sizeof($companyData)>0) || $blacklist || sizeof($courtCases)>0 )
		<div class="row medium-up-2 small-up-1 push-up-block small-push-up-block">
			<div class="block name-value-wrap">
				<div class="name">
					@if(isset($companyData) && sizeof($companyData)>0)
						<div class="title">
							<span class="info-icon"></span>
							<span class="value">{{ $companyData['name'] }}</span>
							<span class="name">@lang('contracts.leaders'): {{ $companyData['director'][0]}}</span>|
							<span class="name">@lang('contracts.founders')
								:{{ ($companyData['founders'])?listFounders($companyData['founders']):'N/A' }} </span>
							<span class="name">(@lang('contracts.as_found_on') <a
										href="http://date.gov.md">date.gov.md</a>)</span>
						</div>

					@else
						No matching company informations were found.
					@endif
				</div>
				<div class="name">
					@if($blacklist)
						<span class="flag-icon-red court-text">@lang('contracts.this_contractor_is_blacklisted') <span class="name">@lang('tender.for_more_detail') <a
										href="http://tender.gov.md/ro/lista-de-interdictie" target="_blank">http://tender.gov.md/ro/lista-de-interdictie</a></span></span> |
					@endif
					@if(sizeof($courtCases)>0)
						<span class="balance-icon">{{sizeof($courtCases)." "}}<span class="court-text"> @lang('contracts.court_cases_found').</span>
                    <span class="court-case-dropdown court-text"><a href="#">@lang('contracts.view_court_cases')</a></span>
                </span>
					@endif
				</div>
				<div class="court-case-list">
                <span class="balance-icon">@lang('contracts.result_based_on_match') <a
							href="http://instante.justice.md">instante.justice.md</a>.</span>
					@forelse($courtCases as $case)
						<ul>
							<li>
                                <span class="title spanblock">{{ $case['title'] }}</span>
								<span class="name-value-wrap">
                                <span class="name">Case type:{{ $case['caseType'] }}</span>
                            </span>

								<span class="name-value-wrap">
                                <span class="name">Court:{{ $case['court'] }} </span>
                            </span>
							</li>
						</ul>
					@empty
						No matching court informations were found.
					@endforelse
				</div>
			</div>
		</div>
	@endif
	<div class="row chart-section-wrap">

		<div class="inner-wrap clearfix" data-equalizer="equal-chart-wrap">
			<div data-equalizer="equal-header">
				<div class="medium-6 small-12 columns">
					<div class="each-chart-section">
						<div class="section-header clearfix" data-equalizer-watch="equal-header">
							<h2 class="section-header-number">
								{{ $totalContract }}
							</h2>

							<h3 class="section-header-title">@lang('contracts.number_of_contracts')</h3>
						</div>
						<div class="chart-wrap default-view" data-equalizer-watch="equal-chart-wrap">
							<div id="linechart-rest"></div>
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

				<div class="medium-6 small-12 columns">
					<div class="each-chart-section">
						<div class="section-header clearfix" data-equalizer-watch="equal-header">
							<h2 class="section-header-number">
								{{($totalAmount)}} MDL
							</h2>

							<h3 class="section-header-title">@lang('contracts.contract_value')</h3>
						</div>
						<div class="chart-wrap default-view default-barChart"
							 data-equalizer-watch="equal-chart-wrap">
							<div id="barChart-amount"></div>
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
		<div class="inner-wrap clearfix" data-equalizer="equal-chart-wrap">
			<div data-equalizer="equal-header">
				<div class="medium-6 small-12 columns">
					<div class="each-chart-section">

						<div class="section-header clearfix" data-equalizer-watch="equal-header">
							<span class="icon procuring-agency">icon</span>
							<h3>@lang('general.top_5_procuring_agencies')</h3>
						</div>
						<div class="chart-wrap default-view default-barChart"
							 data-equalizer-watch="equal-chart-wrap">
							<div class="filter-section">
								<form>
									<div>
										<label>-
											<span class="inner-title">@lang('general.showing_procuring_agencies')</span>
											{{--<select id="select-agency-year">--}}
												{{--@include('selectYear')--}}
											{{--</select>--}}
											<input type="hidden" id="select-year-agency">
											<select id="select-agency" data-for="contractor"
													data="{{ $contractor }}">
												<option value="amount"
														selected>@lang('general.based_on_value')</option>
												<option value="count">@lang('general.based_on_count')</option>
											</select>
											{{--<div><input type="text" id="procuring-agency-range" value=""/></div>--}}
										</label>
									</div>
								</form>
								<div id="procuring-agency-slider"></div>
							</div>
							<div class="disabled-text">@lang('general.click_on_label_or_graph')</div>
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
							<a href="{{ route('procuring-agency.index') }}"
							   class="anchor">@lang('general.view_all_procuring_agencies')<span>  &rarr; </span></a>
						</div>
					</div>
				</div>

				<div class="medium-6 small-12 columns">
					<div class="each-chart-section">

						<div class="section-header clearfix" data-equalizer-watch="equal-header">
							<span class="icon goods-service">icon</span>
							<h3>@lang('general.top_5_goods_&_services_procured')</h3>
						</div>
						<div class="chart-wrap default-view default-barChart"
							 data-equalizer-watch="equal-chart-wrap">
							<div class="filter-section">
								<form>
									<div>
										<label>
											<span class="inner-title">@lang('general.showing_goods_and_services')</span>
											{{--<select id="select-goods-year">--}}
												{{--@include('selectYear')--}}
											{{--</select>--}}
											<input type="hidden" id="select-year-goods">
											<select id="select-goods" data-for="contractor"
													data="{{ $contractor }}">
												<option value="amount"
														selected>@lang('general.based_on_value')</option>
												<option value="count">@lang('general.based_on_count')</option>
											</select>
											{{--<div><input type="text" id="goods-range" value=""/></div>--}}
										</label>
									</div>
								</form>
								<div id="goods-slider"></div>
							</div>
							<div class="disabled-text">@lang('general.click_on_label_or_graph')</div>
							<div id="barChart-goods"></div>
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
							<a href="{{ route('goods.index') }}"
							   class="anchor">@lang('general.view_all_goods_services')
								<span>  &rarr; </span></a>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
	<div class="row table-wrapper">
		{{--<a target="_blank" class="export"--}}
		   {{--href="{{route('contractorDetail.export',['name'=>$contractor])}}">@lang('general.export_as_csv')</a>--}}
		<table id="table_id" class="data_table responsive hover custom-table persist-area">

			<thead class="persist-header">
			<th>@lang('general.contract_number')</th>
			<th class="hide">@lang('general.contract_id')</th>
			<th>@lang('general.goods_and_services_contracted')</th>
			<th>@lang('contracts.contract_status')</th>
			<th width="150px">@lang('general.contract_start_date')</th>
			<th width="150px">@lang('general.contract_end_date')</th>
			<th>@lang('general.amount')</th>
			</thead>
			<tbody>

			@forelse($contractorDetail as $key => $contract)
				<tr>
					<td>{{ $contract['contractNumber'] }}</td>
					<td class="hide">{{ (int) $contract['id'] }}</td>
					<td>{{ (!empty($contract['goods']['mdValue']))?$contract['goods']['mdValue']:'-' }}</td>
					<td>{{ $contract['status']['mdValue'] }}</td>
					<td class="dt">{{ $contract['contractDate']->toDateTime()->format('Y-m-d') }}</td>
					<td class="dt">{{ $contract['finalDate']->toDateTime()->format('Y-m-d') }}</td>
					<td>{{ ($contract['amount']) }}</td>
				</tr>

			@empty
			@endforelse

			</tbody>
		</table>
	</div>
@stop
@section('script')
	<script src="{{url('js/vendorChart.min.js')}}"></script>
	<script src="{{url('js/responsive-tables.min.js')}}"></script>
	<script src="{{url('js/customChart.min.js')}}"></script>
	<script>
        $(document).ready(function () {
            updateTables();
        })
	</script>
	<script src="{{url('js/responsive-tables.min.js')}}"></script>
	<script>

        var createLinks = function () {

            $('#table_id').find('tbody tr').each(function () {
                $(this).css('cursor', 'pointer');
                $(this).click(function () {
                    var contractId = $(this).find("td:nth-child(2)").text();
                    return window.location.assign(window.location.origin + "/contracts/" + contractId);
                });

            });
        };

        var makeTable = $(".data_table").DataTable({
            "bFilter": false,
            "fnDrawCallback": function () {
                changeDateFormat();
                createLinks();
                if ($('#table_id').find('tr').length < 10 && $('a.current').text() === "1") {
                    $('.dataTables_paginate').hide();
                } else {
                    $('.dataTables_paginate').show();
                }
            }
        });

        createLinks();
	</script>
	<script src="{{url('js/fixedHeader.min.js')}}"></script>
	<script src="{{url('js/customChart.js')}}"></script>
	<script>
        $(document).ready(function () {
            if ($(window).width() > 768) {
//                new $.fn.dataTable.FixedHeader(makeTable);
            }
        });
	</script>
	<script>
        var route = '{{ route("filter") }}';
        var contracts = '{!! $contractTrend  !!}';
        var amountTrend = '{!! $amountTrend !!}';
        var procuringAgencies = '{!! $procuringAgency  !!}';
        var goodsAndServices = '{!! $goodsAndServices  !!}';
        var widthofParent = $('.chart-wrap').width();

        var makeCharts = function () {
            var widthofParent = $('.chart-wrap').width();
            createLineChartRest(JSON.parse(contracts), widthofParent);
			createSlider(route, 'agency', widthOfParent, "barChart-procuring", "procuring-agency",
				"#procuring-agency-slider");
			createSlider(route, 'goods', widthOfParent, "barChart-goods", "goods","#goods-slider");

			createBarChartContract(JSON.parse(amountTrend), "barChart-amount");
            createBarChartProcuring(JSON.parse(procuringAgencies), "barChart-procuring","procuring-agency", widthofParent, 'amount');
            createBarChartProcuring(JSON.parse(goodsAndServices), "barChart-goods", "goods", widthofParent, 'amount');
        };

        makeCharts();

        $(window).resize(function () {
            $("#linechart-rest").empty();
            $("#barChart-amount").empty();
			$('#procuring-agency-slider').empty();
			$('#goods-slider').empty();
			makeCharts();
        });

        var show = "@lang('contracts.view_court_cases')";
        var hide = "@lang('contracts.hide_court_cases')";

        $(".court-case-dropdown").click(function () {
            $(this).toggleClass('court-case-upArrow');
            var text = $(this).text();
            $(this).find('a').html((text == hide) ? show : hide);
            $(".court-case-list").slideToggle();
        });

	</script>
@endsection
