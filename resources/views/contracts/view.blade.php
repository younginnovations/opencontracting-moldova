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
        <!-- Trigger/Open The Modal -->
        <button id= "myBtn" class="button blue-button" style="width: auto;">Send a feedback for this contract</button>
        <!-- The Modal -->
        <div id="myModal" class="modal">

            <!-- Modal content -->
            <div class="modal-content">
                <span class="close">×</span>
                <div class="modal__content">
                    <div class="background">
                        <form class="custom-form">
                            <div class="formBox" style="">
                                <div id="ajaxResponse"></div>
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

                </div>
            </div>

        </div>
    </div>

    <div class="custom-switch-wrap row">
        <div class="clearfix">
            <div class="small-title">Contract data in ocds format</div>
            <a href="#" class="toggle-switch toggle--on"></a>
        </div>

        <div class="custom-switch-content block">
            <button name="expand" onclick="expand()">expand</button>
            <button name="collapse" onclick="collapse()">collapse</button>
            <div class="json-view">
                <pre id="json-viewer"></pre>
            </div>
            <div class="table-view text-center">
                <div id="json-table"></div>
                {{--Table view is not available for now.--}}
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        function expand(){
            var input = {!! $contractData !!};
            delete input['_id'];

            $('#json-viewer').JSONView(input);
            $('#json-viewer').JSONView('expand');
        }
        function collapse(){
            var input = {!! $contractData !!};
            delete input['_id'];

            $('#json-viewer').JSONView(input);
            $('#json-viewer').JSONView('collapse');
        }
    </script>
    <link rel="stylesheet" href="https://rawgithub.com/yesmeck/jquery-jsonview/master/dist/jquery.jsonview.css"/>
    <script type="text/javascript"
            src="https://rawgithub.com/yesmeck/jquery-jsonview/master/dist/jquery.jsonview.js"></script>

    <style>
        .level-1 {
            padding-left: 30px;
        }

        .level-2 {
            padding-left: 60px;
        }

        .level-3 {
            padding-left: 90px;
        }

        .level-4 {
            padding-left: 120px;
        }

        .level-5 {
            padding-left: 150px;
        }

        .level-6 {
            padding-left: 180px;
        }

        .level-7 {
            padding-left: 210px;
        }

        .level-8 {
            padding-left: 240px;
        }

        .level-9 {
            padding-left: 240px;
        }

        .level-10 {
            padding-left: 240px;
        }

    </style>
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
                        $("#myModal").hide();

                        if (data.status == "success") {
                            setInterval(function () {
                                $('#fullname').val('');
                                $('#email').val('');
                                $('#message').val('');
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
     
    <link rel="stylesheet" href="https://rawgithub.com/yesmeck/jquery-jsonview/master/dist/jquery.jsonview.css"/>
        
    <script type="text/javascript" src="https://rawgithub.com/yesmeck/jquery-jsonview/master/dist/jquery.jsonview.js"></script>

     
    <script>
        var input = {!! $contractData !!};
        delete input['_id'];

        $('#json-viewer').JSONView(input);
        $('#json-viewer').JSONView('collapse');

        var showJsonTable = function () {
            var parent = $("#json-table");
            var table = $('<table>', {
                class: "jTable"
            });
            var count = 1;
            for (var key in input) {
                if (typeof input[key] === 'string') {
                    table.append('<tr><td class="main-title" id="title' + count + '" colspan="100%">' + key + '</td><td>' + input[key] + '</td></tr>');
                } else {
                    table.append('<tr><td class="main-title" id="title' + count + '" colspan="100%">' + key + '</td></tr>');
                    showArray(table, input[key], 1);
                }
                count++;
            }
            parent.append(table);
        }

        var showArray = function (table, arr, level) {
            for (var a in arr) {
                if (typeof arr[a] != 'object') {
                    var tr = '<tr><td class="level-' + level + '">' + a + '</td><td>' + arr[a] + '</td></tr>';
                    table.append(tr);
                } else {
                    table.append('<tr><td class="level-' + level + '" colspan="100%">' + a + '</td></tr>');
                    level = parseInt(level) + 1;
                    showArray(table, arr[a], level);
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
            var titleOne, titleTwo, titleThree, titleFour;

            $('.toggle-switch').click(function(e) {
                titleOne = $('#title1').offset().top - 158, // 76 + 41 + 41 (fixed header + height of td)
                        titleTwo = $('#title2').offset().top - 158,
                        titleThree = $('#title3').offset().top - 158,
                        titleFour = $('#title4').offset().top - 158;
            });

            $(window).scroll(function () {

                $("#json-table").each(function () {
                    var el = $(this),
                            offset = el.offset(),
                            scrollTop = $(window).scrollTop();

                    if ((scrollTop > offset.top) && (scrollTop < offset.top + el.height())) {
                        fixHeader();
                    }else{
                        $(".main-title-wrap").each(function(){
                            $("td").removeClass("floatingHeader");
                        });
                    }
                });
            });

            var calcHeaderWidth = function(element){
                var tableWidth = $(".jTable").width() - 21;
                element.addClass("floatingHeader");
                element.width(tableWidth);
                element.css('visibility', 'visible');
            }

            var fixHeader = function () {

                var scrollTop = $(window).scrollTop();

                if (titleOne <= scrollTop && scrollTop < titleTwo ){
                    calcHeaderWidth($("#title1"));
                    $(".main-title").not('[id$="1"]').removeClass("floatingHeader");

                } else if ( titleTwo <= scrollTop && scrollTop < titleThree ) {
                    calcHeaderWidth($("#title2"));
                    $(".main-title").not('[id$="2"]').removeClass("floatingHeader");

                } else if (titleThree <= scrollTop && scrollTop < titleFour) {
                    calcHeaderWidth($("#title3"));
                    $(".main-title").not('[id$="3"]').removeClass("floatingHeader");

                } else if (titleFour <= scrollTop) {
                    calcHeaderWidth($("#title4"));
                    $(".main-title").not('[id$="4"]').removeClass("floatingHeader");
                }
            }
        });

    </script>

@endsection
