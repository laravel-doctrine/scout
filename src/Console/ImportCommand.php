<?php

namespace LaravelDoctrine\Scout\Console;

use Doctrine\Common\Persistence\ManagerRegistry;
use Illuminate\Console\Command;
use Illuminate\Contracts\Events\Dispatcher;
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
                $em->getClassMetadata($class)
            );
        }

        $events->listen(ModelsImported::class, function ($event) use ($class) {
            $key = $event->models->last()->getKey();

            $this->line('<comment>Imported [' . $class . '] models up to ID:</comment> ' . $key);
        });

        $repository->makeAllSearchable();

        $this->info('All [' . $class . '] records have been imported.');
    }
}
