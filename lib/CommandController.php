<?php

namespace Cli;
use App\Interfaces\Services\Search\SearchInterface;

abstract class CommandController
{
    protected $app;
    protected $searchInterface;

    abstract public function run($argv);

    public function __construct(App $app, SearchInterface $searchInterface)
    {
        $this->app = $app;
        $this->searchInterface = $searchInterface;
    }

    protected function getApp()
    {
        return $this->app;
    }
}