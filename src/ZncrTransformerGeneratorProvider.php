<?php

namespace ZncrTransformerGenerator;

use Illuminate\Support\ServiceProvider;
use ZncrTransformerGenerator\Console\Commands\ZncrTransformer;

class ZncrTransformerGeneratorProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                ZncrTransformer::class,
            ]);
        }
    }
}