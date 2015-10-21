<?php
/**
 * Project: wp-plugins-core.dev
 * File: TextArea.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 14/10/2015
 * Time: 4:23 μμ
 * Since: TODO ${VERSION}
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace WPluginCore002\Options\Fields;


/**
 * Class TextArea
 *
 * @package WPluginCore002\Options\Fields
 * @author  Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @since   TODO ${VERSION}
 */
class TextArea extends Text {
	/**
	 * @var string
	 */
	protected $type = 'textarea';
	/**
	 * Numbers of text rows to display
	 *
	 * @var int
	 */
	protected $rows = 6;
	/**
	 * Array of allowed HTML tags. See {@link http://codex.wordpress.org/Function_Reference/wp_kses}
	 * for more information
	 *
	 * @link http://codex.wordpress.org/Function_Reference/wp_kses
	 * @var array
	 */
	protected $allowed_html;

	/**
	 * @return int
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function getRows() {
		return $this->rows;
	}

	/**
	 * @param int $rows
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function setRows( $rows ) {
		$this->rows = $rows;

		return $this;
	}

	/**
	 * @return array
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function getAllowedHtml() {
		return $this->allowed_html;
	}

	/**
	 * @param array $allowed_html
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function setAllowedHtml( $allowed_html ) {
		$this->allowed_html = $allowed_html;

		return $this;
	}
}