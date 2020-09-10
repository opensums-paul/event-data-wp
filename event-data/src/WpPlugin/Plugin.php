<?php
/**
 * This file is part of the OpenSums WpPlugin framework.
 *
 * @package    event-data-wp-plugin
 * @copyright  Copyright 2020 OpenSums https://opensums.com/
 * @license    MIT
 */

namespace EventData\WpPlugin;

/**
 * Base class for a WordPress plugin.
 */
abstract class Plugin {
    // --- YOU MUST OVERRIDE THESE IN THE PLUGIN CLASS -------------------------
    /** @var string Name of the admin class (optional). */
    protected $adminClass;

    /** @var string Path to the plugin's templates (optional). */
    protected $templatePath;

    /** @var string Plugin human name. */
    protected $name;

    /** @var string Plugin slug (aka text domain). */
    protected $slug;

    /** @var string Plugin version. */
    protected $version;

    // -------------------------------------------------------------------------

    /** @var mixed[] Global variables for templates. */
    protected $templateGlobals = [];

    // -------------------------------------------------------------------------

    final public function __construct() {
        if ($this->templatePath) {
            $this->templatePath = realpath($this->templatePath);
            $this->templateGlobals = [
                'plugin' => [
                    'name' => $this->name,
                    'slug' => $this->slug,
                    'version' => $this->version,
                ],
            ];
        }
    }

    public function getName() {
        return $this->name;
    }

    public function getVersion() {
        return $this->version;
    }

    // Refactor after here -----------------------------------------------------

    /**
     * Load the plugin.
     */
    final public function load() {
        $this->childLoad();

        // Load the module admin hooks if on an admin page.
        $cls = $this->adminClass;
        if (is_admin() && $cls) {
            (new $cls($this))->load();
        }
    }

    final public function render($template, $vars) {
        extract($this->templateGlobals);
        extract($vars);
        require("{$this->templatePath}/templates/{$template}.tpl.php");
    }

    /**
     * Get a prefixed slug.
     *
     * @param string $slug The slug to be prefixed.
     * @param string $separator A separator to use instead of `-`.
     * @return string The slug with an added prefix.
     */
    final public function slugify(string $slug = null, $separator = null): string {
        // Add the prefix.
        $ret = $slug === null ? $this->slug : "{$this->slug}-{$slug}";
        // Return the kebab-cased slug...
        if ($separator === null) return $ret;
        // ...or replace with another separator (usually an _)/
        return str_replace('-', $separator, $ret);
    }

    /**
     * Called by load(), override in the child class.
     */
    protected function childLoad() {}
}
