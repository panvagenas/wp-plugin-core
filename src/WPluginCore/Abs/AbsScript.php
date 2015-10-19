<?php
/**
 * Project: wp-plugins-core.dev
 * File: AbsScript.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 5/10/2015
 * Time: 8:54 πμ
 * Since: TODO ${VERSION}
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace WPluginCore002\Abs;


use WPluginCore002\Plugin\Plugin;

abstract class AbsScript extends AbsClass {
	/**
	 * @var Plugin
	 */
	protected $plugin;
	protected $handle;
	protected $wpRelPath;
	protected $url;
	protected $deps;
	protected $version;
	protected $hook = array( 'wp_enqueue_scripts' );
	protected $whereMayReside;
	protected $fileExtension;

	public function __construct(
		Plugin $plugin,
		$handle,
		$wpRelPath = '',
		Array $deps = array()
	) {
		parent::__construct( $plugin );

		$this->handle    = $handle;
		$this->wpRelPath = $wpRelPath ? $this->locate() : $wpRelPath;
		$this->deps      = $deps;

		$this->version = $plugin->getVersion();
	}

	public function locate() {
		$fileObj = $this->plugin->getFactory()->file();

		return $fileObj->locate( $this->handle, $this->whereMayReside, $this->fileExtension, $this->plugin );
	}

	abstract public function enqueue();

	abstract public function register();

	abstract public function deRegister();

	abstract public function dequeue();

	abstract public function isRegistered();

	abstract public function isEnqueued();
}