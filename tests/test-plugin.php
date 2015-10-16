<?php

/**
 * Created by PhpStorm.
 * User: vagenas
 * Date: 11/9/2015
 * Time: 5:11 μμ
 */
class PluginTest extends WP_UnitTestCase {
	/**
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function testGlobalPluginInstance() {
		$this->assertTrue(isset($GLOBALS['WpPluginCore']));

		/* @var \WPluginCore002\Plugin\Plugin $WpPluginCore */
		global $WpPluginCore;

		$this->assertTrue($WpPluginCore instanceof \WPluginCore002\Plugin\Plugin);

		$newPluginSlug = 'DummyPlugin';

		$newPlugin = new \WPluginCore\Plugin("Dummy Plugin", "0.0-dummy", $WpPluginCore->getFilePath(), $newPluginSlug);

		$this->assertTrue(isset($GLOBALS[$newPluginSlug]));
		$this->assertTrue($newPlugin instanceof \WPluginCore002\Plugin\Plugin);
	}

	/**
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function testPluginFactory(){
		/* @var \WPluginCore002\Plugin\Plugin $WpPluginCore */
		global $WpPluginCore;

		$factory = $WpPluginCore->getFactory();

		$this->assertTrue( $factory instanceof \WPluginCore002\Factory);
		$this->assertEquals($factory->getPlugin(), $WpPluginCore);
	}

	/**
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function testClassInstantiationFactory(){
		/* @var \WPluginCore002\Plugin\Plugin $WpPluginCore */
		global $WpPluginCore;

		$factory = $WpPluginCore->getFactory();

		$this->assertTrue($factory->paths() instanceof \WPluginCore002\Plugin\Paths);
		$this->assertTrue($factory->hooksFactory() instanceof \WPluginCore002\Hooks\HooksFactory);
		$this->assertTrue($factory->initializer() instanceof \WPluginCore002\Plugin\Initializer);
		$this->assertTrue($factory->installer() instanceof \WPluginCore002\Plugin\Installer);
		$this->assertTrue($factory->options() instanceof \WPluginCore002\Options\Options);
		$this->assertTrue($factory->widget() instanceof \WPluginCore002\Plugin\Widget);
	}
}