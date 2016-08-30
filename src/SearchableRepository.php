<?php

namespace LaravelDoctrine\Scout;

use Doctrine\ORM\EntityRepository;

abstract class SearchableRepository extends EntityRepository
{
    /**
     * @param $query
     * @return Builder
     */
    public function search($query)
    {
        return new Builder($this, $query);
    }

    /**
     * @return string
     */
    public function searchableAs()
    {
        return $this->getClassMetadata()->getTableName();
    }

    /**
     * @return mixed
     */
    public function getKeyName()
    {
        return $this->getClassMetadata()->getIdentifierFieldNames()[0];
    }

    /**
     * @param string $key
     * @param array  $values
     * @return SearchResult
     */
    public function whereIn($key, array $values = [])
    {
        return new SearchResult($this->findBy([
            $key => $values
        ]));
    }
}