<?php
/**
 * Project: pan-wp-core
 * File: Initializer.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 3/9/2015
 * Time: 5:23 πμ
 * Since: TODO ${VERSION}
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace PanWPCore;


class Initializer extends Core{
	/**
	 * @var bool
	 */
	private static $initialized = false;

	/**
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since TODO ${VERSION}
	 */
	public final function run(){
		self::coreInit();
		$this->init();
	}

	/**
	 * @static * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since TODO ${VERSION}
	 */
	private static final function coreInit(){
		if(!self::$initialized){
			add_action( 'admin_menu', function() {
				remove_submenu_page('tools.php','redux-about');
			},12 );
			self::$initialized = true;
		}
	}

	/**
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since TODO ${VERSION}
	 */
	protected function init(){}
}