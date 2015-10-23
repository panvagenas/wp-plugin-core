<?php

/**
 * Project: wp-plugins-core.dev
 * File: PathsTest.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 16/10/2015
 * Time: 2:13 μμ
 * Since: 0.0.2
 * Copyright: 2015 Panagiotis Vagenas
 */

use org\bovigo\vfs;

/**
 * Class PathsTest
 *
 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @since  0.0.2
 */
class PathsTest extends WP_UnitTestCase {
	/**
	 * @throws vfs\vfsStreamException
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function setUp() {
		vfs\vfsStreamWrapper::register();
	}

	/**
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function testVerifyIsUnder() {
		/* @var \WPluginCore003\Plugin\Plugin $WpPluginCore */
		global $WpPluginCore;

		$paths = $WpPluginCore->getFactory()->fcrPlugin()->paths();

		$rootDir = new vfs\vfsStreamDirectory( 'rootDir' );
		vfs\vfsStreamWrapper::setRoot( $rootDir );

		$dirA = new vfs\vfsStreamDirectory( 'a' );
		$dirB = new vfs\vfsStreamDirectory( 'b' );
		$dirC = new vfs\vfsStreamDirectory( 'c' );

		$rootDir->addChild( $dirA );
		$dirA->addChild( $dirB );
		$dirB->addChild( $dirC );


		$this->assertTrue( $paths->verifyPathIsUnder( $dirC->url(), $rootDir->url() ) );
		$this->assertTrue( $paths->verifyPathIsUnder( $dirB->url(), $rootDir->url() ) );
		$this->assertTrue( $paths->verifyPathIsUnder( $dirA->url(), $rootDir->url() ) );
		$this->assertTrue( $paths->verifyPathIsUnder( $rootDir->url(), $rootDir->url() ) );

		$this->assertFalse( $paths->verifyPathIsUnder( $rootDir->url(), $dirC->url() ) );
		$this->assertFalse( $paths->verifyPathIsUnder( $rootDir->url(), $dirB->url() ) );
		$this->assertFalse( $paths->verifyPathIsUnder( $rootDir->url(), $dirA->url() ) );

		$casesTrue = array(
			array(
				'path'  => '/root/dir/subDir/file.php',
				'under' => '/root/dir/subDir/file.php'
			),
			array(
				'path'  => '/root/dir/subDir/./file.php',
				'under' => '/root/dir/subDir/'
			),
			array(
				'path'  => '/root/dir/subDir/file.php',
				'under' => '/root/dir/'
			),
			array(
				'path'  => '/root/dir/subDir/file.php',
				'under' => '/root/'
			),
			array(
				'path'  => '/root/dir/subDir/file.php',
				'under' => '/'
			),
			array(
				'path'  => '/root/dir/subDir/file.php',
				'under' => '/root/dir/subDir'
			),
			array(
				'path'  => '/root/dir/subDir',
				'under' => '/root/dir/subDir/'
			),
			array(
				'path'  => '/root/dir/subDir/',
				'under' => '/root/dir/subDir/'
			),
			array(
				'path'  => '/root/dir/subDir',
				'under' => '/root/dir/subDir'
			),
			array(
				'path'  => '/root/dir/subDir/',
				'under' => '/root/dir'
			),
			array(
				'path'  => '/root/dir/subDir/',
				'under' => '/root/dir/'
			),
			array(
				'path'  => '/root/dir/subDir/file.php',
				'under' => '/'
			),
			array(
				'path'  => 'rel/dir/subDir/subSubDir',
				'under' => 'rel/dir/subDir'
			),
			array(
				'path'  => '/root/dir/subDir/',
				'under' => '/root/dir'
			),
			array(
				'path'  => '/root/dir/subDir/',
				'under' => '/root/dir/'
			),
			array(
				'path'  => '/root/dir/subDir/file.php',
				'under' => '/'
			),
		);

		$casesFalse = array(
			array(
				'path'  => '/root/dir/subDir/file.php/../../',
				'under' => '/root/dir/subDir'
			),
			array(
				'path'  => '/root/dir/subDir/../',
				'under' => '/root/dir/subDir'
			),
			array(
				'path'  => '/root/dir/subDir/subSubDir/../../',
				'under' => '/root/dir/subDir'
			),
			array(
				'path'  => '/root/dir/./',
				'under' => '/root/dir/subDir'
			),
			array(
				'path'  => '/root/dir',
				'under' => '/root/dir/subDir'
			),
			array(
				'path'  => '/path/to/another/dir',
				'under' => '/root/dir/subDir'
			),
			array(
				'path'  => 'path/to/another/dir',
				'under' => '/root/dir/subDir'
			),
			array(
				'path'  => 'path/to/another/dir/../../../',
				'under' => '/root/dir/subDir'
			),
			array(
				'path'  => '/root/dir///',
				'under' => '/root/dir/subDir'
			),
		);

		foreach ( $casesTrue as $i => $case ) {
			$this->assertTrue( $paths->verifyPathIsUnder( $case['path'], $case['under'] ),
				'Failure on case ' . ( $i + 1 ) . ' ---> "' . implode( '" => "', $case ) . '"'
			);
		}

		foreach ( $casesFalse as $i => $case ) {
			$this->assertFalse( $paths->verifyPathIsUnder( $case['path'], $case['under'] ),
				'Failure on case ' . ( $i + 1 ) . ' ---> "' . implode( '" => "', $case ) . '"'
			);
		}
	}

	/**
	 * @throws \WPluginCore003\Diagnostics\Exception
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function testTruePath() {
		$cases = array(
			array(
				'original' => '/1/2/3/4/5/file',
				'expected' => '/1/2/3/4/5/file'
			),
			array(
				'original' => '/1/2/3/../4/5/file',
				'expected' => '/1/2/4/5/file'
			),
			array(
				'original' => '/1/2/3/../../4/5/file',
				'expected' => '/1/4/5/file'
			),
			array(
				'original' => '/1/2/3/../../../../4/5/file',
				'expected' => realpath( getcwd() . '/../' ) . '/4/5/file'
			),
			array(
				'original' => '/1/2/3/../../../../4/5/../file',
				'expected' => realpath( getcwd() . '/../' ) . '/4/file'
			),
			array(
				'original' => '/1/2/3/../../../../4/5/../../file',
				'expected' => realpath( getcwd() . '/../' ) . '/file'
			),
			array(
				'original' => '/1/2/3/../../../../../4/5/../../file',
				'expected' => realpath( getcwd() . '/../../' ) . '/file'
			),
			array(
				'original' => '/1/2/3/../../../../4/5/../../../file',
				'expected' => realpath( getcwd() . '/../../' ) . '/file'
			),
			array(
				'original' => '/1///2/./3/../../../../4/5/../../../file',
				'expected' => realpath( getcwd() . '/../../' ) . '/file'
			),
			array(
				'original' => '/1/2/3/..///./..///../../4/5/../../../file',
				'expected' => realpath( getcwd() . '/../../' ) . '/file'
			),
			array(
				'original' => '/1/2/3/../../../../4/./././5/../../..///./file',
				'expected' => realpath( getcwd() . '/../../' ) . '/file'
			),
			array(
				'original' => '/root/dir',
				'expected' => '/root/dir'
			),
			array(
				'original' => '/root/dir/',
				'expected' => '/root/dir'
			),
			array(
				'original' => '/root/dir/subDir/../',
				'expected' => '/root/dir'
			),
			array(
				'original' => '//root/dir///subDir/..///',
				'expected' => '/root/dir'
			),
			array(
				'original' => '/root/dir',
				'expected' => '/root/dir'
			),
			array(
				'original' => '/root/dir/',
				'expected' => '/root/dir'
			),
			array(
				'original' => '/root/dir/subDir/../',
				'expected' => '/root/dir'
			),
			array(
				'original' => '//root/dir///subDir/..///',
				'expected' => '/root/dir'
			),
			array(
				'original' => '://root/dir///subDir/..///',
				'expected' => '://root/dir'
			),
			array(
				'original' => 'vfs://root/dir///subDir/..///',
				'expected' => 'vfs://root/dir'
			),
		);

		$rootDir = new vfs\vfsStreamDirectory('root');
		$rdDir = new vfs\vfsStreamDirectory('dir');
		$rdSubDir = new vfs\vfsStreamDirectory('subDir');

		$rootDir->addChild($rdDir);
		$rdDir->addChild($rdSubDir);

		vfs\vfsStreamWrapper::setRoot($rootDir);

		foreach ( $cases as $i => $case ) {
			$this->assertSame( $case['expected'], \WPluginCore003\Plugin\Paths::truePath( $case['original'] ),
				'Failure on case ' . ( $i + 1 ) . ' ---> "' . implode( '" => "', $case ) . '"'
			);
		}

	}
}