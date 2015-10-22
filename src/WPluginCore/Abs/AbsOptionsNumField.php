<?php
/**
 * Project: wp-plugins-core.dev
 * File: AbsOptionsNumField.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 14/10/2015
 * Time: 10:03 μμ
 * Since: 0.0.2
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace WPluginCore003\Abs;


/**
 * Class AbsOptionsNumField
 *
 * @package WPluginCore003\Abs
 * @author  Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @since   0.0.2
 */
abstract class AbsOptionsNumField extends AbsOptionGenField {
	/**
	 * Value to set the minimum value
	 *
	 * @var int
	 */
	protected $min = 0;
	/**
	 * Value to set the maximum value
	 *
	 * @var int
	 */
	protected $max = 1;
	/**
	 * Value to set the step value
	 *
	 * @var int
	 */
	protected $step = 1;

	/**
	 * @return int
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function getMin() {
		return $this->min;
	}

	/**
	 * @param int $min
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function setMin( $min ) {
		$this->min = $min;

		return $this;
	}

	/**
	 * @return int
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function getMax() {
		return $this->max;
	}

	/**
	 * @param int $max
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function setMax( $max ) {
		$this->max = $max;

		return $this;
	}

	/**
	 * @return int
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function getStep() {
		return $this->step;
	}

	/**
	 * @param int $step
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function setStep( $step ) {
		$this->step = $step;

		return $this;
	}
}