<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appoinment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'procedure_amount',
        'procedure_name',
        'amount',
        'total_amount',
        'appointment_date'
    ];

    // Relationships
    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function medicines()
    {
        return $this->belongsToMany(Medicine::class, 'appointment_medicine', 'appointment_id', 'medicine_id')->withPivot('days');
    }

    public function labTests()
    {
        return $this->belongsToMany(Lab::class, 'appointment_lab_test', 'appointment_id', 'lab_test_id');
    }



    public function clinicNotes()
    {
        return $this->hasOne(ClinicNote::class, 'appointment_id'); // Change to hasOne since each appointment has one clinic note
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class, 'appointment_id');
    }
}
