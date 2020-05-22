<?php


namespace MediaZoo\MediaZooPlugin\common;


if (!defined('WPINC')) {
	die;
}
use MediaZoo\MediaZooPlugin\Configuration;
use ReflectionClass;
use WP_REST_Request;

class RegisterRoutes
{

	/**
	 * @var RegisterRoutes hold the main login
	 */
	private static ?RegisterRoutes $instance = null;


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

	public static function getInstance(): RegisterRoutes
	{
		if (self::$instance == null) {
			self::$instance = new RegisterRoutes();
		}

		return self::$instance;
	}

	public function load_routes()
	{
		$config = Configuration::getInstance()->getConfig();
		if ($config->hasKey('Routes.list')&&$config->hasKey('Routes.currentVersion')) {
			$currentVersion = $config->getKey('Routes.currentVersion');
			$routes = $config->getKey('Routes.list');
			foreach ($routes as $route) {
				if (is_null($route['validation']) || $route['validation'] == '') {
					$this->register_route($route,$currentVersion);
				} else {
					$this->register_route($route,$currentVersion, true);
				}
			}
		}
	}

	private function register_route($route,$currentVersion, $hasValidation = false)
	{
		$classArgs = explode('@' , $route['namespace']);
		$callbackObject = $this->load_dependencies($route,$classArgs);
		$func =  $classArgs[1];
		$validationRoute = $route['validation'];
		if ($hasValidation) {
			register_rest_route( 'media-zoo/'.$currentVersion, $route['route'], array(
				'methods' => $route['method'],
				'callback' => array($callbackObject , $func),
				'args' => array(
					'id' => array(
						'validate_callback' => function($param, $request, $key) use ($callbackObject,$validationRoute) {
							return $callbackObject->$validationRoute($param ,$request , $key);
						}
					),
				),
				'permission_callback' => function (WP_REST_Request $request) use ($route,$callbackObject) {
					return $this->checkPermission($route, $request,$callbackObject);
				}
			));
		} else {
			register_rest_route( 'media-zoo/'.$currentVersion, $route['route'], array(
				'methods' => $route['method'],
				'callback' => array($callbackObject , $func),
				'permission_callback' => function (WP_REST_Request $request) use ($route,$callbackObject) {
					return $this->checkPermission($route, $request,$callbackObject);
				}
			));

		}
	}
	private function load_dependencies($route,$classArgs=[]) {
		$dynamicLoad = plugin_dir_path(dirname(__FILE__)) . 'admin/controller/'. $route['dependency'];
		require_once($dynamicLoad);
		$class = $classArgs[0];
		$instance = new $class();
		return $instance;

	}

	private function checkPermission($route, WP_REST_Request $request , $callbackObject)
	{
		if (!is_null($route['permission']) && $route['permission']!= '') {
			if (is_null($route['permissionCallback']) || $route['permissionCallback'] == '') {
				return current_user_can($route['permission']);
			} else {
				$func = $route['permissionCallback'];
				return $callbackObject->$func($route, $request);
			}
		} else {
			return true;
		}
	}
}
