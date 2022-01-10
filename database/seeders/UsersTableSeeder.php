<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder  extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'id' => 1,
            'name' => 'demouser',
            'email' => 'demo@test.com',
            'email_verified_at' => '2022-01-01 00:00:00',
            'password' => '$2y$10$KmzbVFBjuKE2M9xrp7yBv.J6oZTw94mxoECOGDHhuRnCKBacz0/Um',
            'created_at' => '2022-01-01 00:00:00'
        ];
        DB::table('users')->insert($param);
    }
}
