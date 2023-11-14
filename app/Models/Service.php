<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Service
 *
 * @property int $id
 * @property string $name
 * @property int|null $company_id
 * @property int $priority
 * @property-read \App\Models\Company|null $company
 * @method static \Illuminate\Database\Eloquent\Builder|Service newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Service newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Service query()
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service wherePriority($value)
 * @mixin \Eloquent
 */
class Service extends Model
{
    //use HasFactory;

    public function company(){
        return $this->belongsTo(Company::class);
    }
    protected $casts = [
        'id' => 'int',
        'name' => 'string',
        'priority' => 'int'
        ];
    protected $fillable = [
        'name',
        'company_id',
        'priority',
    ];
}
