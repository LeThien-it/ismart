@extends('layouts.admin')
@section('css')
    <link rel="stylesheet" href="{{ asset('vendors/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/product/add/add.css') }}">
@endsection

@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
                Thêm sản phẩm
            </div>

            <div class="card-body">
                <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <nav class="nav-justified ">
                        <div class="nav nav-tabs " id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="pop1-tab" data-toggle="tab" href="#pop1"
                                role="tab" aria-controls="pop1" aria-selected="true">Thông tin chung</a>
                            <a class="nav-item nav-link" id="pop2-tab" data-toggle="tab" href="#pop2" role="tab"
                                aria-controls="pop2" aria-selected="false">Bảo hành và khuyến mãi</a>
                            <a class="nav-item nav-link" id="pop3-tab" data-toggle="tab" href="#pop3" role="tab"
                                aria-controls="pop3" aria-selected="false">Thông số kỹ thuật
                            </a>

                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="pop1" role="tabpanel">
                            @include('admin.products.tab.info-product')
                        </div>
                        <div class="tab-pane fade" id="pop2" role="tabpanel">
                            @include('admin.products.tab.warranty-promotion')

                        </div>
                        <div class="tab-pane fade" id="pop3" role="tabpanel">
                            @include('admin.products.tab.parameter')
                        </div>

                    </div>

                    <button type="submit" class="btn btn-primary">Thêm mới</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.tiny.cloud/1/g8rgxy2yvvlw1uv1if15j5qs6y25dmlfse7j03mkzsk2ibz8/tinymce/5/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script src="{{ asset('backend/admin-template/js/tiny.js') }}"></script>
    <script src="{{ asset('vendors/select2/select2.min.js') }}"></script>
    <script src="{{ asset('backend/product/add/add.js') }}"></script>
@endsection
