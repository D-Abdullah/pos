<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>@yield('title') | {{ config('app.name') }}</title>

    <link rel="shortcut icon" href="{{ asset('Assets/imgs/vuexy-logo.png') }}" type="image/x-icon">
    <link rel="apple-touch-icon" href="{{ asset('Assets/imgs/vuexy-logo.png') }}">
    <link rel="stylesheet" href="{{ asset('Assets/Css files/Golobal.css') }}">
    <link rel="stylesheet" href="{{ asset('Assets/Normalize file/Normalize.css') }}">
    <link rel="stylesheet" href="{{ asset('Assets/Bootsrap files/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Assets/Bootsrap files/bootstrap.min.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    @yield('styles')
</head>
