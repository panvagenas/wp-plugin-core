<?php
/**
 * Project: wp-plugins-core.dev
 * File: Style.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 5/10/2015
 * Time: 9:01 πμ
 * Since: TODO ${VERSION}
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace WPluginCore002\Scripts;

use WPluginCore002\Abs\AbsScript;
use WPluginCore002\Plugin\Plugin;

class Style extends AbsScript {
	protected $media = 'all';
	protected $fileExtension = 'css';

	public function __construct( Plugin $plugin, $handle, $wpRelPath = '', Array $deps = array(), $media = 'all' ) {
		$this->media          = $media;
		$this->whereMayReside = $plugin->getFactory()->paths()->getWhereStylesMayReside();

		parent::__construct( $plugin, $handle, $wpRelPath, $deps );
	}

	public function enqueue() {
		$that = $this;
		foreach ( $this->hook as $hook ) {
			$this->plugin->getHookFactory()->action( $hook,
				function () use ( $that ) {
					if ( ! $that->isEnqueued() ) {
						wp_enqueue_style( $that->getHandle(), $that->getWpRelPath(), $that->getDeps(),
							$that->getVersion(), $that->getMedia() );
					}
				}
			)->add();
		}
	}

	public function register() {
		$that = $this;
		foreach ( $this->hook as $hook ) {
			$this->plugin->getHookFactory()->action( $hook,
				function () use ( $that ) {
					if ( ! $that->isRegistered() ) {
						wp_register_style( $that->getHandle(), $that->getWpRelPath(), $that->getDeps(),
							$that->getVersion(), $that->getMedia() );
					}
				}
			)->add();
		}
	}

	public function dequeue() {
		wp_dequeue_style( $this->handle );
	}

	public function deRegister() {
		wp_deregister_style( $this->handle );
	}

	public function isEnqueued() {
		return wp_style_is( $this->handle, 'enqueued' );
	}

	public function isRegistered() {
		return wp_style_is( $this->handle, 'registered' );
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
	 * @return string
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function getMedia() {
		return $this->media;
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