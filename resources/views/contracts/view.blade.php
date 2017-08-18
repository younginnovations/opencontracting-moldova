	@extends('app')
@section('content')
	<div class="block header-block header-with-bg">
		<div class="row clearfix">
			<div class="full-header">
				<h2> {{ $contractDetail['title'] }}
					@lang('contracts.servicii_de_tratament_sanatorial')
				</h2>
			</div>
			<div>
				<div class="small-button grey-yellow-btn"><span>@lang('contracts.status'):</span>
					<span>{{ $contractDetail['status'] }}</span>
				</div>
			</div>
		</div>
	</div>

	<div class="push-up-block row">
		<div class="name-value-section each-row clearfix">
			<div class="medium-6 small-12 columns each-detail-wrap">
				<span class="icon procuring-agency">icon</span>
				<span class="each-detail">
                         <div class="name columns">@lang('contracts.procuring_agency')</div>
                        <div class="value columns">
                            <a href="{{ route('procuring-agency.show',['name'=>$contractDetail['procuringAgency']]) }}">{{ $contractDetail['procuringAgency'] }}</a>
                        </div>
                    </span>
			</div>

			<div class="medium-6 small-12 columns each-detail-wrap">
				<span class="icon contract-period">icon</span>
				<div class="each-detail">
					<div class="name  columns">@lang('contracts.contract_period')</div>
					<div class="value columns dt">{{ $contractDetail['period']['startDate']->toDateTime()->format('c')}}</div>
					<div class="value columns dt">{{ ($contractDetail['period']['endDate']) }}</div>
				</div>
			</div>
		</div>

		<div class="name-value-section each-row clearfix">
			<div class="medium-6 small-12 columns each-detail-wrap">
				<span class="icon contract-value">icon</span>
				<span class="each-detail">
                         <div class="name  columns">@lang('contracts.contract_value')</div>
                        <div class="value columns">{{ number_format($contractDetail['value']['amount']) }} MDL</div>
                    </span>
			</div>

			<div class="medium-6 small-12 columns each-detail-wrap">
				<span class="icon contract-signed">icon</span>
				<span class="each-detail">
                         <div class="name  columns">@lang('contracts.contract_signed')</div>
                        <div class="value columns dt">{{ $contractDetail['dateSigned']->toDateTime()->format('c') }}</div>
                    </span>
			</div>
		</div>

		<div class="name-value-section each-row clearfix">
			<div class="medium-6 small-12 columns each-detail-wrap">
				<span class="icon contractor">icon</span>
				<span class="each-detail">
                         <div class="name  columns">@lang('general.contractor')</div>
                        <div class="value columns">
                            <a href="{{route('contracts.contractor',['name'=>urlencode($contractDetail['contractor'])]) }}  ">
                                {{ $contractDetail['contractor'] }}
                            </a>
                        </div>
                    </span>
			</div>

			<div class="medium-6 small-12 columns each-detail-wrap">
				<span class="icon contract-goods-service">icon</span>
				<span class="each-detail">
                         <div class="name  columns">@lang('contracts.goods_services')</div>
                        <div class="value columns">
                             <a href="{{route('goods',['name'=>urlencode($contractDetail['goods'])]) }}  ">
                            {{ $contractDetail['goods'] }}
                             </a>
						</div>
                    </span>
				</span>
			</div>
		</div>

		<div class="name-value-section each-row clearfix">
			<div class="medium-6 small-12 columns each-detail-wrap end">
				<span class="icon relatedtender">icon</span>
				<span class="each-detail">
                         <div class="name  columns">@lang('contracts.related_tender')</div>
                        <div class="value columns">
                            <a href="{{ route('tenders.show',['tender'=>$contractDetail['tender_id']]) }}">{{ $contractDetail['tender_title'] }}</a>
                        </div>
                    </span>
			</div>
		</div>
	</div>


	<div class="row">
		<!-- Trigger/Open The Modal -->
		<button id="myBtn" class="button blue-button"
				style="width: auto;">@lang('contracts.send_a_feedback_for_this_contract')</button>
		<!-- The Modal -->
		<div id="myModal" class="modal">

			<!-- Modal content -->
			<div class="modal-content">
				<span class="close">×</span>

				<div class="modal__content">
					<div class="background">
						<form class="custom-form">
							<div class="formBox" style="">
								<div id="ajaxResponse"></div>
								{{--<div class="contactTitle"><span class="bold">Contact</span> Us</div>--}}
								<input type="hidden" id="contract_id" name="id" value="{{$contractDetail['id']}}">
								<input type="hidden" id="contract_title" name="title"
									   value="{{$contractDetail['title']}}">
								{{ csrf_field() }}

								<div class="form-group">
									<input class="form-control" type="text" id="fullname" name="fullname"
										   placeholder="@lang('general.your_name')" required>
								</div>
								<div class="form-group">
									<input class="form-control" type="email" id="email" name="feedback-email"
										   placeholder="@lang('general.your_email')" required>
								</div>
								<div class="form-group">
                                <textarea class="form-control" placeholder="@lang('general.your_message')" id="message"
										  name="message" required></textarea>
								</div>
								<div class="g-recaptcha captcha-wrap" id="captcha"
									 data-sitekey="{{ env('RE_CAP_SITE') }}"></div>
							</div>
							<button class="button" id="submit" value="SEND MESSAGE"
									rows="20">@lang('general.send_message')</button>
						</form>
					</div>

				</div>
			</div>

		</div>
	</div>

	<div class="custom-switch-wrap row">
		<div class="clearfix">
			<div class="small-title">@lang('contracts.contract_data_in_ocds_format')</div>
			<a href="#" class="toggle-switch toggle--on"></a>
		</div>

		<div class="custom-switch-content block">
			<div class="json-view">
				<button name="expand" class="expand-btn button yellow-btn">@lang('contracts.expand_all')</button>
				<button name="collapse" class="collapse-btn button yellow-btn">@lang('contracts.collapse_all')</button>
				<a target="_blank" href="{{ route('contracts.jsonView',['id'=>$contractDetail['id']]) }}"
				   class="btn-view-json">@lang('contracts.raw_json')</a>

				<pre id="json-viewer"></pre>
			</div>
			<div class="table-view text-center">
				<div id="json-table"></div>
				{{--Table view is not available for now.--}}
			</div>
		</div>
	</div>
	<div class="row">
		@include('laravelLikeComment.like', ['like_item_id' => $contractDetail['id']])
		@include('laravelLikeComment.comment', ['comment_item_id' => $contractDetail['id']])
	</div>

@endsection

@section('script')
	<script>
        var route = '{{ route('contracts.feedback') }}';
        var contractData = {!! $contractData !!};
        var contractId = {!! $contractDetail['id'] !!};
        var input = contractData;
        delete input['_id'];
        var validateName = "@lang('general.please_enter_your_name')";
        var validateEmail = "@lang('general.enter_valid_email')";
        var validateMessage = "@lang('general.enter_your_message')";
        var successMessage = "@lang('general.email_sent_successfully')";
	</script>
	<link rel="stylesheet" href="https://rawgithub.com/yesmeck/jquery-jsonview/master/dist/jquery.jsonview.css"/>
	<script type="text/javascript" src="https://rawgithub.com/yesmeck/jquery-jsonview/master/dist/jquery.jsonview.js"></script>
	<script src='https://www.google.com/recaptcha/api.js'></script>
	<script src="{{url('js/responsive-tables.min.js')}}"></script>
	<script src="{{url('js/contracts.js')}}"></script>
@endsection
