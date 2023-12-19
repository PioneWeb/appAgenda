<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_id',
        'user_id',
    ];

    public function user(){
        return $this->hasOne(User::class,"id","user_id");
    }

    public function team(){
        return $this->hasOne(Team::class,"id","team_id");
    }

}
