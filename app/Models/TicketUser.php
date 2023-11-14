<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\TicketUser
 *
 * @property int $id
 * @property int|null $ticket_id
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Ticket> $tickets
 * @property-read int|null $tickets_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|TicketUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TicketUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TicketUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|TicketUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TicketUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TicketUser whereTicketId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TicketUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TicketUser whereUserId($value)
 * @mixin \Eloquent
 */
class TicketUser extends Model
{
    //use HasFactory;

    protected $fillable = [
        'ticket_id',
        'user_id',
    ];

    public function user(){
        return $this->hasOne(User::class,"id","user_id");
    }

    public function ticket(){
        return $this->hasOne(Ticket::class,"id","ticket_id");
    }
}
