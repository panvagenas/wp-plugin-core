<?php
/**
 * Project: wp-plugins-core.dev
 * File: Style.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 5/10/2015
 * Time: 9:01 πμ
 * Since: 0.0.2
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace WPluginCore003\Scripts;

use WPluginCore003\Abs\AbsScript;
use WPluginCore003\Plugin\Plugin;

/**
 * Class Style
 *
 * @package WPluginCore003\Scripts
 * @author  Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @since   0.0.2
 */
class Style extends AbsScript {
	/**
	 * @var string
	 */
	protected $media = 'all';
	/**
	 * @var string
	 */
	protected $fileExtension = 'css';

	/**
	 * @param Plugin $plugin
	 * @param        $handle
	 * @param string $wpRelPath
	 * @param array  $deps
	 * @param string $media
	 */
	public function __construct( Plugin $plugin, $handle, $wpRelPath = '', Array $deps = array(), $media = 'all' ) {
		$this->media          = $media;
		$this->whereMayReside = $plugin->getFactory()->paths()->getWhereStylesMayReside();

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
						wp_enqueue_style( $that->getHandle(), $that->getWpRelPath(), $that->getDeps(),
							$that->getVersion(), $that->getMedia() );
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
						wp_register_style( $that->getHandle(), $that->getWpRelPath(), $that->getDeps(),
							$that->getVersion(), $that->getMedia() );
					}
				}
			)->add();
		}
	}

	/**
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function dequeue() {
		wp_dequeue_style( $this->handle );
	}

	/**
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function deRegister() {
		wp_deregister_style( $this->handle );
	}

	/**
	 * @return bool
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function isEnqueued() {
		return wp_style_is( $this->handle, 'enqueued' );
	}

	/**
	 * @return bool
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function isRegistered() {
		return wp_style_is( $this->handle, 'registered' );
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
	 * @return string
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function getMedia() {
		return $this->media;
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