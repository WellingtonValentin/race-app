<?php
namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MainModel
 *
 * @package Modules\Auth\Domain
 * @property int id
 * @property Carbon|string|null created_at
 * @property Carbon|string|null updated_at
 * @property Carbon|string|null deleted_at
 * @method static Builder| MainModel filter($filters)
 * @method static Builder| MainModel query()
 * @method static Builder| MainModel newModelQuery()
 * @method static Builder| MainModel newQuery()
 * @method static Builder| MainModel onlyTrashed()
 * @method static Builder| MainModel withTrashed()
 * @method static Builder| MainModel withoutTrashed()
 * @method static bool|null restore()
 * @method static bool|null forceDelete()
 * @method static Builder| MainModel whereId($value)
 * @method static Builder| MainModel whereCreatedAt($value)
 * @method static Builder| MainModel whereUpdatedAt($value)
 * @method static Builder| MainModel whereDeletedAt($value)
 * @mixin Builder
 * @mixin Model
 */
class MainModel extends Model
{
    protected $dates = ['deleted_at'];

    /**
     * @param $query
     * @param $filters
     *
     * @return mixed
     */
    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }
}
