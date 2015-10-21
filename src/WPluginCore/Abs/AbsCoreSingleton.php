<?php
/**
 * Project: wp-plugins-core.dev
 * File: AbsCoreSingleton.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 16/10/2015
 * Time: 9:37 πμ
 * Since: 0.0.2
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace WPluginCore003\Abs;

/**
 * Class AbsCoreSingleton
 *
 * @package WPluginCore003\Abs
 * @author  Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @since   0.0.2
 */
abstract class AbsCoreSingleton {

	/**
	 * @var $this ::class The reference to *Singleton* instance of this class
	 */
	private static $instances = array();

	/**
	 * Protected constructor to prevent creating a new instance of the
	 * *Singleton* via the `new` operator from outside of this class.
	 */
	protected function __construct() {
	}

	/**
	 * Returns the *Singleton* instance of this class.
	 *
	 * @return $this ::class The *Singleton* instance.
	 */
	public static function getInstance() {
		$class = get_called_class();

		if ( ! isset( self::$instances[ $class ] ) ) {
			self::$instances[ $class ] = new $class();
		}

		return self::$instances[ $class ];
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