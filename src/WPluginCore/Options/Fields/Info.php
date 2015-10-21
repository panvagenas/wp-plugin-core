<?php
/**
 * Project: wp-plugins-core.dev
 * File: Info.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 14/10/2015
 * Time: 10:45 μμ
 * Since: 0.0.2
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace WPluginCore002\Options\Fields;


use WPluginCore002\Abs\AbsOptionsHtmlField;

/**
 * Class Info
 *
 * @package WPluginCore002\Options\Fields
 * @author  Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @since   0.0.2
 */
class Info extends AbsOptionsHtmlField {
	/**
	 * @var string
	 */
	protected $type = 'info';
	/**
	 * Sets the mode of the info box.  Accepts:  `normal`, `info`, `warning`, `success`, `critical`, or `custom`,
	 *
	 * @var string
	 */
	protected $style = 'normal';
	/**
	 * Set the styling to the non-notice styles, instead of the default WordPress 3.8 notice styles
	 *
	 * @var bool
	 */
	protected $notice = true;
	/**
	 * Color that becomes the left border if style is set to custom. Will not work with a non-notice styled field
	 *
	 * @var string
	 */
	protected $color;
	/**
	 * Name of an <a href="http://shoestrap.org/downloads/elusive-icons-webfont/">Elusive Icon</a> font
	 * to use in the info box
	 *
	 * @link http://shoestrap.org/downloads/elusive-icons-webfont
	 * @var string
	 */
	protected $icon;

	/**
	 * @return string
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function getStyle() {
		return $this->style;
	}

	/**
	 * @param string $style
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function setStyle( $style ) {
		$this->style = $style;

		return $this;
	}

	/**
	 * @return boolean
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function isNotice() {
		return $this->notice;
	}

	/**
	 * @param boolean $notice
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function setNotice( $notice ) {
		$this->notice = $notice;

		return $this;
	}

	/**
	 * @return string
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function getColor() {
		return $this->color;
	}

	/**
	 * @param string $color
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function setColor( $color ) {
		$this->color = $color;

		return $this;
	}

	/**
	 * @return string
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function getIcon() {
		return $this->icon;
	}

	/**
	 * @param string $icon
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function setIcon( $icon ) {
		$this->icon = $icon;

		return $this;
	}
}