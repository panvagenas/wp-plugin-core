<?php

/**
 * Created by PhpStorm.
 * User: vagenas
 * Date: 11/9/2015
 * Time: 5:11 μμ
 */
class CoreTest extends WP_UnitTestCase {
	/**
	 * @var string
	 */
	private $pluginFile;
	/**
	 * @var \TestPlugin\Plugin
	 */
	private $testPlugin;

	/**
	 * @param null   $name
	 * @param array  $data
	 * @param string $dataName
	 */
	public function __construct( $name = null, array $data = array(), $dataName = '' ) {
		parent::__construct( $name, $data, $dataName );

		$this->pluginFile = dirname( __FILE__ ) . '/TestPlugin/Plugin.php';
		require_once $this->pluginFile;
		require_once dirname( __FILE__ ) . '/TestPlugin/Options.php';
		$this->testPlugin = new \TestPlugin\Plugin( 'TestPlugin', $this->pluginFile, 'Test Plugin', '0.0.1' );
	}

	/**
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function testCoreInstantiation() {
		global $plugin;

		$pluginDumper  = $plugin->Dumper();
		$pluginOptions = $plugin->Options();

		$this->assertAttributeInstanceOf( '\PanWPCore\Plugin', 'Plugin', $plugin );

		$this->assertObjectNotHasAttribute( 'Dumper', $plugin );
		$plugin->Dumper;
		$this->assertObjectHasAttribute( 'Dumper', $plugin );
		$this->assertAttributeInstanceOf( '\PanWPCore\Dumper', 'Dumper', $plugin );

		$this->assertNotSame( $pluginDumper, $plugin->Dumper );
		$this->assertNotSame( $pluginOptions, $plugin->Options );
	}

	/**
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function testPluginInstantiation() {
		global $plugin;


		$testPluginDumper  = $this->testPlugin->Dumper();
		$testPluginOptions = $this->testPlugin->Options();

		$this->assertAttributeInstanceOf( '\TestPlugin\Plugin', 'Plugin', $this->testPlugin );
		$this->assertAttributeInstanceOf( '\TestPlugin\Options', 'Options', $this->testPlugin );

		$this->assertObjectNotHasAttribute( 'Dumper', $this->testPlugin );
		$this->testPlugin->Dumper;
		$this->assertObjectHasAttribute( 'Dumper', $this->testPlugin );
		$this->assertAttributeInstanceOf( '\PanWPCore\Dumper', 'Dumper', $this->testPlugin );

		$this->assertInstanceOf( '\TestPlugin\Options', $testPluginOptions );
		$this->assertInstanceOf( '\PanWPCore\Dumper', $testPluginDumper );

		$this->assertNotSame( $testPluginDumper, $this->testPlugin->Dumper );
		$this->assertNotSame( $testPluginOptions, $this->testPlugin->Options );
	}
}