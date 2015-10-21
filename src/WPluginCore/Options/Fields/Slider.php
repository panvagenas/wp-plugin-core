<?php
/**
 * Project: wp-plugins-core.dev
 * File: Slider.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 14/10/2015
 * Time: 10:06 μμ
 * Since: 0.0.2
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace WPluginCore003\Options\Fields;


use WPluginCore003\Abs\AbsOptionsNumField;

/**
 * Class Slider
 *
 * @package WPluginCore003\Options\Fields
 * @author  Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @since   0.0.2
 */
class Slider extends AbsOptionsNumField {
	/**
	 * @var string
	 */
	protected $type = 'slider';
	/**
	 * Sets the number of slider handles, either `1` or `2`. Any other value will default to `1`
	 *
	 * @var int
	 */
	protected $handles = 1;
	/**
	 * Sets output mode for the slider value. Accepted values include `none` for no output,
	 * `label` for a printed value, `text` for an editable text box, or `select` for a select box of values.
	 * Any other or incorrect values will default to `text`
	 *
	 * @var string
	 */
	protected $display_value = 'text';
	/**
	 * Sets the value’s decimal significance. Acceptable values are: `1`, `0.1`, `0.01`, `0.001`, `0.0001`, `0.00001`.
	 * Any improper value will default to `1`
	 *
	 * @var int|float
	 */
	protected $resolution = 1;
	/**
	 * Sets the floating point marker to either `.` (decimal) or `,` (comma). Any other value will default to
	 * the decimal value
	 *
	 * @var string
	 */
	protected $float_mark = '.';
	/**
	 * Array of select2 arguments. For more information see the ‘Constructor’ section of the
	 * <a href="http://ivaynberg.github.io/select2/index.html">Select2 docs</a>.
	 * Only applies when `display_value` is set to `select`
	 *
	 * @link http://ivaynberg.github.io/select2/index.html
	 * @var array
	 */
	protected $select2 = array();

	/**
	 * @return array
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function getSelect2() {
		return $this->select2;
	}

	/**
	 * @param array $select2
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function setSelect2( $select2 ) {
		$this->select2 = $select2;

		return $this;
	}

	/**
	 * @return string
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function getFloatMark() {
		return $this->float_mark;
	}

	/**
	 * @param string $float_mark
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function setFloatMark( $float_mark ) {
		$this->float_mark = $float_mark;

		return $this;
	}

	/**
	 * @return int|float
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function getResolution() {
		return $this->resolution;
	}

	/**
	 * @param int|float $resolution
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function setResolution( $resolution ) {
		$this->resolution = $resolution;

		return $this;
	}

	/**
	 * @return string
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function getDisplayValue() {
		return $this->display_value;
	}

	/**
	 * @param string $display_value
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function setDisplayValue( $display_value ) {
		$this->display_value = $display_value;

		return $this;
	}

	/**
	 * @return int
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function getHandles() {
		return $this->handles;
	}

	/**
	 * @param int $handles
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function setHandles( $handles ) {
		$this->handles = $handles;

		return $this;
	}
}