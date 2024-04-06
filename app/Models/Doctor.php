<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Doctor extends Authenticatable
{
    use HasApiTokens,HasFactory,Notifiable;

    protected $fillable = [
            "name",
            "email",
            "username",
            "password",
            "specialization",
            "status",
            "registration_number",
            "phone",
            "gender",
            "birthdate",
            "alamat",
            "address",
            "rating",
            "patient_total",
            "review_total",
            "image"
    ];

    public function schedule_time(): BelongsToMany
    {
        return $this->belongsToMany(ScheduleTime::class, 'doctor_schedules', 'doctor_id','schedule_time_id')->withPivot('day', 'end_date', 'max_patient');
    }

    public function patients(): BelongsToMany
    {
        return $this->belongsToMany(Patient::class, 'reservations', 'doctor_id', 'patient_id');
    }

    public function review(): HasMany
    {
        return $this->hasMany(Review::class);
    }
}
