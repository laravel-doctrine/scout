# Laravel Doctrine Scout

<img src="https://cloud.githubusercontent.com/assets/7728097/18224341/32631f7e-71d2-11e6-9092-e97a647c9a8b.jpg"/>

[![GitHub release](https://img.shields.io/github/release/laravel-doctrine/orm.svg?style=flat-square)](https://packagist.org/packages/laravel-doctrine/orm)
[![Travis](https://img.shields.io/travis/laravel-doctrine/orm.svg?style=flat-square)](https://travis-ci.org/laravel-doctrine/orm)
[![StyleCI](https://styleci.io/repos/39036008/shield)](https://styleci.io/repos/39036008)
[![Scrutinizer](https://img.shields.io/scrutinizer/g/laravel-doctrine/orm.svg?style=flat-square)](https://github.com/laravel-doctrine/orm)
[![Packagist](https://img.shields.io/packagist/dm/laravel-doctrine/orm.svg?style=flat-square)](https://packagist.org/packages/laravel-doctrine/orm)
[![Packagist](https://img.shields.io/packagist/dt/laravel-doctrine/orm.svg?style=flat-square)](https://packagist.org/packages/laravel-doctrine/orm)

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

This package is licensed under the [MIT license](https://github.com/laravel-doctrine/orm/blob/master/LICENSE).
