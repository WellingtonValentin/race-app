<?php
namespace App\Services;

use App\Models\CompetitionResult;
use App\Models\RunnerCompetition;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CompetitionResultService extends CRUDService
{
    protected $modelClass = CompetitionResult::class;

    private $ageRanges = [
        '18 - 24 anos' => 24,
        '25 - 34 anos' => 34,
        '35 - 44 anos' => 44,
        '45 - 54 anos' => 54,
        'Acima de 55 anos' => 999,
    ];
    private $lastPositions = [];

    /**
     * @param array $data
     * @return CompetitionResult
     */
    public function create($data): CompetitionResult
    {
        $model = new CompetitionResult();
        $this->fill($model, $data);

        if (!$this->findCompetition($model)) {
            throw new \RuntimeException(
                'Este competidor não está cadastrado nesta competição',
                Response::HTTP_BAD_REQUEST
            );
        }

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

        if (!$this->findCompetition($model)) {
            throw new \RuntimeException(
                'Este competidor não está cadastrado nesta competição',
                Response::HTTP_BAD_REQUEST
            );
        }

        $model->save();

        return $model;
    }

    /**
     * @param CompetitionResult $model
     * @param array $data
     *
     * @return void
     */
    public function fill(&$model, $data)
    {
        $model->runner_start_time = $data['runner_start_time'];
        $model->runner_end_time = $data['runner_end_time'];
        $model->runner_id = isset($data['runner']) ? $data['runner']['id'] : (
        $data['runner_id'] ? $data['runner_id'] : null
        );
        $model->competition_id = isset($data['competition']) ? $data['competition']['id'] : (
        $data['competition_id'] ? $data['competition_id'] : null
        );
    }

    public function competitionClassification(Request $request)
    {
        $collection = $this->getClassification($request);

        return $collection->map(function ($row) {
            $row->runner->age = Carbon::parse($row->runner->birth_date)->age;
            if (empty($this->lastPositions[$row->competition->id])) {
                $this->lastPositions[$row->competition->id] = 1;
            }
            $row->position = $this->lastPositions[$row->competition->id];
            $this->lastPositions[$row->competition->id]++;
            $row->result_time = $this->getResultTime($row);
            return $row;
        })
            ->mapToGroups(function ($query, $key) {
                return [$query->competition->id => $query];
            })
            ->sortKeys();
    }

    public function competitionClassificationByAge(Request $request)
    {
        $collection = $this->getClassification($request);

        $collection = $collection->map(function ($row) {
            $row->runner->age = Carbon::parse($row->runner->birth_date)->age;
            foreach ($this->ageRanges as $key => $breakpoint) {
                if ($breakpoint > $row->runner->age) {
                    if (empty($this->lastPositions[$row->competition->id][$key])) {
                        $this->lastPositions[$row->competition->id][$key] = 1;
                    }

                    $row->range = $key;
                    $row->position = $this->lastPositions[$row->competition->id][$key];
                    $this->lastPositions[$row->competition->id][$key]++;
                    break;
                }
            }

            $row->result_time = $this->getResultTime($row);
            return $row;
        })
            ->mapToGroups(function ($query, $key) {
                return [$query->competition->id => $query];
            })
            ->sortKeys();

        foreach ($collection as $key => $row) {
            $returnCollection[$key] = $collection[$key]->mapToGroups(function ($query, $key) {
                return [$query->range => $query];
            })
                ->sortKeys();
        }

        return $returnCollection;
    }

    private function getResultTime($result)
    {
        if (!empty($result->runner_start_time) && !empty($result->runner_end_time)) {
            return $result->runner_start_time->diffInSeconds($result->runner_end_time);
        }
        return 0;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getClassification(Request $request)
    {
        /** @var CompetitionResult $result */
        $result = CompetitionResult::with(['runner', 'competition']);

        if ($request->has('competition')) {
            $result->whereCompetitionId($request->get('competition'));
        }

        return $result->orderBy('runner_end_time')->get();
    }

    private function findCompetition($model)
    {
        return RunnerCompetition
            ::whereRunnerId($model->runner_id)
            ->where('competition_id', $model->competition_id)
            ->first();
    }
}
