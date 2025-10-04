<?php

namespace Atilla\SubmoduleGenerator\Generators;
use Illuminate\Support\Str;

class RoutesGenerator extends BaseGenerator
{
    public function generate(string $moduleName, array $options = []): bool
    {
        return $this->generateWebRoutes($moduleName) && $this->generateApiRoutes($moduleName);
    }

    protected function generateWebRoutes(string $moduleName): bool
    {
        $stub = $this->getStub('routes-web');
        $replacements = array_merge($this->getCommonReplacements($moduleName), [
            'MODULE_NAME' => $moduleName,
            'MODULE_NAME_LOWER' => Str::lower($moduleName),
            'WEB_PREFIX' => config('submodules.routes.web_prefix', Str::kebab($moduleName)),
            'WEB_MIDDLEWARE' => implode(',', config('submodules.routes.middleware.web', ['web']))
        ]);

        $content = $this->replacePlaceholders($stub, $replacements);

        $filePath = $this->getModulePath($moduleName, 'routes/web.php');
        $this->ensureDirectoryExists($filePath);

        return $this->filesystem->put($filePath, $content) !== false;
    }

    protected function generateApiRoutes(string $moduleName): bool
    {
        $stub = $this->getStub('routes-api');
        $replacements = array_merge($this->getCommonReplacements($moduleName), [
            'MODULE_NAME' => $moduleName,
            'MODULE_NAME_LOWER' => Str::lower($moduleName),
            'API_PREFIX' => config('submodules.routes.api_prefix', 'api'),
            'API_MIDDLEWARE' => implode(',', config('submodules.routes.middleware.api', ['api']))
        ]);

        $content = $this->replacePlaceholders($stub, $replacements);

        $filePath = $this->getModulePath($moduleName, 'routes/api.php');
        $this->ensureDirectoryExists($filePath);

        return $this->filesystem->put($filePath, $content) !== false;
    }
}