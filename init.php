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
