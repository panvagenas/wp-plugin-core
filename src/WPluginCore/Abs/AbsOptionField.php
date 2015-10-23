<?php
/**
 * Project: wp-plugins-core.dev
 * File: AbsOptionField.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 22/10/2015
 * Time: 10:01 μμ
 * Since: 0.0.2
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace WPluginCore003\Abs;


use WPluginCore003\Options\Components\Section;
use WPluginCore003\Plugin\Plugin;

/**
 * Class AbsOptionField
 *
 * @package WPluginCore003\Abs
 * @author  Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @since   0.0.2
 */
abstract class AbsOptionField extends AbsClass{
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
	 * @param Plugin $plugin
	 * @param        $fieldId
	 */
	public function __construct( Plugin $plugin, $fieldId ) {
		parent::__construct($plugin);
		$this->id = $fieldId;
	}

	/**
	 * @param Section $section
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.3
	 */
	public function addToSection( Section $section ) {
		$section->addField( $this );

		return $this;
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
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function setTitle( $title ) {
		$this->title = $title;

		return $this;
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
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function setSubtitle( $subtitle ) {
		$this->subtitle = $subtitle;

		return $this;
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
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function setDesc( $desc ) {
		$this->desc = $desc;

		return $this;
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
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function setClass( $class ) {
		$this->class = $class;

		return $this;
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
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function setRequired( $required ) {
		$this->required = $required;

		return $this;
	}

	/**
	 * @return array
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function toArray() {
		$out = array();

		$reflect = new \ReflectionClass( $this );
		$props   = $reflect->getProperties( \ReflectionProperty::IS_PUBLIC | \ReflectionProperty::IS_PROTECTED );

		foreach ( $props as $prop ) {
			$out[ $prop->getName() ] = $this->{$prop->getName()};
		}

		return $out;
	}
}