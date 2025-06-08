<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <title>Home | E-Shopper</title>

    <link href="{{asset('client/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('client/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('client/css/prettyPhoto.css')}}" rel="stylesheet">
    <link href="{{asset('client/css/price-range.css')}}" rel="stylesheet">
    <link href="{{asset('client/css/animate.css')}}" rel="stylesheet">
    <link href="{{asset('client/css/main.css')}}" rel="stylesheet">
    <link href="{{asset('client/css/responsive.css')}}" rel="stylesheet">

    <script src="{{asset('client/js/html5shiv.js')}}"></script>

    <link rel="shortcut icon" href="{{asset('client/images/ico/favicon.ico')}}">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{asset('client/images/ico/apple-touch-icon-144-precomposed.png')}}">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{asset('client/images/ico/apple-touch-icon-114-precomposed.png')}}">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{asset('client/images/ico/apple-touch-icon-72-precomposed.png')}}">
    <link rel="apple-touch-icon-precomposed" href="{{asset('client/images/ico/apple-touch-icon-57-precomposed.png')}}">
</head>
<body>
@if (session('error'))
    <div style="color:red;">{{ session('error') }}</div>
@elseif(session('success'))
    <div style="color:blue;">{{ session('success') }}</div>
@endif

@yield('frontend')

<script src="{{asset('client/js/jquery.js')}}"></script>
<script src="{{asset('client/js/bootstrap.min.js')}}"></script>
<script src="{{asset('client/js/jquery.scrollUp.min.js')}}"></script>
<script src="{{asset('client/js/price-range.js')}}"></script>
<script src="{{asset('client/js/jquery.prettyPhoto.js')}}"></script>
<script src="{{asset('client/js/main.js')}}"></script>
<script src="{{asset('client/js/custom.js')}}"></script>

</body>
</html>
