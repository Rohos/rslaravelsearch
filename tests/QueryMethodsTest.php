<?php

namespace Rohos\Rslaravelsearch;

use Illuminate\Database\Eloquent\Builder;
use Rohos\Rslaravelsearch\Traits\Searchable;
use Rohos\Rslaravelsearch\Entities\EntitySearch;
use Rohos\Rslaravelsearch\Contracts\Rsquerylible;

class QueryMethodsTest extends \PHPUnit_Framework_TestCase
{
    use Searchable;

    /** @test */
    public function hasQuerybleMethods()
    {
        $newSearch = $this->createSearchEntity();

        $this->assertTrue(method_exists($newSearch, 'search'));
        $this->assertTrue(method_exists($newSearch, 'searchWithCount'));
        $this->assertInstanceOf(Rsquerylible::class, $newSearch);
    }

    /** @test */
    public function isSearchReturnBuilder()
    {
        $builder = $this->createBuilder();
        $newSearch = $this->createSearchEntity();
        $result = $newSearch->search($builder, []);

        $this->assertTrue($result instanceof Builder);
    }


    /** @test */
    public function isSearchWithCountReturnValidArray()
    {
        $builder = $this->createBuilder();
        $newSearch = $this->createSearchEntity();
        $result = $newSearch->searchWithCount($builder, []);

        $this->assertTrue(is_array($result));
        $this->assertTrue(count($result) === 3);
    }

    /** @test1 */
    public function it()
    {
        $builder = $this->createBuilder();
        $newSearch = $this->getMockBuilder(EntitySearch::class)
                            ->setMethods(['doSomething'])
                            ->getMock();
    }

}