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
                    'name' => 'Users',
                    'key_code' => null,
                    'parent_id' => 0
                ],
                [
                    'name' => 'Xem Users',
                    'key_code' => 'list_user',
                    'parent_id' => 35
                ],
                [
                    'name' => 'Thêm Users',
                    'key_code' => 'add_user',
                    'parent_id' => 35
                ],
                [
                    'name' => 'Sửa Users',
                    'key_code' => 'edit_user',
                    'parent_id' => 35
                ],
                [
                    'name' => 'Xóa Users',
                    'key_code' => 'delete_user',
                    'parent_id' => 35
                ],
            ]
        );
    }
}
