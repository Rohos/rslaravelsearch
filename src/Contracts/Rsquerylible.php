<?php

namespace Rohos\Rslaravelsearch\Contracts;

use Illuminate\Database\Eloquent\Builder;

interface Rsquerylible
{
    /**
     * Main search method
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @params array $filterData
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function search(Builder $builder, array $filterData);

    /**
     * Returns a search result and the number of
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @params array $filterData
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function searchWithCount(Builder $builder, array $filterData);

}