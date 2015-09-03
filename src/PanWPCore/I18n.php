<?php
/**
 * Project: pan-wp-core
 * File: I18n.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 3/9/2015
 * Time: 6:57 πμ
 * Since: TODO ${VERSION}
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace PanWPCore;


class I18n extends Core{
	/**
	 * @param $text
	 *
	 * @return string|void
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since TODO ${VERSION}
	 */
	public function __($text){
		$text = (string)$text;
		return __($text, $this->Plugin->getTextDomain());
	}

	/**
	 * @param $text
	 *
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since TODO ${VERSION}
	 */
	public function _e($text){
		_e($text, $this->Plugin->getTextDomain());
	}

	/**
	 * @param $single
	 * @param $plural
	 * @param $number
	 *
	 * @return string
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since TODO ${VERSION}
	 */
	public function _n($single, $plural, $number){
		return _n($single, $plural, $number, $this->Plugin->getTextDomain());
	}

	/**
	 * @param $text
	 * @param $context
	 *
	 * @return string|void
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since TODO ${VERSION}
	 */
	public function _x( $text, $context ){
		return _x($text, $context, $this->Plugin->getTextDomain());
	}

	/**
	 * @param $text
	 * @param $context
	 *
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since TODO ${VERSION}
	 */
	public function _ex( $text, $context ){
		_ex($text, $context, $this->Plugin->getTextDomain());
	}
}