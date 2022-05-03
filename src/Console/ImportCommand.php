<?php

namespace LaravelDoctrine\Scout\Console;

use Doctrine\Persistence\ManagerRegistry;
use Illuminate\Console\Command;
use Illuminate\Contracts\Events\Dispatcher;
use Laravel\Scout\EngineManager;
use Laravel\Scout\Events\ModelsImported;
use LaravelDoctrine\Scout\SearchableRepository;

class ImportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'doctrine:scout:import {model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import the given model into the search index';

    /**
     * Execute the console command.
     *
     * @param \Illuminate\Contracts\Events\Dispatcher $events
     * @param ManagerRegistry                         $registry
     */
    public function handle(Dispatcher $events, ManagerRegistry $registry)
    {
        $class = $this->argument('model');
        $em    = $registry->getManagerForClass($class);

        $repository = $em->getRepository($class);

        if (!$repository instanceof SearchableRepository) {
            $repository = new SearchableRepository(
                $em,
                $em->getClassMetadata($class),
                $this->getLaravel()->make(EngineManager::class)
            );
        }

        $events->listen(ModelsImported::class, function ($event) use ($class) {
            $this->line(sprintf(
                '<comment>Imported %d [%s] models up to ID: %s</comment>',
                $event->models->count(),
                $class,
                $event->models->last()->getKey()
            ));
        });

        $repository->makeAllSearchable();

        $events->forget(ModelsImported::class);

        $this->info('All [' . $class . '] records have been imported.');
    }
}
