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

/**
 * Class AbsScript
 *
 * @package WPluginCore002\Abs
 * @author  Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @since   TODO ${VERSION}
 */
abstract class AbsScript extends AbsClass {
	/**
	 * @var Plugin
	 */
	protected $plugin;
	/**
	 * @var
	 */
	protected $handle;
	/**
	 * @var string
	 */
	protected $wpRelPath;
	/**
	 * @var
	 */
	protected $url;
	/**
	 * @var array
	 */
	protected $deps;
	/**
	 * @var string
	 */
	protected $version;
	/**
	 * @var array
	 */
	protected $hook = array( 'wp_enqueue_scripts' );
	/**
	 * @var
	 */
	protected $whereMayReside;
	/**
	 * @var
	 */
	protected $fileExtension;

	/**
	 * @param Plugin $plugin
	 * @param        $handle
	 * @param string $wpRelPath
	 * @param array  $deps
	 */
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

	/**
	 * @return string
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function locate() {
		$fileObj = $this->plugin->getFactory()->file();

		return $fileObj->locate( $this->handle, $this->whereMayReside, $this->fileExtension, $this->plugin );
	}

	/**
	 * @return mixed
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	abstract public function enqueue();

	/**
	 * @return mixed
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	abstract public function register();

	/**
	 * @return mixed
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	abstract public function deRegister();

	/**
	 * @return mixed
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	abstract public function dequeue();

	/**
	 * @return mixed
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	abstract public function isRegistered();

	/**
	 * @return mixed
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	abstract public function isEnqueued();
}