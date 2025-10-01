<?php

namespace Atilla\ModuleGenerator\Facades;

use Illuminate\Support\Facades\Facade;

class SubmoduleGenerator extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'submodule-generator';
    }
}