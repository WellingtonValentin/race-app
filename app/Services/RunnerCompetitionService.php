<?php
namespace App\Services;

use App\Models\RunnerCompetition;
use Illuminate\Database\Eloquent\Model;

class RunnerCompetitionService extends CRUDService
{
    protected $modelClass = RunnerCompetition::class;

    /**
     * @param array $data
     * @return RunnerCompetition
     */
    public function create($data): RunnerCompetition
    {
        $model = new RunnerCompetition();
        $this->fill($model, $data);
        $model->save();

        return $model;
    }

    /**
     * @param Model $data
     * @param RunnerCompetition $model
     * @return RunnerCompetition
     */
    public function update($data, $model): RunnerCompetition
    {
        $this->fill($model, $data->toArray());
        $model->save();

        return $model;
    }

    /**
     * @param RunnerCompetition $model
     * @param array  $data
     *
     * @return void
     */
    public function fill(& $model, $data)
    {
        $model->runner_id = isset($data['runner']) ? $data['runner']['id'] : (
            $data['runner_id'] ? $data['runner_id'] : null
        );
        $model->competition_id =  isset($data['competition']) ? $data['competition']['id'] : (
            $data['competition_id'] ? $data['competition_id'] : null
        );
    }
}
