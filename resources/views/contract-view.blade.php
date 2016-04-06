@extends('app')
@section('content')
    <div class="block header-block header-with-bg">
        <div class="row clearfix">
            <div class="left-content">
                <h2> {{ $contractDetail['title'] }}
                    Servicii de tratament sanatorial
                </h2>
            </div>

            <div class="right-content">
                <button class="small-button grey-yellow-btn"><span>status:</span>
                        <span>{{ $contractDetail['status'] }}</span>
                </button>
            </div>

        </div>
    </div>

    <div class="row">
        <div class="description-summary clearfix">
            <div class="name-value-section  medium-4 small-12 columns">
            <span class="icon procuring-agency">icon</span>
            <span class="each-detail">
                 <div class="name columns">Procuring Agency</div>
                <div class="value columns">Departamentul dotări</div>
            </span>
        </div>
        <div class="name-value-section  medium-4 small-12 columns">
            <span class="icon tender-period">icon</span>
            <span class="each-detail">
                 <div class="name columns">Procuring Agency</div>
                <div class="value columns">Departamentul dotări</div>
            </span>
        </div>
        <div class="name-value-section  medium-4 small-12 columns">
            <span class="icon procurement-method">icon</span>
            <span class="each-detail">
                 <div class="name columns">Procuring Agency</div>
                <div class="value columns">Departamentul dotări</div>
            </span>
        </div>
        </div>
    </div>

    <div class="row">
        <div class="name-value-section medium-6 small-12 columns">
            <span class="icon procuring-agency">icon</span>
            <span class="each-detail">
                 <div class="name columns">Procuring Agency</div>
                <div class="value columns">Departamentul dotări</div>
            </span>
        </div>


        <div class="name-value-section medium-6 small-12 columns">
            <span class="icon contract-period">icon</span>
            <div class="each-detail">
                 <div class="name  columns">Contract Period</div>
                <div class="value columns">{{ $contractDetail['period']['startDate'] }}</div>
                <div class="value columns">{{ ($contractDetail['period']['endDate']) }}</div>
            </div>
        </div>

        <div class="name-value-section medium-6 small-12 columns">
            <span class="icon contract-value">icon</span>
            <span class="each-detail">
                 <div class="name  columns">Contract value: </div>
                <div class="value columns">{{ number_format($contractDetail['value']) }} leu</div>
            </span>
        </div>

        <div class="name-value-section medium-6 small-12 columns">
            <span class="icon contract-signed">icon</span>
            <span class="each-detail">
                 <div class="name  columns">Contract Signed:</div>
                <div class="value columns">{{ $contractDetail['dateSigned'] }}</div>
            </span>
        </div>

        <div class="name-value-section medium-6 small-12 columns">
            <span class="icon contract-period">icon</span>
            <span class="each-detail">
                 <div class="name  columns">Procuring Agency</div>
                <div class="value columns">Departamentul dotări</div>
            </span>
        </div>

        <div class="name-value-section medium-6 small-12 columns">
            <span class="icon relatedtender">icon</span>
            <span class="each-detail">
                 <div class="name  columns">Procuring Agency</div>
                <div class="value columns">Departamentul dotări</div>
            </span>
        </div>



    </div>

@endsection