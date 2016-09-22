<?php

namespace Rohos\Rslaravelsearch\Traits;

/**
 * Adds methods for ordering
 */
trait Rsorderble
{
    /**
     * Set order
     *
     * @return void
     */
    protected function setOrder()
    {
        $isLatest = $this->defaultOrderDir() == 'desc';
        $field = $this->defaultOrderField();

        $isLatest ? $this->builder->latest($field) : $this->builder->oldest($field);
    }

    /**
     * Return default order field
     *
     * @return string
     */
    protected function defaultOrderField()
    {
        return empty($this->defaultOrder)
                ? $this->config('default_order', 'id')
                : $this->defaultOrder;
    }

    /**
     * Return default order dir
     *
     * @return string
     */
    protected function defaultOrderDir()
    {
        return strtolower($this->config('default_order_dir', 'asc'));
    }

}