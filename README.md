Doctrine Tools
====

![Build Status](https://github.com/headsnet/doctrine-tools-bundle/actions/workflows/ci.yml/badge.svg)
![Coverage](https://raw.githubusercontent.com/headsnet/doctrine-tools-bundle/image-data/coverage.svg)
[![Latest Stable Version](https://poser.pugx.org/headsnet/doctrine-tools-bundle/v)](//packagist.org/packages/headsnet/doctrine-tools-bundle)
[![Total Downloads](https://poser.pugx.org/headsnet/doctrine-tools-bundle/downloads)](//packagist.org/packages/headsnet/doctrine-tools-bundle)
[![License](https://poser.pugx.org/headsnet/doctrine-tools-bundle/license)](//packagist.org/packages/headsnet/doctrine-tools-bundle)

Various tools and helpers for using Doctrine ORM in larger Symfony projects.

## Installation

```bash
composer require headsnet/doctrine-tools
```
If your Symfony installation does not auto-register bundles, add it manually:

```php
// bundles.php
return [
    ...
    Headsnet\DoctrineToolsBundle\HeadsnetDoctrineToolsBundle::class => ['all' => true],
];
```

## Features

### Auto-Register Custom Column Types

The bundle can auto-register custom Doctrine DBAL types, eliminating the need to specify them all in 
`config/packages/doctrine.yaml`:

Define the directories to scan for Doctrine types:

```yaml
headsnet_doctrine_tools:
  custom_types:
    scan_dirs:
      - 'src/Infra/Persistence/DBAL/Types'
```

Then add the `#[CustomType]` attribute to the custom type class:

```php
use Doctrine\DBAL\Types\Type;

#[CustomType]
final class CarbonDateTimeType extends Type
{
    ...
}
```

This will register a custom type based on the class name - in this case the custom column type will be called 
`carbon_date_time`.

To customise the type name, specify it in the `#[CustomType]` attribute - e.g. the following will register a type 
called `custom_carbon_datetime`.

```php
#[CustomType(name: 'custom_carbon_datetime')]
```

## Contributions

Contributions are welcome via Pull Requests. Please include a single change in each PR.

## License

Released under the [MIT License](LICENSE).
