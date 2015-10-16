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
use WPluginCore002\Diagnostics\Exception;
use WPluginCore002\Diagnostics\InvalidArgumentException;
use WPluginCore002\Factory;
use WPluginCore002\Hooks\HooksFactory;
use WPluginCore002\Options\Options;

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
	 * Plugin slug. Should contain only alpha-numeric chars and underscore. This also the `global` var
	 * you can use to reference your plugin class, so it should be unique.
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
	 * @var Options
	 */
	protected $options;

	/**
	 * @param string $name       Plugin name. {@link WPluginCore002\Plugin\Plugin::$name}
	 * @param string $version    Version of the plugin. {@link WPluginCore002\Plugin\Plugin::$version}
	 * @param string $filePath   Abs path to plugin file. {@link WPluginCore002\Plugin\Plugin::$filePath}
	 * @param string $slug       Plugin slug. Should contain only alpha-numeric chars and underscore. All other chars
	 *                           get replaced with ` `(space) and the {@link Stringy::upperCamelize()} is then
	 *                           applied. See also {@link WPluginCore002\Plugin\Plugin::$slug}
	 * @param string $textDomain Text domain of the plugin for localization support.
	 *                           This should be a lowercase alpha-num string with underscores.
	 *                           {@link Stringy::underscored()} is applied to this.
	 *                           See also {@link WPluginCore002\Plugin\Plugin::$textDomain}
	 *
	 * @throws Exception If plugin base namespace isn't set or trying to instantiate core Plugin class
	 */
	public function __construct( $name, $version, $filePath = '', $slug = '', $textDomain = '' ) {
		parent::__construct( $this );
		$this->name    = $name;
		$this->version = $version;

		$this->factory     = new Factory( $this );
		$this->hookFactory = new HooksFactory();

		$ref       = new \ReflectionClass( get_class( $this ) );
		$baseNSStr = $ref->getNamespaceName();

		if ( $baseNSStr === __NAMESPACE__ ) {
			throw new Exception( 'Can\'t instantiate core Plugin class. You should extend it instead.' );
		}

		$baseNSAr = explode( '\\', $baseNSStr );

		if ( isset( $baseNSAr[0] ) ) {
			$this->baseNamespace = $baseNSAr[0];
		} else {
			throw new Exception( 'Base namespace not found' );
		}

		if ( ( ! empty( $filePath ) && ! file_exists( $filePath ) )
		     || ( empty( $filePath ) && ! file_exists( $filePath = dirname( dirname( dirname( __FILE__ ) ) ) . '/plugin.php' ) )
		) {
			throw new InvalidArgumentException( 'Plugin file couldn\'t be located' );
		}
		$this->filePath = $filePath;

		$this->baseName = plugin_basename( $this->filePath );

		if ( empty( $slug ) ) {
			$baseNameAr = explode( '/', plugin_basename( substr( $filePath, 0, - 4 ) ) );
			$slug       = end( $baseNameAr );
		}
		$slug = preg_replace( "/[^A-Za-z0-9 _]/", ' ', $slug );

		$this->slug = $slug = (string) Stringy::create( $slug )->upperCamelize();

		$GLOBALS[ $slug ] = &$this;

		$this->textDomain = empty( $textDomain )
			? $this->slug
			: $textDomain;

		$this->textDomain = preg_replace( "/[^A-Za-z0-9 _]/", ' ', $this->textDomain );
		$this->textDomain = (string) Stringy::create( $this->textDomain )->underscored();

		$this->options = $this->factory->options();

		$this->factory->initializer()->coreInit();
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