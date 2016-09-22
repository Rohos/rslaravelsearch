<?php

namespace Rohos\Rslaravelsearch\Traits;

use Illuminate\Database\Eloquent\Builder;

/**
 * Adds search methods
 */
trait Rssearchable
{
    protected $rssearchesEntities = [];

    /**
     * Returns a search result
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array $filterData
     * @params string $entityName
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRssearch(Builder $query, array $filterData, $entityName = 'default')
    {
        return $this->rsSearchEntity($entityName)
                    ->search($query, $filterData);
    }

    /**
     * Returns a search result
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array $filterData
     * @params string $entityName
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRssearchWithCount(Builder $query, array $filterData, $entityName = 'default')
    {
        return $this->rsSearchEntity($entityName)
                    ->searchWithCount($query, $filterData);
    }

    /**
     * Returns a search instance
     *
     * @params string $entityName
     * @return \Rohos\Rslaravelsearch\Contracts\Searchable
     */
    protected function rssearchEntity($entityName)
    {
        $this->setRssearchEntity();

        $clsName = empty($this->rssearchesEntities[$entityName])
                        ? $this->rsSearchDefaultEntity()
                        : $this->rssearchesEntities[$entityName];

        return new $clsName;
    }

    /**
     * Set the list of search classes
     *
     * @return void
     */
    protected function setRssearchEntity()
    {

    }

    /**
     * It returns an instance of the default search class
     *
     * @return \Rohos\Rslaravelsearch\Contracts\Searchable
     */
    abstract protected function rssearchDefaultEntity();

}