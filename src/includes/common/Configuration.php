<?php
/**
 * Main plugin file
 *
 * @package      MediaZoo\MediaZooPlugin
 * @author       Sivan Wolberg
 * @copyright    2020 Wolberg pro
 */


namespace MediaZoo\MediaZooPlugin\common;

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
    protected static Configuration $instance;

    private ConfigInterface $config;
    /**
     * Instantiate a Plugin object.
     *
     * Don't call the constructor directly, use the `Plugin::get_instance()`
     * static method instead.
     *
     * @since 0.1.0
     *
     * @throws FailedToProcessConfigException If the Config could not be parsed correctly.
     *
     * @param ConfigInterface $config Config to parametrize the object.
     */
    private function __construct()
    {
        $this->processConfig(self::$config);
    }
    public function getConfig()
    {
        return self::$config;
    }
    public function setConfig(ConfigInterface $config)
    {
        $this->$config = $config;
    }
    // The object is created from within the class itself
    // only if the class has no instance.
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new Configuration();
        }

        return self::$instance;
    }
}
