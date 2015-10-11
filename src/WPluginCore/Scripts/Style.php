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
					if ( ! wp_style_is( $that->handle, 'enqueued' ) ) {
						wp_enqueue_style( $that->handle, $that->wpRelPath, $that->deps, $that->version, $that->media );
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
					if ( ! wp_style_is( $that->handle, 'registered' ) ) {
						wp_register_style( $that->handle, $that->wpRelPath, $that->deps, $that->version, $that->media );
					}
				}
			)->add();
		}
	}
}