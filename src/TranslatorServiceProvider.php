<?php

namespace AmirHossein5\RequestTranslator;

use Illuminate\Support\ServiceProvider;
use AmirHossein5\RequestTranslator\Console\CreateTranslationFileCommand;
use AmirHossein5\RequestTranslator\Console\InstallCommand;

class TranslatorServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallCommand::class,
                CreateTranslationFileCommand::class,
            ]);
        }
    }
}
