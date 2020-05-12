<?php

/**
 * Loading Zone
 *
 * @package      MediaZoo\MediaZooPlugin
 * @author       Sivan Wolberg
 * @copyright    2020 Wolberg pro
 */


namespace MediaZoo\MediaZooPlugin;

use BrightNucleus\Config\ConfigFactory;

// If this file is called directly, abort.
if (!defined('WPINC')) {
	die;
}

if (!defined('MediaZoo_DIR')) {
	define('MediaZoo_DIR', plugin_dir_path(__FILE__));
}

if (!defined('MediaZoo_URL')) {
	define('MediaZoo_URL', plugin_dir_url(__FILE__));
}

define('MediaZoo_VERSION', '1.0.0');
// Load Composer autoloader.
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
	require_once __DIR__ . '/vendor/autoload.php';
}
/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-plugin-name-activator.php
 */
function activate_plugin_name()
{
	require_once plugin_dir_path(__FILE__) . 'src/class-plugin-name-activator.php';
	MediaZoo_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-plugin-name-deactivator.php
 */
function deactivate_plugin_name()
{
	require_once plugin_dir_path(__FILE__) . 'src/class-plugin-name-deactivator.php';
	MediaZoo_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_plugin_name');
register_deactivation_hook(__FILE__, 'deactivate_plugin_name');
/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'src/class-plugin-name.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_plugin_name()
{
	$plugin = new  MediaZoo(ConfigFactory::create(__DIR__ . '/config/defaults.php')->getSubConfig('MediaZoo\MediaZooPlugin'));
	$plugin->run();
}

run_plugin_name();
