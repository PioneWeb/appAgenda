<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clinics extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "doctor_id",
        "nome",
        "indirizzo",
        'localita',
        'cap',
        'attivo',
        'tipo',
        'provincia',
        'telefono',
        'cretaed_at',
        'updated_at'
    ];


    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [

        "doctor_id" => 'int',
        "nome" => 'string',
        "indirizzo" => 'string',
        'localita' => 'string',
        'cap' => 'string',
        'attivo' => 'boolean',
        'tipo' => 'int',
        'provincia' => 'string',
        'telefono' => 'string',
        'cretaed_at' => 'date',
        'updated_at' => 'date'
    ];

    public function doctor(){
        return $this->hasManyThrough(User::class,DoctorClinics::class,"clinic_id","id","id","doctor_id");
    }

}
