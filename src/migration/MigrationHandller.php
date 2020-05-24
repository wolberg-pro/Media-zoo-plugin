<?php


namespace MediaZoo\MediaZooPlugin\migration;


use MediaZoo\MediaZooPlugin\Configuration;

class MigrationHandller
{
	/**
	 * @var MigrationHandller hold the main login
	 */
	private static ?MigrationHandller $instance = null;


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
		$this->load_dependencies();
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

	public static function getInstance(): MigrationHandller
	{
		if (self::$instance == null) {
			self::$instance = new MigrationHandller();
		}

		return self::$instance;
	}
	private array $loaded_migrations = [];
	private function load_dependencies() {
		$loaded_migrations = [];
		$config = Configuration::getInstance()->getConfig();
		if ($config->hasKey('Migration.load')) {
			foreach ($config->getKey('Migration.load') as $migrate) {
				$migration_location = plugin_dir_path(dirname(__FILE__)) . 'migration/'.$migrate.'.php';
				if (file_exists($migration_location)) {
					require_once $migration_location;
					$class = 'MediaZoo\\MediaZooPlugin\\migration\\'.$migrate;
					$instance = new $class();
					array_push($this->loaded_migrations,$instance);
				}
			}
		}
	}
	public function install() {
		foreach ($this->loaded_migrations as $migrate) {
			$migrate->Up();
		}
	}
	public function uninstall() {
		foreach ($this->loaded_migrations as $migrate) {
			$migrate->Down();
		}
	}

}
