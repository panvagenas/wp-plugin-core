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
	public function testRemoveAll() {
		/* @var \WPluginCore002\Plugin\Plugin $WpPluginCore */
		global $WpPluginCore;

		$hooksFactory = $WpPluginCore->getHookFactory();

		$filterTag = 'myFilterTag';
		$actionTag = 'myActionTag';

		$hooksFactory->removeAll( $filterTag );
		$hooksFactory->removeAll( $actionTag );

		$dumFilFun = function () {
		};
		$dumActFun = function () {
		};

		$dummyFilter = $hooksFactory->filter( $filterTag, $dumFilFun );
		$dummyAction = $hooksFactory->action( $actionTag, $dumActFun );

		$this->assertFalse( has_filter( $filterTag ) );
		$this->assertFalse( has_action( $actionTag ) );

		$this->assertFalse( $dummyFilter->has() );
		$this->assertFalse( $dummyAction->has() );

		$dummyFilter->add();
		$dummyAction->add();

		$this->assertTrue( has_filter( $filterTag ) );
		$this->assertTrue( has_action( $actionTag ) );

		$this->assertTrue( $dummyFilter->has() === $dummyFilter->getPriority() );
		$this->assertTrue( $dummyAction->has() === $dummyAction->getPriority() );

		$hooksFactory->removeAll( $filterTag );
		$hooksFactory->removeAll( $actionTag );

		$this->assertFalse( has_filter( $filterTag ) );
		$this->assertFalse( has_action( $actionTag ) );

		$this->assertFalse( $dummyFilter->has() );
		$this->assertFalse( $dummyAction->has() );
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

		$var = false;

		$filter = $hooksFactory->filter( 'myFilterTag',
			function ( $var ) {
				if ( ! $var ) {
					$var = true;
				}

				return $var;
			}
		);

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

		$action = $hooksFactory->action( 'myActionTag',
			function () {
				global $myFancyVar;
				$myFancyVar = true;
			}
		);
		$action->add();

		$this->assertFalse( $myFancyVar );

		$hooksFactory->action( 'myActionTag', null )->perform();

		$this->assertTrue( $myFancyVar );

		$this->assertTrue((bool)$action->did());
	}

	/**
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function testWhereStylesMayResideFilter() {
		/* @var \WPluginCore002\Plugin\Plugin $WpPluginCore */
		global $WpPluginCore;

		$hooksFactory = $WpPluginCore->getHookFactory();

		$originalWhereStylesMayResideArray = $WpPluginCore->getFactory()->paths()->getWhereStylesMayReside();
		$pathToInclude                     = array( '/my/new/path' );
		$newWhereStylesMayResideArray      = $originalWhereStylesMayResideArray + $pathToInclude;

		$hook = $hooksFactory->getWhereStylesMayResideFilter( $WpPluginCore, function ( $orAr ) use ( $pathToInclude ) {
			return $orAr + $pathToInclude;
		} );
		$hook->add();

		$this->assertEquals( $originalWhereStylesMayResideArray,
			$WpPluginCore->getFactory()->paths()->getWhereStylesMayReside() );

		$filteredPaths = $hook->apply( $originalWhereStylesMayResideArray );

		$this->assertEquals( $newWhereStylesMayResideArray, $filteredPaths );
	}

	/**
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function testWhereScriptsMayResideFilter() {
		/* @var \WPluginCore002\Plugin\Plugin $WpPluginCore */
		global $WpPluginCore;

		$hooksFactory = $WpPluginCore->getHookFactory();

		$originalWhereScriptsMayResideArray = $WpPluginCore->getFactory()->paths()->getWhereScriptsMayReside();
		$pathToInclude                      = array( '/my/new/path' );
		$newWhereScriptsMayResideArray      = $originalWhereScriptsMayResideArray + $pathToInclude;

		$hook = $hooksFactory->getWhereScriptsMayResideFilter( $WpPluginCore,
			function ( $orAr ) use ( $pathToInclude ) {
				return $orAr + $pathToInclude;
			} );
		$hook->add();

		$this->assertEquals( $originalWhereScriptsMayResideArray,
			$WpPluginCore->getFactory()->paths()->getWhereScriptsMayReside() );

		$filteredPaths = $hook->apply( $originalWhereScriptsMayResideArray );

		$this->assertEquals( $newWhereScriptsMayResideArray, $filteredPaths );
	}

	/**
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function testWhereTemplatesMayResideFilter() {
		/* @var \WPluginCore002\Plugin\Plugin $WpPluginCore */
		global $WpPluginCore;

		$hooksFactory = $WpPluginCore->getHookFactory();

		$originalWhereTemplatesMayResideArray = $WpPluginCore->getFactory()->paths()->getWhereTemplatesMayReside();
		$pathToInclude                        = array( '/my/new/path' );
		$newWhereTemplatesMayResideArray      = $originalWhereTemplatesMayResideArray + $pathToInclude;

		$hook = $hooksFactory->getWhereTemplatesMayResideFilter( $WpPluginCore,
			function ( $orAr ) use ( $pathToInclude ) {
				return $orAr + $pathToInclude;
			} );
		$hook->add();

		$this->assertEquals( $originalWhereTemplatesMayResideArray,
			$WpPluginCore->getFactory()->paths()->getWhereTemplatesMayReside() );

		$filteredPaths = $hook->apply( $originalWhereTemplatesMayResideArray );

		$this->assertEquals( $newWhereTemplatesMayResideArray, $filteredPaths );
	}
}