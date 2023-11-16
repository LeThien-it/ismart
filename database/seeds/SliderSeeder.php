<?php

use Illuminate\Database\Seeder;

class SliderSeeder extends Seeder
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
                    'name' => 'Hình ảnh quảng cáo',
                    'key_code' => null,
                    'parent_id' => 0
                ],
                [
                    'name' => 'Xem quảng cáo',
                    'key_code' => 'list_slider',
                    'parent_id' => 11
                ],
                [
                    'name' => 'Thêm quảng cáo',
                    'key_code' => 'add_slider',
                    'parent_id' => 11
                ],
                [
                    'name' => 'Sửa quảng cáo',
                    'key_code' => 'edit_slider',
                    'parent_id' => 11
                ],
                [
                    'name' => 'Xóa quảng cáo',
                    'key_code' => 'delete_slider',
                    'parent_id' => 11
                ],
            ]
        );
    }
}
