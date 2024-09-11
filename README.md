# A plugin for adding inline date time pickers to your Filament forms.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/jacobtims/inline-date-time-picker.svg?style=flat-square)](https://packagist.org/packages/jacobtims/inline-date-time-picker)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/jacobtims/inline-date-time-picker/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/jacobtims/inline-date-time-picker/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/jacobtims/inline-date-time-picker/fix-php-code-styling.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/jacobtims/inline-date-time-picker/actions?query=workflow%3A"Fix+PHP+code+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/jacobtims/inline-date-time-picker.svg?style=flat-square)](https://packagist.org/packages/jacobtims/inline-date-time-picker)



This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Installation

You can install the package via composer:

```bash
composer require jacobtims/inline-date-time-picker
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="inline-date-time-picker-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="inline-date-time-picker-config"
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="inline-date-time-picker-views"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage

```php
$inlineDateTimePicker = new Jacobtims\InlineDateTimePicker();
echo $inlineDateTimePicker->echoPhrase('Hello, Jacobtims!');
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

- [Jacobtims](https://github.com/Jacobtims)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
