<?php

use Illuminate\Database\Seeder;

class AttributeSeeder extends Seeder
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
                    'name' => 'Thuộc tính',
                    'key_code' => null,
                    'parent_id' => 0
                ],
                [
                    'name' => 'Xem Thuộc tính',
                    'key_code' => 'list_attribute',
                    'parent_id' => 25
                ],
                [
                    'name' => 'Thêm Thuộc tính',
                    'key_code' => 'add_attribute',
                    'parent_id' => 25
                ],
                [
                    'name' => 'Sửa Thuộc tính',
                    'key_code' => 'edit_attribute',
                    'parent_id' => 25
                ],
                [
                    'name' => 'Xóa Thuộc tính',
                    'key_code' => 'delete_attribute',
                    'parent_id' => 25
                ],
            ]
        );
    }
}
