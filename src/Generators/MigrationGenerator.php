<?php

namespace Atilla\ModuleGenerator\Generators;

class ModelGenerator extends BaseGenerator
{
    public function generate(string $moduleName, array $options = []): bool
    {
        $modelName = $options['name'] ?? $moduleName . 'Model';
        
        $stub = $this->getStub('model');
        $replacements = array_merge($this->getCommonReplacements($moduleName), [
            'MODEL_NAME' => $modelName,
        ]);
        
        $content = $this->replacePlaceholders($stub, $replacements);
        
        $filePath = $this->getModulePath($moduleName, "Models/{$modelName}.php");
        $this->ensureDirectoryExists($filePath);
        
        return $this->filesystem->put($filePath, $content) !== false;
    }
}