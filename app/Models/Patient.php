<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Patient extends Authenticatable
{
    use HasApiTokens,HasFactory,Notifiable;
    public $timestamps = false;

    protected $fillable = [
        'username',
        'name',
        'email',
        'password',
        'student_id',
        'phone',
        'address',
        'gender',
        'birthdate'
    ];

    public function getRouteKeyName()
    {
        return 'username';
    }

    public function doctors(): BelongsToMany
    {
        return $this->belongsToMany(Doctor::class, 'reservations', 'patient_id','doctor_id');
    }
}
