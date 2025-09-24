<?php

namespace Atilla\ModuleGenerator\Facades;

use Illuminate\Support\Facades\Facade;

class ModuleGenerator extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'module-generator';
    }
}