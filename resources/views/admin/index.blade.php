@extends('app')

@section('content')
	<div class="block header-block header-with-bg block-header--small">
		<div class="row header-with-icon">
			<h2>@lang('general.contracts_with_comments')</h2>
		</div>
	</div>

	<div class="row table-wrapper ">
		<table class="responsive hover custom-table display persist-area">
			<tbody>
			@forelse($contractsWithComments as $comments)
				<tr>
					<td class="admin-contract-list"><a href="{{ url('contracts', $comments['id']) }}">{{
					$comments['title'] }}</a></td>
				</tr>
			@empty
				No comments found.
			@endforelse
			</tbody>
		</table>
	</div>


@endsection
