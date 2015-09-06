<?php
/**
 * Created by PhpStorm.
 * User: vagenas
 * Date: 29/8/2015
 * Time: 12:29 μμ
 */

namespace PanWPCore;


use Stringy\Stringy;

class Options extends Core {
	protected $optName = '';
	/**
	 * @var \ReduxFramework
	 */
	protected $reduxInstance;
	/**
	 * @var array
	 */
	protected $defaults = array();
	/**
	 * @var array
	 */
	protected $reduxArgs = array();

	/**
	 * @param Plugin $plugin
	 */
	public function __construct( Plugin $plugin ) {
		parent::__construct( $plugin );

//		if ( empty( $this->optName ) ) {
//			$this->optName = $plugin->getSlug() . '_options';
//		}


//		if(!($this->reduxInstance instanceof \ReduxFramework)){
//			$this->reduxInstance = new \ReduxFramework(array(), array_merge(Redux::$reduxDefaults, array('opt_name' => $this->optName)));
//		}
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

	/**
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function setupReduxInstance(){
		$this->reduxInstance = get_redux_instance( $this->optName );
//		Dumper::dd($GLOBALS['wp_actions'], $this);
	}

	/**
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function setup(){}

	/**
	 * @param string $name
	 *
	 * @return mixed
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function getDefaults($name = '') {
		return empty($name) ? $this->defaults : (isset($this->defaults[$name]) ? $this->defaults[$name] : false);
	}

	/**
	 * @return array
	 */
	public function getReduxArgs() {
		return $this->reduxArgs;
	}
}