<?php

namespace LaravelDoctrine\Scout\Jobs;

use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Laravel\Scout\EngineManager;
use LaravelDoctrine\Scout\Searchable;
use LaravelDoctrine\Scout\SearchableRepository;

class MakeSearchable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * The entity to be made searchable.
     *
     * @var \LaravelDoctrine\Scout\Searchable
     */
    public $entity;

    /**
     * Create a new job instance.
     *
     * @param  Searchable $entity
     */
    public function __construct(Searchable $entity)
    {
        $this->entity = $entity;
    }

    /**
     * @param EngineManager          $engine
     * @param EntityManagerInterface $em
     * @return bool|void
     */
    public function handle(EngineManager $engine, EntityManagerInterface $em)
    {
        if (empty($this->entity)) {
            return false;
        }

        $repository = $this->getRepository($em, $this->entity, $engine);

        return $repository->makeEntitiesSearchable(new Collection([$this->entity]));
    }

    /**
     * @param  EntityManagerInterface $em
     * @param  Searchable             $object
     * @param EngineManager           $engine
     * @return SearchableRepository
     */
    private function getRepository(EntityManagerInterface $em, Searchable $object, EngineManager $engine)
    {
        $class = get_class($object);
        $cmd = $em->getClassMetadata($class);
        $repository = $em->getRepository($class);

        if (! $repository instanceof SearchableRepository) {
            $repository = new SearchableRepository(
                $em,
                $cmd,
                $engine
            );
        }

        $object->setClassMetaData($cmd);
        $object->setSearchableAs($repository->searchableAs());

        return $repository;
    }
}
