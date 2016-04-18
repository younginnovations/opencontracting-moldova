<header class="top-bar fixed-header">
    <div class="row">
        <div class="top-bar-left">
            <a href="{{ route('/') }}" class="project-logo">
                <div class="first-section">MOLDOVA CONTRACT</div>
                <div class="second-section">DATA VISUALISATION</div>
            </a>
        </div>

        <div class="top-bar-right" id="main-menu">
            <ul class="menu">
                <li><a href="{{ route('/') }}" class="{{ (\Request::segment(1) === null)?'active':'' }}">Home</a></li>
                <li><a href="#">About</a></li>
                <li><a href="{{ route('tenders.index') }}"
                       class="{{ (Request::segment(1) === 'tenders')?'active':'' }}">Tenders</a>
                </li>
                <li><a href="{{ route('contracts') }}" class="{{ (Request::segment(1) === 'contracts')?'active':'' }}">Contracts</a>
                </li>
                <li><a href="{{ route('procuring-agency.index') }}"
                       class="{{ (Request::segment(1) === 'procuring-agency')?'active':'' }}">Agencies</a></li>
                <li><a href="{{ route('goods.index') }}"
                       class="{{ (Request::segment(1) === 'goods')?'active':'' }}">Goods</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
        </div>
    </div>
</header>