<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CancelledAppointments extends Model
{
    use HasFactory;
    public function getKeyName(){
        return "cancelled_id";
    }
}
