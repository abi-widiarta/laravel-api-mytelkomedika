<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'reservation_id',
        'weight',
        'height',
        'temperature',
        'initial_complaint',
        'diagnosis',
        'recommendations',
        'medications',
        'sick_note',
    ]; 

    public function reservation(): BelongsTo
    {
        return $this->belongsTo(Reservation::class);
    }

    public function review(): HasOne
    {
        return $this->hasOne(Review::class);
    }
}
