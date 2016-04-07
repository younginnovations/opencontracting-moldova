@extends('app')

@section('content')
    <div class="block header-block header-with-bg">
        <div class="row clearfix">
            <div class="left-content">
                <h2> {{ $tenderDetail['tender']['title'] }}
                    Servicii de tratament sanatorial
                </h2>
            </div>

            <div class="right-content">
                <button class="small-button grey-yellow-btn"><span>status:</span>
                    <span>{{ $tenderDetail['tender']['status'] }}</span>
                </button>
            </div>

        </div>
    </div>

    <div class="row">
        <div class="description-summary clearfix">
            <div class="name-value-section  medium-4 small-12 columns">
                <span class="icon procuring-agency">icon</span>
            <span class="each-detail">
                 <div class="name columns">PROCURING AGENCY</div>
                <div class="value columns">
                    <a href="{{ route('procuring-agency',['name'=>$tenderDetail['buyer']['name']]) }}">
                        {{ $tenderDetail['buyer']['name'] }}
                    </a>
                </div>
            </span>
            </div>
            <div class="name-value-section  medium-4 small-12 columns">
                <span class="icon tender-period">icon</span>
            <span class="each-detail">
                 <div class="name columns">TENDER PERIOD</div>
                <div class="value columns"><i class="dt">{{ $tenderDetail['tender']['tenderPeriod']['startDate'] }}</i>
                    - <i class="dt">{{ $tenderDetail['tender']['tenderPeriod']['endDate'] }}</i></div>
            </span>
            </div>
            <div class="name-value-section  medium-4 small-12 columns">
                <span class="icon procurement-method">icon</span>
            <span class="each-detail">
                 <div class="name columns">PROCUREMENT METHOD</div>
                <div class="value columns">{{ $tenderDetail['tender']['procuringAgency']['identifier']['scheme'] }}</div>
            </span>
            </div>
        </div>
    </div>

    <div class="row table-wrapper">
        <table class="responsive hover custom-table">
            <tbody>
            <tr>
                <th>Contract number</th>
                <th>Goods and services contracted</th>
                <th width="150px">Contract start date</th>
                <th width="150px">Contract end date</th>
                <th>Amount</th>
            </tr>

            @forelse($tenderDetail['contract'] as $key => $contract)
                @if($key < 10)
                    <tr>
                        <td>{{ $contract['id'] }}</td>
                        <td>{{ $tenderDetail['award'][$key]['title'] }}</td>
                        <td class="dt">{{ (!empty($contract['period']['startDate']))?$contract['period']['startDate']:'-' }}</td>
                        <td class="dt">{{ $contract['period']['endDate'] }}</td>
                        <td>{{ number_format($contract['value']) }}</td>
                    </tr>
                @endif
            @empty
            @endforelse


            </tbody>
        </table>
    </div>

@endsection
