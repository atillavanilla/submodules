<?php

namespace Atilla\ModuleGenerator;

use Illuminate\Filesystem\Filesystem;
use Atilla\ModuleGenerator\Generators\ServiceProviderGenerator;
use Atilla\ModuleGenerator\Generators\ControllerGenerator;
use Atilla\ModuleGenerator\Generators\ModelGenerator;

class SubmoduleGenerator
{
    protected Filesystem $filesystem;
    protected array $generators;

    public function __construct()
    {
        $this->filesystem = new Filesystem();
        $this->initializeGenerators();
    }

    protected function initializeGenerators(): void
    {
        $this->generators = [
            'service_provider' => new ServiceProviderGenerator($this->filesystem),
            'controller' => new ControllerGenerator($this->filesystem),
            'model' => new ModelGenerator($this->filesystem),
        ];
    }

    /**
     * Generate a complete module.
     */
    public function generateModule(string $moduleName, array $options = []): bool
    {
        $this->createModuleStructure($moduleName);
        
        $config = config('submodules.files', []);
        
        foreach ($this->generators as $type => $generator) {
            if ($config[$type] ?? true) {
                $generator->generate($moduleName, $options);
            }
        }

        return true;
    }

    /**
     * Create module directory structure.
     */
    protected function createModuleStructure(string $moduleName): void
    {
        $structure = config('submodules.structure', []);
        $modulePath = base_path(config('submodules.modules_path', 'src/Modules') . '/' . $moduleName);

        foreach ($structure as $directory) {
            $this->filesystem->makeDirectory($modulePath . '/' . $directory, 0755, true);
        }
    }

    /**
     * Check if module exists.
     */
    public function moduleExists(string $moduleName): bool
    {
        $modulePath = base_path(config('submodules.modules_path', 'src/Modules') . '/' . $moduleName);
        return $this->filesystem->isDirectory($modulePath);
    }

    /**
     * Get all modules.
     */
    public function getAllModules(): array
    {
        $modulesPath = base_path(config('submodules.modules_path', 'src/Modules'));
        
        if (!$this->filesystem->isDirectory($modulesPath)) {
            return [];
        }

        return array_filter(
            $this->filesystem->directories($modulesPath),
            fn($path) => basename($path)[0] !== '.'
        );
    }
}