<?php

namespace App\Libraries;

use App\Models\Rest;
use App\Models\User;

class Common
{
    //任意の条件で抽出されたレコードを加工・計算して返す
    public static function workTimeCalculation($attendances_array)
    {
        foreach ($attendances_array as $attendance_array) {
        $user_id = $attendance_array->user_id;
        $name = User::find($user_id)->name;
        $attendance_array['name'] = $name;

        $punch_in = $attendance_array->start_time;
        $punch_out = $attendance_array->end_time;

        $work_start = strtotime($punch_in);
        $work_end = strtotime($punch_out);
        $working_time = $work_end - $work_start;

        $attendance_id = $attendance_array->id;
        $rests = Rest::where('attendance_id', $attendance_id)->get();
        $rest_total = 0;

        //休憩時間の合計を取得し配列に格納
        foreach ($rests as $rest) {
            $rest_start = strtotime($rest->start_time);
            $rest_end = strtotime($rest->end_time);

            if (!is_null($rest->end_time)) {
                $rest_total += $rest_end - $rest_start;
            }
        }
        $attendance_array['rest_time'] = $rest_total;

        //勤務時間から休憩時間を引いて実働時間を求め配列に格納
        $true_working_time = null;
        if (!is_null($punch_out)) {
            $true_working_time = $working_time - $rest_total;
        }
        $attendance_array['working_time'] = $true_working_time;
        }
        return $attendances_array;
    }
}

