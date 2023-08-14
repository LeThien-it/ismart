<?php

use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
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
                    'name' => 'Trang',
                    'key_code' => null,
                    'parent_id' => 0
                ],
                [
                    'name' => 'Xem Trang',
                    'key_code' => 'list_page',
                    'parent_id' => 20
                ],
                [
                    'name' => 'Thêm Trang',
                    'key_code' => 'add_page',
                    'parent_id' => 20
                ],
                [
                    'name' => 'Sửa Trang',
                    'key_code' => 'edit_page',
                    'parent_id' => 20
                ],
                [
                    'name' => 'Xóa Trang',
                    'key_code' => 'delete_page',
                    'parent_id' => 20
                ],
            ]
        );
    }
}
