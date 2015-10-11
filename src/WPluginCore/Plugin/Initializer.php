<?php
/**
 * Project: wp-plugins-core.dev
 * File: Initializer.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 28/9/2015
 * Time: 12:06 μμ
 * Since: TODO ${VERSION}
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace WPluginCore002\Plugin;


use WPluginCore002\Abs\AbsSingleton;

class Initializer extends AbsSingleton{
	/**
	 * @var bool
	 */
	private static $initialized = false;

	/**
	 * This is used for core initialization. **DO NOT** override this, use init() instead.
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public final function coreInit(){
		if ( ! self::$initialized ) {
			add_action( 'admin_menu', function () {
				remove_submenu_page( 'tools.php', 'redux-about' );
			}, 12 );
			self::$initialized = true;
		}

		$this->plugin->getHookFactory()->action('after_setup_theme', array($this, 'init'))->add();
	}

	/**
	 * This can be used by extenders for plugin initialization purposes. This is fired at TODO
	 * **IMPORTANT** - Always call parent init() if extending.
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function init(){}
}