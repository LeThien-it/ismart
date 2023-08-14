<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Lỗi 404</title>
</head>

<body>
    <style>
        a {
            text-decoration: none;
        }

        .error404 {
            align-items: center;
            display: flex;
            max-width: 960px;
            margin: 0 auto;
            padding-top: 64px;
            text-align: center;
        }

        .error404 .error-img img {
            max-width: 481px;
        }

        .error404 .error-content h3 {
            margin-bottom: 30px;
        }

        .error-content h3 {
            color: #30425B;
            font-size: 46px;
            font-weight: 500;
            line-height: 57px;
            max-width: 460px;
        }

        .error-content a {
            background-color: #FFC801;
            border-color: #FFC801;
            border-radius: 15px;
            display: inline-block;
            padding: 10px;
            font-size: 18px;

        }

    </style>
    <section>
        <div class="error404">
            <div class="error-img">
                <img src="{{ asset('frontend/public/images/404-error.jpg') }}" alt="">
            </div>
            <div class="error-content">
                <h3>Xin lỗi, Chúng tôi không tìm thấy trang này!</h3>

                <a href="{{ url('') }}">
                    <span>Trở về trang chủ</span>
                </a>

            </div>
        </div>
        </div>
    </section>
</body>

</html>
