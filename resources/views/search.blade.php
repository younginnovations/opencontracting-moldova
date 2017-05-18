@extends('app')

@section('content')
	{{--<div class="buffer-top">
		<div class="block-with-margin filter-wrap">
			<div class="row">
				<div class="filter-inner clearfix">
					<form class="search-wrap" action="{{ route('search') }}" method="get">
						<div class="search-wrap">
							<input type="search" name="q" class="" placeholder="Search">
						</div>
					</form>
					<span class="filter-toggler">
                        <a class="show-filter">@lang('general.advance-filter')</a>
                    </span>
				</div>
				<form action="{{ route('search') }}" method="get" class="custom-form advance-search-wrap">
					<div class="form-inner clearfix">
						<div class="form-group medium-4 columns end">
							<select name="contractor" class="cs-select2 cs-skin-elastic">
								<option value="" disabled selected>@lang('general.select_a_contractor')</option>
								@forelse($contractTitles as $contractTitle)
									<option value="{{ $contractTitle['_id'][0] }}">{{ $contractTitle['_id'][0] }}</option>
								@empty
								@endforelse
							</select>
						</div>
						<div class="form-group medium-4 columns end">
							<select name="agency" class="cs-select2 cs-skin-elastic">
								<option value="" disabled selected>@lang('general.select_a_buyer')</option>
								@forelse($procuringAgencies as $procuringAgency)
									<option value="{{ $procuringAgency->toArray()[0] }}">{{ $procuringAgency->toArray()[0] }}</option>
								@empty
								@endforelse
							</select>
						</div>
						<div class="form-group medium-4 columns end">
							<select name="amount" class="cs-select2 cs-skin-elastic">
								<option value="" disabled selected>@lang('general.select_a_range')</option>
								<option value="0-10000">0-10000</option>
								<option value="10000-100000">10000-100000</option>
								<option value="100000-200000">100000-200000</option>
								<option value="200000-500000">200000-500000</option>
								<option value="500000-1000000">500000-1000000</option>
								<option value="1000000-Above">1000000-@lang('general.above')</option>
							</select>
						</div>

						<div class="form-group medium-4 columns end">
							<select name="startDate" class="cs-select2 cs-skin-elastic">
								@foreach(range(date('Y'), date('Y')-100) as $year)
									<option value="" disabled selected>@lang('general.select_a_year')</option>
									<option value="{{$year}}">{{$year}}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group medium-4 columns end">
							<select name="endDate" class="cs-select2 cs-skin-elastic">
								@foreach(range(date('Y'), date('Y')-100) as $year)
									<option value="" disabled selected>@lang('general.select_a_year')</option>
									<option value="{{$year}}">{{$year}}</option>
								@endforeach
							</select>
						</div>
					</div>

					<div class="input-group-button medium-12 clearfix">
						<div class="medium-4 columns">
							<input type="submit" class="button yellow-button" value="Submit">
						</div>
						<div class="medium-4 columns end">
							<div class="button cancel-btn">@lang('general.cancel')</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>--}}
	@if(!empty($params))
		<div class="block-with-margin">
			<div class="row">
				<div class="search-result-wrap block">
					<div class="title">@lang('search.showing_search_result_for'):</div>
					<div class="search-token">
						{!! (!empty($params['q']))?'<span>'.$params['q'].'</span>':'' !!}
						{!! (!empty($params['contractor'])) ?'<span>Contractor :  '.$params['contractor'].' </span>': ''!!}
						{!! (!empty($params['agency'])) ? '<span>Procuring Agency : '.$params['agency'].' </span>': '' !!}
						{!! (!empty($params['amount'])) ?'<span>Amount :  '.$params['amount'].' </span>' : '' !!}
						{!! (!empty($params['startDate'])) ?'<span>Start Date :  '.$params['startDate'].' </span>' : '' !!}
						{!! (!empty($params['endDate'])) ?'<span>End Date :  '.$params['endDate'].' </span>' : '' !!}
						{!! (!empty($params['goods'])) ?'<span>Goods/Services:  '.$params['goods'].' </span>' : '' !!}
					</div>
					{{--<div class="button-group clearfix">--}}
						{{--<div class="button btn cancel-btn">@lang('general.cancel')</div>--}}
						{{--<div class="button btn reset-btn">@lang('search.reset')</div>--}}
					</div>
				</div>
			</div>
		</div>
	@endif
	{{--@if(sizeof($contracts)==0)--}}
	{{--<div class="block-with-margin">--}}
	{{--<div class="row">--}}
	{{--<div class="search-result-wrap block">--}}
	{{--<div class="negative-result">@lang('search.no_results_found')</div>--}}
	{{--</div>--}}
	{{--</div>--}}
	{{--</div>--}}
	{{--@else--}}

	<div class="row table-wrapper persist-area">
		<a target="_blank" class="export hide" href="{{route('home.searchExport',$params)}}">@lang('general
		.export_as_csv')</a>
		<table id="table_id" class="responsive hover custom-table display">
			<thead class="persist-header">
			<tr>
				<th class="contract-number">@lang('general.contract_number')</th>
				<th class="hide">@lang('general.contract_id')</th>
				<th>@lang('general.goods_and_services_contracted')</th>
				<th>@lang('general.contract_status')</th>
				<th width="150px">@lang('general.contract_start_date')</th>
				<th width="150px">@lang('general.contract_end_date')</th>
				<th>@lang('general.amount')</th>
			</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
	</div>
	{{--@endif--}}

@endsection

@section('script')
	<script src="{{url('js/responsive-tables.min.js')}}"></script>
	<script src="{{url('js/foundation-datepicker.js')}}"></script>
	<link href="{{url('css/foundation-datepicker.css')}}" rel="stylesheet"/>
	<link href="//cdnjs.cloudflare.com/ajax/libs/foundicons/3.0.0/foundation-icons.css" rel="stylesheet">
	<link href="//netdna.bootstrapcdn.com/font-awesome/3.0.2/css/font-awesome.css" rel="stylesheet">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/css/select2.min.css" rel="stylesheet"/>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/js/select2.min.js"></script>
	<script type="text/javascript">
        $(document).ready(function () {
            $(".cs-select2").select2();
        });
	</script>
	<script>
        $(function () {
            $('#dpMonths').fdatepicker();
            $('#dpMonth').fdatepicker();
        });
	</script>
	<script>
        $(document).ready(function () {
            $(".custom-form").submit(function () {
                if ($("input[name='startDate']").val() == "") {
                    $("input[name='startDate']").remove();
                }
                if ($("input[name='endDate']").val() == "") {
                    $("input[name='endDate']").remove();
                }
            });
        });
	</script>
	<script>

		var params = {!! json_encode($params) !!};

        var createLinks = function () {
            $('#table_id tbody tr').each(function () {
                $(this).css('cursor', 'pointer');
                $(this).click(function () {
                    var contractId = $(this).find("td:nth-child(2)").text();
                    return window.location.assign(window.location.origin + "/contracts/" + contractId);
                });

            });
        };

        var makeTable = $("#table_id").DataTable({
            "language": {
                "lengthMenu": ""
            },
            "bFilter": false,
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: '/api/search',
				data: function (d) {
					return $.extend(d, params);
                }
            },
            "columns": [
                {"data": 'contractNumber'},
                {"data": 'id', className: 'hide'},
                {"render": function (data,type, row) {
                    return row.goods || '-';
                }},
                {"data": 'status'},
                {"render": function (data, type, row) {
					console.log(row.contractDate);
					return new Date(Number(row.contractDate.$date.$numberLong)).toDateString();
                }},
                {"render": function (data, type, row) {
                    return new Date(Number(row.finalDate.$date.$numberLong)).toDateString();
                }},
                {"data": 'amount'}
			],
            "fnDrawCallback": function () {
                changeDateFormat();
                createLinks();
                updateTables();
                if ($('#table_id tr').length < 10 && $('a.current').text() === "1") {
                    $('.dataTables_paginate').hide();
                } else {
                    $('.dataTables_paginate').show();
                }
            }
        });

        createLinks();
	</script>
	<script src="{{url('js/fixedHeader.min.js')}}"></script>
	<script>
        $(document).ready(function () {
            if ($(window).width() > 768) {
                new $.fn.dataTable.FixedHeader(makeTable);
            }

//            $(window).resize(function () {
//                new $.fn.dataTable.FixedHeader(makeTable);
//            });

           /* $('.cancel').each(function () {
                $(this).click(
                    function (e) {
                        e.preventDefault(); // prevent the default action
                        e.stopPropagation(); // stop the click from bubbling
                        $(this).parent().addClass('hide');
                    });

            });*/

        });
	</script>
@endsection
