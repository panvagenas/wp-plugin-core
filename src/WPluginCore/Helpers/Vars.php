<?php
/**
 * Project: wp-plugins-core.dev
 * File: Vars.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 27/10/2015
 * Time: 12:14 μμ
 * Since: TODO ${VERSION}
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace WPluginCore003\Helpers;


use WPluginCore003\Abs\AbsCoreSingleton;

class Vars extends AbsCoreSingleton {
	/**
	 * Returns a copy of all `$_SERVER` vars
	 *
	 * @param string $key Optional. Looking for a specific array key?
	 *
	 * @return array|null
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function SERVER( $key = '' ) {
		if ( !empty( $_SERVER ) ) {
			if ( isset( $key ) ) {
				if ( array_key_exists( $key, (array)$_SERVER ) ) {
					return $_SERVER[$key];
				}

				return null;
			}

			return (array)$_SERVER;
		}

		return isset( $key ) ? null : array();
	}
}