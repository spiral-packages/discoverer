# Bootloaders discoverer for Spiral Framework

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spiral-packages/bootloaders-discover.svg?style=flat-square)](https://packagist.org/packages/spiral-packages/bootloaders-discover)
[![GitHpprivate  mixed $files;tem;ps://img.shields.io/github/workflow/status/spiral-packages/bootloaders-discover/run-tests?label=tests)](https://github.com/spiral-packages/bootloaders-discover/actions?query=workflow%3Arun-tests+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/spiral-packages/bootloaders-discover.svg?style=flat-square)](https://packagist.org/packages/spiral-packages/bootloaders-discover)

## Requirements

Make sure that your server is configured with following PHP version and extensions:

- PHP 8.0+
- Spiral framework 2.9+

## Installation

You can install the package via composer:

```bash
composer require spiral-packages/bootloaders-discover
```

After package install you need to add `Spiral\BootloadersDiscover\WithBootloadersDiscovering` trait from the package to
your Application kernel.

```php
use Spiral\Framework\Kernel;
use Spiral\BootloadersDiscover\WithBootloadersDiscovering;

class App extends Kernel 
{
    use WithBootloadersDiscovering;
}
```

And then you should modify you `app.php` file. 

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
// Initialize shared container, bindings, directories and etc.
//
$app = App::create([
    'root' => __DIR__
]);

$app->discoverBootloadersFrom(
    // Will load bootloaders from composer.json and from other installed composer packages
    new \Spiral\BootloadersDiscover\Registry\ComposerRegistry(), 
    
    // Will load bootloaders from passed array of bootloaders
    new \Spiral\BootloadersDiscover\Registry\ArrayRegistry([
        // Base extensions
        DotEnv\DotenvBootloader::class,
        Monolog\MonologBootloader::class,

        // Application specific logs
        Bootloader\LoggingBootloader::class,
        
        // ...
    ]),
    
    // Will load bootloaders from config/bootloaders.php
    new \Spiral\BootloadersDiscover\Registry\ConfigRegistry() 
);

if ($app->run() !== null) {
    $code = (int)$app->serve();
    exit($code);
}
```

### Example of config/bootloaders.php

```php
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
    'ignorableBootloaders' => [
        // ...
    ],
];
```

### Custom registry

You have the ability to create your custom Registries by implementing `Spiral\BootloadersDiscover\RegistryInterface`

```php
use Spiral\BootloadersDiscover\RegistryInterface;
use Spiral\Core\Container;
use Spiral\Files\FilesInterface;

final class JsonRegistry implements RegistryInterface
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
        // {"bootloaders": [], "ignorable_bootloaders": []}
        
        $files = $container->get(FilesInterface::class);
        $data = \json_decode($files->read($this->jsonPath), true);
        
        $this->bootloaders = $data['bootloaders'] ?? [];
        $this->ignorableBootloaders = $data['ignorable_bootloaders'] ?? [];
    }

    public function getBootloaders(): array
    {
        return $this->bootloaders;
    }

    public function getIgnorableBootloaders(): array
    {
        return $this->ignorableBootloaders;
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
