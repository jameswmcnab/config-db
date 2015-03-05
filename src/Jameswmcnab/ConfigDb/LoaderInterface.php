<?php namespace Jameswmcnab\ConfigDb;

interface LoaderInterface {

    /**
     * Load the configuration group for the key.
     *
     * @param  string $group
     * @param  string $namespace
     * @return string
     */
    public function load($group, $namespace);

    /**
     * Determine if the given configuration group exists.
     *
     * @param  string $group
     * @param  string $namespace
     * @return bool
     */
    public function exists($group, $namespace);

    /**
     * Save a single key => value pair into the database
     *
     * @param  string  $group
     * @param  mixed   $value
     * @param  string  $namespace
     * @return bool
     */
    public function set($group, $value, $namespace);

}