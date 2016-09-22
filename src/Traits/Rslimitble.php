<?php

namespace Rohos\Rslaravelsearch\Traits;

/**
 * Adds methods for limiting
 */
trait Rslimitble
{
    /**
     * Set order
     *
     * @return void
     */
    protected function setLimit()
    {
        $this->builder
            ->skip($this->pageNumber())
            ->take($this->defultLimit());
    }

    /**
     * Return page number
     *
     * @return void
     */
    protected function pageNumber()
    {
        $page = (int) request()->get($this->defaultPageName());
        return $page > 0 ? $page : 0;
    }

    /**
     * Return limit
     *
     * @return void
     */
    protected function defultLimit()
    {
        return empty($this->defaultLimit)
                ? $this->config('default_limit', 25)
                : $this->defaultLimit;
    }

    /**
     * Return default page name
     *
     * @return string
     */
    protected function defaultPageName()
    {
        return empty($this->defaultLimitPageName)
                ? $this->config('default_page_name', 'page')
                : $this->defaultLimitPageName;
    }

}