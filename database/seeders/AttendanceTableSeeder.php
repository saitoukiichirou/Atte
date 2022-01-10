<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AttendanceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'user_id' => 1,
            'date' => '2022-01-01',
            'start_time' => '09:00:00',
            'end_time' => '17:00:00'
        ];
        DB::table('attendances')->insert($param);
        $param = [
            'user_id' => 1,
            'date' => '2022-01-02',
            'start_time' => '09:00:00',
            'end_time' => '16:25:00'
        ];
        DB::table('attendances')->insert($param);
        $param = [
            'user_id' => 1,
            'date' => '2022-01-03',
            'start_time' => '08:30:00',
            'end_time' => '17:00:00'
        ];
        DB::table('attendances')->insert($param);
        $param = [
            'user_id' => 1,
            'date' => '2022-01-04',
            'start_time' => '09:02:35',
            'end_time' => '17:56:00'
        ];
        DB::table('attendances')->insert($param);
        $param = [
            'user_id' => 1,
            'date' => '2022-01-05',
            'start_time' => '09:05:01',
            'end_time' => '16:48:44'
        ];
        DB::table('attendances')->insert($param);
        $param = [
            'user_id' => 1,
            'date' => '2022-01-06',
            'start_time' => '10:20:00',
            'end_time' => '18:59:00'
        ];
        DB::table('attendances')->insert($param);
        $param = [
            'user_id' => 1,
            'date' => '2022-01-07',
            'start_time' => '09:35:35',
            'end_time' => '17:25:18'
        ];
        DB::table('attendances')->insert($param);
    }
}
