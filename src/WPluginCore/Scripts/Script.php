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

class Script extends AbsScript {
	protected $inFooter = true;

	public function __construct( Plugin $plugin, $handle, $wpRelPath = '', Array $deps = array(), $inFooter = true ) {
		$this->inFooter = $inFooter;
		$this->whereMayReside = $plugin->getFactory()->paths()->getWhereScriptsMayReside();

		parent::__construct( $plugin, $handle, $wpRelPath, $deps );
	}

	public function enqueue() {
		$that = $this;
		foreach ( $this->hook as $hook ) {
			$this->plugin->getHookFactory()->action( $hook,
				function () use ( $that ) {
					if ( ! wp_script_is( $that->handle, 'enqueued' ) ) {
						wp_enqueue_script( $that->handle, $that->wpRelPath, $that->deps, $that->version, $that->inFooter );
					}
				}
			)->add();
		}
	}

	public function register(){
		$that = $this;
		foreach ( $this->hook as $hook ) {
			$this->plugin->getHookFactory()->action( $hook,
				function () use ( $that ) {
					if ( ! wp_script_is( $that->handle, 'registered' ) ) {
						wp_register_script( $that->handle, $that->wpRelPath, $that->deps, $that->version, $that->inFooter );
					}
				}
			)->add();
		}
	}
}