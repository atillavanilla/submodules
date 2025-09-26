<?php

namespace Atilla\ModuleGenerator\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Atilla\ModuleGenerator\Facades\ModuleGenerator;

class MakeModule extends Command
{
    protected $signature = 'make:module {name} {--force : Overwrite existing module}';
    protected $description = 'Create a new module with all necessary files and structure';

    public function handle()
    {
        $moduleName = Str::studly($this->argument('name'));
        $force = $this->option('force');

        $this->info("Creating module: {$moduleName}");

        if (ModuleGenerator::moduleExists($moduleName) && !$force) {
            $this->error("Module {$moduleName} already exists! Use --force to overwrite.");
            return 1;
        }

        try {
            ModuleGenerator::generateModule($moduleName, [
                'force' => $force
            ]);

            $this->info("✅ Module {$moduleName} created successfully!");
            $this->showNextSteps($moduleName);

        } catch (\Exception $e) {
            $this->error("❌ Failed to create module: " . $e->getMessage());
            return 1;
        }

        return 0;
    }

    protected function showNextSteps($moduleName)
    {
        $this->line('');
        $this->info('🎉 Next Steps:');
        $this->line('1. Run: php artisan migrate (if migration was generated)');
        $this->line("2. Visit /src/Modules/{$this->getKebabCase($moduleName)} to see your module");
        $this->line('3. Customize the generated files as needed');
        $this->line('');
        $this->comment("Module created at: " . config('module-generator.modules_path', 'src/Modules') . "/{$moduleName}");
    }

    protected function getKebabCase($string)
    {
        return Str::kebab($string);
    }
}