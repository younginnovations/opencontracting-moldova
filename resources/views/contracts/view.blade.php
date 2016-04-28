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
                         <div class="name  columns">Contract Value</div>
                        <div class="value columns">{{ number_format($contractDetail['value']['amount']) }} leu</div>
                    </span>
            </div>

            <div class="medium-6 small-12 columns each-detail-wrap">
                <span class="icon contract-signed">icon</span>
                    <span class="each-detail">
                         <div class="name  columns">Contract Signed</div>
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
                         <div class="name  columns">Related Tender</div>
                        <div class="value columns">
                            <a href="{{ route('tenders.show',['tender'=>$contractDetail['tender_id']]) }}">{{ $contractDetail['tender_title'] }}</a>
                        </div>
                    </span>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="demo-btns">
            <div class="info">
                <div class="buttons">
                    <p>
                        <a href="" data-modal="#modal" class="modal__trigger">Send a feedback for this contract</a>
                    </p>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div id="modal" class="modal modal__bg" role="dialog" aria-hidden="true">
            <div class="modal__dialog">
                <div class="modal__content">
                    <div class="background">
                        <form class="custom-form">
                            <div class="formBox" style="">
                                {{--<div class="contactTitle"><span class="bold">Contact</span> Us</div>--}}
                                <input type="hidden" id="contract_id" name="id" value="{{$contractDetail['id']}}">
                                <input type="hidden" id="contract_title" name="title"
                                       value="{{$contractDetail['title']}}">

                                <div class="form-group">
                                    <input class="form-control" type="text" id="fullname" name="fullname"
                                           placeholder="YOUR NAME" required>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" type="email" id="email" name="email"
                                           placeholder="YOUR EMAIL" required>
                                </div>
                                <div class="form-group">
                                    <textarea class="form-control" placeholder="YOUR MESSAGE" id="message"
                                              name="message" required></textarea>
                                </div>
                                <div class="g-recaptcha captcha-wrap" id="captcha"
                                     data-sitekey="{{ env('RE_CAP_SITE') }}"></div>
                            </div>
                            <button class="button" id="submit" value="SEND MESSAGE" rows="20">SEND MESSAGE</button>
                        </form>
                    </div>

                    <!-- modal close button -->
                    {{--<a href="" class="modal__close demo-close">--}}
                    {{--<svg class="" viewBox="0 0 24 24"><path d="M19 6.41l-1.41-1.41-5.59 5.59-5.59-5.59-1.41 1.41 5.59 5.59-5.59 5.59 1.41 1.41 5.59-5.59 5.59 5.59 1.41-1.41-5.59-5.59z"/><path d="M0 0h24v24h-24z" fill="none"/></svg>--}}
                    {{--</a>--}}

                </div>
            </div>
        </div>
    </div>

    <div id="ajaxResponse"></div>
    <div class="row clearfix">
        <div class="cusotm-switch clearfix">
            <a href="#" class="toggle-switch toggle--on"></a>

            <div class="custom-switch-content block">
                <div class="json-view">
                    <pre id="json-viewer"></pre>
                </div>
                <div class="table-view text-center">
                    <div id="json-table"></div>
                    {{--Table view is not available for now.--}}
                </div>
            </div>
        </div>
    </div>


@endsection

@section('script')
    <script>
        $(document).ready(function () {
            $('#submit').on('click', function (e) {
                var route = '{{ route('contracts.feedback') }}';
                e.preventDefault();
                var id = $('#contract_id').val();
                var title = $('#contract_title').val();
                var name = $('#fullname').val();
                var email = $('#email').val();
                var message = $('#message').val();
                var g_recaptcha_response = $("#g-recaptcha-response").val();//grecaptcha.getResponse();
                var data = {
                    id: id,
                    title: title,
                    fullname: name,
                    email: email,
                    message: message,
                    'g-recaptcha-response': g_recaptcha_response
                };
                $.ajax({
                    type: "POST",
                    url: route,
                    data: data,
                    success: function (data) {
                        $(".demo-btns").remove();
                        $("#modal").remove();

                        if (data.status == "success") {
                            setInterval(function () {
                                $("#ajaxResponse").addClass('alert success');
                            }, 3000);
                        } else {
                            setInterval(function () {
                                $("#ajaxResponse").addClass('alert error');
                            }, 3000);
                        }

                        $("#ajaxResponse").html(data.msg);
                    }
                });
            });
        });
    </script>
    <script>
        var input = {!! $contractData !!};
        delete input['_id'];
        $('#json-viewer').jsonViewer(input, {collapsed: true});


        var showJsonTable = function () {
            var parent = $("#json-table");

            var table = $('<table>', {
                class: "jTable"
            });

            for (var key in input) {
                if (typeof input[key] === 'string') {
                    table.append('<tr><td class="main-title" colspan="100%">' + key + '</td><td>' + input[key] + '</td></tr>');
                } else {
                    table.append('<tr><td class="main-title" colspan="100%">' + key + '</td></tr>');
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
                    table.append('<tr>' + td + '<td class="sub-title" colspan="100%">' + a + '</td></tr>');
                    td = td + '<td></td>';
                    showArray(td, table, arr[a]);
                }

            }
        }

        showJsonTable();
    </script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <script src="{{url('js/responsive-tables.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            updateTables();
        })
    </script>
@endsection