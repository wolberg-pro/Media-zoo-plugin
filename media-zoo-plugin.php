<?php
/**
 * Plugin Name
 *
 * This file should only use syntax available in PHP 5.6 or later.
 *
 * @package      MediaZoo\MediaZooPlugin
 * @author       Sivan Wolberg
 * @copyright    2020 Wolberg pro
 *
 *
 * @wordpress-plugin
 * Plugin Name:       Media Zoo Plugin
 * Plugin URI:        https://github.com/garyjones/...
 * Description:       ...
 * Version:           1.0
 * Author:            Sivan Wolberg
 * Author URI:        https://garyjones.io
 * Text Domain:       media-zoo-plugin
 * Requires PHP:      7.0
 * Requires WP:       5.3
 */

namespace MediaZoo\MediaZooPlugin;
error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE ^  E_DEPRECATED);
// If this file is called directly, abort.
if (!defined('WPINC')) {
	die;
}

require_once __DIR__ . '/vendor/autoload.php';
require_once(__DIR__ . '/src/common/functions.php');

if (!defined('MediaZoo_DIR')) {
	define('MediaZoo_DIR', plugin_dir_path(__FILE__));
}

if (!defined('MediaZoo_URL')) {
	define('MediaZoo_URL', plugin_dir_url(__FILE__));
}

define('MediaZoo_VERSION', '1.0.0');
/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-plugin-name-activator.php
 */


register_activation_hook(__FILE__, function () {
	require_once plugin_dir_path(__FILE__) . 'src/class-plugin-name-activator.php';
	MediaZoo_Activator::activate();

});

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-plugin-name-deactivator.php
 */

register_deactivation_hook(__FILE__, function () {
	require_once plugin_dir_path(__FILE__) . 'src/class-plugin-name-deactivator.php';
	MediaZoo_Deactivator::deactivate();
});
/**
 * Load plugin initialisation file.
 */
require plugin_dir_path(__FILE__) . '/init.php';
