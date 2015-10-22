<?php
/**
 * Project: wp-plugins-core.dev
 * File: Select.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 14/10/2015
 * Time: 10:14 μμ
 * Since: 0.0.2
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace WPluginCore003\Options\Fields;


use WPluginCore003\Abs\AbsOptionField;

/**
 * Class Select
 *
 * @package WPluginCore003\Options\Fields
 * @author  Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @since   0.0.2
 */
class Select extends AbsOptionField {
	/**
	 * @var string
	 */
	protected $type = 'select';
	/**
	 * Value to populate the selector with WordPress values.
	 * Accepts:  `category`, `categories`, `menu`, `menus`, `menu_location`, `menu_locations`, `page`, `pages`, `post`,
	 * `posts`, `post_type`, `post_types`, `tag`, `tags`. To list icons, specify `elusive-icons`
	 *
	 * @var string
	 */
	protected $data;
	/**
	 * WordPress arguments for the specific data to be retrieved
	 *
	 * @var array
	 */
	protected $args;
	/**
	 * Value to set the width of the selector
	 *
	 * @var string
	 */
	protected $width = '40%';
	/**
	 * Flag to set the multi-select variation of the field
	 *
	 * @var bool
	 */
	protected $multi = false;
	/**
	 * Text to display in the selector when no value is present
	 *
	 * @var string
	 */
	protected $placeholder;
	/**
	 * Flag to enable data sorting
	 *
	 * @var bool
	 */
	protected $sortable = false;
	/**
	 * Array of options in key pair format.  The key represents the ID of the option.  The value represents the text to appear in the selector
	 *
	 * @var array
	 */
	protected $options = array();
	/**
	 * Array of select2 arguments. For more information see the ‘Constructor’ section of the
	 * <a href="http://ivaynberg.github.io/select2/index.html">Select2 docs</a>.
	 * Only applies when `display_value` is set to `select`
	 *
	 * @link http://ivaynberg.github.io/select2/index.html
	 * @var array
	 */
	protected $select2 = array();

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

	/**
	 * @return string
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function getWidth() {
		return $this->width;
	}

	/**
	 * @param string $width
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function setWidth( $width ) {
		$this->width = $width;

		return $this;
	}

	/**
	 * @return string
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function getPlaceholder() {
		return $this->placeholder;
	}

	/**
	 * @param string $placeholder
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function setPlaceholder( $placeholder ) {
		$this->placeholder = $placeholder;

		return $this;
	}

	/**
	 * @return boolean
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function isSortable() {
		return $this->sortable;
	}

	/**
	 * @param boolean $sortable
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function setSortable( $sortable ) {
		$this->sortable = $sortable;

		return $this;
	}

	/**
	 * @return array
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function getSelect2() {
		return $this->select2;
	}

	/**
	 * @param array $select2
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function setSelect2( $select2 ) {
		$this->select2 = $select2;

		return $this;
	}

	/**
	 * @return array
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function getOptions() {
		return $this->options;
	}

	/**
	 * @param array $options
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function setOptions( $options ) {
		$this->options = $options;

		return $this;
	}
}