<?php

namespace LaravelDoctrine\Scout;

use Doctrine\ORM\Mapping\ClassMetadata;
use LaravelDoctrine\ORM\Serializers\ArraySerializer;

trait Indexable
{
    /**
     * @var ClassMetadata
     */
    protected $classMetaData;

    /**
     * @var string
     */
    protected $searchableAs;

    /**
     * Get primary key value
     * @return int
     */
    public function getKey()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function searchableAs()
    {
        return $this->searchableAs;
    }

    /**
     * @param string $as
     */
    public function setSearchableAs($as)
    {
        $this->searchableAs = $as;
    }

    /**
     * @return string
     */
    public function toSearchableArray()
    {
        return (new ArraySerializer)->serialize($this);
    }

    /**
     * @param ClassMetadata $classMetadata
     */
    public function setClassMetaData(ClassMetadata $classMetadata)
    {
        $this->classMetaData = $classMetadata;
    }
}
