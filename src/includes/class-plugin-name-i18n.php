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

use BrightNucleus\Config\ConfigInterface;
use MediaZoo\MediaZooPlugin\common\Configuration;

class MediaZoo_i18n
{

    /**
     * Load the plugin text domain for translation.
     *
     * @since    1.0.0
     */
    public function load_plugin_textdomain(ConfigInterface $config)
    {
        $config = Configuration::getInstance()->getConfig();
        $text_domain = $config->getKey('Plugin.textdomain');
        $languages_dir = 'languages';
        if ($this->config->hasKey('Plugin/languages_dir')) {
            /**
             * Directory path.
             *
             * @var string
             */
            $languages_dir = $this->config->getKey('Plugin.languages_dir');
        }

        load_plugin_textdomain($text_domain, false, $text_domain . '/' . $languages_dir);
    }
}
