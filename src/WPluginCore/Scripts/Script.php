<?php
/**
 * Project: wp-plugins-core.dev
 * File: Script.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 5/10/2015
 * Time: 8:58 πμ
 * Since: TODO ${VERSION}
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace WPluginCore002\Scripts;

use WPluginCore002\Abs\AbsScript;
use WPluginCore002\Plugin\Plugin;

/**
 * Class Script
 *
 * @package WPluginCore002\Scripts
 * @author  Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @since   TODO ${VERSION}
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
	 * @param           $handle
	 * @param string    $wpRelPath
	 * @param array     $deps
	 * @param bool|true $inFooter
	 */
	public function __construct( Plugin $plugin, $handle, $wpRelPath = '', Array $deps = array(), $inFooter = true ) {
		$this->inFooter       = $inFooter;
		$this->whereMayReside = $plugin->getFactory()->paths()->getWhereScriptsMayReside();

		parent::__construct( $plugin, $handle, $wpRelPath, $deps );
	}

	/**
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
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
	 * @since  TODO ${VERSION}
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
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function dequeue() {
		wp_dequeue_script( $this->handle );
	}

	/**
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function deRegister() {
		wp_deregister_script( $this->handle );
	}

	/**
	 * @return bool
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function isEnqueued() {
		return wp_script_is( $this->handle, 'enqueued' );
	}

	/**
	 * @return bool
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function isRegistered() {
		return wp_script_is( $this->handle, 'registered' );
	}

	/**
	 * @return mixed
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function getHandle() {
		return $this->handle;
	}

	/**
	 * @return string
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function getWpRelPath() {
		return $this->wpRelPath;
	}

	/**
	 * @return mixed
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function getUrl() {
		return $this->url;
	}

	/**
	 * @return array
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function getDeps() {
		return $this->deps;
	}

	/**
	 * @return string
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function getVersion() {
		return $this->version;
	}

	/**
	 * @return array
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function getHook() {
		return $this->hook;
	}

	/**
	 * @return mixed
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function getWhereMayReside() {
		return $this->whereMayReside;
	}

	/**
	 * @return boolean
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function isInFooter() {
		return $this->inFooter;
	}

	/**
	 * @return string
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function getFileExtension() {
		return $this->fileExtension;
	}
}