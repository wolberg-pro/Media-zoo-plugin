<?php
/**
 * Activator Class
 *
 * @package      MediaZoo\MediaZooPlugin
 * @author       Sivan Wolberg
 * @copyright    2020 Wolberg pro
 */

declare(strict_types=1);

namespace MediaZoo\MediaZooPlugin;


use MediaZoo\MediaZooPlugin\migration\MigrationHandller;

if (!defined('WPINC')) {
	die;
}

class MediaZoo_Activator
{

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate()
	{
		MigrationHandller::getInstance()->install();
		// Remove all default WP template redirects/lookups
		remove_action('template_redirect', 'redirect_canonical');
		add_action('init', 'remove_redirects');
	}
}
