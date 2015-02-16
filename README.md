# Database config loader for Laravel
This package provides simple database config storage and loading for Laravel, in the form of a single table to 
store key => value pairs.

## Installation
Require this package in your `composer.json` file:

~~~json
"jameswmcnab/config-yaml": "dev-master"
~~~

And add the ServiceProvider to the `providers` array in `app/config/app.php` file:

~~~php
'Jameswmcnab\ConfigYaml\ConfigYamlServiceProvider',
~~~

Publish the package config using Artisan (If you want to change the default YAML config file directory).

~~~bash
php artisan config:publish jameswmcnab/config-yaml
~~~

## Usage

### Get configuration by key:

~~~yaml
# Example YAML config.yaml file
app:
  name: "Great App"
  version: 1.0.2

log:
  dir: /var/log/vendor/app
  level: debug

database:
  adapter: mysql
  database: app_live
  username: user
  password: password
~~~

~~~php
ConfigYaml::get('config.database.adapter'); // mysql
~~~