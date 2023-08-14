<?php

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
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
                    'name' => 'Nhóm quyền',
                    'key_code' => null,
                    'parent_id' => 0
                ],
                [
                    'name' => 'Xem Nhóm quyền',
                    'key_code' => 'list_role',
                    'parent_id' => 30
                ],
                [
                    'name' => 'Thêm Nhóm quyền',
                    'key_code' => 'add_role',
                    'parent_id' => 30
                ],
                [
                    'name' => 'Sửa Nhóm quyền',
                    'key_code' => 'edit_role',
                    'parent_id' => 30
                ],
                [
                    'name' => 'Xóa Nhóm quyền',
                    'key_code' => 'delete_role',
                    'parent_id' => 30
                ],
            ]
        );
    }
}
