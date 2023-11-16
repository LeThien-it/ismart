<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
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
                    'name' => 'Thành viên',
                    'key_code' => null,
                    'parent_id' => 0
                ],
                [
                    'name' => 'Xem Thành viên',
                    'key_code' => 'list_user',
                    'parent_id' => 35
                ],
                [
                    'name' => 'Thêm Thành viên',
                    'key_code' => 'add_user',
                    'parent_id' => 35
                ],
                [
                    'name' => 'Sửa Thành viên',
                    'key_code' => 'edit_user',
                    'parent_id' => 35
                ],
                [
                    'name' => 'Xóa Thành viên',
                    'key_code' => 'delete_user',
                    'parent_id' => 35
                ],
            ]
        );
    }
}
