<?php

namespace LaravelDoctrine\Scout;

use Illuminate\Support\ServiceProvider;
use LaravelDoctrine\Scout\Console\ImportCommand;

class ScoutServiceProvider extends ServiceProvider
{
    /**
     * Register Service Provider
     */
    public function register()
    {
        $this->commands([
            ImportCommand::class
        ]);
    }
}
