# Filament Inline Date-time Picker

[![Filament 5.x](https://img.shields.io/badge/filament-5.x-EBB304?style=flat-square)](https://filamentphp.com/docs/5.x/introduction/installation)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/jacobtims/inline-date-time-picker.svg?style=flat-square)](https://packagist.org/packages/jacobtims/inline-date-time-picker)
[![Total Downloads](https://img.shields.io/packagist/dt/jacobtims/inline-date-time-picker.svg?style=flat-square&color=#44CC11)](https://packagist.org/packages/jacobtims/inline-date-time-picker)

![Screenshot](./art/preview.png)

A Filament plugin for adding inline date-time pickers to your forms.


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

You can use all of the methods available for the Filament [Date-time picker](https://filamentphp.com/docs/4.x/forms/date-time-picker) field, except for the prefix and suffix methods.

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
