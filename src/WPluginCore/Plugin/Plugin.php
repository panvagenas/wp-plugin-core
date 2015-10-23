<?php
/**
 * Project: wp-plugins-core.dev
 * File: Plugin.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 28/9/2015
 * Time: 6:06 πμ
 * Since: 0.0.2
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace WPluginCore003\Plugin;


use Stringy\Stringy;
use WPluginCore003\Abs\AbsPluginSingleton;
use WPluginCore003\Diagnostics\Exception;
use WPluginCore003\Diagnostics\InvalidArgumentException;
use WPluginCore003\Factory;
use WPluginCore003\Hooks\FcrHooks;
use WPluginCore003\Options\Options;

/**
 * Class Plugin
 *
 * @package WPluginCore003\Plugin
 * @author  Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @since   0.0.2
 */
class Plugin extends AbsPluginSingleton {
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
	 * **Optional**: Will be generated from {@link WPluginCore003\Plugin\Plugin::$name}
	 * based on various string transformation rules.
	 *
	 * @var string
	 */
	protected $slug;
	/**
	 * Text domain of the plugin for localization support.
	 *
	 * **Optional**: if omitted, it will be generated from {@link WPluginCore003\Plugin\Plugin::$slug}
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
	 * @see WPluginCore003\Factory
	 */
	protected $factory;
	/**
	 * @var FcrHooks
	 */
	protected $hookFactory;
	/**
	 * @var Options
	 */
	protected $options;

	/**
	 * @param string $name       Plugin name. {@link WPluginCore003\Plugin\Plugin::$name}
	 * @param string $version    Version of the plugin. {@link WPluginCore003\Plugin\Plugin::$version}
	 * @param string $filePath   Abs path to plugin file. {@link WPluginCore003\Plugin\Plugin::$filePath}
	 * @param string $slug       Plugin slug. Should contain only alpha-numeric chars and underscore. All other chars
	 *                           get replaced with ` `(space) and the {@link Stringy::upperCamelize()} is then
	 *                           applied. See also {@link WPluginCore003\Plugin\Plugin::$slug}
	 * @param string $textDomain Text domain of the plugin for localization support.
	 *                           This should be a lowercase alpha-num string with underscores.
	 *                           {@link Stringy::underscored()} is applied to this.
	 *                           See also {@link WPluginCore003\Plugin\Plugin::$textDomain}
	 *
	 * @throws Exception If plugin base namespace isn't set or trying to instantiate core Plugin class
	 */
	public function __construct( $name, $version, $filePath = '', $slug = '', $textDomain = '' ) {
		parent::__construct( $this );
		$this->name    = $name;
		$this->version = $version;

		$this->factory     = new Factory( $this );
		$this->hookFactory = $this->factory->fcrHooks();

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
			throw new InvalidArgumentException( "Plugin file couldn't be located" );
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

		$this->options = $this->factory->fcrOptions()->options();

		$this->factory->fcrPlugin()->initializer()->coreInit();
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
	 * @return FcrHooks
	 */
	public function getHookFactory() {
		return $this->hookFactory;
	}

	/**
	 * @return Options
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function getOptions() {
		return $this->options;
	}
}