<?php


// Redirect all requests to index.php so the Vue app is loaded and 404s aren't thrown
function remove_redirects()
{
	add_rewrite_rule('^/(.+)/?', 'index.php', 'top');
}

// Load scripts
function load_vue_scripts()
{
	wp_enqueue_script(
		'MediaZoo_asset_js',
		MediaZoo_URL . '/views/dist/scripts/index.js',
		array('jquery'),
		filemtime(MediaZoo_DIR . '/views/dist/scripts/index.js'),
		true
	);
}

function load_vue_styles()
{
	wp_enqueue_style(
		'MediaZoo_asset_css',
		MediaZoo_URL . '/views/dist/styles.css',
		null,
		filemtime(MediaZoo_DIR. '/views/dist/styles.css')
	);
}

// add_action('plugins_loaded', 'MediaZoo_init_deactivation');

/**
 * Initialise deactivation functions.
 */
function MediaZoo_init_deactivation()
{
	if (current_user_can('activate_plugins')) {
		add_action('admin_init', 'MediaZoo_deactivate');
		add_action('admin_notices', 'MediaZoo_deactivation_notice');
	}
}

/**
 * Deactivate the plugin.
 */
function MediaZoo_deactivate()
{
	deactivate_plugins(plugin_basename(__FILE__));
}

/**
 * Show deactivation admin notice.
 */
function MediaZoo_deactivation_notice()
{
	$notice = sprintf(
	// Translators: 1: Required PHP version, 2: Current PHP version.
		'<strong>Plugin Boilerplate</strong> requires PHP %1$s to run. This site uses %2$s, so the plugin has been <strong>deactivated</strong>.',
		'7.X',
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
