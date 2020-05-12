<?php
/**
 * Main plugin file
 *
 * @package      MediaZoo\MediaZooPlugin
 * @author       Sivan Wolberg
 * @copyright    2020 Wolberg pro
 */


namespace MediaZoo\MediaZooPlugin\common;

require_once plugin_dir_path(dirname(__FILE__)) . 'common/MediaZooHelperLoader.php';
/**
 * Loader Helper class for Wordpress
 *
 * @since   0.1.0
 *
 * @package MediaZoo\MediaZooPlugin
 * @author       Sivan Wolberg
 * @copyright    2020 Wolberg pro
 */
class Loader extends MediaZooHelperLoader
{
	/**
	 * @var Loader hold the main login
	 */
	private static ?Loader $instance = null;


	/**
	 * Instantiate a Plugin object.
	 *
	 * Don't call the constructor directly, use the `Plugin::get_instance()`
	 * static method instead.
	 *
	 * @since 0.1.0
	 */
	protected function __construct() { }

	/**
	 * Singletons should not be cloneable.
	 */
	protected function __clone() { }

	/**
	 * Singletons should not be restorable from strings.
	 */
	public function __wakeup()
	{
		throw new \Exception("Cannot unserialize a singleton.");
	}
	public static function getInstance(): Loader
	{
		if (self::$instance == null)
		{
			self::$instance = new Loader();
		}

		return self::$instance;
	}
}
