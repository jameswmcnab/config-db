<?php namespace Jameswmcnab\ConfigDb;

use Illuminate\Database\DatabaseManager;
use Illuminate\Support\NamespacedItemResolver;

class DbLoader extends NamespacedItemResolver implements LoaderInterface {

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
     * Get a query builder instance for the config table.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    protected function table()
    {
        return $this->db->connection()->table($this->tableName);
    }

    /**
     * Load the configuration group for the key.
     *
     * @param  string $group
     * @param  string $namespace
     * @return null|string|array
     */
    public function load($group, $namespace)
    {
        $items = null;

        // Get database key prefix
        $prefix = $this->getKeyPrefix($namespace);

        // Set database key
        $databaseKey = "{$prefix}{$group}";

        // Get items matching database key
        $config = $this->table()->where('key', 'LIKE', $databaseKey.'%')->lists('value', 'key');

        if ($config)
        {
            foreach ($config as $key => $value)
            {
                list(, , $key) = $this->parseKey($key);
                array_set($items, $key, $value);
            }
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
    public function exists($group, $namespace)
    {
        $key = $group.$namespace;

        // We'll first check to see if we have determined if this namespace and
        // group combination have been checked before. If they have, we will
        // just return the cached result so we don't have to hit the disk.
        if (isset($this->exists[$key]))
        {
            return $this->exists[$key];
        }

        // To check if a group exists, we will simply get the prefix based on the
        // namespace, and then check to see if this config key exists within that
        // namespace. False is returned if no path exists for a namespace.
        if (is_null($namespace))
        {
            return $this->exists[$key] = false;
        }

        $prefix = $this->getKeyPrefix($namespace);

        // Set database key
        $databaseKey = "{$prefix}{$group}";

        // Finally, we can simply check if this key exists our config
        // database table. We will also cache the value in an array so
        // we don't have to go through this process again on subsequent
        // checks for the existing of the database config value.
        $exists = $this->configKeyExists($databaseKey);

        return $this->exists[$key] = $exists;
    }

    /**
     * Save a single key => value pair into the database
     *
     * @param  string  $key
     * @param  mixed   $value
     * @param  string  $namespace
     * @return bool
     */
    public function set($key, $value, $namespace = null)
    {
        // Get database key prefix
        $prefix = $this->getKeyPrefix($namespace);

        // Convert non-array values to array
        if (!is_array($value))
        {
            $value = [$key => $value];
        }

        // Convert array to dot.syntax key=>value pairs
        $config = array_dot($value, "{$prefix}::{$key}.");

        // Store all of the config values in the database, inside a transaction
        return $this->db->connection()->transaction(function() use ($config)
        {
            return $this->storeMultiple($config);
        });
    }

    /**
     * Store an array of key => value pairs in the config database.
     *
     * @param  array  $config
     * @return bool
     */
    protected function storeMultiple(array $config)
    {
        foreach ($config as $key => $value)
        {
            $this->store($key, $value);
        }
    }

    /**
     * Store a value in the config table by key.
     *
     * @param  string  $key
     * @param  mixed   $key
     * @return bool|int
     */
    protected function store($key, $value)
    {
        if ($this->configKeyExists($key))
        {
            return $this->table()->where('key', '=', $key)->update(['value' => $value]);
        }

        return $this->table()->insert(['key' => $key, 'value' => $value]);
    }

    /**
     * Check if a key exists in the config table.
     *
     * @param $key
     * @return bool
     */
    protected function configKeyExists($key)
    {
        return $this->table()->where('key','LIKE', $key . '%')->exists();
    }

    /**
     * @param $namespace
     * @return null|string
     */
    protected function getKeyPrefix($namespace)
    {
        $prefix = $namespace ? $namespace.'::' : null;

        return $prefix;
    }

}