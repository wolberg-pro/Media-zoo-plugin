<?php
/**
 * Plugin configuration file
 *
 * @package      MediaZoo\MediaZooPlugin
 * @author       Sivan Wolberg
 * @copyright    2020 Wolberg pro
 */

declare(strict_types=1);

namespace MediaZoo\MediaZooPlugin;

if (!defined('WPINC')) {
	die;
}
$plugin_slug_routes = [
	'currentVersion' => 'v1',
	'list' => [
		[
			'version' => 'v1',
			'route' => 'request_ping/(?P<id>\d+)',
			'method' => 'GET',
			'namespace' => '\MediaZoo\MediaZooPlugin\admin\controllers\TestController@test',
			'dependency' => 'TestController.php',
			'validation' => 'validationTest',
			'permission' => 'manage_options',
			'permissionCallback' => 'permissionTest'
		]
	]
];
$plugin_slug_plugin = [
	'textdomain' => 'media-zoo-plugin',
	'languages_dir' => 'languages',
];

$plugin_slug_settings = [
	'submenu_pages' => [
		[
			'parent_slug' => 'options-general.php',
			'page_title' => __('Plugin Slug Settings', 'plugin-slug'),
			'menu_title' => __('Plugin Slug', 'plugin-slug'),
			'capability' => 'manage_options',
			'menu_slug' => 'plugin-slug',
			'view' => 'Media-zoo-plugin/views/admin-page.php'

		],
	],

	'settings' => [
		'setting1' => [
			'option_group' => 'pluginslug',
			'sanitize_callback' => null,
			'sections' => [
				'section1' => [
					'title' => __('My Section Title', 'plugin-slug'),
					'view' => MediaZoo_DIR . 'views/section1.php',
					'fields' => [
						'field1' => [
							'title' => __('My Field Title', 'plugin-slug'),
							'view' => MediaZoo_DIR . 'views/field1.php',
						],
					],
				],
			],
		],
	],
];

return [
	'MediaZoo' => [
		'MediaZooPlugin' => [
			'Plugin' => $plugin_slug_plugin,
			'Settings' => $plugin_slug_settings,
			'Routes' => $plugin_slug_routes
		],
	],
];
