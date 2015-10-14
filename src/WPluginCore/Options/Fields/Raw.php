<?php
/**
 * Project: wp-plugins-core.dev
 * File: Raw.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 14/10/2015
 * Time: 10:41 μμ
 * Since: TODO ${VERSION}
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace WPluginCore002\Options\Fields;


use WPluginCore002\Abs\AbsOptionsHtmlField;

class Raw extends AbsOptionsHtmlField {
	protected $type = 'raw';
	/**
	 * Flag to set denote if the field is full width or sectioned
	 *
	 * @var bool
	 */
	protected $full_width = true;
	/**
	 * Flag to set the markdown of standard line-break and tab characters to HTML
	 *
	 * @var bool
	 */
	protected $markdown = false;
	/**
	 * HTML content to display.  String values or file output may be used
	 *
	 * @var string
	 */
	protected $content;
	/**
	 * Full path to file that will be used as the content for this field
	 *
	 * @var string
	 */
	protected $content_path;
	/**
	 * Array containing the `content` and optional `title` arguments for the hint tooltip
	 *
	 * @link https://docs.reduxframework.com/redux-framework/the-basics/using-hints-in-fields/
	 * @var array
	 */
	protected $hint;

	/**
	 * @return boolean
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function isFullWidth() {
		return $this->full_width;
	}

	/**
	 * @param boolean $full_width
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function setFullWidth( $full_width ) {
		$this->full_width = $full_width;

		return $this;
	}

	/**
	 * @return boolean
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function isMarkdown() {
		return $this->markdown;
	}

	/**
	 * @param boolean $markdown
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function setMarkdown( $markdown ) {
		$this->markdown = $markdown;

		return $this;
	}

	/**
	 * @return string
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function getContent() {
		return $this->content;
	}

	/**
	 * @param string $content
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function setContent( $content ) {
		$this->content = $content;

		return $this;
	}

	/**
	 * @return string
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function getContentPath() {
		return $this->content_path;
	}

	/**
	 * @param string $content_path
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function setContentPath( $content_path ) {
		$this->content_path = $content_path;

		return $this;
	}

	/**
	 * @return array
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function getHint() {
		return $this->hint;
	}

	/**
	 * @param array $hint
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function setHint( $hint ) {
		$this->hint = $hint;

		return $this;
	}
}