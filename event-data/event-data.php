<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://example.com
 * @package           event-data-wp
 *
 * @wordpress-plugin
 * Plugin Name:       Event Data
 * Plugin URI:        http://example.com/plugin-name-uri/
 * Description:       Integrate data from various APIs.
 * Version:           0.1.0-dev
 * Author:            OpenSums
 * Author URI:        https://opensums.com/
 * License:           MIT
 * License URI:       https://github.com/opensums/event-data-wp/LICENSE.md
 * Text Domain:       event-data
 * Domain Path:       /languages
 */

namespace EventData;

// If this file is called directly, abort.
if (!defined('WPINC')) die;

// Register a really simple class autoloader.
spl_autoload_register(function ($class) {
    $len = strlen(__NAMESPACE__);
    $path = __DIR__.'/src';
    if (strncmp(__NAMESPACE__, $class, $len) === 0) {
        $file = __DIR__.'/src'.str_replace('\\', '/', substr($class, $len)).'.php';
        if (file_exists($file)) require $file;
    }
});

(new Plugin(__DIR__))->load();

return;

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PLUGIN_NAME_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-plugin-name-activator.php
 */
function activate_plugin_name() {
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-plugin-name-activator.php';
    Plugin_Name_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-plugin-name-deactivator.php
 */
function deactivate_plugin_name() {
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-plugin-name-deactivator.php';
    Plugin_Name_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_plugin_name' );
register_deactivation_hook( __FILE__, 'deactivate_plugin_name' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-plugin-name.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_plugin_name() {

    $plugin = new Plugin_Name();
    $plugin->run();

}
run_plugin_name();
