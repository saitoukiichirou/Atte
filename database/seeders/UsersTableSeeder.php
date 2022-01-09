<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $param = [
            'name' => 'テスト一郎',
            'email' => 'ichiro@test.com',
            'password' => '00000000'
        ];
        DB::table('users')->insert($param);
        $param = [
            'name' => 'テスト次郎',
            'email' => 'jiro@test.com',
            'password' => '00000000'
        ];
        DB::table('users')->insert($param);
        $param = [
            'name' => 'テスト三郎',
            'email' => 'saburo@test.com',
            'password' => '00000000'
        ];
        DB::table('users')->insert($param);
        $param = [
            'name' => 'テスト四郎',
            'email' => 'shiro@test.com',
            'password' => '00000000'
        ];
        DB::table('users')->insert($param);
        $param = [
            'name' => 'テスト五郎',
            'email' => 'goro@test.com',
            'password' => '00000000'
        ];
        DB::table('users')->insert($param);
//        users::insert($param);
    }
}
