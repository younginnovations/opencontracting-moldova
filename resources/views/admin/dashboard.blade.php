
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

        <div class="dashboard-detials clearfix">

            <div class="last-data-import text-center">
				<p>Last company data imported: <a href="{{url('/csv/download')}}">Download CSV</a> </p>
				<span>On {{$last_imported_date}}</span>
			</div>

            <div class="external-links">
                 <div class="columns medium-6 small-12 external-links-services">
                    <h4 class="external-links-title">Status of services</h4>
                    <ul>
                        <li>
                            <span>MongoDB</span>
                            <span>Running</span>
                        </li>
                       <li>
                            <span>NGINX</span>
                            <span>Running</span>
                        </li>
                    </ul>
                </div>

                <div class="columns medium-6 small-12 external-links-links">
                        <h4 class="external-links-title">Useful links</h4>
                        <ul>
                            <li><a href="">View data assessment</a></li>
                            <li><a href="/help">General IT troubleshooting guide</a></li>
                        </ul>
                </div>
            </div>

        </div>

	</div>
@endsection
