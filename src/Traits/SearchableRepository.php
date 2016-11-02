<?php

namespace LaravelDoctrine\Scout\Traits;

use Illuminate\Support\Collection;
use Laravel\Scout\Builder;
use Laravel\Scout\EngineManager;
use Laravel\Scout\Events\ModelsImported;
use LaravelDoctrine\Scout\Searchable;
use LaravelDoctrine\Scout\SearchResult;

trait SearchableRepository
{
    /**
     * @var EngineManager
     */
    protected $engine;

    /**
     * @param $query
     * @return \Laravel\Scout\Builder
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
        return config('scout.prefix') . $this->getClassMetadata()->getTableName();
    }

    /**
     * Get the Scout engine for the model.
     *
     * @return mixed
     */
    public function searchableUsing()
    {
        return $this->getEngineManager()->engine();
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

    /**
     * Returns instance of EngineManager.
     *
     * @return EngineManager
     */
    abstract protected function getEngineManager();

    /**
     * Creates a new ClassMetaData object for this entity.
     *
     * @return \Doctrine\ORM\Mapping\ClassMetadata
     */
    abstract public function getClassMetadata();

    /**
     * Finds objects by a set of criteria.
     *
     * Optionally sorting and limiting details can be passed. An implementation may throw
     * an UnexpectedValueException if certain values of the sorting or limiting details are
     * not supported.
     *
     * @param array      $criteria
     * @param array|null $orderBy
     * @param int|null   $limit
     * @param int|null   $offset
     *
     * @return array The objects.
     *
     * @throws \UnexpectedValueException
     */
    abstract public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null);

    /**
     * Creates a new QueryBuilder instance that is prepopulated for this entity name.
     *
     * @param string $alias
     * @param string $indexBy The index for the from.
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    abstract public function createQueryBuilder($alias, $indexBy = null);
}