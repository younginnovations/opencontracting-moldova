@extends('app')
@section('content')
    <div class="row contact-page">
        <div class="inner-wrap-static">
            <div class="buffer-top clearfix">
                <div class="medium-5 columns background">
                    <form class="custom-form clearfix">
                        <div class="formBox">
                            <div class="contactTitle"><span class="bold">Contact</span> Us</div>
                            <div class="form-group">
                                <input class="form-control" type="text" id="fullname" name="fullname" placeholder="YOUR NAME" required>
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="email" id="email" name="email" placeholder="YOUR EMAIL" required>
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" placeholder="YOUR MESSAGE" id="message" name="message" required></textarea>
                            </div>
                            <div class="g-recaptcha captcha-wrap" id="captcha" data-sitekey="{{ env('RE_CAP_SITE') }}" style="transform:scale(0.77);-webkit-transform:scale(0.77);transform-origin:0 0;-webkit-transform-origin:0 0;"></div>
                        </div>
                        <div id="ajaxResponse"></div>
                        <button class="button" id="submit" type="submit" value="SEND MESSAGE" rows="20">SEND MESSAGE</button>
                    </form>
                </div>
                <div class="medium-7 columns ocdsAddress">
                    <div class="">
                        <div class="ad">Chisinau, Moldova</div>
                        <div class="ph">+373-xx-xx-xx-xx</div>
                    </div>
                </div>
            </div>


        </div>
    </div>
    <style>
        #rc-imageselect {
            transform:scale(0.77) !important;
            -webkit-transform:scale(0.77) !important;
            transform-origin:0 0 !important;
            -webkit-transform-origin:0 0 !important;
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
        $(document).ready(function(){
            $('#submit').on('click',function(e){
                var route = '{{ route('home.contact') }}';
                e.preventDefault();
                var name  = $('#fullname').val();
                var email  = $('#email').val();
                var message = $('#message').val();
                var g_recaptcha_response = $("#g-recaptcha-response").val();
                var data = {fullname: name, email: email,message:message,'g-recaptcha-response':g_recaptcha_response};
                $.ajax({
                    type: "POST",
                    url: route,
                    data: data,
                    success: function(data){
                        if(data.status == "success"){
                            $('#fullname').val("");
                            $('#email').val('');
                            $('#message').val('');
                        }

                        $("#ajaxResponse").html(data.msg);
                    }
                });
            });
        });
    </script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
@endsection