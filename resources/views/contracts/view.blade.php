@extends('app')
@section('content')
    <div class="block header-block header-with-bg">
        <div class="row clearfix">
            <div class="full-header">
                <h2> {{ $contractDetail['title'] }}
                    Servicii de tratament sanatorial
                </h2>
            </div>
            <div>
                <div class="small-button grey-yellow-btn"><span>Status:</span>
                    <span>{{ $contractDetail['status'] }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="push-up-block row">
        <div class="name-value-section each-row clearfix">
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

        <div class="name-value-section each-row clearfix">
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

        <div class="name-value-section each-row clearfix">
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

        <div class="name-value-section each-row clearfix">
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
    <div class="row clearfix">
        <div class="cusotm-switch clearfix">
            <a href="#" class="toggle-switch toggle--on"></a>

            <div class="custom-switch-content block">
                <div class="json-view">
                    <pre id="json-viewer"></pre>
                </div>
                <div class="table-view text-center">
                    <div id="json-table"></div>
                    Table view is not available for now.
                </div>
            </div>
        </div>
    </div>


@endsection

@section('script')
    <script>
        var input = {!! $contractData !!};
        delete input['_id'];
        $('#json-viewer').jsonViewer(input, {collapsed: true});


        var showJsonTable = function () {
            var parent = $("#json-table");

            console.log(parent);
            var table = $('<table>', {
                class: "jTable"
            });

            for (var key in input) {
                if (typeof input[key] === 'string') {
                    table.append('<tr><td>' + key + '</td><td>' + input[key] + '</td></tr>');
                } else {
                    table.append('<tr><td>' + key + '</td></tr>');
                    showArray('<td></td>', table, input[key]);
                }
            }

            parent.append(table);
        }

        var showArray = function (td, table, arr) {
            for (var a in arr) {
                if (typeof arr[a] != 'object') {
                    var tr = '<tr>' + td + '<td>' + a + '</td><td>' + arr[a] + '</td></tr>';
                    table.append(tr);
                } else {
                    table.append('<tr>' + td + '<td>' + a + '</td></tr>');
                    td = td + '<td></td>';
                    showArray(td, table, arr[a]);
                }

            }
        }

        showJsonTable();
    </script>
    <script src="{{url('js/responsive-tables.min.js')}}"></script>
    <script>
        $(document).ready(function(){
            updateTables();
        })
    </script>
@endsection