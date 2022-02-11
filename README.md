# Discoverer for Spiral Framework

[![PHP](https://img.shields.io/packagist/php-v/spiral-packages/discoverer.svg?style=flat-square)](https://packagist.org/packages/spiral-packages/discoverer)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/spiral-packages/discoverer.svg?style=flat-square)](https://packagist.org/packages/spiral-packages/discoverer)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/spiral-packages/discoverer/run-tests?label=tests)](https://github.com/spiral-packages/discoverer/actions?query=workflow%3Arun-tests+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/spiral-packages/discoverer.svg?style=flat-square)](https://packagist.org/packages/spiral-packages/discoverer)

## Requirements

Make sure that your server is configured with following PHP version and extensions:

- PHP 8.0+
- Spiral framework 2.9+

## Installation

You can install the package via composer:

```bash
composer require spiral-packages/discoverer
```

After package install you need to register bootloader from the package.

```php
protected const LOAD = [
    // ...
    \Spiral\Discoverer\DiscovererBootloader::class,
];
```

After package install you need to add `Spiral\Discoverer\WithDiscovering` trait from the package to your Application
kernel.

```php
use Spiral\Discoverer\WithDiscovering;
use Spiral\Framework\Kernel;

class App extends Kernel 
{
    use WithDiscovering;
}
```

And then you should modify you `app.php` file. Example you can see below.

```php
<?php

declare(strict_types=1);

use App\App;

//
// If you forgot to configure some of this in your php.ini file,
// then don't worry, we will set the standard environment
// settings for you.
//

mb_internal_encoding('UTF-8');
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 'stderr');

//
// Register Composer's auto loader.
//
require __DIR__ . '/vendor/autoload.php';


//
// Initialize shared container, bindings, directories etc.
//
$app = App::create([
    'root' => __DIR__
]);

$app->discover(
    new \Spiral\Discoverer\Bootloader\BootloadersDiscoverer(
        new \Spiral\Discoverer\Bootloader\ComposerRegistry(),
        new \Spiral\Discoverer\Bootloader\ArrayRegistry(...),
        new \Spiral\Discoverer\Bootloader\ConfigRegistry() 
    ),
    
    new \Spiral\Discoverer\Tokenizer\DirectoriesDiscoverer(
        new \Spiral\Discoverer\Tokenizer\ComposerRegistry(), 
    )
);

if ($app->run() !== null) {
    $code = (int)$app->serve();
    exit($code);
}
```

### Bootloaders discoverer

It will help you to register bootloaders from different sources

#### From composer

Will register bootloaders from application `composer.json` and from other installed composer packages

```php
new \Spiral\Discoverer\Bootloader\ComposerRegistry(),
```

**Package composer.json**

```json
{
  // ...
  "extra": {
    "spiral": {
      "bootloaders": [
        "Spiral\\Monolog\\Bootloader\\DotenvBootloader",
        "Spiral\\DotEnv\\Bootloader\\MonologBootloader"
      ],
      "dont-discover": [
        "spiral-packages/event-bus"
      ]
    }
  }
}
```

**Application composer.json**

```json
{
  // ...
  "extra": {
    "spiral": {
      "dont-discover": [
        "spiral-packages/foo",
        "spiral-packages/bar"
      ]
    }
  }
}
```

#### From array

Will register bootloaders from the passed array

```php
new \Spiral\Discoverer\Bootloader\ArrayRegistry([
    // Application specific logs
    Bootloader\LoggingBootloader::class,
    
    // ...
]),
```

#### From config

```php
new \Spiral\Discoverer\Bootloader\ConfigRegistry(),
```

```php
// config/discoverer.php
<?php

declare(strict_types=1);

return [
    'bootloaders' => [
        // Core Services
        Framework\SnapshotsBootloader::class,
        Framework\I18nBootloader::class,

        // Security and validation
        Framework\Security\EncrypterBootloader::class,
        Framework\Security\ValidationBootloader::class,
        Framework\Security\FiltersBootloader::class,
        Framework\Security\GuardBootloader::class,
    ],
    'ignoredBootloaders' => [
        // ...
    ],
];
```

#### Custom Bootloader registry

You have the ability to create your custom Registries by
implementing `Spiral\Discoverer\Bootloader\BootloaderRegistryInterface`

```php
use Spiral\Discoverer\Bootloader\BootloaderRegistryInterface;
use Spiral\Core\Container;
use Spiral\Files\FilesInterface;

final class JsonRegistry implements BootloaderRegistryInterface
{
    private array $bootloaders = [];
    private array $ignorableBootloaders = [];
 
    public function __construct(
        private string $jsonPath
    ) {
    }
    
    public function init(Container $container): void
    {
        // json structure
        // {
        //    "bootloaders": [
        //        "Framework\Security\EncrypterBootloader",
        //        "Framework\Security\GuardBootloader"
        //    ],
        //    "ignored_bootloaders": []
        //}
        
        $files = $container->get(FilesInterface::class);
        $data = \json_decode($files->read($this->jsonPath), true);
        
        $this->bootloaders = $data['bootloaders'] ?? [];
        $this->ignorableBootloaders = $data['ignored_bootloaders'] ?? [];
    }

    public function getBootloaders(): array
    {
        return $this->bootloaders;
    }

    public function getIgnoredBootloaders(): array
    {
        return $this->ignorableBootloaders;
    }
}
```

### Tokenizer directories discoverer

It will help you to register Tokenizer directories from different sources

#### From composer

Will register directories from application `composer.json` and from other installed composer packages

**Package composer.json**

```json
{
  // ...
  "extra": {
    "spiral": {
      "directories": [
        "src/Entities"
      ]
    }
  }
}
```

**Application composer.json**

```json
{
  // ...
  "extra": {
    "spiral": {
      "directories": {
        "self": [
          "src/Events"
        ],
        "spiral-package/event-bus": [
          "src/Events"
        ],
        "spiral-package/notifications": "src/Events"
      }
    }
  }
}
```

```php
new \Spiral\Discoverer\Tokenizer\ComposerRegistry(), 
```

#### Custom Directory registry

You have the ability to create your custom Registries by
implementing `Spiral\Discoverer\Tokenizer\DirectoryRegistryInterface`

```php
use Spiral\Discoverer\Tokenizer\DirectoryRegistryInterface;
use Spiral\Core\Container;
use Spiral\Files\FilesInterface;

final class JsonRegistry implements DirectoryRegistryInterface
{
    private array $directories = [];
 
    public function __construct(
        private string $jsonPath
    ) {
    }
    
    public function init(Container $container): void
    {
        // json structure
        // {
        //    "directories": [
        //        "src/Listeners",
        //        "src/Entities"
        //    ]
        // }
        
        $root = $container->get(\Spiral\Boot\DirectoriesInterface::class)->get('root');
        
        $files = $container->get(FilesInterface::class);
        $data = \json_decode($files->read($this->jsonPath), true);
        
        $this->directories = \array_map(function (string $dir) use($root) {
            return $root . $dir;
        }, $data['directories'] ?? []);
    }

    public function getDirectories(): array
    {
        return $this->directories;
    }
}
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [butschster](https://github.com/spiral-packages)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
