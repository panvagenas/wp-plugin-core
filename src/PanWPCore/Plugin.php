<?php
/**
 * Created by PhpStorm.
 * User: vagenas
 * Date: 29/8/2015
 * Time: 9:56 πμ
 */

namespace PanWPCore;


class Plugin extends Core {
	protected $slug;
	protected $name;
	protected $version;
	protected $textDomain;
	protected $filePath;
	protected $baseNamespace;
	protected $baseName;

	public function __construct( $baseNamespace, $filePath, $name, $version, $textDomain = '', $slug = '' ) {
		parent::__construct( $this );

		$this->filePath      = $filePath;
		$this->baseNamespace = $baseNamespace;
		$this->baseName = plugin_basename($filePath);

		if ( ! $slug ) {
			$slug = String::create( plugin_basename( substr($filePath, 0, -4) ) )->underscored()->toString();
		}
		$slug = preg_replace( RegExp::nonAlphaNumeric, '_', $slug );

		$this->slug       = $slug;
		$this->name       = $name;
		$this->version    = $version;
		$this->textDomain = $textDomain;

		$this->Initializer->run();
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

	/**
	 * @return array
	 */
	public function getPluginData() {
		return $this->pluginData;
	}

	/**
	 * @return string
	 */
	public function getFilePath() {
		return $this->filePath;
	}

	/**
	 * @return string
	 */
	public function getBaseName() {
		return $this->baseName;
	}

	/**
	 * @return Plugin
	 */
	public function getBaseNamespace() {
		return $this->baseNamespace;
	}
}