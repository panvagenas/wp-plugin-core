<?php

/**
 * Project: wp-plugins-core.dev
 * File: ScriptsTest.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 19/10/2015
 * Time: 8:41 πμ
 * Since: TODO ${VERSION}
 * Copyright: 2015 Panagiotis Vagenas
 */
class ScriptsTest extends WP_UnitTestCase {
	protected $login_enqueue_scripts = 'login_enqueue_scripts';
	protected $admin_enqueue_scripts = 'admin_enqueue_scripts';
	protected $wp_enqueue_scripts = 'wp_enqueue_scripts';

	public function testStyleEnqueue(){
		/* @var \WPluginCore002\Plugin\Plugin $WpPluginCore */
		global $WpPluginCore;

		$handle = uniqid();
		$wpRelPathToStyle = "path/to/{$handle}.css";

		$style = new \WPluginCore002\Scripts\Style($WpPluginCore, $handle, $wpRelPathToStyle);
		$this->styleTest($style, $this->wp_enqueue_scripts);
	}

	public function testAdminStyleEnqueue(){
		/* @var \WPluginCore002\Plugin\Plugin $WpPluginCore */
		global $WpPluginCore;

		$handle = uniqid();
		$wpRelPathToStyle = "path/to/{$handle}.css";

		$style = new \WPluginCore002\Scripts\AdminStyle($WpPluginCore, $handle, $wpRelPathToStyle);
		$this->styleTest($style, $this->admin_enqueue_scripts);
	}



	public function testLoginStyleEnqueue(){
		/* @var \WPluginCore002\Plugin\Plugin $WpPluginCore */
		global $WpPluginCore;

		$handle = uniqid();
		$wpRelPathToStyle = "path/to/{$handle}.css";

		$style = new \WPluginCore002\Scripts\LoginStyle($WpPluginCore, $handle, $wpRelPathToStyle);
		$this->styleTest($style, $this->login_enqueue_scripts);
	}

	protected function styleTest(\WPluginCore002\Scripts\Style $style, $hook){
		$this->assertFalse($style->isRegistered());

		$style->register();
		$style->enqueue();
		do_action($hook);
		$this->assertTrue($style->isRegistered());
		$this->assertTrue($style->isEnqueued());

		$style->dequeue();
		$this->assertFalse($style->isEnqueued());

		$style->deRegister();
		$this->assertFalse($style->isRegistered());
	}
}