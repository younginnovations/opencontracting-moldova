@extends('app')

@section('content')
<div class="row wiki-page">

<div id="wiki">



<h1>Data Download</h1>

<div class="json-download">
<h1>JSON Downloads</h1>
<p>In the portal JSON can be downloaded filtered by year. The portal captures data from the year 2012 to 2017 (till latest available from eTenders site). </p>

<div class="json-download-item">
<p>Links to all the JSON data across the year can be downloaded from</p>
<ul>
<li><a href="http://localhost:8000/multiple-file-api/releases.json">Overall Releases</a></li>
</ul>

</div>

<div class="json-download-item">
<p>Links to JSON data according to the year can be downloaded from</p>

<ul>
<li><a href="http://moldova-demo.yipl.com.np/ocds-api/year/2012">Releases for year 2012.</a></li>
<li><a href="http://moldova-demo.yipl.com.np/ocds-api/year/2013">Releases for year 2013.</a></li>
<li><a href="http://moldova-demo.yipl.com.np/ocds-api/year/2014">Releases for year 2014.</a></li>
<li><a href="http://moldova-demo.yipl.com.np/ocds-api/year/2015">Releases for year 2015.</a></li>
<li><a href="http://moldova-demo.yipl.com.np/ocds-api/year/2016">Releases for year 2016.</a></li>
<li><a href="http://moldova-demo.yipl.com.np/ocds-api/year/2017">Releases for year 2017.</a></li>
</ul>
</div>


</div>

<div class="csv-download-section">
<h1>CSV Downloads</h1>
<p>In the portal, CSV's are available for different components of the OCDS (Open Contractng Data Standards). CSV'S for Contracts, Tenders, Procuring Agencies, Contractors and Goods &
Services are available.</p>
<p>Links for CSV</p>
<li><a href="http://moldova-demo.yipl.com.np/csv/download">CSV for Contracts</a></li>
<li><a href="http://moldova-demo.yipl.com.np/csv/download/tenders">CSV for Tenders</a></li>
<li><a href="http://moldova-demo.yipl.com.np/csv/download/agencies">CSV for Procuring Agencies</a></li>
<li><a href="http://moldova-demo.yipl.com.np/csv/download/contractors">CSV for Contractors</a></li>
<li><a href="http://moldova-demo.yipl.com.np/csv/download/goods">CSV for Goods & Services</a></li>
</div>
</div>
</div>

@endsection