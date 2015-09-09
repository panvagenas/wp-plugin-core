<?php
/**
 * Project: pan-wp-core
 * File: Scripts.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 6/9/2015
 * Time: 8:25 πμ
 * Since: TODO ${VERSION}
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace PanWPCore;


class Scripts extends Core {
	/**
	 * @param $file
	 *
	 * @return string
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function findScriptFile( $file ) {
		$file = $this->Paths->removeDots( $file );

		foreach ( $this->Paths->whereScriptsMayReside as $dir ) {
			if ( file_exists( $path = $dir . DIRECTORY_SEPARATOR . $file ) && is_readable( $path ) ) {
				return $path;
			}
		}

		return '';
	}

	/**
	 * @param $file
	 *
	 * @return string
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function findStyleFile( $file ) {
		$file = $this->Paths->removeDots( $file );

		foreach ( $this->Paths->whereStylesMayReside as $dir ) {
			if ( file_exists( $path = $dir . DIRECTORY_SEPARATOR . $file ) && is_readable( $path ) ) {
				return $path;
			}
		}

		return '';
	}

	/**
	 * @param            $handle
	 * @param bool|false $src
	 * @param array      $deps
	 * @param bool|false $ver
	 * @param string     $media
	 * @param string     $hook
	 *
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function enqueueStyle(
		$handle,
		$src = false,
		$deps = array(),
		$ver = false,
		$media = 'all',
		$hook = 'wp_enqueue_scripts'
	) {
		$pluginVersion = $this->Plugin->getVersion();
		add_action( $hook, function () use ( $handle, $src, $deps, $ver, $media, $pluginVersion ) {
			if ( ! wp_style_is( $handle, 'enqueued' ) ) {
				if ( ! $ver ) {
					$ver = $pluginVersion;
				}
				wp_enqueue_style( $handle, $src, $deps, $ver, $media );
			}
		} );
	}

	/**
	 * @param            $handle
	 * @param bool|false $src
	 * @param array      $deps
	 * @param bool|false $ver
	 * @param bool|false $inFooter
	 * @param string     $hook
	 *
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function enqueueScript(
		$handle,
		$src = false,
		$deps = array(),
		$ver = false,
		$inFooter = false,
		$hook = 'wp_enqueue_scripts'
	) {
		$pluginVersion = $this->Plugin->getVersion();
		add_action( $hook, function () use ( $handle, $src, $deps, $ver, $inFooter, $pluginVersion ) {
			if ( ! wp_script_is( $handle, 'enqueued' ) ) {
				if ( ! $ver ) {
					$ver = $pluginVersion;
				}
				wp_enqueue_script( $handle, $src, $deps, $ver, $inFooter );
			}
		} );
	}

	/**
	 * @param            $handle
	 * @param bool|false $src
	 * @param array      $deps
	 * @param bool|false $ver
	 * @param string     $media
	 *
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public
	function enqueueAdminStyle(
		$handle,
		$src = false,
		$deps = array(),
		$ver = false,
		$media = 'all'
	) {
		$this->enqueueStyle( $handle, $src, $deps, $ver, $media, 'admin_enqueue_scripts' );
	}

	/**
	 * @param            $handle
	 * @param bool|false $src
	 * @param array      $deps
	 * @param bool|false $ver
	 * @param bool|false $inFooter
	 *
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public
	function enqueueAdminScript(
		$handle,
		$src = false,
		$deps = array(),
		$ver = false,
		$inFooter = false
	) {
		$this->enqueueScript( $handle, $src, $deps, $ver, $inFooter, 'admin_enqueue_scripts' );
	}

	/**
	 * @param            $handle
	 * @param bool|false $src
	 * @param array      $deps
	 * @param bool|false $ver
	 * @param string     $media
	 *
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public
	function enqueueLoginStyle(
		$handle,
		$src = false,
		$deps = array(),
		$ver = false,
		$media = 'all'
	) {
		$this->enqueueStyle( $handle, $src, $deps, $ver, $media, 'login_enqueue_scripts' );
	}

	/**
	 * @param            $handle
	 * @param bool|false $src
	 * @param array      $deps
	 * @param bool|false $ver
	 * @param bool|false $inFooter
	 *
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public
	function enqueueLoginScript(
		$handle,
		$src = false,
		$deps = array(),
		$ver = false,
		$inFooter = false
	) {
		$this->enqueueScript( $handle, $src, $deps, $ver, $inFooter, 'login_enqueue_scripts' );
	}

	/**
	 * @param string $baseHandle
	 *
	 * @return string
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public
	function getScriptHandle(
		$baseHandle
	) {
		return $this->Plugin->getSlug() . $baseHandle;
	}

	/**
	 * @param string $fileAbsPath
	 *
	 * @return string
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public
	function getUrl(
		$fileAbsPath
	) {
		return get_home_url() . '/' . str_replace( ABSPATH, '', $fileAbsPath );
	}
}