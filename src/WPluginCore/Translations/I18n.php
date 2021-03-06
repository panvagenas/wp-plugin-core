<?php
/**
 * Project: wp-plugins-core.dev
 * File: I18n.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 5/10/2015
 * Time: 8:51 πμ
 * Since: 0.0.2
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace WPluginCore003\Translations;


use WPluginCore003\Abs\AbsPluginSingleton;

/**
 * Class I18n
 *
 * @package WPluginCore003\Translations
 * @author  Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @since   0.0.2
 */
class I18n extends AbsPluginSingleton {
	/**
	 * @param $text
	 *
	 * @return string|void
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function __( $text ) {
		$text = (string) $text;

		return __( $text, $this->plugin->getTextDomain() );
	}

	/**
	 * @param $text
	 *
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function _e( $text ) {
		_e( $text, $this->plugin->getTextDomain() );
	}

	/**
	 * @param $single
	 * @param $plural
	 * @param $number
	 *
	 * @return string
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function _n( $single, $plural, $number ) {
		return _n( $single, $plural, $number, $this->plugin->getTextDomain() );
	}

	/**
	 * @param $text
	 * @param $context
	 *
	 * @return string|void
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function _x( $text, $context ) {
		return _x( $text, $context, $this->plugin->getTextDomain() );
	}

	/**
	 * @param $text
	 * @param $context
	 *
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function _ex( $text, $context ) {
		_ex( $text, $context, $this->plugin->getTextDomain() );
	}
}