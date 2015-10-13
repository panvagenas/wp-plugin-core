<?php
/**
 * Project: wp-plugins-core.dev
 * File: AbsOptionField.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 13/10/2015
 * Time: 10:02 πμ
 * Since: TODO ${VERSION}
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace WPluginCore002\Abs;

use Respect\Validation\Exceptions\NestedValidationExceptionInterface;
use Respect\Validation\Validator;


/**
 * Class AbsOptionField
 *
 * @package WPluginCore002\Abs
 * @author  Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @since   TODO ${VERSION}
 */
class AbsOptionField {
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
	 * Flag to run the compiler hook
	 *
	 * @link https://docs.reduxframework.com/redux-framework/integrating-a-compiler/
	 * @var bool|array
	 */
	protected $compiler;
	/**
	 * Provide the parent, comparison operator, and value which affects the field’s visibility
	 *
	 * @link https://docs.reduxframework.com/redux-framework/the-basics/the-required-argument/
	 * @var array
	 */
	protected $required;
	/**
	 * Default value
	 *
	 * @var string|array|int
	 */
	protected $default;
	/**
	 * String specifying the capability required to view this field
	 *
	 * @link https://docs.reduxframework.com/redux-framework/fields/using-permissions/
	 * @var string
	 */
	protected $permissions;
	/**
	 * Array containing the `content` and optional `title` arguments for the hint tooltip
	 *
	 * @link https://docs.reduxframework.com/redux-framework/the-basics/using-hints-in-fields/
	 * @var array
	 */
	protected $hint;
	/**
	 * @var string
	 */
	protected $validate;
	/**
	 * @var array
	 */
	protected $validate_callback;
	/**
	 * Array of {@link Respect\Validation\Validator}
	 * @var array
	 */
	public $validators = array();

	/**
	 * @param $type
	 * @param $id
	 * @param $title
	 * @param $default
	 */
	public function __construct( $type, $id, $title, $default ) {
		$this->type    = $type;
		$this->id      = $id;
		$this->title   = $title;
		$this->default = $default;
		$this->validate_callback = array($this, 'validate');
	}

	/**
	 * @param $field
	 * @param $value
	 * @param $existing_value
	 *
	 * @return array
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function validate($field, $value, $existing_value){
		$valid = true;
		$errors = array();
		$return = array();

		foreach ( $this->validators as $validator ) {
			/* @var Validator $validator */
			try {
				$validator->assert($value);
			} catch( NestedValidationExceptionInterface $exception) {
				$errors[] = $exception->getFullMessage();
				$valid = false;
			}
		}

		$return['value'] = $valid ? $value : $existing_value;

		if(!$valid){
			$field['msg'] = implode('<br>', str_replace("\n",'<br>', $errors));
			$return['error'] = $field;
		}

		return $return;
	}

	/**
	 * @param Validator $validator
	 *
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function addValidator( Validator $validator){
		$this->validators[] = $validator;
	}

	/**
	 * @return string
	 */
	public function getValidate() {
		return $this->validate;
	}

	/**
	 * @param $validate
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function setValidate( $validate ) {
		$this->validate = $validate;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * @param $title
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function setTitle( $title ) {
		$this->title = $title;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getSubtitle() {
		return $this->subtitle;
	}

	/**
	 * @param $subtitle
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function setSubtitle( $subtitle ) {
		$this->subtitle = $subtitle;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getDesc() {
		return $this->desc;
	}

	/**
	 * @param $desc
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function setDesc( $desc ) {
		$this->desc = $desc;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getClass() {
		return $this->class;
	}

	/**
	 * @param $class
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function setClass( $class ) {
		$this->class = $class;

		return $this;
	}

	/**
	 * @return array|bool
	 */
	public function getCompiler() {
		return $this->compiler;
	}

	/**
	 * @param $compiler
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function setCompiler( $compiler ) {
		$this->compiler = $compiler;

		return $this;
	}

	/**
	 * @return array
	 */
	public function getRequired() {
		return $this->required;
	}

	/**
	 * @param array $required
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function setRequired( $required ) {
		$this->required = $required;

		return $this;
	}

	/**
	 * @return array|int|string
	 */
	public function getDefault() {
		return $this->default;
	}

	/**
	 * @param $default
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function setDefault( $default ) {
		$this->default = $default;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getPermissions() {
		return $this->permissions;
	}

	/**
	 * @param $permissions
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function setPermissions( $permissions ) {
		$this->permissions = $permissions;

		return $this;
	}

	/**
	 * @return array
	 */
	public function getHint() {
		return $this->hint;
	}

	/**
	 * @param $hint
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function setHint( $hint ) {
		$this->hint = $hint;

		return $this;
	}

	/**
	 * @return array
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function toArray() {
		$out = array();

		$reflect = new \ReflectionClass( $this );
		$props   = $reflect->getProperties( \ReflectionProperty::IS_PROTECTED );

		foreach ( $props as $prop ) {
			$out[ $prop->getName() ] = $this->{$prop->getName()};
		}

		return $out;
	}
}