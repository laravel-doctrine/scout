<?php

namespace LaravelDoctrine\Scout;

use Doctrine\ORM\EntityRepository;
use Laravel\Scout\Builder as ScoutBuilder;
use Laravel\Scout\EngineManager;

class Builder extends ScoutBuilder
{
    /**
     * @var EntityRepository
     */
    public $model;

    /**
     * The query expression.
     *
     * @var string
     */
    public $query;

    /**
     * The custom index specified for the search.
     *
     * @var string
     */
    public $index;

    /**
     * The "where" constraints added to the query.
     *
     * @var array
     */
    public $wheres = [];

    /**
     * The "limit" that should be applied to the search.
     *
     * @var int
     */
    public $limit;

    /**
     * Create a new search builder instance.
     *
     * @param EntityRepository $repository
     * @param  string          $query
     */
    public function __construct(EntityRepository $repository, $query)
    {
        $this->query = $query;
        $this->model = $repository;
    }

    /**
     * Get the results of the search.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function get()
    {
        return $this->engine()->get($this);
    }

    /**
     * Get the engine that should handle the query.
     *
     * @return mixed
     */
    protected function engine()
    {
        return app(EngineManager::class)->engine();
    }
}