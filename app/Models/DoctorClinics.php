<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorClinics extends Model
{
    use HasFactory;


    public function clinic(){
        return $this->hasOne(Clinics::class,"id","clinic_id");
    }

    public function doctor(){
        return $this->hasOne(User::class,"id","doctor_id");
    }
}
