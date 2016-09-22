<?php

namespace Rohos\Rslaravelsearch;

use Illuminate\Database\Eloquent\Builder;
use Rohos\Rslaravelsearch\Traits\Rslimitble;
use Rohos\Rslaravelsearch\Traits\Rsorderble;
use Rohos\Rslaravelsearch\Traits\Rscountble;
use Rohos\Rslaravelsearch\Contracts\Rsquerylible;

/**
 * Class for clear and simple searching
 */
abstract class QueryFilter implements Rsquerylible
{
    use Rsorderble, Rslimitble, Rscountble;

    const PACKAGE_NAME = 'rslaravelsearch';

    /**
     *
     * @var \Illuminate\Database\Eloquent\Builder
     */
    protected $builder;
    protected $defaultLimit;
    protected $defaultLimitPageName;
    protected $defaultOrder;
    protected $defaultGetFields;
    protected $defaultCountFields;
    protected $needLimit = true;
    protected $needSort = true;
    protected $data = [];

    /**
     * Main search method
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param array $filterData
     * @return Builder
     */
    public function search(Builder $builder, array $filterData)
    {
        $this->builder = $builder;
        $this->data = $this->prepareQueryParams($filterData);

        $this->beforeSearch();

        foreach ($this->data as $name => $params) {
            $this->runSearchMethod($name, $params);
        }

        $this->afterSearch();

        return $this->builder;
    }

    /**
     * Prepare request parameters
     *
     * @return array
     */
    protected function prepareQueryParams($filterData)
    {
        return $this->isEmptyArr($filterData) ? [] : $filterData;
    }

    /**
     * Starts the search methods
     *
     * @param string $name
     * @param mix $data
     */
    protected function runSearchMethod($name, $data)
    {
        $mtdName = $this->config('mtd_prefix', '_') . $name;

        // Если есть метод поиска - запускаем его
        if (method_exists($this, $mtdName)) {
            call_user_func_array([$this, $mtdName], array_filter([$data]));
        }
    }

    /**
     * Runs before the main search method
     */
    protected function beforeSearch()
    {

    }

    /**
     * Runs after the main search method
     */
    protected function afterSearch()
    {

    }

    /**
     * Returns data from config
     *
     * @param string $key
     * @param mix $default
     * @return mix
     */
    public function config($key, $default = '')
    {
        return config(self::PACKAGE_NAME .'.'. $key, $default);
    }

    /**
     * Checks whether the array is empty
     *
     * @param mix $arr
     * @return bool
     */
    protected function isEmptyArr($arr)
    {
        return empty($arr) || ! is_array($arr);
    }

}