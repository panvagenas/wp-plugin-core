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


class Initializer extends Core {
	/**
	 * @var bool
	 */
	private static $initialized = false;

	/**
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public final function run() {
		self::coreInit();
		$this->_init();
	}

	/**
	 * @static * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	private static final function coreInit() {
		if ( ! self::$initialized ) {
			add_action( 'admin_menu', function () {
				remove_submenu_page( 'tools.php', 'redux-about' );
			}, 12 );
			self::$initialized = true;
		}
	}

	/**
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	private final function _init() {
		$textDomain = $this->Plugin->getTextDomain();
		if ( ! empty( $textDomain ) ) {
			$pluginDir = basename( dirname( $this->Plugin->getFilePath() ) ) . $this->Paths->translationsRelDirPath;
			add_action( 'plugins_loaded', function () use ( $textDomain, $pluginDir ) {
				load_plugin_textdomain( $textDomain, null, $pluginDir );
			} );
		}

		register_activation_hook( $this->Plugin->getBaseName(), array( $this->Installer, 'activation' ) );
		register_deactivation_hook( $this->Plugin->getBaseName(), array( $this->Installer, 'deactivation' ) );
		register_uninstall_hook( $this->Plugin->getBaseName(), array( get_class( $this->Installer ), 'uninstall' ) );

		$optName = $this->Options->getOptName();
		if ( ! empty( $optName ) ) {
			if ( is_admin() ) {
				$this->Options->setup();
			}
		} else {
			unset( $this->Options );
		}

		$this->init();
	}

	/**
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 *
	 * @info   Already runed hooks:
	 *          "muplugins_loaded"
	 *          "registered_taxonomy"
	 *          "registered_post_type"
	 *          "redux/init"
	 *          "doing_it_wrong_run"
	 *          "plugins_loaded"
	 *          "load_textdomain"
	 *          "sanitize_comment_cookies"
	 *          "setup_theme"
	 *          "unload_textdomain"
	 *          "after_setup_theme"
	 *          "redux/construct"
	 */
	protected function init() {
	}
}