<?php namespace Jameswmcnab\ConfigDb;

use Illuminate\Database\DatabaseManager;

class DbLoader implements LoaderInterface {

    /**
     * The database manager instance.
     *
     * @type \Illuminate\Database\DatabaseManager
     */
    protected $db;

    /**
     * The database table name used to store config.
     *
     * @type string
     */
    protected $tableName;

    /**
     * All of the named key hints.
     *
     * @var array
     */
    protected $hints = array();

    /**
     * A cache of whether namespaces and groups exists.
     *
     * @var array
     */
    protected $exists = array();

    /**
     * @param  \Illuminate\Database\DatabaseManager  $db
     * @param  string                                $tableName
     */
    public function __construct(DatabaseManager $db, $tableName)
    {
        $this->db = $db;
        $this->tableName = $tableName;
    }

    /**
     * Load the configuration group for the key.
     *
     * @param  string $group
     * @param  string $namespace
     * @return null|string|array
     */
    public function load($group, $namespace = null)
    {
        $items = null;

        // First we'll get the root configuration path for the environment which is
        // where all of the configuration files live for that namespace, as well
        // as any environment folders with their specific configuration items.
        $prefix = $this->getKeyPrefix($namespace);

        // The key is the group
        $key = $group;

        // If we have a prefix then we can use that
        if (!is_null($prefix))
        {
            $key .= "{$prefix}.{$key}";
        }

        if ($this->configKeyExists($key))
        {
            $items = $this->table()->where('key', 'LIKE', $key . '%')->pluck('value');
        }

        return $items;
    }

    /**
     * Determine if the given configuration group exists.
     *
     * @param  string $group
     * @param  string $namespace
     * @return bool
     */
    public function exists($group, $namespace = null)
    {
        $key = $group.$namespace;

        // We'll first check to see if we have determined if this namespace and
        // group combination have been checked before. If they have, we will
        // just return the cached result so we don't have to hit the disk.
        if (isset($this->exists[$key]))
        {
            return $this->exists[$key];
        }

        $prefix = $this->getKeyPrefix($namespace);

        // The key is the group
        $key = $group;

        // If we have a prefix then we can use that
        if (!is_null($prefix))
        {
            $key .= "{$prefix}.{$key}";
        }

        // Finally, we can simply check if this key exists our config
        // database table. We will also cache the value in an array so
        // we don't have to go through this process again on subsequent
        // checks for the existing of the database config value.
        $exists = $this->configKeyExists($key);

        return $this->exists[$key] = $exists;
    }

    /**
     * Save a single key => value pair into the database
     *
     * @param  string  $group
     * @param  mixed   $value
     * @return bool
     */
    public function save($group, $value, $namespace = null)
    {
        $prefix = $this->getKeyPrefix($namespace);

        // The key is the group
        $key = $group;

        // If we have a prefix then we can use that
        if (!is_null($prefix))
        {
            $key .= "{$prefix}.{$key}";
        }

        // Delete the existing key and insert the new data
        return $this->db->connection()->transaction(function() use ($key, $value) {
            $this->table()->where('key', '=', $key)->delete();

            return $this->table()->insert(['key' => $key, 'value' => $value]);
        });
    }

    /**
     * Add a new namespace to the loader.
     *
     * @param  string  $namespace
     * @param  string  $hint
     * @return void
     */
    public function addNamespace($namespace, $hint)
    {
        $this->hints[$namespace] = $hint;
    }

    /**
     * Returns all registered namespaces with the config
     * loader.
     *
     * @return array
     */
    public function getNamespaces()
    {
        return $this->hints;
    }

    /**
     * Get a query builder instance for the config table.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    protected function table()
    {
        return $this->db->connection()->table($this->tableName);
    }

    /**
     * Get the database key prefix for a namespace.
     *
     * @param  string  $namespace
     * @return string
     */
    protected function getKeyPrefix($namespace)
    {
        if (is_null($namespace))
        {
            return null;
        }
        elseif (isset($this->hints[$namespace]))
        {
            return $this->hints[$namespace];
        }
    }

    /**
     * Check if a key exists config table.
     *
     * @param $key
     * @return bool
     */
    protected function configKeyExists($key)
    {
        return $this->table()->where('key', '=', $key)->exists();
    }

}
