<?php
/**
 * Project: wp-plugins-core.dev
 * File: AbsOptionsHtmlField.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 14/10/2015
 * Time: 10:32 μμ
 * Since: TODO ${VERSION}
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace WPluginCore002\Abs;


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
	 * @param $id
	 */
	public function __construct( $id ) {
		$this->id = $id;
	}

	/**
	 * @return string
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * @param string $title
	 *
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function setTitle( $title ) {
		$this->title = $title;
	}

	/**
	 * @return string
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function getSubtitle() {
		return $this->subtitle;
	}

	/**
	 * @param string $subtitle
	 *
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function setSubtitle( $subtitle ) {
		$this->subtitle = $subtitle;
	}

	/**
	 * @return string
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function getDesc() {
		return $this->desc;
	}

	/**
	 * @param string $desc
	 *
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function setDesc( $desc ) {
		$this->desc = $desc;
	}

	/**
	 * @return string
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function getClass() {
		return $this->class;
	}

	/**
	 * @param string $class
	 *
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function setClass( $class ) {
		$this->class = $class;
	}

	/**
	 * @return array
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function getRequired() {
		return $this->required;
	}

	/**
	 * @param array $required
	 *
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function setRequired( $required ) {
		$this->required = $required;
	}
}