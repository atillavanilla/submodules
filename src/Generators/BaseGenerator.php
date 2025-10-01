<?php 

namespace Atilla\ModuleGenerator\Generators;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

abstract class BaseGenerator
{
    protected Filesystem $filesystem;
    protected array $config;

    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
        $this->config = config('submodules', []);
    }

    /**
     * Get the stub content.
     */
    protected function getStub(string $name): string
    {
        $stubsPath = $this->config['stubs_path'] ?? __DIR__ . '/../Stubs';
        $stubPath = $stubsPath . '/' . $name . '.stub';

        if (!file_exists($stubPath)) {
            throw new \InvalidArgumentException("Stub file not found: {$stubPath}");
        }

        return file_get_contents($stubPath);
    }

    /**
     * Replace placeholders in stub content.
     */
    protected function replacePlaceholders(string $content, array $replacements): string
    {
        foreach ($replacements as $placeholder => $replacement) {
            $content = str_replace('{{' . $placeholder . '}}', $replacement, $content);
        }

        return $content;
    }

    /**
     * Get module path.
     */
    protected function getModulePath(string $moduleName, string $path = ''): string
    {
        $basePath = base_path($this->config['submodules_path'] . '/' . $moduleName);
        return $basePath . ($path ? DIRECTORY_SEPARATOR . $path : '');
    }

    /**
     * Ensure directory exists.
     */
    protected function ensureDirectoryExists(string $path): void
    {
        if (!$this->filesystem->isDirectory(dirname($path))) {
            $this->filesystem->makeDirectory(dirname($path), 0755, true);
        }
    }

    /**
     * Generate common replacements.
     * 
     * @return array<string, string>
     */
    protected function getCommonReplacements(string $moduleName): array
    {
        return [
            'MODULE_NAME' => $moduleName,
            'MODULE_NAME_LOWER' => strtolower($moduleName),
            'MODULE_NAME_KEBAB' => Str::kebab($moduleName),
            'MODULE_NAME_SNAKE' => Str::snake($moduleName),
            'MODULE_NAME_PLURAL' => Str::plural($moduleName),
            'MODULE_NAME_PLURAL_LOWER' => strtolower(Str::plural($moduleName)),
            'NAMESPACE' => $this->config['namespace'] ?? 'Modules',
            'VARIABLE_NAME' => Str::camel(Str::plural($moduleName)),
            'TABLE_NAME' => Str::snake(Str::plural($moduleName)),
            'TIMESTAMP' => date('Y_m_d_His'),
        ];
    }

    /**
     * Generate the file.
     */
    abstract public function generate(string $moduleName, array $options = []): bool;
}