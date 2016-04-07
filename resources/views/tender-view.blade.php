@extends('app')

@section('content')
    <div class="block header-block header-with-bg">
        <div class="row clearfix">
            <div class="left-content" id = "left-header">
                <h2> {{ $tenderDetail['tender']['title'] }}
                    Servicii de tratament sanatorial
                </h2>
            </div>

            <div class="right-content" id="status">
                <button class="small-button grey-yellow-btn"><span>status:</span>
                    <span>{{ $tenderDetail['tender']['status'] }}</span>
                </button>
            </div>

        </div>
    </div>

    <div class="description-summary clearfix">
        <div class="row">
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
                <div class="value columns"><span class="dt">{{ $tenderDetail['tender']['tenderPeriod']['startDate'] }}</span>
                    - <span class="dt">{{ $tenderDetail['tender']['tenderPeriod']['endDate'] }}</span></div>
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
    <div class="table-with-tab">
        <div class="row">
            <ul class="tabs" data-tabs id="example-tabs">
                <li class="tabs-title is-active">
                    <a href="#panel1" aria-selected="true">
                        <span class="tab-indicator">7</span>
                        <span>Goods/ Services under this tender</span>
                    </a>
                </li>
                <li class="tabs-title">
                    <a href="#panel2">
                        <span class="tab-indicator">20</span>
                        <span>Contracts related to this tender</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="tabs-content" data-tabs-content="example-tabs">
            <div class="tabs-panel is-active" id="panel1">
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
            </div>
            <div class="tabs-panel" id="panel2">
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
            </div>
        </div>
    </div>


@endsection
