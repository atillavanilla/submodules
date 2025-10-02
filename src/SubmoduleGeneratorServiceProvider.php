<?php

namespace Atilla\SubmoduleGenerator;

use Illuminate\Support\ServiceProvider;
use Atilla\SubmoduleGenerator\Commands\MakeSubmodule;
// use Atilla\ModuleGenerator\Commands\ListModules;
// use Atilla\ModuleGenerator\Commands\RemoveModule;
// use Atilla\ModuleGenerator\Commands\ToggleModule;
// use Atilla\ModuleGenerator\Commands\MakeModuleComponent;
// use Atilla\ModuleGenerator\Commands\ModuleDoctor;
// use Atilla\ModuleGenerator\Commands\FixModuleProviders;

class SubmoduleGeneratorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/submodules.php' => config_path('submodules.php'),
        ], 'submodules-config');

        $this->publishes([
            __DIR__ . '/Stubs' => resource_path('stubs/module-generator'),
        ], 'module-generator-stubs');

        if ($this->app->runningInConsole()) {
            $this->commands([
                MakeSubmodule::class,
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
            __DIR__ . '/../config/submodules.php',
            'submodules'
        );

        $this->app->singleton('submodule-generator', function () {
            return new SubmoduleGenerator();
        });
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return ['submodule-generator'];
    }
}