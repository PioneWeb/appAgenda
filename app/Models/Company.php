<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

/**
 * App\Models\Company
 *
 * @property int $id
 * @property bool $attivo
 * @property string|null $email
 * @property string $ragione_sociale
 * @property string|null $localita
 * @property string|null $cap
 * @property string|null $provincia
 * @property string|null $logo
 * @property string|null $piva
 * @property string|null $iban
 * @property string|null $telefono
 * @property string|null $cellulare
 * @property string|null $codice_destinatario
 * @property string|null $pec
 * @property bool $privato
 * @property bool $pubblico
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Service> $services
 * @property-read int|null $services_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TicketType> $ticketType
 * @property-read int|null $ticket_type_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Ticket> $tickets
 * @property-read int|null $tickets_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $utenti
 * @property-read int|null $utenti_count
 * @method static \Database\Factories\CompanyFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Company newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Company newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Company query()
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereAttivo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereCap($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereCellulare($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereCodiceDestinatario($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereIban($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereLocalita($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company wherePec($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company wherePiva($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company wherePrivato($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereProvincia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company wherePubblico($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereRagioneSociale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereTelefono($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereUpdatedAt($value)
 * @property string|null $indirizzo
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereIndirizzo($value)
 * @mixin \Eloquent
 */
class Company extends Model
{
    use Notifiable;
    use HasFactory;

    public $timestamps = true;
    protected $table = 'companies';
    protected $primaryKey = 'id';
    protected $guarded = [
        'id'
    ];
    protected $casts = [
        'attivo' => 'boolean',
        'email' => 'string',
        'ragione_sociale' => 'string',
        'logo' => 'string',
        'piva' => 'string',
        'telefono' => 'string',
        'cellulare' => 'string',
        'codice_destinatario' => 'string',
        'pec' => 'string',
        'privato' => 'boolean',
        'pubblico' => 'boolean'
    ];
    protected $fillable = [
        'attivo',
        'email',
        'ragione_sociale',
        'logo',
        'piva',
        'telefono',
        'cellulare',
        'codice_destinatario',
        'pec',
        'privato',
        'pubblico'
    ];

    public function utenti()
    {
        return $this->hasMany(User::class);
    }
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function services(){
        return $this->hasManyThrough(Service::class, CompanyService::class,"company_id","id","id","service_id");
    }

    public function ticketType(){
        return $this->hasMany(TicketType::class);
    }
}
