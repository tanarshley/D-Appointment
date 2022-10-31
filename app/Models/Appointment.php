<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = ['patient_id', 'patient_name', 'doctor_id', 'doctor_name', 'appointment_date', 'appointment_time', 'appointment_status'];

    public function getKeyName(){
        return "appointment_id";
    }
}
