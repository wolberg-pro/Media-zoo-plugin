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
$plugin_slug_migration = [
	'load' => [
		'Migration_Init_1590332550'
	]
];

$plugin_slug_routes = [
	'currentVersion' => 'v1',
	'list' => [
		[
			'version' => 'v1',
			'route' => 'request_ping/(?P<count>\d+)',
			'method' => 'GET',
			'namespace' => '\MediaZoo\MediaZooPlugin\admin\controller\TestController@test',
			'dependency' => 'TestController.php',
			'validation' => 'validationTest',
			'permission' => 'upload_files',
			'permissionCallback' => 'permissionTest'
		], [
			'version' => 'v1',
			'route' => 'files/all',
			'method' => 'GET',
			'namespace' => '\MediaZoo\MediaZooPlugin\admin\controller\FileSystemController@index',
			'dependency' => 'FileSystemController.php',
			'permission' => 'upload_files',
			'permissionCallback' => 'permissionFileSystem'
		], [
			'version' => 'v1',
			'route' => 'files/create',
			'method' => 'POST',
			'namespace' => '\MediaZoo\MediaZooPlugin\admin\controller\FileSystemController@create',
			'dependency' => 'FileSystemController.php',
			'permission' => 'upload_files',
			'permissionCallback' => 'permissionFileSystem'
		], [
			'version' => 'v1',
			'route' => 'files/remove',
			'method' => 'POST',
			'namespace' => '\MediaZoo\MediaZooPlugin\admin\controller\FileSystemController@deleteFiles',
			'dependency' => 'FileSystemController.php',
			'permission' => 'upload_files',
			'permissionCallback' => 'permissionFileSystem'
		],  [
			'version' => 'v1',
			'route' => 'files/upload',
			'method' => 'POST',
			'namespace' => '\MediaZoo\MediaZooPlugin\admin\controller\FileSystemController@uploadFile',
			'dependency' => 'FileSystemController.php',
			'permission' => 'upload_files',
			'permissionCallback' => 'permissionFileSystem'
		], [
			'version' => 'v1',
			'route' => 'folder/remove',
			'method' => 'POST',
			'namespace' => '\MediaZoo\MediaZooPlugin\admin\controller\FileSystemController@deleteFolders',
			'dependency' => 'FileSystemController.php',
			'permission' => 'upload_files',
			'permissionCallback' => 'permissionFileSystem'
		], [
			'version' => 'v1',
			'route' => 'media/remove',
			'method' => 'POST',
			'namespace' => '\MediaZoo\MediaZooPlugin\admin\controller\FileSystemController@deleteMediaItems',
			'dependency' => 'FileSystemController.php',
			'permission' => 'upload_files',
			'permissionCallback' => 'permissionFileSystem'
		],
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
			'page_title' => __('Media Zoo File Control', 'Media Zoo File Control'),
			'menu_title' => __('Media Zoo', 'Media Zoo'),
			'capability' => 'upload_files',
			'menu_slug' => 'media-zoo',
			'view' => 'Media-zoo-plugin/views/admin-page.php'

		],
	],

	'settings' => [
		'setting1' => [
			'option_group' => 'media-zoo',
			'sanitize_callback' => null,
			'sections' => [
				'section1' => [
					'title' => __('My Section Title', 'Media Zoo'),
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
			'Migration' => $plugin_slug_migration,
			'Routes' => $plugin_slug_routes
		],
	],
];
