<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'start_hour',
        'end_hour',
        'status',
        'initial_complaint',
        'queue_number',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class,'patient_id');
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class,'doctor_id');
    }

    public function report(): HasOne
    {
        return $this->hasOne(Report::class);
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }
}
