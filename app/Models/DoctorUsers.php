<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorUsers extends Model
{
    use HasFactory;
    protected $fillable = [
        'doctor_id',
        'user_id',
    ];

    public function user(){
        return $this->hasOne(User::class,"id","user_id");
    }

    public function doctor(){
        return $this->hasOne(User::class,"id","doctor_id");
    }
}
