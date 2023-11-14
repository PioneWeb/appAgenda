<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CompanyService
 *
 * @property int $company_id
 * @property int $service_id
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyService newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyService newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyService query()
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyService whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyService whereServiceId($value)
 * @mixin \Eloquent
 */
class CompanyService extends Model
{
    use HasFactory;
}
