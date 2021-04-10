<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class Runner
 *
 * @package App\Domains\Runner
 * @property string name
 * @property string document
 * @property string birth_date
 * @method static Builder| Runner whereName($value)
 * @method static Builder| Runner whereDocument($value)
 * @method static Builder| Runner whereBirthDate($value)
 */
class Runner extends MainModel
{
    use HasFactory;

    protected $fillable = [
        'name',
        'document',
        'birth_date',
    ];

    protected $casts = [
        'birth_date' => 'date:d/m/Y',
    ];
}
