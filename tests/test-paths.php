<?php

/**
 * Created by PhpStorm.
 * User: vagenas
 * Date: 11/9/2015
 * Time: 5:14 μμ
 */
class PathsTest extends WP_UnitTestCase {
	/**
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function testRemoveDots() {
		global $plugin;

		$cases = array(
			array(
				'actual'   => '../../path/to/somewhere',
				'expected' => 'path/to/somewhere'
			),
			array(
				'actual'   => '../../path/to/somewhere/../../',
				'expected' => 'path/to/somewhere'
			),
			array(
				'actual'   => '../../path/to/somewhere/../../and/from/there/to/somewhere/else/',
				'expected' => 'path/to/somewhere/and/from/there/to/somewhere/else'
			),
			array(
				'actual'   => '../../path/to/someFile.ext',
				'expected' => 'path/to/someFile.ext'
			),
			array(
				'actual'   => '../../path/to/../../someFile.ext',
				'expected' => 'path/to/someFile.ext'
			),
			array(
				'actual'   => '../../path/to/somewhere/../../and/from/there/to/someFile.ext',
				'expected' => 'path/to/somewhere/and/from/there/to/someFile.ext'
			),
		);

		foreach ( $cases as $case ) {
			$returned = $plugin->Paths->removeDots( $case['actual'] );
			$this->assertEquals( $case['expected'], $returned );
		}

	}
}