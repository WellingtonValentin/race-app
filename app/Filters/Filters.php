<?php

namespace App\Filters;

use App\Utils\StringFormat;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

abstract class Filters
{
    /**
     * @var Builder
     */
    protected $builder;
    /**
     * @var string
     */
    protected $searchTerm;
    public $request;
    public $columnRaw;
    public $valueSearch;

    public function __construct(string $searchTerm = '')
    {
        $this->searchTerm = $searchTerm;
    }

    public function apply(Builder $builder)
    {
        $this->builder = $builder;

        if (!empty($this->searchTerm)) {
            $this->search($this->searchTerm);
        }
    }

    /**
     * @param string $value
     *
     * @return Builder
     */
    private function search(string $value)
    {
        foreach ($this->getAllowedFilters() as $column) {
            $operator = 'like';

            $this->filterTextField($value, $column);
            if (in_array($column, $this->getDataFields())) {
                $this->filterDataField($value, $column);
            }

            $this
                ->builder
                ->orWhere($this->columnRaw, $operator, $this->valueSearch)
                ->orWhere($this->columnRaw, '=', $this->valueSearch);
        }

        return $this->builder;
    }

    /**
     * Get list of columns allowed for search
     *
     * @return array
     */
    abstract protected function getAllowedFilters();

    /**
     * @param string $value
     * @param        $column
     */
    public function filterTextField($value, $column)
    {
        $valueNotAccents = StringFormat::removeAccents($value);
        $this->valueSearch = '%' . strtoupper($valueNotAccents) . '%';
        $this->columnRaw = DB::raw(
            "UPPER(REPLACE($column, 'ŠšŽžÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÑÒÓÔÕÖØÙÚÛÜÝŸÞàáâãäåæçèéêëìíîïñòóôõöøùúûüýÿþƒ', 
            'SsZzAAAAAAACEEEEIIIINOOOOOOUUUUYYBaaaaaaaceeeeiiiinoooooouuuuyybf'))"
        );
    }

    private function filterDataField($value, $column)
    {
        $this->valueSearch = '%' . str_replace(['/', '-'], '', $value) . '%';
        $this->columnRaw = DB::raw("TO_CHAR(" . $column . ", 'DDMMYYYY')");
    }

    /**
     * Get list of data columns allowed for search
     *
     * @return array
     */
    protected function getDataFields()
    {
        return [];
    }
}
