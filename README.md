# Laravel Doctrine Scout

<img src="https://cloud.githubusercontent.com/assets/7728097/18224341/32631f7e-71d2-11e6-9092-e97a647c9a8b.jpg"/>

[![GitHub release](https://img.shields.io/github/release/laravel-doctrine/scout.svg?style=flat-square)](https://packagist.org/packages/laravel-doctrine/scout)
[![Travis](https://img.shields.io/travis/laravel-doctrine/scout.svg?style=flat-square)](https://travis-ci.org/laravel-doctrine/scout)
[![StyleCI](https://styleci.io/repos/66964312/shield)](https://styleci.io/repos/66964312)
[![Packagist](https://img.shields.io/packagist/dm/laravel-doctrine/scout.svg?style=flat-square)](https://packagist.org/packages/laravel-doctrine/scout)
[![Packagist](https://img.shields.io/packagist/dt/laravel-doctrine/scout.svg?style=flat-square)](https://packagist.org/packages/laravel-doctrine/scout)

*A drop-in Doctrine ORM 2 implementation for Laravel Scout*

```php
$repository->search('Albert Einstein')->get()
```

## Documentation

[Read the full documentation](http://www.laraveldoctrine.org/docs/current/scout).

## Versions

Version | Supported Laravel Versions
:---------|:----------
1.0.x | 5.3.x

Require this package  

```php
composer require "laravel-doctrine/scout"
```

After adding the package, add the ServiceProvider to the providers array in `config/app.php`

```php
Laravel\Scout\ScoutServiceProvider::class,
LaravelDoctrine\Scout\ScoutServiceProvider::class,
```

To publish the config use:

```php
php artisan vendor:publish --tag="config"
```

## License

This package is licensed under the [MIT license](https://github.com/laravel-doctrine/scout/blob/master/LICENSE).
