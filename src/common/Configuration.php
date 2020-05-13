<?php
/**
 * Main plugin file
 *
 * @package      MediaZoo\MediaZooPlugin
 * @author       Sivan Wolberg
 * @copyright    2020 Wolberg pro
 */


namespace MediaZoo\MediaZooPlugin;

use BrightNucleus\Config\ConfigInterface;
use BrightNucleus\Config\ConfigTrait;
use BrightNucleus\Config\Exception\FailedToProcessConfigException;
use BrightNucleus\Settings\Settings;

/**
 * Configuration holder class
 *
 * @since   0.1.0
 *
 * @package MediaZoo\MediaZooPlugin
 * @author       Sivan Wolberg
 * @copyright    2020 Wolberg pro
 */
class Configuration
{
	use ConfigTrait;

	/**
	 * Static instance of the plugin.
	 *
	 * @since 0.1.0
	 *
	 * @var self
	 */
	private static ?Configuration $instance = null;
	/**
	 * @var ConfigInterface hold the main login
	 */
	protected ConfigInterface $configObject;


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
	public static function getInstance(): Configuration
	{
		if (self::$instance == null)
		{
			self::$instance = new Configuration();
		}

		return self::$instance;
	}

	public function getConfig()
	{
		return $this->configObject;
	}

	public function setConfig(ConfigInterface $config)
	{
		$this->configObject = $config;
		$this->processConfig($this->configObject);
	}
}
