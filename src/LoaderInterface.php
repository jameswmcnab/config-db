<?php namespace Jameswmcnab\ConfigDb;

interface LoaderInterface
{

    /**
     * Load the configuration group for the key.
     *
     * @param  string $group
     * @param  string $namespace
     * @return string
     */
    public function load($group, $namespace = null);

    /**
     * Determine if the given configuration group exists.
     *
     * @param  string $group
     * @param  string $namespace
     * @return bool
     */
    public function exists($group, $namespace = null);

    /**
     * Save a single key => value pair into the database
     *
     * @param  string  $group
     * @param  mixed   $value
     * @param  string  $namespace
     * @return bool
     */
    public function save($group, $value, $namespace = null);

    /**
     * Add a new namespace to the loader.
     *
     * @param  string $namespace
     * @param  string $hint
     * @return void
     */
    public function addNamespace($namespace, $hint);

    /**
     * Returns all registered namespaces with the config
     * loader.
     *
     * @return array
     */
    public function getNamespaces();
}
