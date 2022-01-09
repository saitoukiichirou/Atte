<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'date', 'start_time', 'end_time'];

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
        return $this->hasMany(Rest::class);
    }

    public function scopeFindByUserIdAndDate($query, $id, $date, $time)
    {
        $query->where([
            ['user_id', $id],
            ['date', $date],
            $time
        ]);
    }
}
