<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Message
 *
 * @property int $id
 * @property string $messaggio
 * @property int|null $ticket_id
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Message newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Message newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Message query()
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereMessaggio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereTicketId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereUserId($value)
 * @property-read \App\Models\User|null $user
 * @mixin \Eloquent
 */
class Message extends Model
{
    use HasFactory;

    public $timestamps = true;
    protected $table = 'messages';
    protected $primaryKey = 'id';
    protected $guarded = [
        'id'
    ];

    protected $casts = [
        'messaggio' => 'string',
        'ticket_id' => 'int',
        'user_id' => 'int'
    ];
    protected $fillable = [
        'messaggio',
        'ticket_id',
        'user_id'
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
}
