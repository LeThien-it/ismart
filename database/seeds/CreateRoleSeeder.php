<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreateRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert(
            [
                [
                    'name' => 'admin',
                    'desc' => 'Quản trị hệ thống',
                ],
                [
                    'name' => 'developer',
                    'desc' => 'phát triển hệ thống',
                ],
                [
                    'name' => 'content',
                    'desc' => 'chỉnh sửa nội dung',
                ],
                [
                    'name' => 'guest',
                    'desc' => 'khách hàng',
                ]
            ]
        );
    }
}
