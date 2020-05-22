<?php


namespace MediaZoo\MediaZooPlugin\services;

use MediaZoo\MediaZooPlugin\models\FileQuery;

if (!defined('WPINC')) {
	die;
}

class FileSystemService
{

	/**
	 * @var FileSystemService hold the main login
	 */
	private static ?FileSystemService $instance = null;


	/**
	 * Instantiate a Plugin object.
	 *
	 * Don't call the constructor directly, use the `Plugin::get_instance()`
	 * static method instead.
	 *
	 * @since 0.1.0
	 */
	protected function __construct()
	{
	}

	/**
	 * Singletons should not be cloneable.
	 */
	protected function __clone()
	{
	}

	/**
	 * Singletons should not be restorable from strings.
	 */
	public function __wakeup()
	{
		throw new \Exception("Cannot unserialize a singleton.");
	}

	public static function getInstance(): FileSystemService
	{
		if (self::$instance == null) {
			self::$instance = new FileSystemService();
		}
		return self::$instance;
	}
	public function GetFiles(string $rootFolder) {
		return FileQuery::getInstance()->getFiles();
	}

}
