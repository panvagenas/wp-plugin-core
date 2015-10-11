<?php
/**
 * Project: wp-plugins-core.dev
 * File: Plugin.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 28/9/2015
 * Time: 6:06 πμ
 * Since: TODO ${VERSION}
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace WPluginCore002\Plugin;


use Stringy\Stringy;
use WPluginCore002\Abs\AbsSingleton;
use WPluginCore002\Diagnostics\InvalidArgumentException;
use WPluginCore002\Factory;
use WPluginCore002\Hooks\HooksFactory;

class Plugin extends AbsSingleton {
	/**
	 * Plugin name.
	 *
	 * **Required**
	 *
	 * @var string
	 */
	protected $name;
	/**
	 * Version of the plugin
	 *
	 * **Required**
	 *
	 * @var string
	 */
	protected $version;
	/**
	 * Abs path to plugin file (eg. `ABSPATH/wp-content/plugins/my-plugin/plugin.php`).
	 *
	 * **Optional**: If omitted then plugin file should be named 'plugin.php' and
	 * located on dir up from Plugin class file location
	 *
	 * @var string
	 */
	protected $filePath;
	/**
	 * Plugin slug for internal core use. Should contain only alpha-numeric chars and underscore.
	 *
	 * **Optional**: Will be generated from {@link WPluginCore002\Plugin\Plugin::$name}
	 * based on various string transformation rules.
	 *
	 * @var string
	 */
	protected $slug;
	/**
	 * Text domain of the plugin for localization support.
	 *
	 * **Optional**: if omitted, it will be generated from {@link WPluginCore002\Plugin\Plugin::$slug}
	 *
	 * @var string
	 */
	protected $textDomain;
	/**
	 * Base name of the plugin. Will contain something
	 * like *'my-plugin/my-plugin.php'*
	 *
	 * **Auto-generated** with {@link plugin_basename()}
	 *
	 * @var string
	 * @see plugin_basename()
	 */
	protected $baseName;
	/**
	 * The base namespace of the plugin.
	 *
	 * **Auto-generated**: Automatically set from current namespace of the extended plugin class
	 *
	 * @var string
	 */
	protected $baseNamespace;
	/**
	 * Use this factory to get class instances.
	 *
	 * @var Factory
	 * @see WPluginCore002\Factory
	 */
	protected $factory;
	/**
	 * @var HooksFactory
	 */
	protected $hookFactory;

	/**
	 * @param string $name       Plugin name. {@link WPluginCore002\Plugin\Plugin::$name}
	 * @param string $version    Version of the plugin. {@link WPluginCore002\Plugin\Plugin::$version}
	 * @param string $filePath   Abs path to plugin file. {@link WPluginCore002\Plugin\Plugin::$filePath}
	 * @param string $slug       Plugin slug for internal core use. Should contain only alpha-numeric chars and underscore.
	 *                           {@link WPluginCore002\Plugin\Plugin::$slug}
	 * @param string $textDomain Text domain of the plugin for localization support. {@link WPluginCore002\Plugin\Plugin::$textDomain}
	 */
	public function __construct( $name, $version, $filePath = '', $slug = '', $textDomain = '' ) {
		parent::__construct($this);
		$this->name    = $name;
		$this->version = $version;

		$this->factory     = new Factory( $this );
		$this->hookFactory = new HooksFactory();

		$ref                 = new \ReflectionClass( get_class( $this ) );
		$this->baseNamespace = $ref->getNamespaceName();

		if ( ( ! empty( $filePath ) && ! file_exists( $filePath ) )
		     || ( empty( $filePath ) && ! file_exists( $filePath = dirname( dirname( dirname( __FILE__ ) ) ) . '/plugin.php' ) )
		) {
			throw new InvalidArgumentException( 'Plugin file couldn\'t be located' );
		}
		$this->filePath = $filePath;

		$this->baseName = plugin_basename( $this->filePath );

		// TODO validate $slug

		if(empty($slug)){
			$baseNameAr = explode('/', plugin_basename( substr( $filePath, 0, - 4 ) ) );
			$slug = end($baseNameAr);
		}
		$slug = preg_replace("/[^A-Za-z0-9 ]/", ' ', $slug);
		$this->slug = $slug = (string) Stringy::create( $slug )->upperCamelize();

		$GLOBALS[$slug] = &$this;

		// TODO validate $textDomain
		$this->textDomain = empty( $textDomain )
			? $this->slug
			: $textDomain;
		$this->textDomain = (string) Stringy::create( $this->textDomain )->underscored();

		$this->factory->initializer()->coreInit();

		if ( ! empty( $this->textDomain ) ) {
			$pluginDir = basename( dirname( $this->filePath ) ) . $this->factory->paths()->getTranslationsRelDirPath();
			$this->hookFactory->action( 'plugins_loaded',
				function () use ( $textDomain, $pluginDir ) {
					load_plugin_textdomain( $textDomain, null, $pluginDir );
				}
			)->add();
		}

		register_activation_hook( $this->baseName, array( $this->factory->installer(), 'activation' ) );
		register_deactivation_hook( $this->baseName, array( $this->factory->installer(), 'deactivation' ) );
		register_uninstall_hook( $this->baseName,
			array(
				get_class( $this->factory->installer() ),
				'uninstall'
			)
		);
	}

	/**
	 * @return string
	 */
	public function getVersion() {
		return $this->version;
	}

	/**
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @return string
	 */
	public function getFilePath() {
		return $this->filePath;
	}

	/**
	 * @return string
	 */
	public function getSlug() {
		return $this->slug;
	}

	/**
	 * @return string
	 */
	public function getTextDomain() {
		return $this->textDomain;
	}

	/**
	 * @return string
	 */
	public function getBaseName() {
		return $this->baseName;
	}

	/**
	 * @return string
	 */
	public function getBaseNamespace() {
		return $this->baseNamespace;
	}

	/**
	 * @return Factory
	 */
	public function getFactory() {
		return $this->factory;
	}

	/**
	 * @return HooksFactory
	 */
	public function getHookFactory() {
		return $this->hookFactory;
	}
}