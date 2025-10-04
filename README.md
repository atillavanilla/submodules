# Laravel Submodule Generator

A Laravel package for generating modular API applications.

## Installation

Install via Composer:

```bash
composer require atilla/submodules
```

The package will automatically register its service provider.

## Configuration 

Publish the configuration file:

```bash
php artisan vendor:publish --tag=submodules-config
```

This will create `config/submodules.php` where you can customize:
- Modules path
- Base namespace
- Directory structure
- Files to generate
- Route configurations
- View settings

## Usage

### Creating a Module

```bash
php artisan make:module Blog
```

This will generate a new module with the following structure:

```
src/SubModules/Blog/
├── Controllers/
│   └── BlogController.php
├── Models/
│   └── Blog.php
└── Providers/
    └── BlogServiceProvider.php
    ... etc
```

### Options

- `--force` - Overwrite existing module

### Generated Files

Each module includes:

- ServiceProvider
- Controller with CRUD + API actions
- Eloquent Model
- Basic routing configuration

## Customization

### Custom Stubs

Publish the stub files to customize the generated code:

```bash
php artisan vendor:publish --tag=module-generator-stubs
```

### Configuration

Key settings in `config/submodules.php`:

```php
return [
    'submodules_path' => 'src/SubModules',
    'namespace' => 'SubModules',
    'structure' => [
        'Controllers',
        'Models',
        'Providers',
        // More to come...
    ],
    'files' => [
        'service_provider' => true,
        'controller' => true,
        'model' => true,
        // Configure which files to generate...
    ]
];
```

## Requirements

- PHP 8.1+
- Laravel 9.0+

## License

