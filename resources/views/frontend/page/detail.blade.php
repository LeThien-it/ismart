@extends('layouts.frontend')

@section('css')
    <link rel="stylesheet" href="{{ asset('frontend/public/css/import/detail_blog.css') }}">
@endsection

@section('content')
    <div id="main-content-wp" class="detail-blog-page">
        <div class="container">
            <div class="width-custom pb-5">
                <div class="secion" id="breadcrumb-wp">
                    <div class="secion-detail">
                        <ul class="list-item">
                            <li>
                                <a href="{{ url('/') }}" title="">Trang chủ</a>
                            </li>
                            <li>
                                <a href="#" title="">{{ $pageDetail->name }}</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="main-content-blog blog-content">
                    <div class="section" id="detail-blog-wp">
                        <div class="section-head">
                            <h3 class="section-title">
                                {{ $pageDetail->name }}
                            </h3>
                        </div>
                        <div class="section-detail">
                            <span class="create-date">{{ $pageDetail->created_at->diffForHumans() }}</span>
                            <div class="detail">
                                {!! $pageDetail->content !!}
                            </div>
                        </div>
                    </div>
                    
                </div>

            </div>
        </div>
    </div>
@endsection
