<?php
/**
 * Project: wp-plugins-core.dev
 * File: FcrScripts.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 23/10/2015
 * Time: 9:31 πμ
 * Since: TODO ${VERSION}
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace WPluginCore003\Scripts;


use WPluginCore003\Abs\AbsFactory;

class FcrScripts extends AbsFactory {
	/**
	 * @param string    $handle
	 * @param string    $wpRelPath
	 * @param array     $deps
	 * @param bool|true $inFooter
	 *
	 * @return Script
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function script( $handle, $wpRelPath = '', Array $deps = array(), $inFooter = true ) {
		return new Script( $this->plugin, $handle, $wpRelPath, $deps, $inFooter );
	}

	/**
	 * @param string    $handle
	 * @param string    $wpRelPath
	 * @param array     $deps
	 * @param bool|true $inFooter
	 *
	 * @return AdminScript
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function adminScript( $handle, $wpRelPath = '', Array $deps = array(), $inFooter = true ) {
		return new AdminScript( $this->plugin, $handle, $wpRelPath, $deps, $inFooter );
	}

	/**
	 * @param string    $handle
	 * @param string    $wpRelPath
	 * @param array     $deps
	 * @param bool|true $inFooter
	 *
	 * @return LoginScript
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function loginScript( $handle, $wpRelPath = '', Array $deps = array(), $inFooter = true ) {
		return new LoginScript( $this->plugin, $handle, $wpRelPath, $deps, $inFooter );
	}

	/**
	 * @param string $handle
	 * @param string $wpRelPath
	 * @param array  $deps
	 * @param string $media
	 *
	 * @return Style
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function style( $handle, $wpRelPath = '', Array $deps = array(), $media = 'all' ) {
		return new Style( $this->plugin, $handle, $wpRelPath, $deps, $media );
	}

	/**
	 * @param string $handle
	 * @param string $wpRelPath
	 * @param array  $deps
	 * @param string $media
	 *
	 * @return AdminStyle
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function adminStyle( $handle, $wpRelPath = '', Array $deps = array(), $media = 'all' ) {
		return new AdminStyle( $this->plugin, $handle, $wpRelPath, $deps, $media );
	}

	/**
	 * @param string $handle
	 * @param string $wpRelPath
	 * @param array  $deps
	 * @param string $media
	 *
	 * @return LoginStyle
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function loginStyle( $handle, $wpRelPath = '', Array $deps = array(), $media = 'all' ) {
		return new LoginStyle( $this->plugin, $handle, $wpRelPath, $deps, $media );
	}
}