<?php
/**
 * Project: wp-plugins-core.dev
 * File: AceEditor.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 15/10/2015
 * Time: 8:57 πμ
 * Since: 0.0.2
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace WPluginCore003\Options\Fields;


use WPluginCore003\Abs\AbsOptionGenField;

/**
 * Class AceEditor
 *
 * @package WPluginCore003\Options\Fields
 * @author  Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @since   0.0.2
 */
class AceEditor extends AbsOptionGenField {
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
	 * @since  0.0.2
	 */
	public function getMode() {
		return $this->mode;
	}

	/**
	 * @param string $mode
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function setMode( $mode ) {
		$this->mode = $mode;

		return $this;
	}

	/**
	 * @return string
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function getTheme() {
		return $this->theme;
	}

	/**
	 * @param string $theme
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function setTheme( $theme ) {
		$this->theme = $theme;

		return $this;
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
}