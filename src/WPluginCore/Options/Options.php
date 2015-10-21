<?php
/**
 * Project: wp-plugins-core.dev
 * File: Options.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 7/10/2015
 * Time: 10:46 μμ
 * Since: TODO ${VERSION}
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace WPluginCore002\Options;


use WPluginCore002\Abs\AbsPluginSingleton;
use WPluginCore002\Hooks\Action;
use WPluginCore002\Plugin\Plugin;

/**
 * Class Options
 *
 * @package WPluginCore002\Options
 * @author  Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @since   TODO ${VERSION}
 */
class Options extends AbsPluginSingleton {
	/**
	 * @var string
	 */
	protected $optName;
	/**
	 * @var array
	 */
	protected $defaults;
	/**
	 * @var array
	 */
	protected $options;
	/**
	 * @var Action
	 */
	protected $menuSetupHook;

	/**
	 * @param Plugin $plugin
	 */
	protected function __construct( Plugin $plugin ) {
		parent::__construct( $plugin );

		if ( $this->optName ) {
			$options = get_option( $this->optName );

			if ( $options ) {
				$this->options = $options;
			} else {
				$this->options = $this->defaults;
				$this->save();
			}

			if ( ! $this->menuSetupHook ) {
				$this->menuSetupHook = $plugin->getHookFactory()->action( 'plugins_loaded',
					array( $this, 'menuPages' ) );
			}
			$this->menuSetupHook->add();
		}
	}

	/**
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function menuPages() {
	}

	/**
	 * @param string $name
	 * @param mixed  $defaultValue
	 *
	 * @return array|null
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function get( $name, $defaultValue ) {
		return isset( $this->options[ $name ] )
			? $this->options[ $name ]
			: $this->def( $name, $defaultValue );
	}

	/**
	 * @param string $name
	 * @param mixed  $value
	 *
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function set( $name, $value ) {
		$this->options[ $name ] = $value;
		$this->save();
	}

	/**
	 * @param string $name
	 * @param mixed  $defaultValue
	 *
	 * @return array|null
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function def( $name, $defaultValue = null ) {
		return empty( $name ) ? $this->defaults : ( isset( $this->defaults[ $name ] ) ? $this->defaults[ $name ] : $defaultValue );
	}

	/**
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function save() {
		return $this->optName ? update_option( $this->optName, $this->options ) : false;
	}

	/**
	 * @return string
	 */
	public function getOptName() {
		return $this->optName;
	}

	/**
	 * @return array
	 */
	public function getDefaults() {
		return $this->defaults;
	}

	/**
	 * @return array
	 */
	public function getOptions() {
		return $this->options;
	}
}