<?php

namespace LaravelDoctrine\Scout;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use Laravel\Scout\EngineManager;
use LaravelDoctrine\Scout\Traits\SearchableRepository as SearchableRepositoryTrait;

class SearchableRepository extends EntityRepository
{
    use SearchableRepositoryTrait;

    /**
     * @param EntityManagerInterface $em     The EntityManager to use.
     * @param ClassMetadata          $class  The class descriptor.
     * @param EngineManager          $engine The search engine manager
     */
    public function __construct($em, ClassMetadata $class, EngineManager $engine)
    {
        parent::__construct($em, $class);

        $this->engine = $engine;
    }
}
