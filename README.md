# Filament Inline Date-time Picker

[![Filament 3.x](https://img.shields.io/badge/filament-3.x-EBB304?style=flat-square)](https://filamentphp.com/docs/3.x/panels/installation)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/jacobtims/inline-date-time-picker.svg?style=flat-square)](https://packagist.org/packages/jacobtims/inline-date-time-picker)
[![Total Downloads](https://img.shields.io/packagist/dt/jacobtims/inline-date-time-picker.svg?style=flat-square&color=#44CC11)](https://packagist.org/packages/jacobtims/inline-date-time-picker)

![Screenshot](https://github.com/jacobtims/inline-date-time-picker/blob/main/media/1.png?raw=true)

A Filament plugin for adding inline Date-time Pickers to your Filament forms.


## Installation

You can install the package via composer:

```bash
composer require jacobtims/inline-date-time-picker
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="inline-date-time-picker-views"
```

## Usage

You can use all of the methods available for the Filament [Date-time picker](https://filamentphp.com/docs/3.x/forms/fields/date-time-picker) field, except for the prefix and suffix methods.

```php
use Jacobtims\InlineDateTimePicker\Forms\Components\InlineDateTimePicker;

InlineDateTimePicker::make('date')
    ->label('My Inline Date Time Picker')
    ->default(today())
    ->minDate(today())
    ->date(true)
    ->time(false)
    ->required();
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
