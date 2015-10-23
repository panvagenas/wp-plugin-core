<?php
/**
 * Project: wp-plugins-core.dev
 * File: Script.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 5/10/2015
 * Time: 8:58 πμ
 * Since: 0.0.2
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace WPluginCore003\Scripts;

use WPluginCore003\Abs\AbsScript;
use WPluginCore003\Plugin\Plugin;

/**
 * Class Script
 *
 * @package WPluginCore003\Scripts
 * @author  Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @since   0.0.2
 */
class Script extends AbsScript {
	/**
	 * @var bool
	 */
	protected $inFooter = true;
	/**
	 * @var string
	 */
	protected $fileExtension = 'js';

	/**
	 * @param Plugin    $plugin
	 * @param string    $handle
	 * @param string    $wpRelPath
	 * @param array     $deps
	 * @param bool|true $inFooter
	 */
	public function __construct( Plugin $plugin, $handle, $wpRelPath = '', Array $deps = array(), $inFooter = true ) {
		$this->inFooter       = $inFooter;
		$this->whereMayReside = $plugin->getFactory()->pluginFactory()->paths()->getWhereScriptsMayReside();

		parent::__construct( $plugin, $handle, $wpRelPath, $deps );
	}

	/**
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function enqueue() {
		$that = $this;
		foreach ( $this->hook as $hook ) {
			$this->plugin->getHookFactory()->action( $hook,
				function () use ( $that ) {
					if ( ! $that->isEnqueued() ) {
						wp_enqueue_script( $that->getHandle(), $that->getWpRelPath(), $that->getDeps(),
							$that->getVersion(),
							$that->isInFooter() );
					}
				}
			)->add();
		}
	}

	/**
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function register() {
		$that = $this;
		foreach ( $this->hook as $hook ) {
			$this->plugin->getHookFactory()->action( $hook,
				function () use ( $that ) {
					if ( ! $that->isRegistered() ) {
						wp_register_script( $that->getHandle(), $that->getWpRelPath(), $that->getDeps(),
							$that->getVersion(),
							$that->isInFooter() );
					}
				}
			)->add();
		}
	}

	/**
	 * Localize script
	 *
	 * @param array  $params
	 * @param string $objectName Default is {@link Plugin::slug}
	 *
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function localize( $params, $objectName = '' ) {
		$scriptHandle = $this->handle;
		$params       = (array) $params;

		if ( ! $objectName ) {
			$objectName = $this->plugin->getSlug();
		}

		foreach ( $this->hook as $hook ) {
			$this->plugin->getHookFactory()->action( $hook,
				function () use ( $params, $scriptHandle, $objectName ) {
					wp_localize_script( $scriptHandle, $objectName, $params );
				}
			)->add();
		}
	}

	/**
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function dequeue() {
		wp_dequeue_script( $this->handle );
	}

	/**
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function deRegister() {
		wp_deregister_script( $this->handle );
	}

	/**
	 * @return bool
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function isEnqueued() {
		return wp_script_is( $this->handle, 'enqueued' );
	}

	/**
	 * @return bool
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function isRegistered() {
		return wp_script_is( $this->handle, 'registered' );
	}

	/**
	 * @return mixed
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function getHandle() {
		return $this->handle;
	}

	/**
	 * @return string
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function getWpRelPath() {
		return $this->wpRelPath;
	}

	/**
	 * @return mixed
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function getUrl() {
		return $this->url;
	}

	/**
	 * @return array
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function getDeps() {
		return $this->deps;
	}

	/**
	 * @return string
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function getVersion() {
		return $this->version;
	}

	/**
	 * @return array
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function getHook() {
		return $this->hook;
	}

	/**
	 * @return mixed
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function getWhereMayReside() {
		return $this->whereMayReside;
	}

	/**
	 * @return boolean
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function isInFooter() {
		return $this->inFooter;
	}

	/**
	 * @return string
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function getFileExtension() {
		return $this->fileExtension;
	}
}