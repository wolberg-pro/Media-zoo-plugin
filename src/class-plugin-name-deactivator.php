<?php
/**
 *  Deactivator
 * @package      MediaZoo\MediaZooPlugin
 * @author       Sivan Wolberg
 * @copyright    2020 Wolberg pro
 */

declare(strict_types=1);

namespace MediaZoo\MediaZooPlugin;

if (!defined('WPINC')) {
	die;
}

class MediaZoo_Deactivator
{

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate()
	{
		MediaZoo_init_deactivation();
	}
}
