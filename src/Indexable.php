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
     * @var array
     */
    protected $scoutMetadata = [];

    /**
     * Get primary key value
     * @return int
     */
    public function getKey()
    {
        return $this->{$this->getKeyName()};
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

    /**
     * @return string
     */
    public function getKeyName()
    {
        return 'id';
    }

    /**
     * @return int
     */
    public function getScoutKey()
    {
        return $this->getKey();
    }

    /**
     * Get all Scout related metadata.
     *
     * @return array
     */
    public function scoutMetadata()
    {
        return $this->scoutMetadata;
    }

    /**
     * Set a Scout related metadata.
     *
     * @param  string    $key
     * @param  mixed     $value
     * @return Indexable
     */
    public function withScoutMetadata($key, $value)
    {
        $this->scoutMetadata[$key] = $value;

        return $this;
    }
}
