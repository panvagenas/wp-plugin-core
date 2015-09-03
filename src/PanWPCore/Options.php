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
	 * @var \ReduxFramework
	 */
	protected $reduxInstance;

	/**
	 * @param Plugin $plugin
	 */
	public function __construct( Plugin $plugin ) {
		parent::__construct( $plugin );

		if ( empty( $this->optName ) ) {
			$this->optName = self::genOptName( $plugin );
		}
		$this->reduxInstance = get_redux_instance( $this->optName );
	}

	public static function genOptName( Plugin $plugin ) {
		return $plugin->getSlug() . '_options';
	}

	/**
	 * @return string
	 */
	public function getOptName() {
		return $this->optName;
	}

	/**
	 * @param $optionName
	 * @param null $default
	 *
	 * @return mixed
	 */
	public function get( $optionName, $default = null ) {
		return ( isset ( $this->reduxInstance->options[ $optionName ] ) )
			? $this->reduxInstance->options[ $optionName ]
			: $this->reduxInstance->_get_default( $optionName, $default );
	}

	/**
	 * @param $optionName
	 * @param $value
	 */
	public function set( $optionName, $value ) {
		$this->reduxInstance->set( $optionName, $value );
	}

	/**
	 * @return array
	 */
	public function getAll() {
		return $this->reduxInstance->options;
	}
}