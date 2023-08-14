<?php

use Illuminate\Database\Seeder;

class CreatePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert(
            [
                [
                    'name' => 'Dashboard',
                    'key_code' => null,
                    'parent_id' => 0
                ],
                [
                    'name' => 'Xem Dashboard',
                    'key_code' => 'list_dashboard',
                    'parent_id' => 1
                ],
                [
                    'name' => 'Thêm Dashboard',
                    'key_code' => 'add_dashboard',
                    'parent_id' => 1
                ],
                [
                    'name' => 'Sửa Dashboard',
                    'key_code' => 'edit_dashboard',
                    'parent_id' => 1
                ],
                [
                    'name' => 'Xóa Dashboard',
                    'key_code' => 'delete_dashboard',
                    'parent_id' => 1
                ],
                [
                    'name' => 'Bài viết',
                    'key_code' => null,
                    'parent_id' => 0
                ],
                [
                    'name' => 'Xem Bài viết',
                    'key_code' => 'list_post',
                    'parent_id' => 6
                ],
                [
                    'name' => 'Thêm Bài viết',
                    'key_code' => 'add_post',
                    'parent_id' => 6
                ],
                [
                    'name' => 'Sửa Bài viết',
                    'key_code' => 'edit_post',
                    'parent_id' => 6
                ],
                [
                    'name' => 'Xóa Bài viết',
                    'key_code' => 'delete_post',
                    'parent_id' => 6
                ],
                [
                    'name' => 'Slider-banners',
                    'key_code' => null,
                    'parent_id' => 0
                ],
                [
                    'name' => 'Xem Slider-banners',
                    'key_code' => 'list_slider',
                    'parent_id' => 11
                ],
                [
                    'name' => 'Thêm Slider-banners',
                    'key_code' => 'add_slider',
                    'parent_id' => 11
                ],
                [
                    'name' => 'Sửa Slider-banners',
                    'key_code' => 'edit_slider',
                    'parent_id' => 11
                ],
                [
                    'name' => 'Xóa Slider-banners',
                    'key_code' => 'delete_slider',
                    'parent_id' => 11
                ],
                [
                    'name' => 'Đơn hàng',
                    'key_code' => null,
                    'parent_id' => 0
                ],
                [
                    'name' => 'Xem Đơn hàng',
                    'key_code' => 'list_order',
                    'parent_id' => 16
                ],
                [
                    'name' => 'Thêm Đơn hàng',
                    'key_code' => 'add_order',
                    'parent_id' => 16
                ],
                [
                    'name' => 'Sửa Đơn hàng',
                    'key_code' => 'edit_order',
                    'parent_id' => 16
                ],
                [
                    'name' => 'Xóa Đơn hàng',
                    'key_code' => 'delete_order',
                    'parent_id' => 16
                ],
                // [
                //     'name' => 'Users',
                //     'key_code' => null,
                //     'parent_id' => 0
                // ],
                // [
                //     'name' => 'Xem Users',
                //     'key_code' => 'list_user',
                //     'parent_id' => 6
                // ],
                // [
                //     'name' => 'Thêm Users',
                //     'key_code' => 'add_user',
                //     'parent_id' => 6
                // ],
                // [
                //     'name' => 'Sửa Users',
                //     'key_code' => 'edit_user',
                //     'parent_id' => 6
                // ],
                // [
                //     'name' => 'Xóa Users',
                //     'key_code' => 'delete_user',
                //     'parent_id' => 6
                // ],
                // [
                //     'name' => 'Sản phẩm',
                //     'key_code' => null,
                //     'parent_id' => 0
                // ],
                // [
                //     'name' => 'Xem Sản phẩm',
                //     'key_code' => 'list_product',
                //     'parent_id' => 11
                // ],
                // [
                //     'name' => 'Thêm Sản phẩm',
                //     'key_code' => 'add_product',
                //     'parent_id' => 11
                // ],
                // [
                //     'name' => 'Sửa Sản phẩm',
                //     'key_code' => 'edit_product',
                //     'parent_id' => 11
                // ],
                // [
                //     'name' => 'Xóa Sản phẩm',
                //     'key_code' => 'delete_product',
                //     'parent_id' => 11
                // ],
                
            ]
        );
    }
}
