# Database configuration loader for Laravel

[![Build Status](https://travis-ci.org/jameswmcnab/config-db.svg)](https://travis-ci.org/jameswmcnab/config-db)
[![Latest Stable Version](https://poser.pugx.org/jameswmcnab/config-db/v/stable)](https://packagist.org/packages/jameswmcnab/config-db)
[![Latest Unstable Version](https://poser.pugx.org/jameswmcnab/config-db/v/unstable)](https://packagist.org/packages/jameswmcnab/config-db)
[![Total Downloads](https://poser.pugx.org/jameswmcnab/config-db/downloads)](https://packagist.org/packages/jameswmcnab/config-db)
[![License](https://poser.pugx.org/jameswmcnab/config-db/license)](https://packagist.org/packages/jameswmcnab/config-db)

This package provides simple database config storage and loading for Laravel, in the form of a single table to
store key => value pairs.

## Laravel Versions

| Laravel | This Package |
| --- | --- |
| 5.4.* | ^2.0 |

Make sure you consult the Upgrade Guide (`UPGRADE.md`) when upgrading.

## Installation

Begin by pulling in the package through Composer.

```bash
composer require jameswmcnab/db-config
```

Next include the service provider within your `config/app.php` file.

```php
'providers' => [
    Jameswmcnab\ConfigDb\ConfigDbServiceProvider::class,
];
```

If you wish to use the `ConfigDb` facade in your application, register within your `config/app.php` file.

```php
'aliases' => [
    'ConfigDb' => Jameswmcnab\ConfigDb\Facades\ConfigDb::class,
];
```

Finally run the migrations to create the database table:

```bash
php artisan migrate
```

## Customising the database table name

If you want to change the default config table name to something other than `config` then publish the
package config:

```bash
php artisan vendor:publish --provider="Jameswmcnab\ConfigDb\ConfigDbServiceProvider"
```

Then edit `config/config-db.php` in your main application directory to change the table name. Note that you'll need
to do this **before** running the migration.

## Usage

### Save configuration by key:

```php
ConfigDb::save('foo', 'bar');
```

### Get configuration by key:

```php
ConfigDb::get('foo'); // bar
```
