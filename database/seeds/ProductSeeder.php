<?php

use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
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
                    'name' => 'Sản phẩm',
                    'key_code' => null,
                    'parent_id' => 0
                ],
                [
                    'name' => 'Xem Sản phẩm',
                    'key_code' => 'list_product',
                    'parent_id' => 1
                ],
                [
                    'name' => 'Thêm Sản phẩm',
                    'key_code' => 'add_product',
                    'parent_id' => 1
                ],
                [
                    'name' => 'Sửa Sản phẩm',
                    'key_code' => 'edit_product',
                    'parent_id' => 1
                ],
                [
                    'name' => 'Xóa Sản phẩm',
                    'key_code' => 'delete_product',
                    'parent_id' => 1
                ],
            ]
        );
    }
}
