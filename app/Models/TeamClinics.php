<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamClinics extends Model
{
    use HasFactory;

    protected $fillable = [
        "team_id",
        "clinic_id",
    ];

    public function clinic(){
        return $this->hasOne(Clinics::class,"id","clinic_id");
    }

    public function team(){
        return $this->hasOne(Team::class,"id","team_id");
    }
}
