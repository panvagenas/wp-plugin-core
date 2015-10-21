<?php
/**
 * Project: wp-plugins-core.dev
 * File: File.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 19/10/2015
 * Time: 10:10 πμ
 * Since: TODO ${VERSION}
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace WPluginCore002\Helpers;


use WPluginCore002\Abs\AbsCoreSingleton;
use WPluginCore002\Plugin\Paths;
use WPluginCore002\Plugin\Plugin;

/**
 * Class File
 *
 * @package WPluginCore002\Helpers
 * @author  Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @since   TODO ${VERSION}
 */
class File extends AbsCoreSingleton {
	/**
	 * @param        $name
	 * @param        $searchIn
	 * @param        $ext
	 * @param Plugin $plugin
	 *
	 * @return string
	 * @throws \WPluginCore002\Diagnostics\Exception
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function locate( $name, $searchIn, $ext, Plugin $plugin ) {
		if ( ! preg_match( '/.*\.' . $ext . '$/', $name ) ) {
			$name .= ".$ext";
		}

		foreach ( (array) $searchIn as $path ) {
			$filePath = Paths::truePath( "{$path}/{$name}", true );

			if ( ! $filePath ) {
				continue;
			}

			if (
				$plugin->getFactory()->paths()->verifyPathIsUnder( $filePath, $path )
				&& file_exists( $filePath )
				&& is_readable( $filePath )
			) {
				return $filePath;
			}
		}

		return '';
	}
}