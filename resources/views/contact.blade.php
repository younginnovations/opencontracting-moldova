@extends('app')
@section('content')
    <div class="row contact-page">
        <div class="inner-wrap-static">
            <h2>Contact Us</h2>
            <div class="buffer-top clearfix">
                <form class="custom-form medium-6 columns">
                    <div class="form-group">
                        {{--<label class="control-label">Input Label</label>--}}
                        <input class="form-control" type="text" placeholder="Enter name">
                    </div>
                    <div class="form-group">
                        {{--<label class="control-label">Input Label</label>--}}
                        <input class="form-control" type="text" placeholder="Enter email">
                    </div>
                    <div class="form-group">
                        {{-- <label class="control-label">
                         What books did you read over summer break?</label>--}}
                        <textarea class="form-control" placeholder="Enter message"></textarea>
                    </div>
                    <div class="form-group clearfix">
                        <div class="medium-4">
                            <input class="button blue-button" type="submit" value="Submit" rows="5">
                        </div>
                    </div>
                </form>

                <div class="medium-6 columns">
                    <p>If you have any suggestions or queries, Please contact us at <a href="mailto:info@yipl.com.np">info@yipl.com.np</a></p>
                </div>
            </div>


        </div>
    </div>

@stop