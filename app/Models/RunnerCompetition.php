<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Collection;

/**
 * Class RunnerCompetition
 *
 * @package App\Domains\RunnerCompetition
 * @property integer runner_id
 * @property integer competition_id
 * @property Runner | Collection runner
 * @property Competition | Collection competition
 * @method static Builder| Runner whereRunnerId($value)
 * @method static Builder| Competition whereCompetitionId($value)
 */
class RunnerCompetition extends MainModel
{
    use HasFactory;

    public function runner()
    {
        return $this->belongsTo(Runner::class);
    }

    public function competition()
    {
        return $this->belongsTo(Competition::class);
    }
}
