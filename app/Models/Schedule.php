<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "doctor_id",
        "clinic_id",
        'tipo',
        'quantita',
        'minuti',
        'giorno',
        'inizio',
        'attivo',
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
        "clinic_id" => 'int',
        'tipo' => 'int',
        'quantita' => 'int',
        'minuti' => 'int',
        'giorno' => 'int',
        'inizio' => 'string',
        'attivo' => 'int',
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
