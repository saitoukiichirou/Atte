<?php

namespace App\Http\Controllers;

use Auth;
use App\Libraries\Common;
use App\Models\User;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DateController extends Controller
{
    public function index(Request $request)
    {
        $date = Carbon::today();
        $param_date = $request->date;

        //例外処理, $requestがdate型以外の場合は,redirect()->back()で前ページに戻す
        try {
            if (is_null($request->date)) {
                $param_date = $date;
            } else {
                $param_date = new Carbon($param_date);
            }
        } catch (\Exception $e) {
            return redirect()->back();
        }
        //$param_dateで指定された日付の全員のレコードを取得する, かつページネーション5件毎
        $attendances = Attendance::where('date', $param_date)->paginate(5);
        $attendances_day = Common::workTimeCalculation($attendances);

        return view('attendance', compact('date', 'attendances_day', 'param_date'));
    }

    public function usersList()
    {
        $users = User::paginate(10);
        return view('users', compact('users'));
    }

    public function userMonthAtte(Request $request)
    {
        $param_date = Carbon::today();
        $user_id = $request->id;
        $param_month = $request->month;

        //例外処理, $request->idがUserテーブルに存在しない場合はredirect()->back()で前ページに戻す
        if (!User::find($user_id)) {
            return redirect()->back();
        }
        //例外処理,$request->dateがdate型以外の場合はredirect()->back()で前ページに戻す
        try {
            if (is_null($param_month)) {
                $param_month = $param_date;
            } else {
                $param_month = new Carbon($param_month);
            }
        } catch (\Exception $e) {
            return redirect()->back();
        }
        $param_month_format = $param_month->format('Y-m');

        //指定されたuser_id, 且つ指定されたparam_monthの月のレコードを検索する, ページネーションは10件ごと
        $attendances = Attendance::where([['user_id', $user_id], ['date', 'like', $param_month_format . "%"]])->paginate(10);
        $attendances_user_month = Common::workTimeCalculation($attendances);
        $user_name = User::find($user_id)->name;

        return view('month', compact('attendances_user_month', 'param_month', 'user_id', 'user_name'));
    }
}
