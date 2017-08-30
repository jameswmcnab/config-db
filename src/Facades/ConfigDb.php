<?php namespace Jameswmcnab\ConfigDb\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Jameswmcnab\ConfigDb\Repository
 */
class ConfigDb extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'config-db'; }

}