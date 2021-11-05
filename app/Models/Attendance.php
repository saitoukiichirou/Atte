<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
//    protected $fillable = ['id','user_id','date','start_time','end_time',];

    public static $rules = array(
        'id' => 'required',
        'date' => 'date',
        'start_time' => 'time',
        'end_time' => 'time'
    );

//    Attendance::create([
//        'start_time'=> Carbon::now();
//        ])

    public function user()
    {
        $this->belongsTo(User::class);
    }

    public function dt()
    {
//        $dt = Carbon::now();
//        date = $dr->month, day;
    }


    public function rest()
    {
        return $this->hasMany(rest::class);
    }
}
