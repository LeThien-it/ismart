<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Trang login</title>
    <link rel="stylesheet" href="{{ asset('vendors/fontawesome/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/login/css/style.css') }}">
</head>

<body>
    <div class="container">
        <div class="d-flex justify-content-center h-100">
            <div class="card">

                <div class="card-header text-center">
                    <h3>Đăng nhập</h3>
                </div>
                <div class="card-body">
                    <form action="" method="post">
                        @csrf
                        <div class="form-group">
                            <input type="email" class="form-input form-control" placeholder="Email" name="email">
                        </div>
                        @error('email')
                            <div class="alert alert-danger"><small>{{ $message }}</small></div>
                        @enderror

                        <div class="form-group">
                            <input id="password-field" type="password" name="password" class="form-input form-control"
                                placeholder="mật khẩu">
                            <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                        </div>

                        @error('password')
                            <div class="alert alert-danger"><small>{{ $message }}</small></div>
                        @enderror

                        <div class="form-group">
                            <input type="submit" value="Đăng nhập" class="form-input form-control login_btn">
                        </div>

                        <div class="form-group d-md-flex">
                            <div class="w-50">
                                <label class="checkbox-wrap checkbox-primary">Ghi nhớ
                                    <input type="checkbox" name="remember_me"/>
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="w-50 text-md-right">
                                <a href="#" style="color: #fff">Quên mật khẩu</a>
                            </div>
                        </div>

                        @if (Session::has('error'))
                            <div class="alert alert-danger"><small>{{ Session::get('error') }}</small></div>
                        @endif

                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('vendors/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendors/jquery/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ asset('backend/login/js/main.js') }}"></script>
</body>

</html>
