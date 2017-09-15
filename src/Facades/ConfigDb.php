<?php

namespace Jameswmcnab\ConfigDb\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class ConfigDb
 *
 * @package Jameswmcnab\ConfigDb\Facades
 * @method static bool has(string $key)
 * @method static mixed get(string $key, $default = null)
 * @method static bool save(string $key, $value)
 */
class ConfigDb extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'config-db';
    }
}
