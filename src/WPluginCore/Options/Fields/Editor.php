<?php
/**
 * Project: wp-plugins-core.dev
 * File: Editor.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 15/10/2015
 * Time: 9:14 πμ
 * Since: 0.0.2
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace WPluginCore003\Options\Fields;


use WPluginCore003\Abs\AbsOptionGenField;

class Editor extends AbsOptionGenField {
	/**
	 * @var string
	 */
	protected $type = 'editor';
	/**
	 * Sets the default WordPress editor arguments
	 *
	 * @link https://codex.wordpress.org/Function_Reference/wp_editor
	 * @var array
	 */
	protected $args = array(
		'wpautop'       => true,
		'media_buttons' => true,
		'textarea_rows' => 10,
		'tabindex'      => '',
		'editor_css'    => '',
		'teeny'         => true,
		'dfw'           => false,
		'tinymce'       => array(),
		'quicktags'     => array()
	);

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