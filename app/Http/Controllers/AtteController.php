<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Attendance;
use App\Models\Rest;

class AtteController extends Controller
{
    public function punchIn()        //テーブルの新規作成でstart_timeを入れる
    {
        $user = Auth::user();
        $today = Carbon::today();
//        dd($today);

        //同日の打刻が既にあるか確認する。打刻が無ければ出勤の打刻をする
        if(Attendance::where(['date', $today])){
         $message = '同日の打刻がある';
        }else {
            $message = '同日の打刻がない';
        };
        dd($message);

        $timestamp = Attendance::create([
            'user_id' =>  $user->id,
            'date' => Carbon::today(),
            'start_time' => Carbon::now(),
        ]);
//        dd($timestamp);

        return redirect('/');
    }


    public function punchOut()        //テーブルの更新でend_timeを入れる
    {
        $user = Auth::user();
        $today = Carbon::today();
//        dd($today);


        $end_time = Attendance::where
            ([
                ['user_id', $user->id],
                ['date', $today]
            ])->update(['end_time' => Carbon::now()]);

//        dd($end_time);
        return redirect('/');
    }

    public function restIn()
    {
        $today = Carbon::today();
        $id = Attendance::where([]);

        $attendance = Attendance::find($id);
        dd($attendance, $today, );

        $rest_start = Rest::create([
            'attendance_id' => $attendance->id,
            'start_time' => Carbon::now(),
        ]);
//        dd($rest_start);

        return redirect('/');

    }


}
