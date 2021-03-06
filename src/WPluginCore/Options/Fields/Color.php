<?php
/**
 * Project: wp-plugins-core.dev
 * File: Color.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 15/10/2015
 * Time: 9:03 πμ
 * Since: 0.0.2
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace WPluginCore003\Options\Fields;

use WPluginCore003\Abs\AbsOptionGenField;

/**
 * Class Color
 *
 * @package WPluginCore003\Options\Fields
 * @author  Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @since   0.0.2
 */
class Color extends AbsOptionGenField {
	/**
	 * @var string
	 */
	protected $type = 'color';
	/**
	 * Array of CSS selectors to dynamically generate CSS
	 *
	 * @link https://docs.reduxframework.com/redux-framework/the-basics/output-2/
	 * @var array
	 */
	protected $output = array();
	/**
	 * Flag to set the display of the transparency checkbox
	 *
	 * @var bool
	 */
	protected $transparent = true;
	/**
	 * String value of the validation type to validate.  The only accepted value is `color`
	 *
	 * @var string
	 */
	protected $validate = 'color';

	/**
	 * @return array
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function getOutput() {
		return $this->output;
	}

	/**
	 * @param array $output
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function setOutput( $output ) {
		$this->output = $output;

		return $this;
	}

	/**
	 * @return boolean
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function isTransparent() {
		return $this->transparent;
	}

	/**
	 * @param boolean $transparent
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function setTransparent( $transparent ) {
		$this->transparent = $transparent;

		return $this;
	}
}