<?php

namespace App\Models;

use Database\Factories\TicketFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

/**
 * App\Models\Ticket
 *
 * @property int $id
 * @property string|null $ticket
 * @property Carbon|null $data
 * @property Carbon|null $ora
 * @property string|null $note
 * @property bool $stato
 * @property int|null $user_id
 * @property int|null $customer_id
 * @property int|null $service_id
 * @property int|null $ticket_type_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User|null $customer
 * @property-read DatabaseNotificationCollection<int, DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read Service|null $service
 * @property-read TicketType|null $ticketType
 * @property-read User|null $user
 * @method static TicketFactory factory($count = null, $state = [])
 * @method static Builder|Ticket newModelQuery()
 * @method static Builder|Ticket newQuery()
 * @method static Builder|Ticket query()
 * @method static Builder|Ticket whereCreatedAt($value)
 * @method static Builder|Ticket whereCustomerId($value)
 * @method static Builder|Ticket whereData($value)
 * @method static Builder|Ticket whereId($value)
 * @method static Builder|Ticket whereNote($value)
 * @method static Builder|Ticket whereOra($value)
 * @method static Builder|Ticket whereServiceId($value)
 * @method static Builder|Ticket whereStato($value)
 * @method static Builder|Ticket whereTicket($value)
 * @method static Builder|Ticket whereTicketTypeId($value)
 * @method static Builder|Ticket whereUpdatedAt($value)
 * @method static Builder|Ticket whereUserId($value)
 * @property-read Collection<int, Message> $messages
 * @property-read int|null $messages_count
 * @property-read Collection<int, TicketUser> $ticketUser
 * @property-read int|null $ticket_user_count
 * @property-read Collection<int, TicketUser> $userTicket
 * @property-read int|null $user_ticket_count
 * @mixin \Eloquent
 */
class Ticket extends Model
{
    use Notifiable;
    use HasFactory;

    public $timestamps = true;
    protected $table = 'tickets';
    protected $primaryKey = 'id';
    protected $guarded = [
        'id'
    ];
    protected $casts = [
        'data' => 'date',
        'ora' => 'date:h:i:s',
        'indirizzo' => 'string',
        'ticket' => 'string',
        'ticket_type_id' => 'int',
        'service_id' => 'int',
        'note' => 'string',
        'stato' => 'boolean',
        'company_id' => 'int',
        'user_id' => 'int'
    ];
    protected $fillable = [
        'ticket',
        'data',
        'ora',
        'ticket_type_id',
        'service_id',
        'note',
        'stato',
        'customer_id',
        'user_id'
    ];

    protected $appends = [
        'users_id'
    ];

    public function users(){
        return $this->belongsToMany(User::class,'ticket_users');
    }
    public function customer(){
        return $this->belongsTo(User::class, "customer_id", "id");
    }
    public function service(){
        return $this->belongsTo(Service::class, "service_id", "id");
    }
    public function ticketType(){
        return $this->belongsTo(TicketType::class, "ticket_type_id", "id");
    }
    public function ticketUser(){
        return $this->hasMany(TicketUser::class, "ticket_id", "id");
    }
    public function messages(){
        return $this->hasMany(Message::class, "ticket_id", "id");
        //return $this->hasMany(Message::class, "ticket_id", "id")->orderBy('id', 'desc');
    }

    public function getUsersIdAttribute() {
        return $this->users->map(function ($item) { return $item->id; });
    }

}
