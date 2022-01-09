<?php

namespace App\Models;

use Carbon\Carbon;
use Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rest extends Model
{
    use HasFactory;

    protected $fillable = ['attendance_id','start_time', 'end_time', 'created_at', 'updated_at'];

    public function scopeFindAtteId($query, $attendance_id)
    {
        $query->where([
            ['attendance_id', $attendance_id],
            ['end_time', null]
        ]);
    }


    public function attendance()
    {
        $this->belongsTo(Attendance::class);
    }
}
