<?php
/**
 * Project: wp-plugins-core.dev
 * File: Singleton.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 28/9/2015
 * Time: 11:59 πμ
 * Since: TODO ${VERSION}
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace WPluginCore002\Abs;


use WPluginCore002\Plugin\Plugin;

abstract class AbsSingleton {
	/**
	 * @var $this ::class The reference to *Singleton* instance of this class
	 */
	protected static $instances = array();
	/**
	 * @var Plugin
	 */
	protected $plugin;

	/**
	 * Protected constructor to prevent creating a new instance of the
	 * *Singleton* via the `new` operator from outside of this class.
	 *
	 * @param Plugin $plugin
	 */
	protected function __construct( Plugin $plugin ) {
		$this->plugin = $plugin;
	}

	/**
	 * Returns the *Singleton* instance of this class.
	 *
	 * @param Plugin $plugin
	 *
	 * @return $this ::class The *Singleton* instance.
	 */
	public static function getInstance( Plugin $plugin ) {
		$class = get_called_class();

		if ( ! isset( self::$instances[ $plugin->getSlug() ] ) ) {
			self::$instances[ $plugin->getSlug() ] = array();
		}

		if ( ! isset( self::$instances[ $plugin->getSlug() ][ $class ] ) ) {
			self::$instances[ $plugin->getSlug() ][ $class ] = new $class( $plugin );
		}

		return self::$instances[ $plugin->getSlug() ][ $class ];
	}

	/**
	 * Private clone method to prevent cloning of the instance of the
	 * *Singleton* instance.
	 *
	 * @return void
	 */
	protected function __clone() {
	}

	/**
	 * Private unserialize method to prevent unserializing of the *Singleton*
	 * instance.
	 *
	 * @return void
	 */
	protected function __wakeup() {
	}
}