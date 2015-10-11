<?php
/**
 * Project: wp-plugins-core.dev
 * File: Installer.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 28/9/2015
 * Time: 12:06 μμ
 * Since: TODO ${VERSION}
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace WPluginCore002\Plugin;


use WPluginCore002\Abs\AbsSingleton;

class Installer extends AbsSingleton{
	public function activation(){
		return true;
	}
	/**
	 * @return bool
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function deactivation(){
		return true;
	}

	/**
	 * @return bool
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public static function uninstall(){
		return true;
	}
}