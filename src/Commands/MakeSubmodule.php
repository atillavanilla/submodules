<?php

namespace Atilla\SubmoduleGenerator\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Atilla\SubmoduleGenerator\Facades\SubmoduleGenerator;

class MakeSubmodule extends Command
{
    protected $signature = 'make:module {name} {--force : Overwrite existing module}';
    protected $description = 'Create a new module with all necessary files and structure';

    public function handle()
    {
        $moduleName = Str::studly($this->argument('name'));
        $force = $this->option('force');

        $this->info("Creating submodule: {$moduleName}");

        if (SubmoduleGenerator::moduleExists($moduleName) && !$force) {
            $this->error("SubModule {$moduleName} already exists! Use --force to overwrite.");
            return 1;
        }

        try {
            SubmoduleGenerator::generateModule($moduleName, [
                'force' => $force
            ]);

            $this->info("✅ SubModule {$moduleName} created successfully!");
            $this->showNextSteps($moduleName);

        } catch (\Exception $e) {
            $this->error("❌ Failed to create SubModule: " . $e->getMessage());
            return 1;
        }

        return 0;
    }

    protected function showNextSteps($moduleName)
    {
        $this->line('');
        $this->info('🎉 Next Steps:');
        $this->line('1. Run: php artisan migrate (if migration was generated)');
        $this->line("2. Visit /src/SubModules/{$this->getKebabCase($moduleName)} to see your module");
        $this->line('3. Customize the generated files as needed');
        $this->line('');
        $this->comment("Module created at: " . config('submodules.submodules_path', 'src/SubModules') . "/{$moduleName}");
    }

    protected function getKebabCase($string)
    {
        return Str::kebab($string);
    }
}