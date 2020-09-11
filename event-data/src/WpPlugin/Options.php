<?php

declare(strict_types=1);

namespace ApiData\WpPlugin;

/**
 * Abstraction for the wp_options API.
 *
 * Access configuration with these methods:
 * * `$config->set('key', $anyValue)` to store $anyValue.
 * * `$config->get('key')` - to get a single value.
 * * `$config->all()` - to get all values.
 * * `$config->all(true)` - to get all loaded values.
 * * `$config->has('key')` - check if a key is defined.
 *
 * Configuration is set up using
 * * `$config->activate()
 * * `$config->uninstall()
 * 
 * Other
 * * `$config->flush() - to save all changes (also called by __destruct).
 */
class Options {

    /** @var string snake_cased option_name for the wp_options table. */
    protected $wpOptionName;

    /**
     * Constructor.
     *
     * @param Plugin $plugin The plugin that owns the options.
     * @param string $name   A name for the set of options.
     */
    public function __construct($plugin, $name) {
        // Save a snake_case version of the plugin slug.
        $this->wpOptionName = $plugin->slugify(str_to_lower($name), '_');
    }

    // Refactor after here -----------------------------------------------------

    /** @var string[] Dirty entries. */
    protected $dirty = [];

    /** @var mixed[] Values for entries that have been loaded. */
    protected $values = [];


    /**
     * Destructor.
     */
    public function __destruct() {
        $this->flush();
    }

    /**
     * Get the values of all entries, or all loaded entries.
     *
     * @param bool $loaded Iff true returns only loaded entries
     * @return mixed[] The entry values
     */
    public function all(): array {
        return $this->values;
    }

    /**
     * Flush all persistent entries.
     *
     * @return self  Chainable
     */
    public function flush(): self {
        foreach ($this->dirty as $key => $isDirty) {
            if ($isDirty) {
                $this->wpOptionUpdate($key, $this->values[$key]);
            }
            $this->dirty = [];
        }
        return $this;
    }

    /**
     * 
     * Get the value of an entry.
     *
     * @param  string $key     The key
     * @param  mixed  $default Default value
     * @return mixed  The value or the default value if the entry does not exist
     */
    public function get($key, $default = null) {
        if (array_key_exists($key, $this->values)) {
            return $this->values[$key];
        }
        return $default;
    }

    /**
     * Returns true iff the entry is defined.
     *
     * @param string $key The key
     *
     * @return bool true if the entry exists, false otherwise
     */
    public function has($key) {
        return array_key_exists($key, $this->values);
    }

    /**
     * Returns entry keys.
     *
     * @return array An array of parameter keys
     */
    public function keys(): array {
        return array_keys($this->values);
    }

    /**
     * Sets the value of an entry.
     *
     * @param string $key   The key
     * @param mixed  $value The value
     * @return self  Chainable
     */
    public function set(string $key, $value): self {
        $this->values[$key] = $value;
        $this->dirty[$key] = true;
        return $this;
    }

    /**
     * Unsets (deletes) an entry.
     *
     * @param string $key   The key
     * @return self  Chainable
     */
    public function unset(string $key): self {
        if (array_key_exists($key, $this->values)) {
            unset($this->values[$key]);
        }
        $this->dirty[$key] = false;
        $this->wpOptionDelete($key);
        return $this;
    }

    /**
     * Convert a string to snake case.
     */
    protected function kebabCaseToSnakeCase(string $key): string {
        return str_replace('-', '_', $key);
    }

    /** Create a wp_options entry with optional autoload. */
    protected function wpOptionCreate(string $name, $value, bool $autoload = false) {
        \add_option("{$this->wpPrefix}$name", $value, null, $autoload);
    }

    /** Get a wp_options entry. */
    protected function wpOptionRetrieve(string $name) {
        \get_option("{$this->wpPrefix}$name");
    }

    /** Update a wp_options entry. */
    public function wpOptionUpdate(string $name, $value) {
        \update_option("{$this->wpPrefix}$name", $value);
    }

    /** Delete a wp_options entry. */
    public function wpOptionDelete(string $name) {
        \delete_option("{$this->wpPrefix}$name");
    }
}
