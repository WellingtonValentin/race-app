<?php

namespace App\Services;

use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

abstract class CRUDService
{
    const ORDER_BY = 'orderBy';
    const DESCENDING = 'descending';

    /**
     * Classe do Model a ser utilizado pelo CRUD
     */
    protected $modelClass;

    /**
     * Builder de filtros
     */
    protected $filter;

    /**
     * Armazena qual a coluna para ordenação
     *
     * @var string
     */
    private $orderBy;

    /**
     * Flag indicando se vai ser ascendente ou decrescente
     *
     * @var bool
     */
    private $orderDesc = true;

    /**
     * @param array $data
     *
     * @return Model
     * @throws Exception
     */
    public function create($data)
    {

        $model = new $this->modelClass();
        $this->fill($model, $data);
        $model->save();

        return $model;
    }

    /**
     * @param Model $model
     * @param array $data
     *
     * @return void
     * @throws Exception
     */
    public function fill(Model &$model, array $data)
    {
        throw new Exception('Método não foi implementado');
    }

    /**
     * @param string | array | Model $model
     * @param                $data
     *
     * @return Model
     * @throws Exception
     */
    public function update($model, $data)
    {
        $model = $this->findById($model);

        $this->fill($model, $data);
        $model->save();

        return $model;
    }

    /**
     * @param string | Model $model
     *
     * @return Model
     */
    protected function findById($model)
    {
        if (is_string($model)) {
            $model = $this->modelClass::find($model);
        }

        return $model;
    }

    /**
     * @param Model | string $model
     *
     * @param array|null $data
     * @throws Exception
     */
    public function delete($model, array $data = null)
    {
        $model = $this->findById($model);

        $model->delete();
    }

    /**
     * @param string $column
     * @param bool   $descending
     *
     * @return CRUDService $this
     */
    public function orderBy($column, bool $descending)
    {
        $this->orderBy = $column;
        $this->orderDesc = $descending;

        return $this;
    }

    /**
     * @param string $searchTerm
     *
     * @param Request $request
     * @return CRUDService $this
     */
    public function filter(string $searchTerm, Request $request)
    {
        $filterLocation = str_replace('\Domains', '\Domains\Filters', $this->modelClass);
        $filterClass = $filterLocation . "Filter";

        if (class_exists($filterClass)) {
            $this->filter = new $filterClass($searchTerm);
            $this->filter->request = $request;
        }

        return $this;
    }

    public function listWithoutPaginate(array $with = [])
    {
        return $this
            ->createQuery()
            ->with($with)
            ->get();
    }

    public function createQuery()
    {
        $query = $this->select();

        if ($this->filter) {
            $query = $query->filter($this->filter);
        }

        if (!empty($this->orderBy)) {
            $order = $this->orderDesc ? 'desc' : 'asc';

            $query = $query->orderBy($this->orderBy, $order);
        }

        return $query;
    }

    /**
     * @return mixed
     */
    protected function select()
    {
        return $this
            ->modelClass::select();
    }

    /**
     * @param int $paginate
     *
     * @param array $with
     * @return LengthAwarePaginator|Collection|static[]
     */
    public function list(int $paginate = 15, array $with = [])
    {
        return $this
            ->createQuery()
            ->with($with)
            ->paginate($paginate);
    }
}
