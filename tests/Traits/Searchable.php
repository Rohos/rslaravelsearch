<?php

namespace Rohos\Rslaravelsearch\Traits;

use Illuminate\Database\Eloquent\Builder;
use Rohos\Rslaravelsearch\Entities\EntitySearch;

trait Searchable
{
    /**
     * Return Builder
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function createBuilder()
    {
        return $this->createMock(Builder::class);
    }

    /**
     * Return search entity
     *
     * @param array $methods
     * @return \Rohos\Rslaravelsearch\Tests\Entities\EntitySearch
     */
    public function createSearchEntity($methods = null)
    {
        return $this->getMockBuilder(EntitySearch::class)
                            ->setMethods($methods)
                            ->getMock();
    }

}