<?php
/**
 * Project: wp-plugins-core.dev
 * File: Initializer.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 28/9/2015
 * Time: 12:06 μμ
 * Since: 0.0.2
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace WPluginCore003\Plugin;


use WPluginCore003\Abs\AbsPluginSingleton;

/**
 * Class Initializer
 *
 * @package WPluginCore003\Plugin
 * @author  Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @since   0.0.2
 */
class Initializer extends AbsPluginSingleton {
	/**
	 * @var bool
	 */
	private static $initialized = false;

	/**
	 * This is used for core initialization. **DO NOT** override this, use {@link Initializer::init()} instead.
	 *
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public final function coreInit() {
		if ( ! self::$initialized ) {
			add_action( 'admin_menu', function () {
				remove_submenu_page( 'tools.php', 'redux-about' );
			}, 12 );
			self::$initialized = true;
		}

		$this->pluginInit();
	}

	/**
	 * This is used for plugin initialization. **DO NOT** override this, use {@link Initializer::init()} instead.
	 *
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	protected function pluginInit() {
		$this->plugin->getHookFactory()->action( 'after_setup_theme', array( $this, 'init' ) )->add();
		$pluginFactory = $this->plugin->getFactory()->fcrPlugin();

		$textDomain = $this->plugin->getTextDomain();

		if ( ! empty( $textDomain ) ) {
			$pluginDir = basename( dirname( $this->plugin->getFilePath() ) ) . $pluginFactory->paths()->getTranslationsRelDirPath();

			$this->plugin->getHookFactory()->action( 'plugins_loaded',
				function () use ( $textDomain, $pluginDir ) {
					load_plugin_textdomain( $textDomain, null, $pluginDir );
				}
			)->add();
		}

		register_activation_hook(
			$this->plugin->getBaseName(),
			array( $pluginFactory->installer(), 'activation' )
		);

		register_deactivation_hook(
			$this->plugin->getBaseName(),
			array( $pluginFactory->installer(), 'deactivation' )
		);

		register_uninstall_hook(
			$this->plugin->getBaseName(),
			array(
				get_class( $pluginFactory->installer() ),
				'uninstall'
			)
		);

	}

	/**
	 * This can be used by extenders for plugin initialization purposes. This is fired at TODO
	 * **IMPORTANT** - Always call parent init() if extending.
	 *
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function init() {
	}
}