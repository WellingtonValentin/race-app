<?php
namespace App\Services;

use App\Models\Competition;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class CompetitionService extends CRUDService
{
    protected $modelClass = Competition::class;

    /**
     * @param array $data
     * @return Competition
     */
    public function create($data): Competition
    {
        $model = new Competition();
        $this->fill($model, $data);
        $model->save();

        return $model;
    }

    /**
     * @param Model $data
     * @param Competition $model
     * @return Competition
     */
    public function update($data, $model): Competition
    {
        $this->fill($model, $data->toArray());
        $model->save();

        return $model;
    }

    /**
     * @param Competition $model
     * @param array  $data
     *
     * @return void
     */
    public function fill(&$model, $data)
    {
        $model->type = $data['type'];
        $model->date = $this->formatBirthDate($data['date']);
    }

    public function formatBirthDate($date): string
    {
        if (Carbon::createFromFormat('d/m/Y', $date) !== false) {
            return Carbon::parse($date)->format('d-m-Y');
        }
        return $date;
    }
}
