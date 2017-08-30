# Database config loader for Laravel
This package provides simple database config storage and loading for Laravel, in the form of a single table to 
store key => value pairs.

## Installation
First, require this package with composer:

```bash
composer require jameswmcnab/db-config
````

And add the ServiceProvider to the `providers` array in `app/config/app.php` file:

```php
'Jameswmcnab\ConfigDb\ConfigDbServiceProvider',
```

Publish the package config using Artisan (if you want to change the default config table name to something other 
than `config`).

```bash
php artisan vendor:publish --tag=config
```

Then edit `config/config-db.php` in your main application directory.

Then run the migrations to create the database table:

```bash
php artisan migrate
```

## Usage

### Save configuration by key:

```php
ConfigDb::save('foo', 'bar');
```

### Get configuration by key:

```php
ConfigDb::get('foo'); // bar
```
