<?php

namespace Atilla\SubmoduleGenerator\Generators;

class ServiceProviderGenerator extends BaseGenerator
{
    public function generate(string $moduleName, array $options = []): bool
    {
        $stub = $this->getStub('service-provider');
        $replacements = $this->getCommonReplacements($moduleName);
        
        $content = $this->replacePlaceholders($stub, $replacements);
        
        $filePath = $this->getModulePath($moduleName, "Providers/{$moduleName}ServiceProvider.php");
        $this->ensureDirectoryExists($filePath);
        
        return $this->filesystem->put($filePath, $content) !== false;
    }
}