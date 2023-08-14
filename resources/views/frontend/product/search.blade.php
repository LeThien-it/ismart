@extends('layouts.frontend')

@section('content')
    <div id="main-content-wp">
        <div class="container px-0">
            <div class="pt-3">
                <div class="card py-3">
                    <div class="text-center d-flex flex-column align-items-center w-100">
                        <img src="{{ asset('frontend/public/images/noti-search.png') }}" alt="">
                        <p>Rất tiếc chúng tôi không tìm thấy kết quả theo yêu cầu của bạn</p>
                        <p>Vui lòng thử lại .</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
