<?php

namespace LaravelDoctrine\Scout;

use Doctrine\Common\Annotations\Reader;
use Doctrine\Common\EventManager;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Config\Repository as ConfigRepository;
use Illuminate\Contracts\Bus\Dispatcher as LaravelBusDispatcher;
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
     * @var ConfigRepository
     */
    private $scoutConfig;

    /**
     * @var LaravelBusDispatcher
     */
    private $dispatcher;

    /**
     * @param EngineManager        $engine
     * @param LaravelBusDispatcher $dispatcher
     * @param ConfigRepository     $config
     */
    public function __construct(EngineManager $engine, LaravelBusDispatcher $dispatcher, ConfigRepository $config)
    {
        $this->engine      = $engine;
        $this->dispatcher  = $dispatcher;
        $this->scoutConfig = $config['scout'];
    }

    /**
     * @param EventManager           $manager
     * @param EntityManagerInterface $em
     * @param Reader|null            $reader
     */
    public function addSubscribers(EventManager $manager, EntityManagerInterface $em, Reader $reader = null)
    {
        $manager->addEventSubscriber(new SearchableSubscriber($this->engine, $this->dispatcher, $this->scoutConfig));
    }

    /**
     * @return array
     */
    public function getFilters()
    {
        return [];
    }
}
