<?php
/**
 * Project: wp-plugins-core.dev
 * File: AbsOptionsNumField.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 14/10/2015
 * Time: 10:03 μμ
 * Since: TODO ${VERSION}
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace WPluginCore002\Abs;


abstract class AbsOptionsNumField extends AbsOptionField {
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
	 * @since  TODO ${VERSION}
	 */
	public function getMin() {
		return $this->min;
	}

	/**
	 * @param int $min
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function setMin( $min ) {
		$this->min = $min;

		return $this;
	}

	/**
	 * @return int
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function getMax() {
		return $this->max;
	}

	/**
	 * @param int $max
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function setMax( $max ) {
		$this->max = $max;

		return $this;
	}

	/**
	 * @return int
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function getStep() {
		return $this->step;
	}

	/**
	 * @param int $step
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function setStep( $step ) {
		$this->step = $step;

		return $this;
	}

}