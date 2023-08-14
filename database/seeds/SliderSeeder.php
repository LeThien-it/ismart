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
            ]
        );
    }
}
