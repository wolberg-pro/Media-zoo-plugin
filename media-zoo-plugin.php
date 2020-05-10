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

if (version_compare(PHP_VERSION, '7.4', '<')) {
    add_action('plugins_loaded', 'media_zoo_init_deactivation');

    /**
     * Initialise deactivation functions.
     */
    function media_zoo_init_deactivation()
    {
        if (current_user_can('activate_plugins')) {
            add_action('admin_init', 'media_zoo_deactivate');
            add_action('admin_notices', 'media_zoo_deactivation_notice');
        }
    }

    /**
     * Deactivate the plugin.
     */
    function media_zoo_deactivate()
    {
        deactivate_plugins(plugin_basename(__FILE__));
    }

    /**
     * Show deactivation admin notice.
     */
    function media_zoo_deactivation_notice()
    {
        $notice = sprintf(
            // Translators: 1: Required PHP version, 2: Current PHP version.
            '<strong>Plugin Boilerplate</strong> requires PHP %1$s to run. This site uses %2$s, so the plugin has been <strong>deactivated</strong>.',
            '7.1',
            PHP_VERSION
        ); ?>
<div class="updated">
    <p><?php echo wp_kses_post($notice); ?></p>
</div>
<?php
// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- not using value, only checking if it is set.
        if (isset($_GET['activate'])) {
            // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- not using value, only checking if it is set.
            unset($_GET['activate']);
        }
    }

    return false;
}

/**
 * Load plugin initialisation file.
 */
require plugin_dir_path(__FILE__) . '/init.php';
