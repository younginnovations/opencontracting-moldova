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
        @if('company' === $type)
            <div class="section-header clearfix" data-equalizer-watch="equal-header">
                <h3>@lang('contracts.company_information')</h3>
            </div>
            <table id="linkage-info" class="responsive hover custom-table persist-area">
                <thead>
                <th width="40%">Company name</th>
                <th width="10%">Leaders</th>
                <th width="40%">Founders</th>
                <th width="10%">Search Weight</th>
                </thead>
                <tbody>
                @forelse($linkageList as $company)
                    <tr>
                        <td>{{ $company['full_name'] }}</td>
                        <td>{{ $company['leaders_list'] }}</td>
                        <td>{{ $company['list_of_founders'] }}</td>
                        <td>{{ number_format($company['score'],2) }}</td>
                    </tr>
                @empty
                    No Data Found
                @endforelse
                </tbody>
            </table>
        @else
            <div class="section-header clearfix" data-equalizer-watch="equal-header">
                <h3>@lang('contracts.court_cases')</h3>
            </div>
            <table id="linkage-info" class="responsive hover custom-table persist-area">
                <thead>
                <th width="40%">Case type</th>
                <th width="10%">Title</th>
                <th width="40%">Court name</th>
                <th width="10%">Search Weight</th>
                </thead>
                <tbody>
                @forelse($linkageList as $case)
                    <tr>
                        <td>{{ $case['case_type'] }}</td>
                        <td><a href="{{  $case['link'] }}">{{ $case['title'] }}</a></td>
                        <td>{{ $case['court_name'] }}</td>
                        <td>{{ number_format($case['score'],2) }}</td>
                    </tr>
                @empty
                    No Data Found
                @endforelse
                </tbody>
            </table>
        @endif
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