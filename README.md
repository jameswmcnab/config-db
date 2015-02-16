# Database config loader for Laravel
This package provides simple database config storage and loading for Laravel, in the form of a single table to 
store key => value pairs.

## Installation
Require this package in your `composer.json` file:

~~~json
"jameswmcnab/config-db": "dev-master"
~~~

And add the ServiceProvider to the `providers` array in `app/config/app.php` file:

~~~php
'Jameswmcnab\ConfigDb\ConfigDbServiceProvider',
~~~

Run the package migrations to create the config table:

~~~bash
php artisan migrate --package="jameswmcnab/config-db"
~~~

Publish the package config using Artisan (If you want to change the default config table name to something other than `config`).

~~~bash
php artisan config:publish jameswmcnab/config-db
~~~

## Usage

### Save configuration by key:

~~~php
ConfigDb::save('foo', bar);
~~~

### Get configuration by key:

~~~php
ConfigDb::get('foo'); // bar
~~~