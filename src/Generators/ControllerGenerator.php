<?php

namespace Atilla\SubmoduleGenerator\Generators;

class ControllerGenerator extends BaseGenerator
{
    public function generate(string $moduleName, array $options = []): bool
    {
        $controllerName = $options['name'] ?? $moduleName . 'Controller';
        
        $stub = $this->getStub('controller');
        $replacements = array_merge($this->getCommonReplacements($moduleName), [
            'CONTROLLER_NAME' => $controllerName,
        ]);
        
        $content = $this->replacePlaceholders($stub, $replacements);
        
        $filePath = $this->getModulePath($moduleName, "Controllers/{$controllerName}.php");
        $this->ensureDirectoryExists($filePath);
        
        return $this->filesystem->put($filePath, $content) !== false;
    }
}