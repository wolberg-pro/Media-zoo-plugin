<?php
/**
 *
 * @package      MediaZoo\MediaZooPlugin
 * @author       Sivan Wolberg
 * @copyright    2020 Wolberg pro
 */
namespace MediaZoo\MediaZooPlugin;

class MediaZooAdmin
{

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	private string $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private string $version;


	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Loader $loader Maintains and registers all hooks for the plugin.
	 */
	protected ?Loader $loader = null;
	/**
	 * Initialize the class and set its properties.
	 *
	 * @param string $plugin_name The name of this plugin.
	 * @param string $version The version of this plugin.
	 * @since    1.0.0
	 */
	public function __construct($plugin_name, $version)
	{
		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->load_dependencies();
		$this->build_menu();
		$this->run();
	}


	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{
		load_vue_styles();
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{
		load_vue_scripts();
	}
	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	private function run()
	{
		$this->loader->run();
	}
	private function load_dependencies()
	{
		require_once plugin_dir_path(dirname(__FILE__)) . 'common/Loader.php';
		require_once plugin_dir_path(dirname(__FILE__)) .'common/Configuration.php';
		$this->loader = Loader::getInstance();
	}
	private function build_menu() {
		$config = Configuration::getInstance()->getConfig();
		if ($config->hasKey('Settings.submenu_pages')) {
			$menuItems = $config->getKey('Settings.submenu_pages');
			foreach ($menuItems as $menuItem) {
				\add_action('admin_menu',
					function () use ($menuItem) {
						$this->buildMenuItem($menuItem);
					});
			}
		}
	}

	private function buildMenuItem($menuItem) {
		if (is_array($menuItem)) {
			\add_menu_page(
				$menuItem['page_title'],
				$menuItem['menu_title'],
				$menuItem['capability'],
				$menuItem['view']
			);
		}
	}
}
