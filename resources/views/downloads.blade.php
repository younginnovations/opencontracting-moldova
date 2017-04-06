@extends('app')

@section('content')


	<div class="block header-block header-with-bg downloads">
		<div class="row header-with-icon">
			<h2>
				<span><img src="http://localhost:8000/images/ic_download.svg"/></span>
				Data Downloads
			</h2>
		</div>
	</div>

	<div class="push-up-block  wide-header row">

		<div class="data-downloads clearfix">

			<div class="text-center data-downloads-tag">
				<span>The portal captures data from the year 2012 to 2017 (till latest available from eTenders site). </span>
			</div>


			<div class="columns medium-6 small-12 data-downloads-json">
				<h1>JSON Downloads</h1>

				<div>
					<p>Links to JSON data according to the year can be downloaded from</p>

					<ul>
						<li><a href="http://moldova-demo.yipl.com.np/multiple-file-api/releases.json">Overall Releases</a></li>
						<li><a href="http://moldova-demo.yipl.com.np/ocds-api/year/2012">Releases for year 2012.</a></li>
						<li><a href="http://moldova-demo.yipl.com.np/ocds-api/year/2013">Releases for year 2013.</a></li>
						<li><a href="http://moldova-demo.yipl.com.np/ocds-api/year/2014">Releases for year 2014.</a></li>
						<li><a href="http://moldova-demo.yipl.com.np/ocds-api/year/2015">Releases for year 2015.</a></li>
						<li><a href="http://moldova-demo.yipl.com.np/ocds-api/year/2016">Releases for year 2016.</a></li>
						<li><a href="http://moldova-demo.yipl.com.np/ocds-api/year/2017">Releases for year 2017.</a></li>
					</ul>
				</div>
			</div>

			<div class="columns medium-6 small-12 data-downloads-csv">
				<h1>CSV Downloads</h1>
				<p>Links for CSV for different components of the OCDS (Open Contractng Data Standards)</p>
				<ul>
					<li><a href="http://moldova-demo.yipl.com.np/csv/download">CSV for Contracts</a></li>
					<li><a href="http://moldova-demo.yipl.com.np/csv/download/tenders">CSV for Tenders</a></li>
					<li><a href="http://moldova-demo.yipl.com.np/csv/download/agencies">CSV for Procuring Agencies</a></li>
					<li><a href="http://moldova-demo.yipl.com.np/csv/download/contractors">CSV for Contractors</a></li>
					<li><a href="http://moldova-demo.yipl.com.np/csv/download/goods">CSV for Goods & Services</a></li>
				</ul>
			</div>
		</div>


	</div>
@endsection
