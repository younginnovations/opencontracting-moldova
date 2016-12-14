@extends('app')
@section('content')
    <div class="block header-block header-with-bg">
        <div class="row header-with-icon">
            <h2><span><img src="{{url('images/ic_contractor.svg')}}"/></span>
                {{ $contractor }}
            </h2>
        </div>
    </div>

    <div class="row table-wrapper">
        <div class="section-header clearfix" data-equalizer-watch="equal-header">
            <h3>@lang('contracts.court_cases')</h3>
        </div>
        <table id="linkage-info" class="responsive hover custom-table persist-area">
            <thead>
            <th width="20%">Case type</th>
            <th width="40%">Title</th>
            <th width="40%">Court name</th>
            </thead>
            <tbody>
            @forelse($linkageList as $case)
                <tr>
                    <td>{{ $case['case_type'] }}</td>
                    <td><a class="court-case-link" href="{{  $case['link'] }}">{{ $case['title'] }}</a></td>
                    <td>{{ $case['court_name'] }}</td>
                </tr>
            @empty
                No Data Found
            @endforelse
            </tbody>
        </table>

        <div style="background-color: #d3d3d3;">Disclaimer: These results are based on best match that we could find in
                the {!! ('company' === $type)?'<a href="http://date.gov.md">date.gov.md</a>':'<a href="http://instante.justice.md/">instante.justice.md</a>' !!}
                .</div>
    </div>


@endsection
@section('script')
    <script>
        $("#linkage-info").DataTable({});
    </script>
@endsection