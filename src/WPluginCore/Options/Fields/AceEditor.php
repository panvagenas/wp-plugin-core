<?php
/**
 * Project: wp-plugins-core.dev
 * File: AceEditor.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 15/10/2015
 * Time: 8:57 πμ
 * Since: TODO ${VERSION}
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace WPluginCore002\Options\Fields;


use WPluginCore002\Abs\AbsOptionField;

/**
 * Class AceEditor
 *
 * @package WPluginCore002\Options\Fields
 * @author  Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @since   TODO ${VERSION}
 */
class AceEditor extends AbsOptionField {
	/**
	 * @var string
	 */
	protected $type = 'ace_editor';
	/**
	 * Sets the language mode of the editor.  Accepts:  `css`, `html`, `javascript`,  `json`, `less`, `markdown`,
	 * `mysql`, `php`, `plain_text`, `sass`, `scss`, `text`, `xml`
	 *
	 * @var string
	 */
	protected $mode = 'javascript';
	/**
	 * Sets the theme of the editor.  Accepts: `chrome` or `monokai`
	 *
	 * @var string
	 */
	protected $theme = 'monokai';
	/**
	 * Pass any option to the Ace Editor object. For more details visit: {@link http://ace.c9.io/}
	 *
	 * @link http://ace.c9.
	 * @var array
	 */
	protected $options = array( 'minLines' => 12, 'maxLines' => 30 );

	/**
	 * @return string
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function getMode() {
		return $this->mode;
	}

	/**
	 * @param string $mode
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function setMode( $mode ) {
		$this->mode = $mode;

		return $this;
	}

	/**
	 * @return string
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function getTheme() {
		return $this->theme;
	}

	/**
	 * @param string $theme
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function setTheme( $theme ) {
		$this->theme = $theme;

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