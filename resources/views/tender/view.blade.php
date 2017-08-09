@extends('app')

@section('content')
	<div class="block header-block header-with-bg">
		<div class="row clearfix">
			<div class="full-header">
				<h2> {{ $tenderDetail['tender']['title'] }}
					@lang('tender.servicii_de_tratament_sanatorial')
				</h2>
			</div>

			<div>
				<button class="small-button grey-yellow-btn"><span>Status:</span>
					<span>{{ $tenderDetail['tender']['status'] }} | Period: <span class="dt">{{
                    $tenderDetail['tender']['tenderPeriod']['startDate']->toDateTime()->format('c') }}</span> - <span
								class="dt">{{
                    $tenderDetail['tender']['tenderPeriod']['endDate']->toDateTime()->format('c') }}</span> </span>
				</button>
			</div>

		</div>
	</div>

	<div class="push-up-block row">
		<div class="description-summary clearfix">

			<div class="name-value-section each-row clearfix">
				<div class="medium-6 small-12 columns each-detail-wrap">
					<span class="icon procuring-agency">icon</span>
					<span class="each-detail">
                         <div class="name columns">@lang('tender.procuring_agency')</div>
                        <div class="value columns">
                            <a href="{{ route('procuring-agency.show',['name'=>$tenderDetail['buyer']['name']]) }}">
                                {{ $tenderDetail['buyer']['name'] }}
                            </a>
                        </div>
                    </span>
				</div>

				<div class="medium-6 small-12 columns each-detail-wrap">
					<span class="icon procurement-method">icon</span>
					<span class="each-detail">
                         <div class="name columns">@lang('tender.procurement_method')</div>
                        <div class="value columns">{{ $tenderDetail['tender']['procurementMethod'] }}</div>
                    </span>
				</div>
			</div>

			<div class="name-value-section each-row clearfix">
				<div class="medium-6 small-12 columns each-detail-wrap end">
					<span class="icon contract-value">icon</span>
					<span class="each-detail">
                         <div class="name columns">@lang('tender.value')</div>
                        <div class="value columns"> N/A </div>
                    </span>
				</div>
				<div class="medium-6 small-12 columns each-detail-wrap end">
					<span class="icon award-criteria">icon</span>
					<span class="each-detail">
                         <div class="name columns">@lang('tender.award_criteria')</div>
                        <div class="value columns">{{ $tenderDetail['tender']['awardCriteria']?$tenderDetail['tender']['awardCriteria']:' N/A '}}</div>
                    </span>
				</div>
			</div>

			<div class="name-value-section each-row clearfix">
				<div class="medium-6 small-12 columns each-detail-wrap end">
					<span class="icon contractor">icon</span>
					<span class="each-detail">
                         <div class="name columns">@lang('tender.contractors')</div>
                        <div class="value columns"> N/A </div>
                    </span>
				</div>
				<div class="medium-6 small-12 columns each-detail-wrap end">
					<span class="icon eligibility-criteria">icon</span>
					<span class="each-detail">
                         <div class="name columns">@lang('tender.eligibility_criteria')</div>
                        <div class="value columns">{{ $tenderDetail['tender']['eligibilityCriteria']?$tenderDetail['tender']['eligibilityCriteria']:' N/A ' }}</div>
                    </span>
				</div>
			</div>
		</div>

	</div>
	<div class="table-with-tab">
		<div class="row">
			<ul class="tabs" data-tabs id="example-tabs">
				<li class="tabs-title is-active">
					<a href="#panel1" aria-selected="true">
						<span>@lang('tender.goods_service_under_this_tender')</span>
						<span class="tab-indicator"> ({{count($tenderDetail['tender']['items'])}})</span>
					</a>
				</li>
				<li class="tabs-title">
					<a href="#panel2">
						<span>@lang('tender.contract_related_to_this_tender')</span>
						<span class="tab-indicator">({{count($tenderDetail['contracts'])}})</span>
					</a>
				</li>
			</ul>
			<div class="tabs-content" data-tabs-content="example-tabs">
				<div class="tabs-panel is-active" id="panel1">
					<div class="table-wrapper">
						<div class="title-section">
                            <span class="title">@lang('tender.goods_service_under_this_tender')
								<span class="tab-indicator"> ({{count($tenderDetail['tender']['items'])}})</span>
                            </span>
						</div>
						<table id="table_items" class="responsive hover custom-table persist-area">
							<thead class="persist-header">
							<tr>
								<th>@lang('general.name')</th>
								<th>@lang('tender.cpv_code')</th>
								<th>@lang('tender.quantity')</th>
								<th>@lang('tender.unit')</th>
							</tr>
							</thead>
							<tbody>
							@forelse($tenderDetail['tender']['items'] as $key => $goods)
								{{--@if($key < 10)--}}
								<tr href="/goods/{{ $goods['classification']['description'] }}">
									<td>{{ $goods['classification']['description'] }}</td>
									<td>{{ $goods['classification']['id'] }}</td>
									<td>{{ $goods['quantity']}}</td>
									<td>{{ $goods['unit']['name'] }}</td>
								</tr>
								{{--@endif--}}
							@empty
							@endforelse


							</tbody>
						</table>
					</div>
				</div>
				<div class="tabs-panel" id="panel2">

					<div class="table-wrapper">
						<div class="title-section">
                            <span class="title">@lang('tender.contract_related_to_this_tender')
								<span class="tab-indicator">({{count($tenderDetail['contracts'])}})</span>
                            </span>
						</div>

						<table id="table_contracts" class="responsive hover custom-table persist-area">
							<thead class="persist-header">
							<tr>
								<th>@lang('general.contract_number')</th>
								<th>@lang('general.goods_and_services_contracted')</th>
								<th width="150px">@lang('general.contract_start_date')</th>
								<th width="150px">@lang('general.contract_end_date')</th>
								<th>@lang('general.amount')(MDL)</th>
							</tr>
							</thead>
							<tbody>
							@forelse($tenderDetail['contracts'] as $key => $contract)
								{{--@if($key < 10)--}}
								<tr href="/contracts/{{$contract['id']}}">
									<td>{{ getContractInfo($tenderDetail['contracts'][$key]['title'],'id') }}</td>
									<td>{{ ($tenderDetail['awards'][$key]['items'])?$tenderDetail['awards'][$key]['items'][0]['classification']['description']:'-' }}</td>
									<td class="dt">{{ (!empty($contract['period']['startDate']))
                                    ?$contract['period']['startDate']->toDateTime()->format('c'):'-' }}</td>
									<td class="dt">{{ $contract['period']['endDate'] }}</td>
									<td class="numeric-data">{{ ($contract['value']['amount']) }}</td>
								</tr>
								{{--@endif--}}
							@empty
							@endforelse


							</tbody>
						</table>
					</div>
				</div>
			</div>

		</div>
	</div>
	@if(sizeof($feedbackData)>0)
		<div class="block colored-block">
			<div class="row clearfix">
				<div class="section-header">Appeal <span class="record-info">(records until May 1, 2016)</span>
					<span id="test-tooltip" data-tooltip aria-haspopup="true" class="has-tip" title="@lang('tender.appeal')">i</span>
				</div>

				<div class="name-value-warp">
					<div class="name">Document date</div>
					<div class="value change-format">{{ ($feedbackData['date_of_document']) }}</div>
				</div>
				<div class="name-value-warp">
					<div class="name">AC-Challenge</div>
					<div class="value">{{ $feedbackData['ac_challenge'] }}</div>
				</div>
				<div class="name-value-warp">
					<div class="name">Issuer</div>
					<div class="value">{{ $feedbackData['issuer'] }}</div>
				</div>
				<div class="name-value-warp">
					<div class="name">Under Appeal</div>
					<div class="value">{{ $feedbackData['under_appeal'] }}</div>
				</div>
				<div class="name-value-warp">
					<div class="name">Procedure no.</div>
					<div class="value">{{ $feedbackData['procedure_no'] }}</div>
				</div>
				<div class="name-value-warp">
					<div class="name">Content Agency Decision</div>
					<div class="value">{{ $feedbackData['content_agency_decision'] }}</div>
				</div>
				<div class="name-value-warp">@lang('tender.for_more_detail') - <a target="_blank" href="http://tender.gov.md/ro/contestatii">http://tender.gov.md/ro/contestatii</a></div>
			</div>
		</div>
	@endif
@endsection
@section('script')
	<script>
        $(document).ready(function () {
            $('.custom-table tbody tr').click(function () {
                if ($(this).attr('href')) {
                    window.location = $(this).attr('href');
                }
                return false;
            });

            var dateFormat = $(".change-format").text().split(".");

            if (dateFormat[1]) {
                dateFormat = dateFormat[2] + '/' + dateFormat[1] + '/' + dateFormat[0];
                var formatted = moment(dateFormat).format('ll');
                $(".change-format").text(formatted);
            }
        });

        $("#table_items").DataTable({"bFilter": false});
        $("#table_contracts").DataTable({"bFilter": false});
	</script>
	<style>
		.custom-table tbody tr {
			cursor: pointer;
		}
	</style>
@endsection
