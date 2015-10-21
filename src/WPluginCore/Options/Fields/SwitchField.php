<?php
/**
 * Project: wp-plugins-core.dev
 * File: SwitchField.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 14/10/2015
 * Time: 9:50 μμ
 * Since: 0.0.2
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace WPluginCore003\Options\Fields;


use WPluginCore003\Abs\AbsOptionField;

/**
 * Class SwitchField
 *
 * @package WPluginCore003\Options\Fields
 * @author  Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @since   0.0.2
 */
class SwitchField extends AbsOptionField {
	/**
	 * Text display for the true value
	 *
	 * @var string
	 */
	protected $on = 'On';
	/**
	 * Text display for the false value
	 *
	 * @var string
	 */
	protected $off = 'Off';

	/**
	 * @return string
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function getOn() {
		return $this->on;
	}

	/**
	 * @param string $on
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function setOn( $on ) {
		$this->on = $on;

		return $this;
	}

	/**
	 * @return string
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function getOff() {
		return $this->off;
	}

	/**
	 * @param string $off
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function setOff( $off ) {
		$this->off = $off;

		return $this;
	}

}