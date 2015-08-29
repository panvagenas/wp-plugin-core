<?php
/**
 * Created by PhpStorm.
 * User: vagenas
 * Date: 29/8/2015
 * Time: 9:56 πμ
 */

namespace PanWPCore;


class Plugin {
	protected $slug = '';
	protected $name = '';
	protected $version = '';
	protected $textDomain;
	protected $pluginData = [];
	protected $filePath = '';

	public function __construct( $filePath, $name, $version, $textDomain, $slug = '' ) {
		$this->filePath = $filePath;
		$baseName = plugin_basename( $filePath );
		$baseName = preg_replace( RegExp::nonAlphaNumeric, '_', $baseName );

		$this->slug = $slug ? $slug : String::create( $baseName )->underscored()->toString();

		$this->name = $name;
		$this->version = $version;
		$this->textDomain = $textDomain;

		add_action('admin_init', [$this, 'setPluginData']);
	}

	/**
	 *
	 */
	public function setPluginData(){
		$this->pluginData = \get_plugin_data( $this->filePath );
	}

	/**
	 * @return string
	 */
	public function getSlug() {
		return $this->slug;
	}

	/**
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @return string
	 */
	public function getVersion() {
		return $this->version;
	}

	/**
	 * @return string
	 */
	public function getTextDomain() {
		return $this->textDomain;
	}
}