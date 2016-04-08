@extends('app')
@section('content')
    <div class="block header-block header-with-bg">
        <div class="row clearfix">
            <div class="left-content" id="left-header">
                <h2> {{ $contractDetail['title'] }}
                    Servicii de tratament sanatorial
                </h2>
            </div>

            <div class="right-content" id="status">
                <button class="small-button grey-yellow-btn"><span>status:</span>
                    <span>{{ $contractDetail['status'] }}</span>
                </button>
            </div>
        </div>
    </div>

    <div class="name-value-section each-row clearfix">
        <div class="row">
            <div class="medium-6 small-12 columns each-detail-wrap">
                <span class="icon procuring-agency">icon</span>
                    <span class="each-detail">
                         <div class="name columns">Procuring Agency</div>
                        <div class="value columns">
                            <a href="{{ route('procuring-agency.show',['name'=>$contractDetail['procuringAgency']]) }}">{{ $contractDetail['procuringAgency'] }}</a>
                        </div>
                    </span>
            </div>

            <div class="medium-6 small-12 columns each-detail-wrap">
                <span class="icon contract-period">icon</span>

                <div class="each-detail">
                    <div class="name  columns">Contract Period</div>
                    <div class="value columns dt">{{ $contractDetail['period']['startDate'] }}</div>
                    <div class="value columns dt">{{ ($contractDetail['period']['endDate']) }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="name-value-section each-row clearfix">
        <div class="row">
            <div class="medium-6 small-12 columns each-detail-wrap">
                <span class="icon contract-value">icon</span>
                    <span class="each-detail">
                         <div class="name  columns">Contract value:</div>
                        <div class="value columns">{{ number_format($contractDetail['value']['amount']) }} leu</div>
                    </span>
            </div>

            <div class="medium-6 small-12 columns each-detail-wrap">
                <span class="icon contract-signed">icon</span>
                    <span class="each-detail">
                         <div class="name  columns">Contract Signed:</div>
                        <div class="value columns dt">{{ $contractDetail['dateSigned'] }}</div>
                    </span>
            </div>
        </div>
    </div>

    <div class="name-value-section each-row clearfix">
        <div class="row">
            <div class="medium-6 small-12 columns each-detail-wrap">
                <span class="icon contract-period">icon</span>
                    <span class="each-detail">
                         <div class="name  columns">Contractor</div>
                        <div class="value columns">
                            <a href="{{route('contracts.contractor',['name'=>urlencode($contractDetail['contractor'])]) }}  ">
                                {{ $contractDetail['contractor'] }}
                            </a>
                        </div>
                    </span>
            </div>

            <div class="medium-6 small-12 columns each-detail-wrap">
                <span class="icon contract-goods-service">icon</span>
                    <span class="each-detail">
                         <div class="name  columns">Goods/ Service</div>
                        <div class="value columns">{{ $contractDetail['goods'] }}</div>
                    </span>
            </div>
        </div>
    </div>

    <div class="name-value-section each-row clearfix">
        <div class="row">
            <div class="medium-6 small-12 columns each-detail-wrap end">
                <span class="icon relatedtender">icon</span>
                    <span class="each-detail">
                         <div class="name  columns">RELATED TENDER</div>
                        <div class="value columns">
                            <a href="{{ route('tenders.show',['tender'=>$contractDetail['tender_id']]) }}">{{ $contractDetail['tender_title'] }}</a>
                        </div>
                    </span>
            </div>
        </div>
    </div>

@endsection