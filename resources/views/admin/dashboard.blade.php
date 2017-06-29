@extends('app')

@section('content')

	<div class="block header-block header-with-bg dashboard">
		<div class="row header-with-icon">
			<h2>
				Dashboard
			</h2>
		</div>
	</div>

	<div class="push-up-block  wide-header row">

		<div class="dashboard-highlight">

			<div class="columns medium-4 small-12">
				<div class="header-description text-center">
					<div class="big-header">

						<span class="spanblock">Last imported on</span>
						<span class="number big-amount">{{$last_imported_days}}</span>
						<span class="spanblock">DAYS AGO</span>
						<span class="spanblock">{{ $last_imported_date }}</span>
					</div>
				</div>
			</div>

			<div class="columns medium-4 small-12">
				<div class="header-description text-center">
					<div class="big-header">

						<span class="spanblock">Countdown to next import</span>
						<span class="number big-amount">{{$next_import_days}}</span>
						<span class="spanblock">DAYS TO GO</span>
						<span class="spanblock">{{$next_import_date}}</span>
					</div>
				</div>
			</div>

			<div class="columns medium-4 small-12">
				<div class="header-description text-center">
					<div class="big-header">
						<span class="spanblock">Number of rows imported</span>
						<span class="number big-amount">{{$total_rows}}</span>
						<span class="spanblock">DATA ROWS</span>
						<span class="spanblock">{{$last_imported_date}}</span>
					</div>
				</div>
			</div>

		</div>

		<div class="clearfix"></div>

		<div class="text-center dashboard-highlight-import">
			{{csrf_field()}}
			<button id="import-data" class="button yellow-btn" @if ($import_running == true)
			disabled
					@endif
			>
				{{$import_running==true?"Importing":"Import data now"}}
			</button>

			<span>See import status <a href="/import-status.txt" target="_blank">here</a></span>


		</div>


		<div class="dashboard-detials clearfix">

			<div class="last-data-import text-center">
				<p>Last company data imported: <a href="{{url('/csv/download')}}">Download CSV</a></p>
				<span>On {{$last_imported_date}}</span>
			</div>

			<div class="row">

				<div class="columns small-6 medium-6">
					<div class="row">
						<div class="excel-upload company-upload">

							<div class="excel-upload-label">
					<span>
						@if($company_import_running)
							Importing company details. See logs <a href="/company-status.txt">here</a>
						@else
							Please upload the company details excel from <a target="_blank" href="http://date.gov
							.md/ckan/ro/dataset/11736-date-din-registrul-de-stat-al-unitatilor-de-drept-privind-intreprinderile-inregistrate-in-repu">here</a>
						@endif
					</span>
							</div>

							<form class="form">

								<div class="file-upload-wrapper {{$company_import_running==true?"importing":""}}"
									 data-text="Select file!">
									<input name="excel" type="file"
										   class="file-upload-field {{$company_import_running==true?"importing":""}}"
										   id="company-upload"
										   {{$company_import_running==true?'disabled':''}}
										   data-url="{{route('dashboard.uploadExcel') }}" value="">
								</div>
								<div id="progress">
                                                                <span class='spanblock last-imported'>
                                                    @if($last_company_import !=null)Last imported on {{$last_company_import}}
																	@elseif($company_import_running == false)
																		No document uploaded till date.
																	@endif
                                                                </span>
									<span class="excel-upload-progress"></span>
									<span class="excel-upload-error"></span>
									<div class="bar" style="width: 0%;"></div>
								</div>
							</form>
						</div>

					</div>

					<div class="row">
						<div class="excel-upload blacklist-upload">

							<div class="excel-upload-label">
						<span>
								Please upload the blacklist excel from <a target="_blank" href="http://etender.gov
								.md/blackList">here</a>
						</span>
							</div>

							<form class="form">

								<div class="file-upload-wrapper" data-text="Select file!">
									<input name="excel" type="file"
										   class="file-upload-field"
										   id="blacklist-upload"
										   data-url="{{route('dashboard.blacklist.uploadExcel')}}" value="">
								</div>
								<div id="progress">
                                                <span class='spanblock last-imported'>
                                                    @if($last_blacklist_import!=null)Last imported on {{$last_blacklist_import}}
													@else
														No document uploaded till date.
													@endif
                                                </span>
									<span class="excel-upload-progress"></span>
									<span class="excel-upload-error"></span>
									<div class="bar" style="width: 0%;"></div>
								</div>
							</form>
						</div>

					</div>
				</div>
				<div class="external-links columns medium-6 small-6">
						<h4 class="external-links-title">Useful links</h4>
						<ul>
							<li><a href="/company-example.xlsx">View company excel example</a></li>
							<li><a href="/blacklist-example.csv">View blacklist csv example</a></li>
							<li><a href="/csv/assessment.csv">View data assessment</a></li>
							<li><a href="/help/troubleshooting">General IT troubleshooting guide</a></li>
						</ul>
				</div>
			</div>

		</div>
	</div>
@endsection
@section('script')
	<script src="{{url('js/vendorFileUpload.js')}}"></script>
	<script type="text/javascript">
        $('#import-data').click(function (e) {
            var csrf = $('input[name="_token"]').val();
            var data = {_token: csrf};
            API.post('{{route('importData.api')}}', data).success(function () {
                $('#import-data').text('Importing');
                $('#import-data').attr('disabled', true);
            });

        });

        $(function () {
            $('#blacklist-upload').fileupload({
                acceptFileTypes: /(\.|\/)(csv)$/i,
                progressall: function (e, data) {
                    var progress = parseInt(data.loaded / data.total * 100, 10);
                    $('.blacklist-upload .excel-upload-label').text("Uploading ");
                    $('.blacklist-upload .excel-upload-progress').text(progress + "%");
                },
                change: function (e, data) {
                    $(this).parent(".file-upload-wrapper").attr("data-text", data.files[0].name);
                },
                fail: function (e, data) {
                    $('.blacklist-upload .excel-upload-error').text('Error in excel validation');
                    $('.blacklist-upload .excel-upload-label').text("");
                    $('.blacklist-upload .excel-upload-progress').text("");
                },
                done: function (e, data) {
                    $('.blacklist-upload .excel-upload-progress').text("");
                    $('.blacklist-upload .excel-upload-error').text("");
                    $('.blacklist-upload .last-imported').text("Last imported on "+(new Date()).toISOString()
                            .slice(0,10));
                    $(this).parent(".file-upload-wrapper").attr("data-text","Select file!");
                    $('.blacklist-upload .excel-upload-label').text("Completed blacklist import");
                    $('#company-upload').addClass('importing');
                    $('#company-upload').attr('disabled', true);

                },
                processfail: function (e, data) {
//					$('#excel-upload-error').text("");
                },
                processalways: function (e, data) {
                    var file = data.files[0];
                    if (file.error) {
                        $('.blacklist-upload .excel-upload-label').text("");
                        $('.blacklist-upload .excel-upload-error').text(file.error);
                    }
                }
            });

            $('#company-upload').fileupload({
                acceptFileTypes: /(\.|\/)(xlsx)$/i,
                progressall: function (e, data) {
                    var progress = parseInt(data.loaded / data.total * 100, 10);
                    $('.company-upload .excel-upload-label').text("Uploading ");
                    $('.company-upload .excel-upload-progress').text(progress + "%");
                },
                change: function (e, data) {
                    $(this).parent(".file-upload-wrapper").attr("data-text", data.files[0].name);
                },
                fail: function (e, data) {
                    $('.company-upload  .excel-upload-error').text('Error in excel validation');
                    $('.company-upload .excel-upload-label').text("");
                    $('.company-upload .excel-upload-progress').text("");
                },
                done: function (e, data) {
                    $('.company-upload .file-upload-wrapper').addClass("importing");
                    $('.company-upload .excel-upload-progress').text("");
                    $('.company-upload .excel-upload-error').text("");
                    $('.company-upload .excel-upload-label').html("Your file is uploaded. See logs <a href='/company-status" +
                        ".txt'>here</a>");
                    $('.company-upload .last-imported').text("");
                    $(this).parent(".file-upload-wrapper").attr("data-text","Select file!");
                    $('#company-upload').addClass('importing');
                    $('#company-upload').attr('disabled', true);

                },
                processfail: function (e, data) {
//					$('#excel-upload-error').text("");
                },
                processalways: function (e, data) {
                    var file = data.files[0];
                    if (file.error) {
                        $('.company-upload .excel-upload-label').text("");
                        $('.company-upload .excel-upload-error').text(file.error);
                    }
                }
            });
        })
	</script>
@endsection
