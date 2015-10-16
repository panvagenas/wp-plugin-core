<?php
/**
 * Project: wp-plugins-core.dev
 * File: Dumper.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 5/10/2015
 * Time: 8:50 πμ
 * Since: TODO ${VERSION}
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace WPluginCore002\Helpers;


use WPluginCore002\Abs\AbsCoreSingleton;

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
	 * @since  TODO ${VERSION}
	 */
	public static function d() {
		call_user_func_array( 'dump', func_get_args() );
	}
}