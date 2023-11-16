<div id="sidebar" class="bg-white">
    <ul id="sidebar-menu">
        <li class="nav-link {{ $module_active == 'dashboard' ? 'active' : '' }}">
            <a href="{{ url('admin/dashboard') }}">
                <div class="nav-link-icon d-inline-flex">
                    <i class="far fa-folder"></i>
                </div>
                Bảng thống kê
            </a>
        </li>

        @can('list_product')
            <li class="nav-link {{ $module_active == 'product' ? 'active' : '' }}">
                <a href="{{ url('admin/product/list') }}">
                    <div class="nav-link-icon d-inline-flex">
                        <i class="far fa-folder"></i>
                    </div>
                    Sản phẩm
                </a>
                <ul class="sub-menu">
                    <li>
                        <a href="{{ url('admin/product/variant/list') }}">Danh sách sản phẩm biến thể</a>
                    </li>
                    <li><a href="{{ url('admin/product/cat/list') }}">Danh mục</a></li>
                </ul>
            </li>
        @endcan

        @can('list_post')
            <li class="nav-link {{ $module_active == 'post' ? 'active' : '' }}">
                <a href="{{ url('admin/post/list') }}">
                    <div class="nav-link-icon d-inline-flex">
                        <i class="far fa-folder"></i>
                    </div>
                    Bài viết
                </a>

                <ul class="sub-menu">
                    <li><a href="{{ url('admin/post/cat/list') }}">Danh mục</a></li>
                </ul>
            </li>
        @endcan

        @can('list_slider')
            <li class="nav-link {{ $module_active == 'slider' ? 'active' : '' }}">
                <a href="{{ url('admin/slider/list') }}">
                    <div class="nav-link-icon d-inline-flex">
                        <i class="far fa-folder"></i>
                    </div>
                    Hình ảnh quảng cáo
                </a>
            </li>
        @endcan

        @can('list_order')
            <li class="nav-link {{ $module_active == 'order' ? 'active' : '' }}">
                <a href="{{ url('admin/order/list') }}">
                    <div class="nav-link-icon d-inline-flex">
                        <i class="far fa-folder"></i>
                    </div>
                    Đơn hàng
                </a>
            </li>
        @endcan

        @can('list_page')
            <li class="nav-link {{ $module_active == 'page' ? 'active' : '' }}">
                <a href="{{ url('admin/page/list') }}">
                    <div class="nav-link-icon d-inline-flex">
                        <i class="far fa-folder"></i>
                    </div>
                    Trang
                </a>
            </li>
        @endcan

        @can('list_attribute')
            <li class="nav-link {{ $module_active == 'attribute' ? 'active' : '' }}">
                <a href="{{ route('attribute.list') }}">
                    <div class="nav-link-icon d-inline-flex">
                        <i class="far fa-folder"></i>
                    </div>
                    Thuộc tính
                </a>
                <ul class="sub-menu">
                    <li><a href="{{ route('attribute.value.list') }}">Giá trị thuộc tính</a></li>

                </ul>
            </li>
        @endcan

        @can('list_role')
            <li class="nav-link {{ $module_active == 'role' ? 'active' : '' }}">
                <a href="{{ url('admin/role/list') }}">
                    <div class="nav-link-icon d-inline-flex">
                        <i class="far fa-folder"></i>
                    </div>
                    Danh sách nhóm quyền
                </a>
            </li>
        @endcan

        @can('list_user')
            <li class="nav-link {{ $module_active == 'user' ? 'active' : '' }}">
                <a href="{{ url('admin/user/list') }}">
                    <div class="nav-link-icon d-inline-flex">
                        <i class="far fa-folder"></i>
                    </div>
                    Thành viên
                </a>
            </li>
        @endcan

        @can('list_customer')
            <li class="nav-link {{ $module_active == 'customer' ? 'active' : '' }}">
                <a href="{{ url('admin/customer/list') }}">
                    <div class="nav-link-icon d-inline-flex">
                        <i class="far fa-folder"></i>
                    </div>
                    Khách hàng
                </a>
            </li>
        @endcan

        @can('list_rating')
            <li class="nav-link {{ $module_active == 'rating' ? 'active' : '' }}">
                <a href="{{ url('admin/rating/list') }}">
                    <div class="nav-link-icon d-inline-flex">
                        <i class="far fa-folder"></i>
                    </div>
                    Đánh giá
                </a>
            </li>
        @endcan
    </ul>
</div>
