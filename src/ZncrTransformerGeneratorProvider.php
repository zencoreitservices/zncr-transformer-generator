<?php

namespace ZncrTransformerGenerator;

use Illuminate\Support\ServiceProvider;

class ZncrTransformerGeneratorProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->setupConfig();

        if ($this->app->runningInConsole()) {
            $this->commands([
                TransformerMakeCommand::class,
            ]);
        }
    }
}