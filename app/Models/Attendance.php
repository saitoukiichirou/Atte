<?php

namespace App\Models;

use Carbon\Carbon;
use Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

//    protected $guarded = ['id'];
    protected $fillable = ['user_id','date','start_time','end_time',];//'id',


    public static $rules = array(
        'id' => 'required',
        'date' => 'date',
        'start_time' => 'time',
        'end_time' => 'time'
    );


    public function user()
    {
        $this->belongsTo(User::class);
    }

    public function rest()
    {
        return $this->hasMany(rest::class);
    }

    public function scopeFindByUserOfDate($query, $id, $date, $time)//scope名変更済み$start_time, $end_time
    {
        $query->where([
            ['user_id', $id],
            ['date', $date],
            $time
        ]);
    }


    public function scopeWhereUserYesterday($query)
    {
        $query->where([
            ['user_id', Auth::user()->id],
            ['date', Carbon::yesterday()],
            ['end_time', null]
        ]);
    }
    public function scopeWhereTodayAtte($query)//未完成
    {
        $query->where([
            ['user_id', Auth::user()->id],
            ['date', Carbon::today()]
        ]);
    }

}
