<?php
/**
 * Project: wp-plugins-core.dev
 * File: Checkbox.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 14/10/2015
 * Time: 4:42 μμ
 * Since: 0.0.2
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace WPluginCore003\Options\Fields;


use WPluginCore003\Abs\AbsOptionGenField;

/**
 * Class Checkbox
 *
 * @package WPluginCore003\Options\Fields
 * @author  Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @since   0.0.2
 */
class Checkbox extends AbsOptionGenField {
	/**
	 * @var string
	 */
	protected $type = 'checkbox';
	/**
	 * Array of key pair values representing the individual check boxes.
	 * They key represents the ID of the checkbox, the value is the text displayed next to the checkbox
	 *
	 * @var array
	 */
	protected $options;
	/**
	 * String value that populates the check boxes with WordPress values.
	 * Accepts:  `category`, `categories`, `menu`, `menus`, `menu_location`, `menu_locations`, `page`, `pages`, `post`,
	 * `posts`, `post_type`, `post_types`, `tag`, `tags`
	 *
	 * @var string
	 */
	protected $data;
	/**
	 * Array of WordPress arguments for the specific data to be retrieved
	 *
	 * @var array
	 */
	protected $args;
	/**
	 * String/int or array values depending on whether or not multiple check boxes are used
	 *
	 * @var string|int|array
	 */
	protected $default;

	/**
	 * @param       $fieldId
	 * @param       $title
	 * @param       $default
	 * @param array $options
	 */
	public function __construct( $fieldId, $title, $default, $options = array() ) {
		parent::__construct( $fieldId, $title, $default );
		$this->options = (array) $options;
	}

	/**
	 * @return array
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function getOptions() {
		return $this->options;
	}

	/**
	 * @param array $options
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function setOptions( $options ) {
		$this->options = $options;

		return $this;
	}

	/**
	 * @return string
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function getData() {
		return $this->data;
	}

	/**
	 * @param string $data
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function setData( $data ) {
		$this->data = $data;

		return $this;
	}

	/**
	 * @return array
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function getArgs() {
		return $this->args;
	}

	/**
	 * @param array $args
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function setArgs( $args ) {
		$this->args = $args;

		return $this;
	}
}