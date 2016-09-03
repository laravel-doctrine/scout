<?php

namespace LaravelDoctrine\Scout;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use Illuminate\Support\Collection;
use Laravel\Scout\Builder;
use Laravel\Scout\EngineManager;
use Laravel\Scout\Events\ModelsImported;

class SearchableRepository extends EntityRepository
{
    /**
     * @var EngineManager
     */
    protected $engine;

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
     * Get the Scout engine for the model.
     *
     * @return mixed
     */
    public function searchableUsing()
    {
        return $this->engine->engine();
    }

    /**
     * @return mixed
     */
    public function getKeyName()
    {
        return $this->getClassMetadata()->getIdentifierFieldNames()[0];
    }

    /**
     * Make all searchable
     */
    public function makeAllSearchable()
    {
        $this->chunk(100, function (Collection $models) {

            $models = $models->map(function (Searchable $model) {
                $model->setSearchableAs($this->searchableAs());
                $model->setClassMetaData($this->getClassMetadata());

                return $model;
            });

            $this->searchableUsing()->update($models);

            event(new ModelsImported($models));
        });
    }

    /**
     * Make specific entities searchable
     * @param Collection $entities
     */
    public function makeEntitiesSearchable(Collection $entities)
    {
        $this->searchableUsing()->update($entities);
    }

    /**
     * Remove specific searchable entities
     * @param Collection $entities
     */
    public function removeSearchableEntities(Collection $entities)
    {
        $this->searchableUsing()->delete($entities);
    }

    /**
     * @param  int      $count
     * @param  callable $callback
     * @return bool
     */
    private function chunk($count, callable $callback)
    {
        $qb    = $this->createQueryBuilder('s');
        $first = 0;

        $results = $qb
            ->getQuery()
            ->setMaxResults($count)
            ->getResult();

        while (count($results) > 0) {
            if (call_user_func($callback, collect($results)) === false) {
                return false;
            }

            $first += $count;

            $results = $qb
                ->getQuery()
                ->setMaxResults($count)
                ->setFirstResult($first)
                ->getResult();
        }

        return true;
    }

    /**
     * @param  string       $key
     * @param  array        $values
     * @return SearchResult
     */
    public function whereIn($key, array $values = [])
    {
        return new SearchResult($this->findBy([
            $key => $values
        ]));
    }
}
