<?php

/**
 * Created by PhpStorm.
 * User: vagenas
 * Date: 11/9/2015
 * Time: 5:14 μμ
 */
class PathsTest extends WP_UnitTestCase {
	public function test_removeDots() {
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
		);

		foreach ( $cases as $case ) {
			$returned = $plugin->Paths->removeDots( $case['actual'] );
			$this->assertEquals( $case['expected'], $returned );
		}

	}
}