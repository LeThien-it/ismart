<?php

use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
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
                    'name' => 'Đơn hàng',
                    'key_code' => null,
                    'parent_id' => 0
                ],
                [
                    'name' => 'Xem Đơn hàng',
                    'key_code' => 'list_order',
                    'parent_id' => 16
                ],
                [
                    'name' => 'Sửa Đơn hàng',
                    'key_code' => 'edit_order',
                    'parent_id' => 16
                ],
                [
                    'name' => 'Xóa Đơn hàng',
                    'key_code' => 'delete_order',
                    'parent_id' => 16
                ],
            ]
        );
    }
}
