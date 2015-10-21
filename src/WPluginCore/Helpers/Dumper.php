<?php
/**
 * Project: wp-plugins-core.dev
 * File: Dumper.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 5/10/2015
 * Time: 8:50 πμ
 * Since: 0.0.2
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace WPluginCore002\Helpers;


use WPluginCore002\Abs\AbsCoreSingleton;

/**
 * Class Dumper
 *
 * @package WPluginCore002\Helpers
 * @author  Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @since   0.0.2
 */
class Dumper extends AbsCoreSingleton {
	/**
	 * Dumps passed arguments and dies
	 */
	public static function dd() {
		call_user_func_array( 'dump', func_get_args() );
		die;
	}

	/**
	 * @static
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public static function d() {
		call_user_func_array( 'dump', func_get_args() );
	}
}