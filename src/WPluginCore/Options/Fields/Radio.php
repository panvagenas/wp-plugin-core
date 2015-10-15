<?php
/**
 * Project: wp-plugins-core.dev
 * File: Radio.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 14/10/2015
 * Time: 9:54 μμ
 * Since: TODO ${VERSION}
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace WPluginCore002\Options\Fields;


use WPluginCore002\Abs\AbsOptionField;

class Radio extends AbsOptionField {
	protected $type = 'radio';
	/**
	 * Array of key pair values representing the radio buttons.  The key value should be numbers in sequential order,
	 * beginning with 1.  The value parameter accepts the text to display beside the radio button
	 *
	 * @var array
	 */
	protected $options;
	/**
	 * Sets the radio option values with WordPress data.  Accepts: `category`, `categories`, `menu`,
	 * `menus`, `menu_location`, `menu_locations`, `page`, `pages`, `post`, `posts`, `post_type`,
	 * `post_types`, `tag`, `tags`, `taxonomy`, `taxonomies`, `roles`, `sidebar`, `sidebars`, `capabilities`,
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
	 * Value indicated the key value of the options array to set as default
	 *
	 * @var string|int
	 */
	protected $default;

	/**
	 * @param       $id
	 * @param       $title
	 * @param       $default
	 * @param array $options
	 */
	public function __construct( $id, $title, $default, $options = array() ) {
		parent::__construct( $id, $title, $default );
		$this->options = (array) $options;
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
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function setOptions( $options ) {
		$this->options = $options;
	}

	/**
	 * @return string
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function getData() {
		return $this->data;
	}

	/**
	 * @param string $data
	 *
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function setData( $data ) {
		$this->data = $data;
	}

	/**
	 * @return array
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function getArgs() {
		return $this->args;
	}

	/**
	 * @param array $args
	 *
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function setArgs( $args ) {
		$this->args = $args;
	}
}