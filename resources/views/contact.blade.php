@extends('app')
@section('content')
    <div class="row contact-page">
        <div class="inner-wrap-static">
            <div class="buffer-top clearfix">
                <div class="medium-5 columns background">
                    <form class="custom-form clearfix">
                        <div class="formBox">
                            <div class="contactTitle"><span
                                        class="bold">@lang('general.contact')</span> @lang('general.us')</div>
                            <div id="ajaxResponse"></div>
                            <div class="form-group">
                                <input class="form-control" type="text" id="fullname" name="fullname"
                                       placeholder="@lang('general.your_name')" required>
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="email" id="email" name="email"
                                       placeholder="@lang('general.your_email')" required>
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" placeholder="@lang('general.your_message')" id="message"
                                          name="message" required></textarea>
                            </div>
                            <div class="g-recaptcha captcha-wrap" id="captcha" data-sitekey="{{ env('RE_CAP_SITE') }}"
                                 style="transform:scale(0.77);-webkit-transform:scale(0.77);transform-origin:0 0;-webkit-transform-origin:0 0;"></div>
                        </div>
                        <button class="button" id="submit" type="submit" value="SEND MESSAGE"
                                rows="20">@lang('general.send_message')</button>
                    </form>
                </div>
                <div class="medium-7 columns ocdsAddress">
                    <div class="">
                        <div class="ad">Public Procurement Agency</div>
                        <div class="ad">MD-2028, mun., Highway Hincesti 53</div>
                        <div class="ad">Chisinau, Moldova</div>
                        <div class="ph">+373-22 23-42-80</div>
                    </div>
                </div>
            </div>


        </div>
    </div>
    <style>
        #rc-imageselect {
            transform: scale(0.77) !important;
            -webkit-transform: scale(0.77) !important;
            transform-origin: 0 0 !important;
            -webkit-transform-origin: 0 0 !important;
        }

        @media screen and (max-height: 575px) {
            #rc-imageselect, .g-recaptcha {
                transform: scale(0.77) !important;
                -webkit-transform: scale(0.77) !important;
                transform-origin: 0 0 !important;
                -webkit-transform-origin: 0 0 !important;
            }
        }
    </style>
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            $('#submit').on('click', function (e) {
                var route = '{{ route('home.contact') }}';
                e.preventDefault();
                var name = $('#fullname').val();
                var trimmedName = $.trim(name);
                var email = $('#email').val();
                var message = $('#message').val();
                var trimmedMessage = $.trim(message);
                var atPos = email.indexOf("@");
                var dotPos = email.lastIndexOf(".");
                if (trimmedName == "") {
                    $("#ajaxResponse").html("@lang('general.please_enter_your_name')");
                    $("#ajaxResponse").css("color", "#BB0505");
                    $("#fullname").focus();
                    return false;
                }
                if (email == "") {
                    $("#ajaxResponse").html("@lang('general.enter_your_email')");
                    $("#ajaxResponse").css("color", "#BB0505");
                    $("#email").focus();
                    return false;
                }
                if (atPos < 1 || dotPos < atPos + 2 || dotPos + 2 >= email.length) {
                    $("#ajaxResponse").html("@lang('general.enter_valid_email')");
                    $("#ajaxResponse").css("color", "#BB0505");
                    $("#email").css("border", "1px solid #BB0303");
                    return false;
                }
                if (trimmedMessage == "") {
                    $("#ajaxResponse").html("@lang('general.enter_your_message')");
                    $("#ajaxResponse").css("color", "#BB0505");
                    $("#message").focus();
                    return false;
                }
                var g_recaptcha_response = $("#g-recaptcha-response").val();
                var data = {
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
                        if (data.status != "success") {
                            $("#ajaxResponse").html(data.msg);
                            $("#ajaxResponse").css("color", "#BB0505");
                            return false;
                        }
                        else {
                            $('#fullname').val("");
                            $("#ajaxResponse").html(data.msg);
                            setInterval(function () {
                                $("#ajaxResponse").empty();
                            }, 3000);
                            $("#ajaxResponse").css("color", "#04692A");
                            $('#email').val('');
                            $("#email").css("border", "1px solid #bbb");
                            $("#email").css("background", "#fff");
                            $('#message').val('');
                            grecaptcha.reset();
                        }
                    }
                });
            });
        });
    </script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
@endsection