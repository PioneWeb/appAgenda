<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\TicketType
 *
 * @property int $id
 * @property string $nome
 * @property int $priority
 * @property int $company_id
 * @property-read \App\Models\Company $company
 * @method static \Illuminate\Database\Eloquent\Builder|TicketType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TicketType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TicketType query()
 * @method static \Illuminate\Database\Eloquent\Builder|TicketType whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TicketType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TicketType whereNome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TicketType wherePriority($value)
 * @mixin \Eloquent
 */
class TicketType extends Model
{
    use HasFactory;

    public function company(){
        return $this->belongsTo(Company::class);
    }
    protected $casts = [
        'id' => 'int',
        'nome' => 'string',
        'priority' => 'int'
    ];
    protected $fillable = [
        'nome',
        'company_id',
        'priority',
    ];
}
