<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8"/>
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Moldova</title>
    <link href="{{asset('css/vendors.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/app.min.css')}}" rel="stylesheet">
</head>

<body>
    @yield('content')
        <footer>
            i am footer
        </footer>
        <script src="{{asset('js/vendors.min.js')}}"></script>
        <script src="{{asset('js/app.min.js')}}"></script>
    @yield('script')
</body>

</html>