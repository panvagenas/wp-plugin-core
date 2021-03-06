<?php

/**
 * Project: wp-plugins-core.dev
 * File: TemplatesTest.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 21/10/2015
 * Time: 11:54 πμ
 * Since: 0.0.2
 * Copyright: 2015 Panagiotis Vagenas
 */

use org\bovigo\vfs;

/**
 * Class TemplatesTest
 *
 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @since  0.0.2
 */
class TemplatesTest extends WP_UnitTestCase {
	/**
	 * @var vfs\vfsStreamDirectory
	 */
	protected static $rootDir;
	/**
	 * @var \WPluginCore003\Plugin\Plugin
	 */
	protected static $WpPluginCore;

	/**
	 * @var
	 */
	protected static $templateBaseName;
	/**
	 * @var
	 */
	protected static $templateName;
	/**
	 * @var
	 */
	protected static $misTemplateBaseName;
	/**
	 * @var
	 */
	protected static $misTemplateName;
	/**
	 * @var vfs\vfsStreamFile
	 */
	protected static $templateFile;
	/**
	 * @var \WPluginCore003\Templates\Template
	 */
	protected static $templateObj;

	/**
	 * @throws \WPluginCore003\Diagnostics\Exception
	 * @throws vfs\vfsStreamException
	 * @static
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public static function setUpBeforeClass() {
		global $WpPluginCore;
		self::$WpPluginCore = $WpPluginCore;

		vfs\vfsStreamWrapper::register();

		self::$rootDir = new vfs\vfsStreamDirectory( 'rootDir' );
		vfs\vfsStreamWrapper::setRoot( self::$rootDir );

		self::$templateBaseName = uniqid();
		self::$templateName     = self::$templateBaseName . '.php';

		self::$misTemplateBaseName = uniqid( 'missing' );
		self::$misTemplateName     = self::$misTemplateBaseName . '.php';

		self::$templateFile = new vfs\vfsStreamFile( self::$templateName );
		self::$templateFile->setContent( '<?php if(isset($var)) echo $var; else echo 1;' );

		self::$rootDir->addChild( self::$templateFile );

		self::$templateObj = self::$WpPluginCore->getFactory()->createOrGet( 'Templates\\Template' );
	}

	/**
	 * @throws vfs\vfsStreamException
	 * @static
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public static function tearDownAfterClass() {
		self::$WpPluginCore->getHookFactory()->getWhereTemplatesMayResideFilter(  )->removeAll();

		self::$rootDir             = null;
		self::$WpPluginCore        = null;
		self::$templateBaseName    = null;
		self::$templateName        = null;
		self::$misTemplateBaseName = null;
		self::$misTemplateName     = null;
		self::$templateFile        = null;
		self::$templateObj         = null;

		vfs\vfsStreamWrapper::unregister();
	}

	/**
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function testLocate() {
		$rootDirPath = self::$rootDir->url();

		$filter = self::$WpPluginCore
			->getHookFactory()
			->getWhereTemplatesMayResideFilter(
				function ( $paths ) use ( $rootDirPath ) {
					$paths[] = $rootDirPath;

					return $paths;
				}
			);
		$filter->add();

		$this->assertNotEmpty( self::$templateObj->locate( self::$templateBaseName ) );
		$this->assertNotEmpty( self::$templateObj->locate( self::$templateName ) );
		$this->assertEmpty( self::$templateObj->locate( self::$misTemplateBaseName ) );
		$this->assertEmpty( self::$templateObj->locate( self::$misTemplateName ) );

		$filter->remove();
	}

	/**
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function testView() {
		$rootDirPath = self::$rootDir->url();

		$filter = self::$WpPluginCore
			->getHookFactory()
			->getWhereTemplatesMayResideFilter(
				function ( $paths ) use ( $rootDirPath ) {
					$paths[] = $rootDirPath;

					return $paths;
				}
			);
		$filter->add();

		$this->assertEquals( '1', self::$templateObj->view( self::$templateBaseName ) );

		$var = 'myVarValue';

		$this->assertEquals( $var, self::$templateObj->view( self::$templateBaseName, compact( 'var' ) ) );

		$filter->remove();
	}
}