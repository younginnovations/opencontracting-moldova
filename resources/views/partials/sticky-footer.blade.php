<div class="advanced-filter">
    <div class="advanced-filter__header">

        <button class="advanced-filter__header-btn">
            <span><img src="{{url('/images/ic_arrowdown.svg')}}" alt="" class="rotate"></span>
        </button>
        <span>Contract Explorer</span>
        <span>Explore through contracts based on contractors, procuring agencies, goods/services/work.</span>
    </div>
    <div class="advanced-filter__body clearfix">

                <form action="{{ route('search') }}" method="get" class="custom-form advanced-filter-form">
                    <div class="form-inner clearfix">
                        <div class="row">
                            <div class="form-group small-6 medium-4 columns end">
                                <input placeholder="Type a contractor, procuring agency or goods/services" name="q" class="input-box">
                            </div>
                            <div class="form-group small-6 medium-4 columns end">
                                <select name="contractor" class="cs-select2 cs-skin-elastic">
                                    <option value="" disabled selected>@lang('general.select_a_contractor')</option>
                                    @forelse($all_contracts as $contractTitle)
                                        <option value="{{ $contractTitle['_id'][0] }}">{{ $contractTitle['_id'][0] }}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                            <div class="form-group small-6 medium-4 columns end">
                                <select name="agency" class="cs-select2 cs-skin-elastic">
                                    <option value="" disabled selected>@lang('general.select_a_buyer')</option>
                                    @forelse($procurings as $procuring)
                                        <option value="{{ $procuring->toArray()[0] }}">{{ $procuring->toArray()[0] }}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>

                            {{--<div class="form-group small-6 medium-4 columns end">
                                <select name="agency" class="cs-select2 cs-skin-elastic">
                                    <option value="" disabled selected>Procuring Agency</option>
                                    @forelse($procurings as $procuringAgency)
                                        <option value="{{ $procuringAgency->toArray()[0] }}">{{ $procuringAgency->toArray()[0] }}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>--}}

                        </div>


                        <div class="row">
                            <div class="form-group small-6 medium-4 columns end">
                                <label class="form-group-title">Select a range</label>

                                <div class="radio-group">
                                    <input name="amount" id="10k" type="radio" value="0-10000">
                                    <label for="10k">0-10k</label>

                                    <input name="amount" id="100k" type="radio" value="10000-100000">
                                    <label for="100k">10k-100k</label>

                                    <input name="amount" id="200k" type="radio" value="100000-200000">
                                    <label for="200k">100k-200k</label>
                                </div>

                                <div class="radio-group">
                                    <input name="amount" id="500k" type="radio" value="200000-500000">
                                    <label for="500k">200k-500k</label>

                                    <input name="amount" id="1000k" type="radio" value="500000-1000000">
                                    <label for="1000k">500k-1000k</label>

                                    <input name="amount" id="above" type="radio" value="1000000-Above">
                                    <label for="above"> 1000k</label>
                                </div>

                            </div>
                            <div id="year_select" class="form-group small-6 medium-4 columns end">
                                <label class="form-group-title">Select Year</label>
                                <div id="year_slider"></div>
                            </div>


                            <div class="form-group small-6 medium-4 columns end">
                                <select name="goods" class="cs-select2 cs-skin-elastic">
                                    <option value="" disabled selected>Goods/services/work</option>
                                    @foreach($goodsList as $key => $value)
                                        @if(isset($value->_id[0]))
                                        <option value="{{ $value->_id[0] }}">{{ $value->_id[0] }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                        </div>

                        <input type="hidden" name="startDate" id="startDate">
                        <input type="hidden" name="endDate" id="endDate">

                        <div class="row">
                            <div class="small-6 medium-4 columns clearfix">
                                <input type="submit" class="button yellow-button advanced-filter-btn" value="Search Contracts">
                            </div>
                        </div>

                    </div>
                </form>



    </div>
</div>

<script src="{{url('js/vendorChart.min.js')}}"></script>

<script src="{{url('js/customChart.js')}}"></script>
<script>
    //similar to $.ready function
    document.onreadystatechange = function () {
        var state = document.readyState;
        var widthOfParent = 370;

        var makeCharts = function () {
            only_slider( widthOfParent,"#year_slider");
        };

        if (state === 'interactive') {
            makeCharts();

        } else if (state === 'complete') {
            $(window).resize(function () {
                widthOfParent = $('#year_select').width();
                $("#year_slider").empty();
                makeCharts();
            });
        }
    };
</script>