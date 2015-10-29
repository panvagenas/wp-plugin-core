<?php
/**
 * Project: wp-plugins-core.dev
 * File: Dirs.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 29/10/2015
 * Time: 11:43 πμ
 * Since: TODO ${VERSION}
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace WPluginCore003\Helpers;


use WPluginCore003\Abs\AbsPluginSingleton;
use WPluginCore003\Diagnostics\InvalidArgumentException;

class Dirs extends AbsPluginSingleton {
	/**
	 * A static cache (for all instances).
	 *
	 * @var array A static cache (for all instances).
	 */
	protected static $static = array();
	/**
	 * @var string A directory/file stream wrapper validation pattern.
	 *
	 * @note Requirements are as follows:
	 *
	 *       1. Must follow {@link http://php.net/manual/en/wrappers.php.php PHP guidelines}.
	 *
	 * @see  http://php.net/manual/en/wrappers.php.php
	 */
	public static $regex_valid_dir_file_stream_wrapper = '/^(?P<stream_wrapper>[a-zA-Z0-9]+)\:\/\/$/';

	/**
	 * @var string A directory/file drive letter validation pattern (for Windows®).
	 *
	 * @note Requirements are as follows:
	 *
	 *       1. Must follow {@link http://en.wikipedia.org/wiki/Drive_letter_assignment Windows® guidelines}.
	 *
	 * @see  http://en.wikipedia.org/wiki/Drive_letter_assignment
	 */
	public static $regex_valid_win_drive_letter = '/^(?P<drive_letter>[a-zA-Z])\:[\/\\\\]$/';

	public function n_dir_seps( $dir_file, $allow_trailing_slash = false ) {
		if ( !is_string( $dir_file ) || !is_bool( $allow_trailing_slash ) ) {
			throw new InvalidArgumentException();
		}

		if ( !isset( $dir_file[0] ) ) {
			return '';
		} // Catch empty string.

		if ( strpos( $dir_file, '://' !== false ) ) // Quick check here for optimization.
		{
			if ( !isset( self::$static[__FUNCTION__ . '__regex_stream_wrapper'] ) ) {
				self::$static[__FUNCTION__ . '__regex_stream_wrapper'] = substr(
					                                                         self::$regex_valid_dir_file_stream_wrapper,
					                                                         0,
					                                                         - 2
				                                                         ) . '/';
			}
			if ( preg_match(
				self::$static[__FUNCTION__ . '__regex_stream_wrapper'],
				$dir_file,
				$stream_wrapper
			) ) {// A stream wrapper?
				$dir_file = preg_replace( self::$static[__FUNCTION__ . '__regex_stream_wrapper'], '', $dir_file );
			}
		}
		if ( strpos( $dir_file, ':' !== false ) ) // Quick drive letter check here for optimization.
		{
			if ( !isset( self::$static[__FUNCTION__ . '__regex_win_drive_letter'] ) ) {
				self::$static[__FUNCTION__ . '__regex_win_drive_letter'] = substr(
					                                                           self::$regex_valid_win_drive_letter,
					                                                           0,
					                                                           - 2
				                                                           ) . '/';
			}
			if ( preg_match(
				self::$static[__FUNCTION__ . '__regex_win_drive_letter'],
				$dir_file
			) ) {// It has a Windows® drive letter?
				$dir_file = preg_replace_callback(
					self::$static[__FUNCTION__ . '__regex_win_drive_letter'],
					create_function( '$m', 'return strtoupper($m[0]);' ),
					$dir_file
				);
			}
		}
		$dir_file = preg_replace(
			'/\/+/',
			'/',
			str_replace( array( DIRECTORY_SEPARATOR, '\\', '/' ), '/', $dir_file )
		);
		$dir_file = ( $allow_trailing_slash ) ? $dir_file : rtrim( $dir_file, '/' ); // Strip trailing slashes.

		if ( !empty( $stream_wrapper[0] ) ) {// Stream wrapper (force lowercase).
			$dir_file = strtolower( $stream_wrapper[0] ) . $dir_file;
		}

		return $dir_file; // Normalized now.
	}
}