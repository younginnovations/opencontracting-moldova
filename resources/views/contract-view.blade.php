@extends('app')
@section('content')
    <div class="block header-block">
        <div class="row">
            <h2> {{ $contractDetail['title'] }}</h2>
        </div>
    </div>

    <div>
        <span>Status: </span>
        <span>{{ $contractDetail['status'] }}</span>
    </div>

    <div>
        <span>Contract Signed: </span>
        <span>{{ $contractDetail['dateSigned'] }}</span>
    </div>

    <div>
        <span>Value: </span>
        <span>{{ number_format($contractDetail['value']) }}</span>
    </div>

    <div>
        <span>Period:</span>

        <div>
            <span>Start Date: </span>
            <span>{{ $contractDetail['period']['startDate'] }}</span>
            {{--<span>{{ ($contractDetail['period']['endDate']) }}</span>--}}
        </div>

        <div>
            <span>End Date: </span>
            <span class="dt">{{ $contractDetail['period']['endDate'] }}</span>
        </div>

    </div>

@endsection