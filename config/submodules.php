<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Modules Path
    |--------------------------------------------------------------------------
    |
    | This is the path where your modules will be generated.
    | You can customize this path based on your project structure.
    |
    */
    'submodules_path' => 'src/Submodules',

    /*
    |--------------------------------------------------------------------------
    | Namespace
    |--------------------------------------------------------------------------
    |
    | The base namespace for your modules.
    |
    */
    'namespace' => 'Modules',

    /*
    |--------------------------------------------------------------------------
    | Stubs Path
    |--------------------------------------------------------------------------
    |
    | Path to the stub files. If you publish the stubs, they will be
    | available for customization.
    |
    */
    'stubs_path' => null, // Will use package stubs by default

    /*
    |--------------------------------------------------------------------------
    | Default Module Structure
    |--------------------------------------------------------------------------
    |
    | Define which directories should be created for each new module.
    |
    */
    'structure' => [
        'Controllers',
        'Models',
        'Providers',
        'Routes',
        // 'Resources/Views',
        // 'Resources/Assets/js',
        // 'Resources/Assets/css',
        'Config',
        'Database/Migrations',
        'Database/Seeders',
        'Services',
        'Repositories',
        'Tests/Unit',
        'Tests/Feature',
    ],

    /*
    |--------------------------------------------------------------------------
    | Files to Generate
    |--------------------------------------------------------------------------
    |
    | Define which files should be generated for each new module.
    |
    */
    'files' => [
        'service_provider' => true,
        'controller' => true,
        'model' => true,
        'migration' => true,
        'routes' => true,
        'views' => false,
        'config' => true,
        'test' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Route Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for route generation.
    |
    */
    'routes' => [
        'web_prefix' => null, // Will use module name if null
        'api_prefix' => 'api',
        'middleware' => [
            'web' => ['web'],
            'api' => ['api'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | View Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for view generation.
    |
    */
    'views' => [
        'default_layout' => 'layouts.app',
        'generate_crud_views' => true,
    ],
];