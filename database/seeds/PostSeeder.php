<?php

use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
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
            ]
        );
    }
}
