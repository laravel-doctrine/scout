<?php

namespace LaravelDoctrine\Scout;

use Doctrine\Common\Annotations\Reader;
use Doctrine\Common\EventManager;
use Doctrine\ORM\EntityManagerInterface;
use Laravel\Scout\EngineManager;
use LaravelDoctrine\ORM\Extensions\Extension;
use LaravelDoctrine\Scout\Subscribers\SearchableSubscriber;

class SearchableExtension implements Extension
{
    /**
     * @var EngineManager
     */
    private $engine;

    /**
     * @param EngineManager $engine
     */
    public function __construct(EngineManager $engine)
    {
        $this->engine = $engine;
    }

    /**
     * @param EventManager           $manager
     * @param EntityManagerInterface $em
     * @param Reader|null            $reader
     */
    public function addSubscribers(EventManager $manager, EntityManagerInterface $em, Reader $reader = null)
    {
        $manager->addEventSubscriber(new SearchableSubscriber($this->engine));
    }

    /**
     * @return array
     */
    public function getFilters()
    {
        return [];
    }
}
