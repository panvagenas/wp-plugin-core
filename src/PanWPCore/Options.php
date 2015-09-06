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
	 * @var mixed|void
	 */
	protected $options;
	/**
	 * @var array
	 */
	protected $reduxArgs = array();

	/**
	 * @param Plugin $plugin
	 */
	public function __construct( Plugin $plugin ) {
		parent::__construct( $plugin );
		if($this->optName){
			$this->options = get_option($this->optName);
		}
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
		return ( isset ( $this->options[ $optionName ] ) )
			? $this->options[ $optionName ]
			: $this->getDefaults( $optionName, $default );
	}

	/**
	 * @param $optionName
	 * @param $value
	 */
	public function set( $optionName, $value ) {
		$this->options[$optionName] = $value;
		update_option($this->optName, $this->options);
	}

	/**
	 * @return array
	 */
	public function getAll() {
		return $this->options;
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
	public function getDefaults($name = '', $default = null) {
		return empty($name) ? $this->defaults : (isset($this->defaults[$name]) ? $this->defaults[$name] : $default);
	}

	/**
	 * @return array
	 */
	public function getReduxArgs() {
		return $this->reduxArgs;
	}
}