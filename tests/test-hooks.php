<?php

/**
 * Created by PhpStorm.
 * User: vagenas
 * Date: 11/9/2015
 * Time: 5:11 μμ
 */
class HooksTest extends WP_UnitTestCase {
	/**
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function testCreateNewFilter() {
		/* @var \WPluginCore002\Plugin\Plugin $WpPluginCore */
		global $WpPluginCore;

		$hooksFactory = $WpPluginCore->getHookFactory();

		$filter = $hooksFactory->filter( 'myFilterTag', null );

		$this->assertTrue( $filter instanceof \WPluginCore002\Hooks\Filter );

		function dummyFilterA() {
		}

		$filterDummy101a = $hooksFactory->filter( 'myFilterTag', 'dummyFilterA' );
		$filterDummy101b = $hooksFactory->filter( 'myFilterTag', 'dummyFilterA' );

		$this->assertTrue( $filterDummy101a instanceof \WPluginCore002\Hooks\Filter );
		$this->assertTrue( $filterDummy101b instanceof \WPluginCore002\Hooks\Filter );
		$this->assertEquals( $filterDummy101a, $filterDummy101b );

		$filterDummy101c = $hooksFactory->filter( 'myFilterTag', 'dummyFilterA', 15 );

		$this->assertTrue( $filterDummy101c instanceof \WPluginCore002\Hooks\Filter );
		$this->assertNotEquals( $filterDummy101a, $filterDummy101c );


		$this->assertFalse( has_filter( 'myFilterTag', 'dummyFilterA' ) );

		$this->assertFalse( $filterDummy101a->has() );
		$this->assertFalse( $filterDummy101b->has() );
		$this->assertFalse( $filterDummy101c->has() );

		$filterDummy101a->add();

		$this->assertTrue( has_filter( 'myFilterTag' ) );
		$this->assertTrue( $filterDummy101a->has() === $filterDummy101a->getPriority() );
	}

	/**
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function testCreateNewAction() {
		/* @var \WPluginCore002\Plugin\Plugin $WpPluginCore */
		global $WpPluginCore;

		$hooksFactory = $WpPluginCore->getHookFactory();

		$action = $hooksFactory->action( 'myActionTag', null );

		$this->assertTrue( $action instanceof \WPluginCore002\Hooks\Action );

		function dummyActionA() {
		}

		$actionDummy101a = $hooksFactory->action( 'myActionTag', 'dummyActionA' );
		$actionDummy101b = $hooksFactory->action( 'myActionTag', 'dummyActionA' );

		$this->assertTrue( $actionDummy101a instanceof \WPluginCore002\Hooks\Action );
		$this->assertTrue( $actionDummy101b instanceof \WPluginCore002\Hooks\Action );
		$this->assertEquals( $actionDummy101a, $actionDummy101b );

		$actionDummy101c = $hooksFactory->action( 'myActionTag', 'dummyActionA', 15 );

		$this->assertTrue( $actionDummy101c instanceof \WPluginCore002\Hooks\Action );
		$this->assertNotEquals( $actionDummy101a, $actionDummy101c );


		$this->assertFalse( has_action( 'myActionTag', 'dummyActionA' ) );

		$this->assertFalse( $actionDummy101a->has() );
		$this->assertFalse( $actionDummy101b->has() );
		$this->assertFalse( $actionDummy101c->has() );

		$actionDummy101a->add();

		$this->assertTrue( has_action( 'myActionTag' ) );
		$this->assertTrue( $actionDummy101a->has() === $actionDummy101a->getPriority() );
	}

	/**
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function testApplyFilter() {
		/* @var \WPluginCore002\Plugin\Plugin $WpPluginCore */
		global $WpPluginCore;

		$hooksFactory = $WpPluginCore->getHookFactory();
		$hooksFactory->removeAll( 'myFilterTag' );

		$that = $this;
		function dummyFilterB( $var ) {
			if ( ! $var ) {
				$var = true;
			}

			return $var;
		}

		$var = false;

		$filter = $hooksFactory->filter( 'myFilterTag', 'dummyFilterB' );
		$filter->add();

		$this->assertFalse( $var );

		$var = $hooksFactory->filter( 'myFilterTag', null )->apply( $var );

		$this->assertTrue( $var );
	}

	/**
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function testPerformAction() {
		/* @var \WPluginCore002\Plugin\Plugin $WpPluginCore */
		global $WpPluginCore;

		$hooksFactory = $WpPluginCore->getHookFactory();
		$hooksFactory->removeAll( 'myActionTag' );

		global $myFancyVar;
		$myFancyVar = false;

		function dummyActionB() {
			global $myFancyVar;
			$myFancyVar = true;
		}

		$action = $hooksFactory->action( 'myActionTag', 'dummyActionB' );
		$action->add();

		$this->assertFalse( $myFancyVar );

		$hooksFactory->action( 'myActionTag', null )->perform();

		$this->assertTrue( $myFancyVar );
	}
}