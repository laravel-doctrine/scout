<?php

namespace LaravelDoctrine\Scout;

use Doctrine\ORM\Mapping\ClassMetadata;

interface Searchable
{
    /**
     * Get primary key value
     * @return int
     */
    public function getKey();

    /**
     * @return string
     */
    public function searchableAs();

    /**
     * @param string $as
     */
    public function setSearchableAs($as);

    /**
     * @return string
     */
    public function toSearchableArray();

    /**
     * @param ClassMetadata $classMetadata
     */
    public function setClassMetaData(ClassMetadata $classMetadata);

    /**
     * Get the queue connection that should be used when syncing.
     *
     * @return string
     */
    public function syncWithSearchUsing();
}
