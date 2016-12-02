@if (Session::has('success'))
	<div class="alert success alert-box callout">
		<span class="check icon"></span>
		<strong>Success</strong>
		{{Session::get('success')}}
		<button class="close-button" aria-label="Dismiss alert" type="button" >
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
@endif

@if (Session::has('error'))
	<div class="alert error alert-box callout">
		<span class="error icon"></span>
		<strong>Error</strong>
		{{Session::get('error')}}
		<button class="close-button" aria-label="Dismiss alert" type="button">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
@endif
