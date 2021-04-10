<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Class CompetitionResult
 *
 * @package App\Domains\CompetitionResult
 * @property integer runner_id
 * @property integer competition_id
 * @property string runner_start_time
 * @property string runner_end_time
 * @property Runner | Collection runner
 * @property Competition | Collection competition
 * @method static Builder| Runner whereRunnerId($value)
 * @method static Builder| Competition whereCompetitionId($value)
 */
class CompetitionResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'runner_id',
        'competition_id',
        'runner_start_time',
        'runner_end_time',
    ];

    protected $casts = [
        'runner_start_time' => 'date:H:i:s',
        'runner_end_time' => 'date:H:i:s',
    ];

    public function runner()
    {
        return $this->belongsTo(Runner::class);
    }

    public function competition()
    {
        return $this->belongsTo(Competition::class);
    }
}
