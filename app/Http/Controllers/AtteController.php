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
//        Eloquentのcreateメソッドの特徴 1,作成したモデルインスタンス, 2,null
//        createはscopeに入れない
//        idの取得はcontrollerにて行う

    public function punchIn(Request $request)
    {
        //ログインしているユーザーidを変数に定義する
        $id = Auth::user()->id;

//        同日の打刻が既にあるか確認する。打刻が無ければ出勤の打刻をする findByUserOfToday
        if (!is_null(Attendance::findByUserOfDate($id, Carbon::yesterday(), ['end_time', null])->first())) {
            return redirect('/')->with(['message' => 'まず昨日の退勤をしろ']);
        }

        if (!is_null(Attendance::findByUserOfDate($id, Carbon::today(), ['start_time', 'LIKE', '%'])->first())) {
            return redirect('/')->with(['message' => '既に本日の出勤打刻が有ります(29)']);
        }

        if (!Attendance::create([
            'user_id' => $id,
            'date' => Carbon::today(),
            'start_time' => Carbon::now()
        ])) {
            return redirect('/')->with(['message' => '打刻に失敗しました(37)']);
        }

        return redirect('/')->with(['message' => '出勤時刻の打刻が完了しました']);
    }


    public function punchOut()      //テーブルの更新でend_timeを入れる
    {
        $id = Auth::user()->id;
        $attendance_id = Attendance::findByUserOfDate($id, Carbon::yesterday(), ['end_time', null])->latest()->first()->id ?? 0;

        //休憩中だった場合はエラーメッセージを返す
        if (!is_null(Rest::findAtteId($attendance_id)->latest()->first())) {
            return redirect('/')->with(['message' => '現在休憩開始中です。休憩終了してから退勤ボタンを押してください(51)']);
        }

        //前日の'end_time'がnullだった場合は日付を跨いで退勤する。updateの場合もifでエラー回避を行うこと
        if (!is_null(Attendance::findByUserOfDate($id, Carbon::yesterday(), ['end_time', null])->latest()->first())) {
            if (!Attendance::findByUserOfDate($id, Carbon::yesterday(), ['end_time', null])->first()->update(['end_time' => '23:59:59'])) {
                return redirect('/')->with(['message' => '打刻に失敗しました(57)']);
            }
            if (!Attendance::create([
                'user_id' => $id,
                'date' => Carbon::today(),
                'start_time' => '00:00:00',
                'end_time' => Carbon::now()
            ])) {
                return redirect('/')->with(['message' => '打刻に失敗しました(65)']);
            }

            return redirect('/')->with(['message' => '日付を跨いでの退勤時刻の打刻が完了しました']);
        }

        $attendance_id = Attendance::findByUserOfDate($id, Carbon::today(), ['end_time', null])->latest()->first()->id ?? 0;
        //休憩中だった場合はエラーメッセージを返す
        if (!is_null(Rest::findAtteId($attendance_id)->latest()->first())) {
            return redirect('/')->with(['message' => '現在休憩開始中です。休憩終了してから退勤ボタンを押してください']);
        }

        //当日のレコードの'end_time'に退勤時刻を入れてupdate
        if (!Attendance::findByUserOfDate($id, Carbon::today(), ['end_time', null])->update(['end_time' => Carbon::now()])) {
            return redirect('/')->with(['message' => '打刻に失敗しました()79']);
        }
        return redirect('/')->with(['message' => '同日内での退勤時刻の打刻が完了しました']);
    }


    public function restIn()
    {
        //ログインしているユーザーidを変数に定義する
        $id = Auth::user()->id;
        $message = '同日内での';
        //今日の勤務開始しているか Attendancesテーブルの当日のレコードの'start_time'がなかった場合はエラーメッセージを返す
        if (!is_null(Attendance::findByUserOfDate($id, Carbon::today(), ['start_time', null])->first())) {
            return redirect('/')->with(['message' => 'まだ本日の出勤打刻がありません(92)']);
        }


        if (!is_null($date1 = Attendance::findByUserOfDate($id, Carbon::yesterday(), ['end_time', null])->first())) {
//dd($date1);

            if (!Attendance::findByUserOfDate($id, Carbon::yesterday(), ['end_time', null])->first()->update(['end_time' => '23:59:59'])) {
                return redirect('/')->with(['message' => '打刻に失敗しました(131)']);
            }
            if (!Attendance::create([
                'user_id' => $id,
                'date' => Carbon::today(),
                'start_time' => '00:00:00'
            ])) {
                return redirect('/')->with(['message' => '打刻に失敗しました(138)']);
            }
            $message = '日を跨いでの';
        }

        if (is_null(Attendance::findByUserOfDate($id, Carbon::today(), ['end_time', null])->first())) {
            return redirect('/')->with(['message' => '休憩開始に失敗しました(96)']);
        }

        //前回の休憩が終わっているかどうか
        $attendance_id = Attendance::findByUserOfDate($id, Carbon::today(), ['end_time', null])->latest()->first()->id;
        if (!is_null($rest = Rest::findAtteId($attendance_id)->latest()->first())) {
            return redirect('/')->with(['message' => '既に休憩開始中です。休憩終了が押されていません']);
        }
        //休憩開始時刻をcreate
        if (!Rest::create([
            'attendance_id' => $attendance_id,//idの取得はcontrollerにて
            'start_time' => Carbon::now(),
        ])) {
            return redirect('/')->with(['message' => '休憩打刻に失敗しました(109)']);
        }

        return redirect('/')->with(['message' => $message.'休憩に入りました']);
    }


    public function restOut()
    {
        //ログインしているユーザーidを変数に定義する
        $id = Auth::user()->id;

        //昨日の勤怠が終了しているか確認する
        if (!is_null(Attendance::findByUserOfDate($id, Carbon::yesterday(), ['end_time', null])->first())) {
            //昨日の勤怠が終了していなかった場合は昨日のattendance_idをセットする
            $attendance_id = Attendance::findByUserOfDate($id, Carbon::yesterday(), ['end_time', null])->latest()->first()->id;
            //昨日の昨日から今日にかけて取得中の休憩が無いか
            if ($rest = Rest::findAtteId($attendance_id, ['end_time', null])->first()) {
                if (!Rest::findAtteId($attendance_id)->first()->update(['end_time' => '23:59:59'])) {
                    return redirect('/')->with(['message' => '休憩打刻に失敗しました(128)']);
                }
                if (!Attendance::findByUserOfDate($id, Carbon::yesterday(), ['end_time', null])->first()->update(['end_time' => '23:59:59'])) {
                    return redirect('/')->with(['message' => '打刻に失敗しました(131)']);
                }
                if (!Attendance::create([
                    'user_id' => $id,
                    'date' => Carbon::today(),
                    'start_time' => '00:00:00'
                ])) {
                    return redirect('/')->with(['message' => '打刻に失敗しました(138)']);
                }
                $attendance_id = Attendance::findByUserOfDate($id, Carbon::today(), ['end_time', null])->latest()->first()->id;
                if (!Rest::create([
                    'attendance_id' => $attendance_id,//idの取得はcontrollerにて
                    'start_time' => '00:00:00',
                    'end_time' => Carbon::now()
                ])) {
                    return redirect('/')->with(['message' => '休憩休憩打刻に失敗しました(146)']);
                }
                return redirect('/')->with(['message' => '日付を跨いでの休憩取得が完了しました']);
            }
        }

        $attendance_id = Attendance::findByUserOfDate($id, Carbon::today(), ['end_time', null])->first()->id ?? 0;
        if (is_null(Rest::findAtteId($attendance_id)->latest()->first())) {
            return redirect('/')->with(['message' => '休憩が開始されていません(154)']);
        }
        if (!Rest::findAtteId($attendance_id)->first()->update(['end_time' => Carbon::now()])) {
            return redirect('/')->with(['message' => '休憩休憩打刻に失敗しました(157)']);
        }
        return redirect('/')->with(['message' => '休憩が終了しました']);
    }
}
