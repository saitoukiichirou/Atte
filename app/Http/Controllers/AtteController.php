<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Attendance;
use App\Models\Rest;
use Carbon\Carbon;

class AtteController extends Controller
{
    //打刻ボタンの活性・非活性をcontroller側にてできるようにする
    public function index()
    {
        $id = Auth::user()->id;
        $attendance_id = Attendance::where([['user_id', $id], ['date', Carbon::today()]])->first()->id ?? 0;
        if ($attendance_id == 0) {
            $attendance_id = Attendance::where([['user_id', $id], ['date', Carbon::yesterday()]])->first()->id ?? 0;
        }
        $attendance_status = 10;

        if (is_null(Attendance::where([['user_id', $id], ['date', Carbon::today()]])->first())) {//今日の勤怠情報が何も無い時
            //パターン1：出勤が押せる
            $attendance_status = 11;
            if (!is_null(Attendance::findByUserIdAndDate($id, Carbon::yesterday(), ['end_time', null])->first())) {
                //パターン2：退勤が押せる（日跨ぎ）
                $attendance_status = 12;
            }
        }

        if (!is_null(Attendance::findByUserIdAndDate($id, Carbon::today(), ['end_time', null])->first())) {
            //パターン3：退勤が押せる（同日内）
            $attendance_status = 13;
        }

        if (is_null($rest1 = Rest::findAtteId($attendance_id)->first())) {
            //パターン5：休憩開始が押せる
            $rest_status = 21;
        }
        if (!is_null(Rest::findAtteId($attendance_id)->first())) {
            //パターン4：休憩終了が押せる
            $rest_status = 22;
        }
        return view('dashboard', compact('attendance_status', 'rest_status'));
    }

    public function punchIn()
    {
        //ログインしているユーザーidを変数に定義する
        $id = Auth::user()->id;

        //同日の打刻が既にあるか確認する, 打刻が無ければ出勤の打刻をする
        if (!is_null(Attendance::findByUserIdAndDate($id, Carbon::yesterday(), ['end_time', null])->first())) {
            return redirect('/')->with(['message' => '先に昨日の退勤をしてください']);
        }

        if (!is_null(Attendance::findByUserIdAndDate($id, Carbon::today(), ['start_time', 'LIKE', '%'])->first())) {
            return redirect('/')->with(['message' => '既に本日の出勤打刻が有ります']);
        }

        if (!Attendance::create(['user_id' => $id, 'date' => Carbon::today(), 'start_time' => Carbon::now()])) {
            return redirect('/')->with(['message' => '打刻に失敗しました']);
        }

        return redirect('/')->with(['message' => '出勤時刻の打刻が完了しました']);
    }

    public function punchOut()
    {
        $id = Auth::user()->id;
        $attendance_id = Attendance::findByUserIdAndDate($id, Carbon::yesterday(), ['end_time', null])->latest()->first()->id ?? 0;

        //休憩中だった場合はエラーメッセージを返す
        if (!is_null(Rest::findAtteId($attendance_id)->latest()->first())) {
            return redirect('/')->with(['message' => '現在休憩開始中です。休憩終了してから退勤ボタンを押してください']);
        }

        //前日の'end_time'がnullだった場合は日付を跨いで退勤する, 失敗時はエラーメッセージを返す
        if (!is_null(Attendance::findByUserIdAndDate($id, Carbon::yesterday(), ['end_time', null])->latest()->first())) {
            if (!Attendance::findByUserIdAndDate($id, Carbon::yesterday(), ['end_time', null])->first()->update(['end_time' => '23:59:59'])) {
                return redirect('/')->with(['message' => '打刻に失敗しました']);
            }
            if (!Attendance::create([
                'user_id' => $id,
                'date' => Carbon::today(),
                'start_time' => '00:00:00',
                'end_time' => Carbon::now()
            ])) {
                return redirect('/')->with(['message' => '打刻に失敗しました']);
            }

            return redirect('/')->with(['message' => '日付を跨いでの退勤時刻の打刻が完了しました']);
        }

        $attendance_id = Attendance::findByUserIdAndDate($id, Carbon::today(), ['end_time', null])->latest()->first()->id ?? 0;

        //休憩中だった場合はエラーメッセージを返す
        if (!is_null(Rest::findAtteId($attendance_id)->latest()->first())) {
            return redirect('/')->with(['message' => '現在休憩開始中です。休憩終了してから退勤ボタンを押してください']);
        }

        //当日のレコードの'end_time'に退勤時刻を入れてupdate, 失敗時はエラーメッセージを返す
        if (!Attendance::findByUserIdAndDate($id, Carbon::today(), ['end_time', null])->update(['end_time' => Carbon::now()])) {
            return redirect('/')->with(['message' => '打刻に失敗しました']);
        }
        return redirect('/')->with(['message' => '退勤時刻の打刻が完了しました。お疲れ様でした！']);
    }


    public function restIn()
    {
        //ログインしているユーザーidを変数に定義する
        $id = Auth::user()->id;
        $message = '同日内での';

        //今日の勤務開始しているか Attendancesテーブルの当日のレコードの'start_time'がなかった場合はエラーメッセージを返す
        if (!is_null(Attendance::findByUserIdAndDate($id, Carbon::today(), ['start_time', null])->first())) {
            return redirect('/')->with(['message' => 'まだ本日の出勤打刻がありません']);
        }

        if (!is_null(Attendance::findByUserIdAndDate($id, Carbon::yesterday(), ['end_time', null])->first())) {

            if (!Attendance::findByUserIdAndDate($id, Carbon::yesterday(), ['end_time', null])->first()->update(['end_time' => '23:59:59'])) {
                return redirect('/')->with(['message' => '打刻に失敗しました']);
            }
            if (!Attendance::create([
                'user_id' => $id,
                'date' => Carbon::today(),
                'start_time' => '00:00:00'
            ])) {
                return redirect('/')->with(['message' => '打刻に失敗しました']);
            }
            $message = '日を跨いでの';
        }

        if (is_null(Attendance::findByUserIdAndDate($id, Carbon::today(), ['end_time', null])->first())) {
            return redirect('/')->with(['message' => '休憩開始に失敗しました']);
        }

        //前回の休憩が終わっているかどうか
        $attendance_id = Attendance::findByUserIdAndDate($id, Carbon::today(), ['end_time', null])->latest()->first()->id;
        if (!is_null($rest = Rest::findAtteId($attendance_id)->latest()->first())) {
            return redirect('/')->with(['message' => '既に休憩開始中です。休憩終了が押されていません']);
        }

        //休憩開始時刻をcreate, 失敗時はエラーメッセージを返す
        if (!Rest::create([
            'attendance_id' => $attendance_id,
            'start_time' => Carbon::now(),
        ])) {
            return redirect('/')->with(['message' => '休憩打刻に失敗しました']);
        }

        return redirect('/')->with(['message' => $message . '休憩に入りました']);
    }


    public function restOut()
    {
        //ログインしているユーザーidを変数に定義する
        $id = Auth::user()->id;

        //昨日の勤怠が終了しているか確認する
        if (!is_null(Attendance::findByUserIdAndDate($id, Carbon::yesterday(), ['end_time', null])->first())) {

            //昨日の勤怠が終了していなかった場合は昨日のattendance_idをセットする
            $attendance_id = Attendance::findByUserIdAndDate($id, Carbon::yesterday(), ['end_time', null])->latest()->first()->id;

            //昨日の昨日から今日にかけて取得中の休憩が無いか
            if (Rest::findAtteId($attendance_id, ['end_time', null])->first()) {
                if (!Rest::findAtteId($attendance_id)->first()->update(['end_time' => '23:59:59'])) {
                    return redirect('/')->with(['message' => '休憩打刻に失敗しました']);
                }
                if (!Attendance::findByUserIdAndDate($id, Carbon::yesterday(), ['end_time', null])->first()->update(['end_time' => '23:59:59'])) {
                    return redirect('/')->with(['message' => '打刻に失敗しました']);
                }
                if (!Attendance::create([
                    'user_id' => $id,
                    'date' => Carbon::today(),
                    'start_time' => '00:00:00'
                ])) {
                    return redirect('/')->with(['message' => '打刻に失敗しました']);
                }
                $attendance_id = Attendance::findByUserIdAndDate($id, Carbon::today(), ['end_time', null])->latest()->first()->id;
                if (!Rest::create([
                    'attendance_id' => $attendance_id,
                    'start_time' => '00:00:00',
                    'end_time' => Carbon::now()
                ])) {
                    return redirect('/')->with(['message' => '休憩休憩打刻に失敗しました']);
                }
                return redirect('/')->with(['message' => '日付を跨いでの休憩取得が完了しました']);
            }
        }

        $attendance_id = Attendance::findByUserIdAndDate($id, Carbon::today(), ['end_time', null])->first()->id ?? 0;
        if (is_null(Rest::findAtteId($attendance_id)->latest()->first())) {
            return redirect('/')->with(['message' => '休憩が開始されていません']);
        }
        if (!Rest::findAtteId($attendance_id)->first()->update(['end_time' => Carbon::now()])) {
            return redirect('/')->with(['message' => '休憩休憩打刻に失敗しました']);
        }
        return redirect('/')->with(['message' => '休憩が終了しました']);
    }
}
