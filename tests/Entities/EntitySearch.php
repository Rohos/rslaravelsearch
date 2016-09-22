<?php

namespace Rohos\Rslaravelsearch\Entities;

use Illuminate\Config\Repository;
use Rohos\Rslaravelsearch\QueryFilter;

class EntitySearch extends QueryFilter
{
    public function config($key, $default = '')
    {
        $this->config = new Repository();
        return $this->config->get(self::PACKAGE_NAME . $key, $default);
    }

}