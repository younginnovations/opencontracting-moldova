@extends('app')
@section('content')
    <div class="row contact-page">
        <div class="inner-wrap-static">
            <div class="buffer-top clearfix">
                <div class="medium-5 columns background">
                    <form class="custom-form clearfix" action="{{route('home.contact')}}" method="post">
                        <div class="formBox">
                            <div class="contactTitle"><span class="bold">Contact</span> Us</div>
                            <div class="form-group">
                                <input class="form-control" type="text" name="fullname" placeholder="YOUR NAME" required>
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="email" name="email" placeholder="YOUR EMAIL" required>
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" placeholder="YOUR MESSAGE" name="message" required></textarea>
                            </div>
                            <div class="g-recaptcha captcha-wrap" data-sitekey="{{ env('RE_CAP_SITE') }}" style="transform:scale(0.77);-webkit-transform:scale(0.77);transform-origin:0 0;-webkit-transform-origin:0 0;"></div>
                        </div>
                                <button class="button" type="submit" value="SEND MESSAGE" rows="20">SEND MESSAGE</button>
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
    <script src='https://www.google.com/recaptcha/api.js'></script>
@endsection