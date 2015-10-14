<?php
/**
 * Project: wp-plugins-core.dev
 * File: Text.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 13/10/2015
 * Time: 10:00 πμ
 * Since: TODO ${VERSION}
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace WPluginCore002\Options\Fields;


use WPluginCore002\Abs\AbsOptionField;

/**
 * Class Text
 *
 * @package WPluginCore002\Options\Fields
 * @author  Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @since   TODO ${VERSION}
 */
class Text extends AbsOptionField {
	/**
	 * Sets the input field to be readonly or not
	 *
	 * @var bool
	 */
	protected $readonly;
	/**
	 * Text to display in the input when n value is present
	 *
	 * @var string
	 */
	protected $placeholder;
	/**
	 * Custom message to display upon failure of validation
	 *
	 * @var string
	 */
	protected $msg;

	/**
	 * @param $id
	 * @param $title
	 * @param $default
	 */
	public function __construct($id, $title, $default){
		parent::__construct('text', $id, $title, $default);
	}

	/**
	 * @return boolean
	 */
	public function isReadonly() {
		return $this->readonly;
	}

	/**
	 * @param $readonly
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function setReadonly( $readonly ) {
		$this->readonly = $readonly;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getPlaceholder() {
		return $this->placeholder;
	}

	/**
	 * @param $placeholder
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function setPlaceholder( $placeholder ) {
		$this->placeholder = $placeholder;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getMsg() {
		return $this->msg;
	}

	/**
	 * @param $msg
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function setMsg( $msg ) {
		$this->msg = $msg;

		return $this;
	}
}