<?php namespace Jameswmcnab\ConfigDb;

interface RepositoryInterface
{

    /**
     * Determine if the given configuration value exists.
     *
     * @param  string $key
     * @return bool
     */
    public function has($key);

    /**
     * Determine if a configuration group exists.
     *
     * @param  string $key
     * @return bool
     */
    public function hasGroup($key);

    /**
     * Get a single item or group of items by key.
     *
     * @param  string $key
     * @param  mixed  $default
     * @return string|array
     */
    public function get($key, $default = null);

    /**
     * Save a single key => value pair into the database
     *
     * @param  string  $key
     * @param  mixed   $value
     * @return bool
     */
    public function set($key, $value);

    /**
     * Save a single key => value pair into the database
     *
     * @param  string  $key
     * @param  mixed   $value
     * @return bool
     */
    public function save($key, $value);

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

    /**
     * Get the loader implementation.
     *
     * @return \Jameswmcnab\ConfigDb\LoaderInterface
     */
    public function getLoader();

    /**
     * Set the loader implementation.
     *
     * @param  \Jameswmcnab\ConfigDb\LoaderInterface $loader
     * @return void
     */
    public function setLoader(LoaderInterface $loader);
}
