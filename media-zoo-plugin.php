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
 * Requires PHP:      7.4
 * Requires WP:       5.3
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

require_once(__DIR__ . 'src/common/functions.php');

/**
 * Load plugin initialisation file.
 */
require plugin_dir_path(__FILE__) . '/init.php';
