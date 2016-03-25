<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Moldova</title>
    <link href="{{url('css/vendors.min.css')}}" rel="stylesheet">
    <link href="{{url('css/app.min.css')}}" rel="stylesheet">
</head>

<body>

<div class="title-bar burger-menu-button" data-responsive-toggle="main-menu" data-hide-for="medium">
    <button class="menu-icon" type="button" data-toggle></button>
</div>

<header class="top-bar fixed-header">
    <div class="row">
        <div class="top-bar-left">
            <div class="project-logo">
                <div class="first-section">MOLDOVA CONTRACT</div>
                <div class="second-section">DATA VISUALISATION</div>
            </div>
        </div>

        <div class="top-bar-right">
            <ul class="menu">
                <li><a href="#" class="active">Home</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Contracts</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
        </div>
    </div>
</header>

<section class="main-content">
    @yield('content')
</section>
<footer class="clearfix">
    <div class="row">
        <div class="top-bar-left">
            <div class="project-logo">
                <div class="first-section">MOLDOVA CONTRACT</div>
                <div class="second-section">DATA VISUALISATION</div>
            </div>
        </div>
    </div>
</footer>
<script src="{{url('js/vendors.min.js')}}"></script>
<script src="{{url('js/app.min.js')}}"></script>

@yield('script')
<script>
    $(document).foundation();
</script>
</body>

</html>