<?php

/**
 * Activator Class
 *
 * @package      MediaZoo\MediaZooPlugin
 * @author       Sivan Wolberg
 * @copyright    2020 Wolberg pro
 */


namespace MediaZoo\MediaZooPlugin;

use BrightNucleus\Config\ConfigInterface;

if (!defined('WPINC')) {
	die;
}
require_once(plugin_dir_path(dirname(__FILE__)) . 'src/common/Configuration.php');

class MediaZoo_i18n
{

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain()
	{
		$config = Configuration::getInstance()->getConfig();
		$text_domain = $config->getKey('Plugin.textdomain');
		$languages_dir = 'languages';
		if ($config->hasKey('Plugin/languages_dir')) {
			/**
			 * Directory path.
			 *
			 * @var string
			 */
			$languages_dir = $config->getKey('Plugin.languages_dir');
		}

		load_plugin_textdomain($text_domain, false, $text_domain . '/' . $languages_dir);
	}
}
