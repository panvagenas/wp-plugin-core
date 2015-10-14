<?php
/**
 * Project: wp-plugins-core.dev
 * File: HelpTab.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 14/10/2015
 * Time: 9:36 πμ
 * Since: TODO ${VERSION}
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace WPluginCore002\Options\Components;


use WPluginCore002\Abs\AbsClass;
use WPluginCore002\Helpers\Random;
use WPluginCore002\Plugin\Plugin;

class HelpTab extends AbsClass {
	protected $id;
	protected $title;
	protected $content;

	public function __construct( Plugin $plugin, $title, $content, $id = '' ) {
		parent::__construct( $plugin );
		$this->title   = $title;
		$this->content = $content;
		$this->id      = $id ? $id : Random::lowStrengthRandomString( 10 );
	}

	/**
	 * @return array
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function toArray() {
		$out = array();

		$reflect = new \ReflectionClass( $this );
		$props   = $reflect->getProperties( \ReflectionProperty::IS_PUBLIC | \ReflectionProperty::IS_PROTECTED );

		foreach ( $props as $prop ) {
			$out[ $prop->getName() ] = $this->{$prop->getName()};
		}

		return $out;
	}

	/**
	 * @return mixed
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * @param mixed $title
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function setTitle( $title ) {
		$this->title = $title;

		return $this;
	}

	/**
	 * @return mixed
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function getContent() {
		return $this->content;
	}

	/**
	 * @param mixed $content
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function setContent( $content ) {
		$this->content = $content;

		return $this;
	}
}