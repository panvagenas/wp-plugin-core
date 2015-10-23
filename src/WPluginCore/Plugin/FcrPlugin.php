<?php
/**
 * Project: wp-plugins-core.dev
 * File: FcrPlugin.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 23/10/2015
 * Time: 9:35 πμ
 * Since: TODO ${VERSION}
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace WPluginCore003\Plugin;


use WPluginCore003\Abs\AbsFactory;

class FcrPlugin extends AbsFactory{
	/**
	 * @return Initializer
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function initializer(){
		return Initializer::getInstance($this->plugin);
	}

	/**
	 * @return Paths
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function paths(){
		return Paths::getInstance($this->plugin);
	}
}