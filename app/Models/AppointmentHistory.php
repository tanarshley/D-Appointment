<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentHistory extends Model
{
    use HasFactory;
    public function getKeyName(){
        return "app_history_id";
    }
}
