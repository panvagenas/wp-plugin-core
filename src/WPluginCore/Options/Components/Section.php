<?php
/**
 * Project: wp-plugins-core.dev
 * File: Section.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 13/10/2015
 * Time: 10:00 πμ
 * Since: TODO ${VERSION}
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace WPluginCore002\Options\Components;


use WPluginCore002\Abs\AbsClass;
use WPluginCore002\Abs\AbsOptionField;
use WPluginCore002\Plugin\Plugin;

class Section extends AbsClass {
	/**
	 * The icon to be displayed next to the section title. This could be a preset Elusive Icon
	 * or a URL to an icon of your own
	 *
	 * @var string
	 */
	protected $icon;
	/**
	 * Set to `image` when using a custom URL to an icon
	 *
	 * @var string
	 */
	protected $icon_type;
	/**
	 * The title of the section that will appear on the option tab
	 *
	 * @var string
	 */
	protected $title;
	/**
	 * Text to appear at the top of the section page. By default the title argument is used as the title.
	 * Text specified via this argument replaces it
	 *
	 * @var string
	 */
	protected $heading;
	/**
	 * Text to appear under the section title. HTML is permitted
	 *
	 * @var string
	 */
	protected $desc;

	/**
	 * Appends any number of classes to the section’s class attribute
	 *
	 * @var string
	 */
	protected $class;
	/**
	 * String specifying the capability required to view the section.
	 *
	 * @link https://docs.reduxframework.com/redux-framework/fields/using-permissions/
	 * @var array
	 */
	protected $permissions;
	/**
	 * An array of arrays representing individual options
	 *
	 * @var array
	 */
	protected $customizer_only;
	/**
	 * Boolean to denote if this section should appear as a subsection to the previously defined section
	 *
	 * @var bool
	 */
	protected $subsection = false;
	/**
	 * @var array
	 */
	protected $fields = array();

	/**
	 * @param Plugin $plugin
	 * @param string $title
	 */
	public function __construct( Plugin $plugin, $title ) {
		parent::__construct( $plugin );
		$this->title = $title;
	}

	/**
	 * @param AbsOptionField $field
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function addField(AbsOptionField $field){
		$this->fields[] = $field;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getDesc() {
		return $this->desc;
	}

	/**
	 * @param $desc
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function setDesc( $desc ) {
		$this->desc = $desc;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getClass() {
		return $this->class;
	}

	/**
	 * @param $class
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function setClass( $class ) {
		$this->class = $class;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getIcon() {
		return $this->icon;
	}

	/**
	 * @param $icon
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function setIcon( $icon ) {
		$this->icon = $icon;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getIconType() {
		return $this->icon_type;
	}

	/**
	 * @param $icon_type
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function setIconType( $icon_type ) {
		$this->icon_type = $icon_type;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getHeading() {
		return $this->heading;
	}

	/**
	 * @param $heading
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function setHeading( $heading ) {
		$this->heading = $heading;

		return $this;
	}

	/**
	 * @return array
	 */
	public function getPermissions() {
		return $this->permissions;
	}

	/**
	 * @param $permissions
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function setPermissions( $permissions ) {
		$this->permissions = $permissions;

		return $this;
	}

	/**
	 * @return array
	 */
	public function getCustomizerOnly() {
		return $this->customizer_only;
	}

	/**
	 * @param $customizer_only
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function setCustomizerOnly( $customizer_only ) {
		$this->customizer_only = $customizer_only;

		return $this;
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

		$out['fields'] = array();
		foreach ( $this->fields as $field ) {
			/* @var AbsOptionField $field */
			$out['fields'][] = $field->toArray();
		}


		return $out;
	}
}