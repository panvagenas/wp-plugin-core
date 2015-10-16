<?php
/**
 * Project: wp-plugins-core.dev
 * File: ShortCode.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 2/10/2015
 * Time: 9:47 πμ
 * Since: TODO ${VERSION}
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace WPluginCore002\Plugin;


use WPluginCore002\Abs\AbsClass;
use WPluginCore002\Diagnostics\Exception;

/**
 * Class ShortCode
 *
 * @package WPluginCore002\Plugin
 * @author  Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @since   TODO ${VERSION}
 */
class ShortCode extends AbsClass {
	/**
	 * Assoc array `['attr_name' => 'attr_default_value']`
	 *
	 * @var array
	 */
	protected $atts = array();
	/**
	 * Assoc array `['attr_name' => 'attr_type']`.
	 * For attribute type you should use one of `Core\Constants::TYPE_*`
	 *
	 * @var array
	 */
	protected $types = array();
	/**
	 * @var bool
	 */
	protected $enclosing = false;
	/**
	 * @var string
	 */
	protected $tag;

	/**
	 * @param Plugin     $plugin
	 * @param string     $tag
	 * @param array      $atts
	 * @param array      $types
	 * @param bool|false $enclosing
	 *
	 * @throws Exception
	 */
	public function __construct( Plugin $plugin, $tag, $atts = array(), $types = array(), $enclosing = false ) {
		parent::__construct( $plugin );

		$this->tag       = (string) $tag;
		$this->atts      = (array) $atts;
		$this->types     = (array) $types;
		$this->enclosing = (bool) $enclosing;

		if ( array_diff_key( $atts, $types ) ) {
			throw new Exception( 'Doing it wrong. Array keys don\'t match' );
		}

		add_shortcode( $this->tag, array( $this, 'prepare' ) );
	}

	/**
	 * @param      $atts
	 * @param null $content
	 *
	 * @return string
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function prepare( $atts, $content = null ) {
		$atts = array_intersect_key( $atts, $this->atts );
		$atts = shortcode_atts( $this->atts, $atts );

		foreach ( $this->types as $attrName => $attrType ) {
			settype( $atts[ $attrName ], $attrType );
		}

		return $this->output( $atts, $content );
	}

	/**
	 * @param      $atts
	 * @param null $content
	 *
	 * @return string
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	protected function output( $atts, $content = null ) {
		return '';
	}
}
