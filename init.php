<?php
/**
 * Initialise the plugin
 *
 * This file can use syntax from the required level of PHP or later.
 *
 * @package      Gamajo\PluginSlug
 * @author       Gary Jones
 * @copyright    2020 Gary Jones
 * @license      GPL-2.0-or-later
 */

declare(strict_types = 1);

namespace MediaZoo\MediaZooPlugin;

use BrightNucleus\Config\ConfigFactory;

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

if (!defined('MEDIA_ZOO_DIR')) {
    define('MEDIA_ZOO_DIR', plugin_dir_path(__FILE__));
}

if (!defined('MEDIA_ZOO_URL')) {
    define('MEDIA_ZOO_URL', plugin_dir_url(__FILE__));
}

// Load Composer autoloader.
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
}

// Initialize the plugin.
$GLOBALS['media_zoo'] = new Plugin(ConfigFactory::create(__DIR__ . '/config/defaults.php')->getSubConfig('MediaZoo\MediaZooPlugin'));
$GLOBALS['media_zoo']->run();
