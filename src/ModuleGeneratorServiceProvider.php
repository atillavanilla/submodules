<?php

namespace Atilla\ModuleGenerator;

use Illuminate\Support\ServiceProvider;
use Atilla\ModuleGenerator\Commands\MakeModule;
use Atilla\ModuleGenerator\Commands\ListModules;
use Atilla\ModuleGenerator\Commands\RemoveModule;
use Atilla\ModuleGenerator\Commands\ToggleModule;
use Atilla\ModuleGenerator\Commands\MakeModuleComponent;
use Atilla\ModuleGenerator\Commands\ModuleDoctor;
use Atilla\ModuleGenerator\Commands\FixModuleProviders;

class ModuleGeneratorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/module-generator.php' => config_path('module-generator.php'),
        ], 'module-generator-config');

        $this->publishes([
            __DIR__ . '/Stubs' => resource_path('stubs/module-generator'),
        ], 'module-generator-stubs');

        if ($this->app->runningInConsole()) {
            $this->commands([
                MakeModule::class,
                // ListModules::class,
                // RemoveModule::class,
                // ToggleModule::class,
                // MakeModuleComponent::class,
                // ModuleDoctor::class,
                // FixModuleProviders::class,
            ]);
        }
    }

    /**
     * Register any package services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/module-generator.php',
            'module-generator'
        );

        $this->app->singleton('module-generator', function () {
            return new ModuleGenerator();
        });
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return ['module-generator'];
    }
}