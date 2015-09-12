<?php

/**
 * Created by PhpStorm.
 * User: vagenas
 * Date: 11/9/2015
 * Time: 5:12 μμ
 */
class OptionsTest extends WP_UnitTestCase{
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
	public function testInitialization(){
		$this->assertEquals('TestPluginOptions', $this->testPlugin->Options->getOptName());
	}

	/**
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function testOptionsUpdate(){
		$this->testPlugin->Options->set('someName', 1);

		$this->assertEquals(get_option($this->testPlugin->Options->getOptName()), $this->testPlugin->Options->getAll());

		$newValue = 2;
		$this->testPlugin->Options->set('someName', $newValue);

		$this->assertEquals(get_option($this->testPlugin->Options->getOptName()), $this->testPlugin->Options->getAll());
	}

	/**
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function testGetValues(){
		$oldValue= 1;
		$this->testPlugin->Options->set('someName', $oldValue);

		$this->assertEquals($oldValue, $this->testPlugin->Options->get('someName'));

		$newValue = 2;
		$this->testPlugin->Options->set('someName', $newValue);
		$this->assertEquals($newValue, $this->testPlugin->Options->get('someName'));

		$this->assertNull($this->testPlugin->Options->get('someMissingName', null));
		$this->assertNotNull($this->testPlugin->Options->get('someMissingName', 1));

		$this->assertNull($this->testPlugin->Options->getDefaults('someMissingName', null));
		$this->assertNotNull($this->testPlugin->Options->getDefaults('someMissingName', 1));

		$this->assertEquals(-1, $this->testPlugin->Options->getDefaults('someName'));
	}
}