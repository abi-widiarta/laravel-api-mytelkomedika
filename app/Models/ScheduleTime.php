<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ScheduleTime extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_hour',
        'end_hour',
    ];

    public function doctors(): BelongsToMany
    {
        return $this->belongsToMany(Doctor::class, 'doctor_schedules','schedule_time_id','doctor_id');
    }
}
