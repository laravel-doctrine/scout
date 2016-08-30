<?php

namespace LaravelDoctrine\Scout;

use Illuminate\Support\Collection;

class SearchResult
{
    /**
     * @var array
     */
    private $results = [];

    /**
     * @param array $results
     */
    public function __construct(array $results)
    {
        $this->results = $results;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function get()
    {
        return new Collection($this->results);
    }
}