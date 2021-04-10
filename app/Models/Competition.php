<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Competition
 *
 * @package App\Domains\Competition
 * @property string type
 * @property string date
 * @method static Builder| Competition whereType($value)
 * @method static Builder| Competition whereDate($value)
 */
class Competition extends MainModel
{
    use HasFactory;

    protected $fillable = [
        'type',
        'date',
    ];

    protected $casts = [
        'date' => 'date:d/m/Y',
    ];

    public function runners()
    {
        return $this->belongsToMany(Runner::class, 'runner_competitions');
    }
}
