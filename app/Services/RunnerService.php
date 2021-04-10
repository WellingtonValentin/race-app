<?php
namespace App\Services;

use App\Models\Runner;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class RunnerService extends CRUDService
{
    protected $modelClass = Runner::class;

    /**
     * @param array $data
     * @return Runner
     */
    public function create($data): Runner
    {
        $model = new Runner();
        $this->fill($model, $data);
        $model->save();

        return $model;
    }

    /**
     * @param Model $data
     * @param Runner $model
     * @return Runner
     */
    public function update($data, $model): Runner
    {
        $this->fill($model, $data->toArray());
        $model->save();

        return $model;
    }

    /**
     * @param Runner $model
     * @param array  $data
     *
     * @return void
     */
    public function fill(& $model, $data)
    {
        $model->name = $data['name'];
        $model->document = $data['document'];
        $model->birth_date = $this->formatBirthDate($data['birth_date']);
    }

    public function formatBirthDate($date): string
    {
        if (Carbon::createFromFormat('d/m/Y', $date) !== false) {
            return Carbon::parse($date)->format('d-m-Y');
        }
        return $date;
    }
}
