# Discoverer for Spiral Framework

[![PHP Version Require](https://poser.pugx.org/spiral-packages/discoverer/require/php)](https://packagist.org/packages/spiral-packages/discoverer)
[![Latest Stable Version](https://poser.pugx.org/spiral-packages/discoverer/v/stable)](https://packagist.org/packages/spiral-packages/discoverer)
[![phpunit](https://github.com/spiral-packages/discoverer/actions/workflows/phpunit.yml/badge.svg)](https://github.com/spiral-packages/discoverer/actions)
[![psalm](https://github.com/spiral-packages/discoverer/actions/workflows/psalm.yml/badge.svg)](https://github.com/spiral-packages/discoverer/actions)
[![Total Downloads](https://poser.pugx.org/spiral-packages/discoverer/downloads)](https://packagist.org/spiral-packages/discoverer/phpunit)

The `spiral-packages/discoverer` package is a useful tool for the Spiral framework. It enhances the framework by allowing the discovery of bootloaders and tokenizer directories from sources beyond the Application kernel. This feature simplifies the process of managing and integrating various packages in your Spiral application.

**Features**

1. **Automatic Discovery of Bootloaders**: Automates the process of discovering and registering bootloaders from installed packages, significantly simplifying the integration and setup process in Spiral applications.
    
2. **Composer.json Integration**: The package leverages the `composer.json` file of other packages to define bootloaders and tokenizer directories. This integration streamlines the configuration process, making it easier for developers to manage package settings.
    
3. **Custom Registry Support**: The package allows for the creation of custom bootloader and tokenizer registries. This flexibility enables developers to tailor the discovery process to their specific needs, enhancing the customization and scalability of their Spiral applications.

## Requirements

Make sure that your server is configured with following PHP version and extensions:

- PHP 8.1+
- Spiral Framework version 3.10 or higher

## Documentation, Installation, and Usage Instructions

See the [documentation](https://spiral.dev/docs/component-discoverer) for detailed installation and usage instructions.

## Testing

```bash
composer test
```

## Credits

- [butschster](https://github.com/butschster)
- [msmakouz](https://github.com/msmakouz)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
