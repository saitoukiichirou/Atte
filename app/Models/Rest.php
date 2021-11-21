<?php

namespace App\Models;

use Carbon\Carbon;
use Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rest extends Model
{
    use HasFactory;

//    protected $guarded = ['id'];
        protected $fillable = ['attendance_id','start_time', 'end_time', 'created_at', 'updated_at'];

    public function scopeFindAtteId($query, $attendance_id)
    {
//        $attendance_id = Attendance::findByUserOfDate()->latest()->first()->id;//idの取得はcontrollerにて. ModelからModelを呼び出すな
        $query->where([
            ['attendance_id', $attendance_id],
            ['end_time', null]
        ]);
    }

//    public function scopeCreateRestStart($query, $start_time)
//    {
//        $query->create([
//            'attendance_id' => Attendance::whereUserToday()->latest()->first()->id,//idの取得はcontrollerにて
//            'start_time' => $start_time,
//        ]);
//    }

    public function attendance()
    {
        $this->belongsTo(Attendance::class);
    }
}
