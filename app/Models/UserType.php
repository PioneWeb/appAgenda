<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class UserType extends Model
{
    use Notifiable;
    use HasFactory;

    public $timestamps = true;
    protected $table = 'user_types';
    protected $primaryKey = 'id';
    protected $guarded = [
        'id'
    ];
    protected $fillable = [
        'descrizione'
    ];

}
