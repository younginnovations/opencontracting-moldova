
<header class="top-bar fixed-header">
    <div class="row">
        <div class="top-bar-left">
            <a href="{{ route('/') }}" class="project-logo">
                <div class="first-section">MOLDOVA CONTRACT</div>
                <div class="second-section">DATA VISUALISATION</div>
            </a>
        </div>

        <div class="top-bar-right" id="main-menu">
            <ul class="menu" class=" ">
                <li><a href="{{ route('/') }}" class="{{ (\Request::segment(1) === null)?'active':'' }}">Home</a></li>
                <li><a href="/about" class="{{ (Request::segment(1) === 'about')?'active':'' }}">About</a></li>
                <li><a href="{{ route('tenders.index') }}"
                       class="{{ (Request::segment(1) === 'tenders')?'active':'' }}">Tenders</a>
                </li>
                <li><a href="{{ route('contracts') }}" class="{{ (Request::segment(1) === 'contracts')?'active':'' }}">Contracts</a>
                </li>
                <li><a href="{{ route('procuring-agency.index') }}"
                       class="{{ (Request::segment(1) === 'procuring-agency')?'active':'' }}">Agencies</a></li>
                <li><a href="{{ route('goods.index') }}"
                       class="{{ (Request::segment(1) === 'goods')?'active':'' }}">Goods</a></li>
                <li><a href="/contact" class="{{ (Request::segment(1) === 'contact')?'active':'' }}">Contact</a></li>
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

