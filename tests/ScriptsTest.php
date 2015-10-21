<?php

/**
 * Project: wp-plugins-core.dev
 * File: ScriptsTest.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 19/10/2015
 * Time: 8:41 πμ
 * Since: 0.0.2
 * Copyright: 2015 Panagiotis Vagenas
 */

use org\bovigo\vfs;

/**
 * Class ScriptsTest
 *
 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @since  0.0.2
 */
class ScriptsTest extends WP_UnitTestCase {
	/**
	 * @var string
	 */
	protected $login_enqueue_scripts = 'login_enqueue_scripts';
	/**
	 * @var string
	 */
	protected $admin_enqueue_scripts = 'admin_enqueue_scripts';
	/**
	 * @var string
	 */
	protected $wp_enqueue_scripts = 'wp_enqueue_scripts';

	/**
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function testStyleEnqueue() {
		/* @var \WPluginCore002\Plugin\Plugin $WpPluginCore */
		global $WpPluginCore;

		$handle           = uniqid();
		$wpRelPathToStyle = "path/to/{$handle}.css";

		$style = new \WPluginCore002\Scripts\Style( $WpPluginCore, $handle, $wpRelPathToStyle );
		$this->scriptTest( $style, $this->wp_enqueue_scripts );
	}

	/**
	 * @param \WPluginCore002\Abs\AbsScript $script
	 * @param                               $hook
	 *
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	protected function scriptTest( \WPluginCore002\Abs\AbsScript $script, $hook ) {
		$this->assertFalse( $script->isRegistered() );

		$script->register();
		$script->enqueue();
		do_action( $hook );
		$this->assertTrue( $script->isRegistered() );
		$this->assertTrue( $script->isEnqueued() );

		$script->dequeue();
		$this->assertFalse( $script->isEnqueued() );

		$script->deRegister();
		$this->assertFalse( $script->isRegistered() );
	}

	/**
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function testAdminStyleEnqueue() {
		/* @var \WPluginCore002\Plugin\Plugin $WpPluginCore */
		global $WpPluginCore;

		$handle           = uniqid();
		$wpRelPathToStyle = "path/to/{$handle}.css";

		$style = new \WPluginCore002\Scripts\AdminStyle( $WpPluginCore, $handle, $wpRelPathToStyle );
		$this->scriptTest( $style, $this->admin_enqueue_scripts );
	}

	/**
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function testLoginStyleEnqueue() {
		/* @var \WPluginCore002\Plugin\Plugin $WpPluginCore */
		global $WpPluginCore;

		$handle           = uniqid();
		$wpRelPathToStyle = "path/to/{$handle}.css";

		$style = new \WPluginCore002\Scripts\LoginStyle( $WpPluginCore, $handle, $wpRelPathToStyle );
		$this->scriptTest( $style, $this->login_enqueue_scripts );
	}

	/**
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function testScriptEnqueue() {
		/* @var \WPluginCore002\Plugin\Plugin $WpPluginCore */
		global $WpPluginCore;

		$handle            = uniqid();
		$wpRelPathToScript = "path/to/{$handle}.js";

		$script = new \WPluginCore002\Scripts\Script( $WpPluginCore, $handle, $wpRelPathToScript );
		$this->scriptTest( $script, $this->wp_enqueue_scripts );
	}

	/**
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function testAdminScriptEnqueue() {
		/* @var \WPluginCore002\Plugin\Plugin $WpPluginCore */
		global $WpPluginCore;

		$handle            = uniqid();
		$wpRelPathToScript = "path/to/{$handle}.js";

		$script = new \WPluginCore002\Scripts\AdminScript( $WpPluginCore, $handle, $wpRelPathToScript );
		$this->scriptTest( $script, $this->admin_enqueue_scripts );
	}

	/**
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function testLoginScriptEnqueue() {
		/* @var \WPluginCore002\Plugin\Plugin $WpPluginCore */
		global $WpPluginCore;

		$handle            = uniqid();
		$wpRelPathToScript = "path/to/{$handle}.css";

		$script = new \WPluginCore002\Scripts\LoginScript( $WpPluginCore, $handle, $wpRelPathToScript );
		$this->scriptTest( $script, $this->login_enqueue_scripts );
	}

	/**
	 * @throws vfs\vfsStreamException
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function testLocateScripts() {
		/* @var \WPluginCore002\Plugin\Plugin $WpPluginCore */
		global $WpPluginCore;

		$scriptHandle = 'myScript';
		$styleHandle  = 'myStyle';

		$scriptsFileName = $scriptHandle . '.js';
		$stylesFileName  = $styleHandle . '.css';

		vfs\vfsStreamWrapper::register();

		$scriptsRootDir = new vfs\vfsStreamDirectory( 'scriptsRoot' );
		vfs\vfsStreamWrapper::setRoot( $scriptsRootDir );

		$stylesDir  = new vfs\vfsStreamDirectory( 'css' );
		$scriptsDir = new vfs\vfsStreamDirectory( 'js' );

		$scriptFile = new vfs\vfsStreamFile( $scriptsFileName );
		$styleFile  = new vfs\vfsStreamFile( $stylesFileName );

		$scriptsDir->addChild( $scriptFile );
		$stylesDir->addChild( $styleFile );

		$hooksFactoryObj = $WpPluginCore->getHookFactory();
		$pathsObj        = $WpPluginCore->getFactory()->paths();

		$scriptsRootDir->addChild( $stylesDir );
		$scriptsRootDir->addChild( $scriptsDir );

		$scriptsFilter = $hooksFactoryObj->getWhereScriptsMayResideFilter( $WpPluginCore,
			function ( $paths ) use ( $scriptsDir ) {
				$paths[] = $scriptsDir->url();

				return $paths;
			}
		);
		$scriptsFilter->add();

		$stylesFilter = $hooksFactoryObj->getWhereStylesMayResideFilter( $WpPluginCore,
			function ( $paths ) use ( $stylesDir ) {
				$paths[] = $stylesDir->url();

				return $paths;
			}
		);
		$stylesFilter->add();

		$this->assertTrue( in_array( $stylesDir->url(), $pathsObj->getWhereStylesMayReside() ) );
		$this->assertTrue( in_array( $scriptsDir->url(), $pathsObj->getWhereScriptsMayReside() ) );

		$this->assertTrue( file_exists( $scriptFile->url() ), is_readable( $scriptFile->url() ) );

		$script = new \WPluginCore002\Scripts\Script( $WpPluginCore, $scriptHandle );
		$style  = new \WPluginCore002\Scripts\Style( $WpPluginCore, $styleHandle );

		$this->assertTrue( strlen( $script->locate() ) > 0 );
		$this->assertTrue( strlen( $style->locate() ) > 0 );

		$nonExistentScript = new \WPluginCore002\Scripts\Script( $WpPluginCore, 'nonExistentScript' );
		$nonExistentStyle  = new \WPluginCore002\Scripts\Style( $WpPluginCore, 'nonExistentStyle' );

		$this->assertFalse( strlen( $nonExistentScript->locate() ) > 0 );
		$this->assertFalse( strlen( $nonExistentStyle->locate() ) > 0 );

		$scriptsFilter->remove();
		$stylesFilter->remove();
	}
}