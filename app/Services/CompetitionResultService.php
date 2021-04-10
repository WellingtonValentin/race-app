<?php
namespace App\Services;

use App\Models\CompetitionResult;
use Illuminate\Database\Eloquent\Model;

class CompetitionResultService extends CRUDService
{
    protected $modelClass = CompetitionResult::class;

    /**
     * @param array $data
     * @return CompetitionResult
     */
    public function create($data): CompetitionResult
    {
        $model = new CompetitionResult();
        $this->fill($model, $data);
        $model->save();

        return $model;
    }

    /**
     * @param Model $data
     * @param CompetitionResult $model
     * @return CompetitionResult
     */
    public function update($data, $model): CompetitionResult
    {
        $this->fill($model, $data->toArray());
        $model->save();

        return $model;
    }

    /**
     * @param CompetitionResult $model
     * @param array  $data
     *
     * @return void
     */
    public function fill(& $model, $data)
    {
        $model->runner_start_time = $data['runner_start_time'];
        $model->runner_end_time = $data['runner_end_time'];
        $model->runner_id = isset($data['runner']) ? $data['runner']['id'] : (
            $data['runner_id'] ? $data['runner_id'] : null
        );
        $model->competition_id =  isset($data['competition']) ? $data['competition']['id'] : (
            $data['competition_id'] ? $data['competition_id'] : null
        );
    }
}
