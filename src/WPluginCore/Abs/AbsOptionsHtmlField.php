<?php
/**
 * Project: wp-plugins-core.dev
 * File: AbsOptionsHtmlField.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 14/10/2015
 * Time: 10:32 μμ
 * Since: 0.0.2
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace WPluginCore003\Abs;


/**
 * Class AbsOptionsHtmlField
 *
 * @package WPluginCore003\Abs
 * @author  Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @since   0.0.2
 */
abstract class AbsOptionsHtmlField {
	/**
	 * Value identifying the field type.
	 *
	 * @var string
	 */
	protected $type;
	/**
	 * Unique ID identifying the field. Must be different from all other field IDs
	 *
	 * @var string
	 */
	protected $id;
	/**
	 * Displays title of the option
	 *
	 * @var string
	 */
	protected $title;
	/**
	 * Subtitle display of the option, situated beneath the title
	 *
	 * @var string
	 */
	protected $subtitle;
	/**
	 * Description of the option, appearing beneath the field control
	 *
	 * @var string
	 */
	protected $desc;
	/**
	 * Appends any number of classes to the field’s class attribute
	 *
	 * @var string
	 */
	protected $class;
	/**
	 * Provide the parent, comparison operator, and value which affects the field’s visibility
	 *
	 * @link https://docs.reduxframework.com/redux-framework/the-basics/the-required-argument/
	 * @var array
	 */
	protected $required;

	/**
	 * @param $fieldId
	 */
	public function __construct( $fieldId ) {
		$this->id = $fieldId;
	}

	/**
	 * @return string
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * @param string $title
	 *
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function setTitle( $title ) {
		$this->title = $title;
	}

	/**
	 * @return string
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function getSubtitle() {
		return $this->subtitle;
	}

	/**
	 * @param string $subtitle
	 *
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function setSubtitle( $subtitle ) {
		$this->subtitle = $subtitle;
	}

	/**
	 * @return string
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function getDesc() {
		return $this->desc;
	}

	/**
	 * @param string $desc
	 *
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function setDesc( $desc ) {
		$this->desc = $desc;
	}

	/**
	 * @return string
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function getClass() {
		return $this->class;
	}

	/**
	 * @param string $class
	 *
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function setClass( $class ) {
		$this->class = $class;
	}

	/**
	 * @return array
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function getRequired() {
		return $this->required;
	}

	/**
	 * @param array $required
	 *
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function setRequired( $required ) {
		$this->required = $required;
	}
}