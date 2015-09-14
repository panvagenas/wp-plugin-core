<?php

/**
 * Project: wp-plugins-core.dev
 * File: test-scripts.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 14/9/2015
 * Time: 8:45 μμ
 * Since: TODO ${VERSION}
 * Copyright: 2015 Panagiotis Vagenas
 */
class ScriptsTest extends WP_UnitTestCase {
	public function testStyleEnqueue(){
		global $plugin;
		$handle = 'my-style';
		$src = 'http://some.source.tld';

		$plugin->Scripts->enqueueAdminStyle($handle, $src);
		do_action('admin_enqueue_scripts');
		$this->assertTrue(wp_style_is($handle, 'enqueued'));

		wp_dequeue_style($handle);
		$this->assertFalse(wp_style_is($handle, 'enqueued'));

		$plugin->Scripts->enqueueLoginStyle($handle, $src);
		do_action('login_enqueue_scripts');
		$this->assertTrue(wp_style_is($handle, 'enqueued'));

		wp_dequeue_style($handle);
		$this->assertFalse(wp_style_is($handle, 'enqueued'));

		$plugin->Scripts->enqueueStyle($handle, $src);
		do_action('wp_enqueue_scripts');
		$this->assertTrue(wp_style_is($handle, 'enqueued'));

		wp_dequeue_style($handle);
		$this->assertFalse(wp_style_is($handle, 'enqueued'));
	}

	public function testScriptEnqueue(){
		global $plugin;
		$handle = 'my-script';
		$src = 'http://some.source.tld';

		$plugin->Scripts->enqueueAdminScript($handle, $src);
		do_action('admin_enqueue_scripts');
		$this->assertTrue(wp_script_is($handle, 'enqueued'));

		wp_dequeue_script($handle);
		$this->assertFalse(wp_script_is($handle, 'enqueued'));

		$plugin->Scripts->enqueueLoginScript($handle, $src);
		do_action('login_enqueue_scripts');
		$this->assertTrue(wp_script_is($handle, 'enqueued'));

		wp_dequeue_script($handle);
		$this->assertFalse(wp_script_is($handle, 'enqueued'));

		$plugin->Scripts->enqueueScript($handle, $src);
		do_action('wp_enqueue_scripts');
		$this->assertTrue(wp_script_is($handle, 'enqueued'));

		wp_dequeue_script($handle);
		$this->assertFalse(wp_script_is($handle, 'enqueued'));
	}
	
	public function testUniqueHandlers(){
		global $plugin;
		
		$handler = rand_str();
		
		$pluginHandler = $plugin->Scripts->getScriptHandle($handler);
		$pluginHandler2 = $plugin->Scripts->getScriptHandle($handler);
		
		$this->assertNotEquals($handler, $pluginHandler);
		
		$this->assertEquals($pluginHandler, $pluginHandler2);
	}
	
	public function testScriptsURL(){
		global $plugin;
		
		$fileInRoot = ABSPATH . 'style.css';
		$fileInWpContent = ABSPATH . 'wp-content/style.css';
		$fileInPluginBaseDir = ABSPATH . 'wp-content/plugins/wp-plugin-core/style.css';
		$fileInPluginAssetsDir = ABSPATH . 'wp-content/plugins/wp-plugin-core/assets/css/style.css';
		$cssFileInActiveThemeOverride = get_template_directory() . '/' . $plugin->getSlug() . '/assets/css/style.css';
		$jsFileInActiveThemeOverride = get_template_directory() . '/' . $plugin->getSlug() . '/assets/js/script.js';
		
		$homeUrl = get_home_url();
		$templateDirectoryURI = get_template_directory_uri();

		$this->assertEquals($homeUrl . '/style.css', $plugin->Scripts->getUrl($fileInRoot));
		$this->assertEquals($homeUrl . '/wp-content/style.css', $plugin->Scripts->getUrl($fileInWpContent));
		$this->assertEquals($homeUrl . '/wp-content/plugins/wp-plugin-core/style.css', $plugin->Scripts->getUrl($fileInPluginBaseDir));
		$this->assertEquals($homeUrl . '/wp-content/plugins/wp-plugin-core/assets/css/style.css', $plugin->Scripts->getUrl($fileInPluginAssetsDir));
		$this->assertEquals($templateDirectoryURI . '/' . $plugin->getSlug() . '/assets/css/style.css', $plugin->Scripts->getUrl($cssFileInActiveThemeOverride));
		$this->assertEquals($templateDirectoryURI . '/' . $plugin->getSlug() . '/assets/js/script.js', $plugin->Scripts->getUrl($jsFileInActiveThemeOverride));
	}
}