<?php
/**
 * Project: wp-plugins-core.dev
 * File: AbsOptionGenField.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 13/10/2015
 * Time: 10:02 πμ
 * Since: 0.0.2
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace WPluginCore003\Abs;

use Respect\Validation\Exceptions\ValidationExceptionInterface;
use Respect\Validation\Validator;
use WPluginCore003\Plugin\Plugin;


/**
 * Class AbsOptionGenField
 *
 * @package WPluginCore003\Abs
 * @author  Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @since   0.0.3
 */
abstract class AbsOptionGenField extends AbsOptionField {
	/**
	 * Flag to run the compiler hook
	 *
	 * @link https://docs.reduxframework.com/redux-framework/integrating-a-compiler/
	 * @var bool|array
	 */
	protected $compiler;
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
	 *
	 * @var array
	 */
	protected $validators = array();

	/**
	 * @param Plugin $plugin
	 * @param        $fieldId
	 * @param        $title
	 */
	public function __construct( Plugin $plugin, $fieldId, $title ) {
		parent::__construct( $plugin, $fieldId );
		$this->title             = $title;
		$this->default           = $this->plugin->getOptions()->def( $this->id );
		$this->validate_callback = array( $this, 'validate' );
	}

	/**
	 * @param $field
	 * @param $value
	 * @param $existing_value
	 *
	 * @return array
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function validate( $field, $value, $existing_value ) {
		$valid  = true;
		$errors = array();
		$return = array();

		foreach ( $this->validators as $validator ) {
			/* @var Validator $validator */
			try {
				$validator->check( $value );
			} catch ( ValidationExceptionInterface $exception ) {
				$error    = $exception->getMainMessage();
				$errors[] = preg_replace( '/^("' . $value . '")/', "<em>{$field['title']}</em>", $error );
				$valid    = false;
			}
		}

		$return['value'] = $valid ? $value : $existing_value;

		if ( ! $valid ) {
			$field['msg']    = implode( '<br>', $errors );
			$return['error'] = $field;
		}

		return $return;
	}

	/**
	 * @param Validator $validator
	 *
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function addValidator( Validator $validator ) {
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
	 * @since  0.0.2
	 */
	public function setValidate( $validate ) {
		$this->validate = $validate;

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
	 * @since  0.0.2
	 */
	public function setCompiler( $compiler ) {
		$this->compiler = $compiler;

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
	 * @since  0.0.2
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
	 * @since  0.0.2
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
	 * @since  0.0.2
	 */
	public function setHint( $hint ) {
		$this->hint = $hint;

		return $this;
	}
}