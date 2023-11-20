<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class event extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "doctor_id",
        "patient_id",
        "clinic_id",
        'denominazione',
        'data',
        'ora',
        'stato',
        'created_at',
        'updated_at'
    ];


    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        "doctor_id" => 'int',
        "patient_id" => 'int',
        "clinic_id" => 'int',
        'denominazione' => 'int',
        'data' => 'date',
        'ora' => 'datetime',
        'stato' => 'int',
        'created_at' => 'date',
        'updated_at' => 'date'
    ];



    public function doctor(){
        return $this->belongsTo(User::class, 'doctor_id','id');
    }

    public function patient(){
        return $this->belongsTo(User::class, 'patient_id','id');
    }

    public function clinic(){
        return $this->belongsTo(Clinics::class, 'clinic_id','id');
    }

}
