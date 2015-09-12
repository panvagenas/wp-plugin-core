<?php
/**
 * Created by PhpStorm.
 * User: vagenas
 * Date: 29/8/2015
 * Time: 12:29 μμ
 */

namespace PanWPCore;

class Options extends Core {
	protected $optName = '';
	/**
	 * @var array
	 */
	protected $defaults = array();
	/**
	 * @var mixed|void
	 */
	protected $options;
	/**
	 * @var array
	 */
	protected $reduxArgs = array();

	/**
	 * @param Plugin $plugin
	 * @param null   $optionsName
	 */
	public function __construct( Plugin $plugin, $optionsName = null ) {
		parent::__construct( $plugin );

		if ( $optionsName ) {
			$this->optName = $optionsName;
		}
		if ( $this->optName ) {
			$this->options = get_option( $this->optName );
		}
	}

	/**
	 * @return null|string
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function getOptName() {
		return $this->optName;
	}

	/**
	 * @param      $optionName
	 * @param null $default
	 *
	 * @return mixed
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function get( $optionName, $default = null ) {
		return ( isset ( $this->options[ $optionName ] ) )
			? $this->options[ $optionName ]
			: $this->getDefaults( $optionName, $default );
	}

	/**
	 * @param $optionName
	 * @param $value
	 *
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function set( $optionName, $value ) {
		$this->options[ $optionName ] = $value;
		update_option( $this->optName, $this->options );
	}

	/**
	 * @return mixed|void
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function getAll() {
		return $this->options;
	}

	/**
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function setup() {
	}

	/**
	 * @param string $name
	 *
	 * @return mixed
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function getDefaults( $name = '', $default = null ) {
		return empty( $name ) ? $this->defaults : ( isset( $this->defaults[ $name ] ) ? $this->defaults[ $name ] : $default );
	}

	/**
	 * @return array
	 */
	public function getReduxArgs() {
		return $this->reduxArgs;
	}
}