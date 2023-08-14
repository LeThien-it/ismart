<?php

use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
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
                    'name' => 'Khách hàng',
                    'key_code' => null,
                    'parent_id' => 0
                ],
                [
                    'name' => 'Xem Khách hàng',
                    'key_code' => 'list_customer',
                    'parent_id' => 40
                ],
                
                [
                    'name' => 'Xóa Khách hàng',
                    'key_code' => 'delete_customer',
                    'parent_id' => 40
                ],
            ]
        );
    }
}
