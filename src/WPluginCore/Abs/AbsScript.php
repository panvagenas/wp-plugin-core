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

abstract class AbsScript extends AbsClass{
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

	public function __construct(
		Plugin $plugin,
		$handle,
		$wpRelPath = '',
		Array $deps = array(),
		Array $hook = array( 'wp_enqueue_scripts' )
	) {
		parent::__construct($plugin);

		$this->handle = $handle;
		$this->wpRelPath = $wpRelPath ? $this->locate() : $wpRelPath;
		$this->deps = $deps;
		$this->hook = $hook;

		$this->version = $plugin->getVersion();
	}

	abstract public function enqueue();

	abstract public function register();

	public function locate() {
		foreach ( $this->whereMayReside as $dir ) {
			if ( file_exists( $path = $dir . DIRECTORY_SEPARATOR . $this->handle . '.js' ) && is_readable( $path ) ) {
				return $path;
			}
		}

		return '';
	}
}