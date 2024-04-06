<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
            "doctor_id",
            "schedule_time_id",
            "day",
            "max_patient",
            "end_date",
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class,'doctor_id');
    }

    public function schedule_time()
    {
        return $this->belongsTo(ScheduleTime::class,'schedule_time_id');
    }
}
