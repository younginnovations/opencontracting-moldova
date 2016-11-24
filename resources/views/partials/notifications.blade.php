@if (Session::has('success'))
	<div class="alert success alert-box callout" data-closable>
		<strong>Success</strong>
		- {{Session::get('success')}}
		<button class="close-button" aria-label="Dismiss alert" type="button" data-close>
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
@endif

@if (Session::has('error'))
	<div class="alert error alert-box callout" data-closable>
		<strong>Error</strong>
		- {{Session::get('error')}}
		<button class="close-button" aria-label="Dismiss alert" type="button" data-close>
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
@endif
