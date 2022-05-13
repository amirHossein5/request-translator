<?php

namespace AmirHossein5\RequestTranslator;

use AmirHossein5\RequestTranslator\Console\CreateTranslationFileCommand;
use AmirHossein5\RequestTranslator\Console\InstallCommand;
use Illuminate\Support\ServiceProvider;

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
