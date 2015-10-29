<?php
/**
 * Project: wp-plugins-core.dev
 * File: String.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 15/10/2015
 * Time: 9:59 μμ
 * Since: 0.0.2
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace WPluginCore003\Helpers;


/**
 * Class String
 *
 * @package WPluginCore003\Helpers
 * @author  Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @since   0.0.2
 */
class String {
	/**
	 * Escapes regex back-reference chars (i.e. `\\$` and `\\\\`).
	 *
	 * @param string  $string A string value.
	 * @param integer $times  Number of escapes. Defaults to `1`.
	 *
	 * @return string Escaped string.
	 */
	public function escRefs( $string, $times = 1 ) {
		return $this->escRefsDeep( $string, $times );
	}

	/**
	 * Escapes regex back-reference chars deeply (i.e. `\\$` and `\\\\`).
	 *
	 * @note This is a recursive scan running deeply into multiple dimensions of arrays/objects.
	 * @note This routine will usually NOT include private, protected or static properties of an object class.
	 *    However, private/protected properties *will* be included, if the current scope allows access to these
	 *    private/protected properties. Static properties are NEVER considered by this routine, because static
	 *    properties are NOT iterated by `foreach()`.
	 *
	 * @param mixed   $value Any value can be converted into an escaped string.
	 *                       Actually, objects can't, but this recurses into objects.
	 * @param integer $times Number of escapes. Defaults to `1`.
	 *
	 * @return string|array|object Escaped string, array, object
	 */
	public function escRefsDeep( $value, $times = 1 ) {
		if ( is_array( $value ) || is_object( $value ) ) {
			foreach ( $value as &$_value ) {
				$_value = $this->escRefsDeep( $_value, $times );
			}

			return $value;
		}

		return str_replace(
			array( '\\', '$' ),
			array( str_repeat( '\\', abs( $times ) ) . '\\', str_repeat( '\\', abs( $times ) ) . '$' ),
			(string)$value
		);
	}
}