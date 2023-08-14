<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('vendors/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/admin-template/plugins/fontawesome-free/css/solid.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/admin-template/css/style.css') }}">
    @yield('css')
    <title>Admintrator</title>
</head>

<body>
    <div id="warpper" class="nav-fixed">
        <nav class="topnav shadow navbar-light bg-white d-flex">
            <div class="navbar-brand"><a href="?">UNITOP ADMIN</a></div>
            <div class="nav-right ">
                <div class="btn-group ml-auto">
                    <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        {{ auth()->user()->name }}
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="#">Tài khoản</a>
                        <a class="dropdown-item" href="{{ route('admin.logout') }}">Thoát</a>
                    </div>
                </div>
            </div>
        </nav>
        <!-- end nav  -->
        @php
            $module_active = session('module_active');
        @endphp
        <div id="page-body" class="d-flex">
           @include('admin.components.sidebar')
            <div id="wp-content">
                @yield('content')
            </div>
        </div>


    </div>

    <script src="{{ asset('vendors/jquery/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ asset('vendors/bootstrap/js/popper.min.js') }}"></script>
    <script src="{{ asset('vendors/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendors/sweetAlert2/sweetalert2@11.js') }}"></script>
    <script src="{{ asset('backend/admin-template/js/app.js') }}"></script>
    @yield('js')
</body>

</html>
