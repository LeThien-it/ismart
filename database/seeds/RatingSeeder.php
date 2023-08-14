<?php

use Illuminate\Database\Seeder;

class RatingSeeder extends Seeder
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
                    'name' => 'Đánh giá',
                    'key_code' => null,
                    'parent_id' => 0
                ],
                [
                    'name' => 'Xem Đánh giá',
                    'key_code' => 'list_rating',
                    'parent_id' => 43
                ],
                
                [
                    'name' => 'Sửa Đánh giá',
                    'key_code' => 'edit_rating',
                    'parent_id' => 43
                ],
                [
                    'name' => 'Xóa Đánh giá',
                    'key_code' => 'delete_rating',
                    'parent_id' => 43
                ],
            ]
        );
    }
}
