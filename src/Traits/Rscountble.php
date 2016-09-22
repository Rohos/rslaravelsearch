<?php

namespace Rohos\Rslaravelsearch\Traits;

use Illuminate\Database\Eloquent\Builder;

/**
 * Adds methods for search with count
 */
trait Rscountble
{
    /**
     * Returns a search result and the number of
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array $filterData
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function searchWithCount(Builder $builder, array $filterData)
    {
        $this->search($builder, $filterData);

        $allCountKey = $this->allCountKey();
        $currentCountKey = $this->currentCountKey();
        $itemsKey = $this->itemCountKey();

        $data = [
            $allCountKey => $this->getCount(),
            $currentCountKey => 0,
            $itemsKey => collect()
        ];

        if ($data[$allCountKey] > 0) {
            $this->beforeGet();

            $data[$itemsKey] = $this->getItems();
            $data[$currentCountKey] = $this->getCurrentCount($data[$itemsKey]);
        }

        $this->prepareDataAfterSearch($data);

        return $data;
    }

    /**
     * Runs before method get
     * 
     * @return void
     */
    protected function beforeGet()
    {
        if ($this->needLimit) {
            $this->setLimit();
        }

        if ($this->needSort) {
            $this->setOrder();
        }
    }

    /**
     * Return all count
     *
     * @return int
     */
    protected function getCount()
    {
        return $this->builder->count($this->defaultCountFields());
    }

    /**
     * Return current count
     *
     * @return int
     */
    protected function getCurrentCount($items)
    {
        return count($items);
    }

    /**
     * Return items
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    protected function getItems()
    {
        return $this->builder->get($this->defaultGetFields());
    }

    /**
     * Return get fields
     *
     * @return string
     */
    protected function defaultGetFields()
    {
        return empty($this->defaultGetFields)
                ? $this->config('default_get_fields', ['*'])
                : $this->defaultGetFields;
    }

    /**
     * Return all count fields
     *
     * @return string
     */
    protected function defaultCountFields()
    {
        return empty($this->defaultCountFields)
                ? $this->config('default_count_fields', '*')
                : $this->defaultCountFields;
    }

    /**
     * Prepare data after search by link
     * 
     * @param array $data
     */
    protected function prepareDataAfterSearch(&$data)
    {

    }

    /**
     * Return all count key
     *
     * @return string
     */
    protected function allCountKey()
    {
        return $this->config('all_count_key', 'count');
    }

    /**
     * Return current count key
     *
     * @return string
     */
    protected function currentCountKey()
    {
        return $this->config('current_count_key', 'current_count');
    }

    /**
     * Return items key
     *
     * @return string
     */
    protected function itemCountKey()
    {
        return $this->config('items_key', 'items');
    }

}