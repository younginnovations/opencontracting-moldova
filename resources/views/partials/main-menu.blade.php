<header class="top-bar fixed-header">
    <div class="row">
        <div class="top-bar-left">
            <a href="{{ route('/') }}" class="project-logo">
                <div class="first-section">@lang('general.moldova_contract')</div>
                <div class="second-section">@lang('general.data_visualization')</div>
            </a>
            <a href="javascript:" onclick="changeLang('en')" style="color: #FFFFFF">English</a>/<a href="javascript:" onclick="changeLang('md')" style="color: #FFFFFF">Moldovian</a>
        </div>

        <div class="top-bar-right" id="main-menu">
            <ul class="menu" class=" ">
                <li><a href="{{ route('/') }}"
                       class="{{ (\Request::segment(1) === null)?'active':'' }}">@lang('general.home')</a></li>
                <li><a href="/about"
                       class="{{ (Request::segment(1) === 'about')?'active':'' }}">@lang('general.about')</a></li>
                <li><a href="{{ route('tenders.index') }}"
                       class="{{ (Request::segment(1) === 'tenders')?'active':'' }}">@lang('general.tenders')</a>
                </li>
                <li><a href="{{ route('contracts') }}"
                       class="{{ (Request::segment(1) === 'contracts')?'active':'' }}">@lang('general.contracts')</a>
                </li>
                <li><a href="{{ route('procuring-agency.index') }}"
                       class="{{ (Request::segment(1) === 'procuring-agency')?'active':'' }}">@lang('general.agencies')</a>
                </li>
                <li>
                    <a href="{{ route('goods.index') }}" class="{{ (Request::segment(1) === 'goods')?'active':'' }}">
                        @lang('general.goods')
                    </a>
                </li>
                <li>
                    <a href="/contact"
                       class="{{ (Request::segment(1) === 'contact')?'active':'' }}">@lang('general.contact')</a>
                </li>
            </ul>

            <form action="{{ route('search') }}" method="get" class="search">
                <input name="q" type="search" class="search-box"
                       placeholder="Type a contractor, procuring agency or goods & services ...">
                <span class="search-button">
                    <span class="search-icon"></span>
                </span>
            </form>
        </div>
    </div>
</header>

