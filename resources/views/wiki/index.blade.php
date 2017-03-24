@extends('app')
@section('content')
	<div class="row wiki-page">
		<div id="wiki"></div>
	</div>
@endsection()
@section('script')
	<script>
		var link = '{{ $link }}';
	</script>
	<script src="{{url('js/vendorMarkdown.js')}}"></script>
	<script src="{{url('js/wiki.js')}}"></script>
@endsection()
