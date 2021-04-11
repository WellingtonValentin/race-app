<?php

namespace App\Services;

use App\Models\Competition;
use App\Models\RunnerCompetition;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;

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

        if ($this->findSamePeriodCompetition($model)) {
            throw new \RuntimeException(
                'Este competidor já está cadastrado em uma competição nesta data',
                Response::HTTP_BAD_REQUEST
            );
        }

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

        if ($this->findSamePeriodCompetition($model)) {
            throw new \RuntimeException(
                'Este competidor já está cadastrado em uma competição nesta data',
                Response::HTTP_BAD_REQUEST
            );
        }

        $model->save();

        return $model;
    }

    /**
     * @param RunnerCompetition $model
     * @param array $data
     *
     * @return void
     */
    public function fill(&$model, $data)
    {
        $model->runner_id = isset($data['runner']) ? $data['runner']['id'] : (
        $data['runner_id'] ? $data['runner_id'] : null
        );
        $model->competition_id = isset($data['competition']) ? $data['competition']['id'] : (
        $data['competition_id'] ? $data['competition_id'] : null
        );
    }

    private function findSamePeriodCompetition($model)
    {
        $competition = Competition::find($model->competition_id);
        $date = Carbon::parse($competition->date)->format('d-m-Y');
        return RunnerCompetition
            ::whereRunnerId($model->runner_id)
            ->where('competition_id', '!=', $model->competition_id)
            ->whereHas('competition', function ($relationship) use ($date) {
                $relationship->where('date', $date);
            })
            ->first();
    }
}
