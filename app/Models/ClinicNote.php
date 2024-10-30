<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClinicNote extends Model
{
    use HasFactory;

    protected $table = 'clinic_notes';

    // Fillable fields for mass assignment
    protected $fillable = [
        'appointment_id',
        'dm',
        'ht',
        'bp',
        'pc',
    ];

    // Define relationships if necessary
    public function appointment()
    {
        return $this->belongsTo(Appoinment::class);
    }
}
