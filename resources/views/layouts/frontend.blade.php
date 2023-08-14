<!DOCTYPE html>
<html>

<head>
    <title>ISMART STORE</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link href="{{ asset('vendors/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('frontend/public/reset.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('frontend/public/css/carousel/owl.carousel.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('frontend/public/css/carousel/owl.theme.default.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('vendors/fontawesome/css/all.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('frontend/public/style.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    @yield('css')
    <link href="{{ asset('frontend/public/responsive.css') }}" rel="stylesheet" type="text/css" />
</head>

<body>
    <div id="site">
        <div id="wrapper">
            @include('frontend.components.header')
            @yield('content')
            @include('frontend.components.footer')
        </div>
        @include('frontend.components.menu-respon')
        <div id="btn-top"><img src="{{ asset('frontend/public') }}/images/icon-to-top.png" alt="" /></div>
        <div id="fb-root"></div>
        {{-- <script>
            (function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id))
                    return;
                js = d.createElement(s);
                js.id = id;
                js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.8&appId=849340975164592";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
        </script> --}}

        <script src="{{ asset('vendors/jquery/jquery-3.5.1.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('vendors/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('frontend/public/js/carousel/owl.carousel.js') }}" type="text/javascript"></script>
        <script src="{{ asset('frontend/public/js/main.js') }}" type="text/javascript"></script>
        @yield('js')
</body>

</html>
