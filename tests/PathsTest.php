<?php

/**
 * Project: wp-plugins-core.dev
 * File: PathsTest.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 16/10/2015
 * Time: 2:13 μμ
 * Since: TODO ${VERSION}
 * Copyright: 2015 Panagiotis Vagenas
 */
class PathsTest extends WP_UnitTestCase {
	public function setUp() {
	}

	public function testVerifyIsUnder() {
		/* @var \WPluginCore002\Plugin\Plugin $WpPluginCore */
		global $WpPluginCore;

		$paths = $WpPluginCore->getFactory()->paths();

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

		foreach ( $cases as $i => $case ) {
			$this->assertSame( $case['expected'], \WPluginCore002\Plugin\Paths::truePath( $case['original'] ),
				'Failure on case ' . ( $i + 1 ) . ' ---> "' . implode( '" => "', $case ) . '"'
			);
		}

	}
}