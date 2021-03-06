<?php
/**
 * Project: wp-plugins-core.dev
 * File: Options.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 7/10/2015
 * Time: 10:46 μμ
 * Since: 0.0.2
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace WPluginCore003\Options;


use WPluginCore003\Abs\AbsPluginSingleton;
use WPluginCore003\Hooks\Action;
use WPluginCore003\Plugin\Plugin;

/**
 * Class Options
 *
 * @package WPluginCore003\Options
 * @author  Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @since   0.0.2
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
					array( $this, 'setupMenuPages' ) );
			}
			$this->menuSetupHook->add();
		}
	}

	/**
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function setupMenuPages() {
	}

	/**
	 * @param string $name
	 * @param mixed|null  $defaultValue
	 *
	 * @return array|null
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function get( $name, $defaultValue = null ) {
		return isset( $this->options[ $name ] )
			? $this->options[ $name ]
			: $this->def( $name, $defaultValue );
	}

	/**
	 * @param string $name
	 * @param mixed  $value
	 *
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function set( $name, $value ) {
		$this->options[ $name ] = $value;
		$this->save();
	}

	/**
	 * @param string $name
	 * @param mixed|null  $defaultValue
	 *
	 * @return array|null
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function def( $name, $defaultValue = null ) {
		return empty( $name ) ? $this->defaults : ( isset( $this->defaults[ $name ] ) ? $this->defaults[ $name ] : $defaultValue );
	}

	/**
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
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