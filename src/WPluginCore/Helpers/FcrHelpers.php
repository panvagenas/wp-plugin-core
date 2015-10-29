<?php
/**
 * Project: wp-plugins-core.dev
 * File: FcrHelpers.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 23/10/2015
 * Time: 11:25 μμ
 * Since: TODO ${VERSION}
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace WPluginCore003\Helpers;


use WPluginCore003\Abs\AbsFactory;

class FcrHelpers extends AbsFactory{
	/**
	 * @return Dumper
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function dumper(){
		return Dumper::getInstance();
	}

	/**
	 * @return File
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function file(){
		return File::getInstance();
	}

	/**
	 * @return Random
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function random(){
		return new Random();
	}

	/**
	 * @return \WPluginCore003\Helpers\String
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function string(){
		return new String();
	}

	/**
	 * @return Vars
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function vars(){
		return Vars::getInstance();
	}

	/**
	 * @return Dirs
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function dirs(){
		return Dirs::getInstance($this->plugin);
	}

	/**
	 * @return URL
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function url(){
		return URL::getInstance($this->plugin);
	}
}