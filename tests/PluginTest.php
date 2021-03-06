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
	 * @since  0.0.2
	 */
	public function testGlobalPluginInstance() {
		$this->assertTrue( isset( $GLOBALS['WpPluginCore'] ) );

		/* @var \WPluginCore003\Plugin\Plugin $WpPluginCore */
		global $WpPluginCore;

		$this->assertTrue( $WpPluginCore instanceof \WPluginCore003\Plugin\Plugin );

		$newPluginSlug = 'DummyPlugin';

		$newPlugin = new \WPluginCore\Plugin( "Dummy Plugin", "0.0-dummy", $WpPluginCore->getFilePath(),
			$newPluginSlug );

		$this->assertTrue( isset( $GLOBALS[ $newPluginSlug ] ) );
		$this->assertTrue( $newPlugin instanceof \WPluginCore003\Plugin\Plugin );
	}

	/**
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function testPluginFactory() {
		/* @var \WPluginCore003\Plugin\Plugin $WpPluginCore */
		global $WpPluginCore;

		$factory = $WpPluginCore->getFactory();

		$this->assertTrue( $factory instanceof \WPluginCore003\Factory );
		$this->assertEquals( $factory->getPlugin(), $WpPluginCore );
	}

	/**
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function testClassInstantiationFactory() {
		/* @var \WPluginCore003\Plugin\Plugin $WpPluginCore */
		global $WpPluginCore;

		$factory = $WpPluginCore->getFactory();

		$this->assertTrue( $factory->fcrPlugin()->paths() instanceof \WPluginCore003\Plugin\Paths );
		$this->assertTrue( $factory->fcrHooks() instanceof \WPluginCore003\Hooks\FcrHooks );
		$this->assertTrue( $factory->fcrPlugin()->initializer() instanceof \WPluginCore003\Plugin\Initializer );
		$this->assertTrue( $factory->fcrPlugin()->installer() instanceof \WPluginCore003\Plugin\Installer );
		$this->assertTrue( $factory->fcrOptions()->options() instanceof \WPluginCore003\Options\Options );
	}
}