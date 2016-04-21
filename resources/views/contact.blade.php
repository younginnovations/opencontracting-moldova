@extends('app')
@section('content')
    <div class="row contact-page">
        <div class="inner-wrap-static">
            <div class="buffer-top clearfix">
                <div class="medium-5 columns background">
                    <form class="custom-form" action="{{route('home.contact')}}" method="post">
                        <div class="formBox">
                            <div class="contactTitle"><span class="bold">Contact</span> Us</div>
                            <div class="form-group">
                                {{--<label class="control-label">Input Label</label>--}}
                                <input class="form-control" type="text" name="fullname" placeholder="YOUR NAME" required>
                            </div>
                            <div class="form-group">
                                {{--<label class="control-label">Input Label</label>--}}
                                <input class="form-control" type="email" name="email" placeholder="YOUR EMAIL" required>
                            </div>
                            <div class="form-group">
                                {{-- <label class="control-label">
                                 What books did you read over summer break?</label>--}}
                                <textarea class="form-control" placeholder="YOUR MESSAGE" name="message" required></textarea>
                            </div>
                            <div class="g-recaptcha captcha-wrap" data-sitekey="{{ env('RE_CAP_SITE') }}"></div>
                        </div>
                                <button class="button" type="submit" value="SEND MESSAGE" rows="20">SEND MESSAGE</button>
                    </form>
                </div>
                <div class="medium-6 columns">
                    <div class="ocdsAddress">
                        <div class="ad">Chisinau, Moldova</div>
                        <div class="ph">+373-xx-xx-xx-xx</div>
                    </div>
                </div>
            </div>


        </div>
    </div>

@endsection
@section('script')
    <script src='https://www.google.com/recaptcha/api.js'></script>
@endsection