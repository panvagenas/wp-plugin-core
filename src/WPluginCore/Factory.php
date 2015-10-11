<?php
/**
 * Project: wp-plugins-core.dev
 * File: Factory.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 2/10/2015
 * Time: 9:49 πμ
 * Since: TODO ${VERSION}
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace WPluginCore002;


use WPluginCore002\Plugin\Installer;
use WPluginCore002\Helpers\Paths;
use WPluginCore002\Abs\AbsFactory;
use WPluginCore002\Abs\AbsSingleton;
use WPluginCore002\Diagnostics\Exception;
use WPluginCore002\Hooks\HooksFactory;
use WPluginCore002\Plugin\Initializer;
use WPluginCore002\Plugin\Plugin;
use WPluginCore002\Plugin\ShortCode;
use WPluginCore002\Plugin\Widget;

class Factory extends AbsFactory {
	/**
	 * @var Plugin
	 */
	protected $plugin;

	/**
	 * @param Plugin $plugin Always use an instance of **YOUR** plugin class to instantiate this factory
	 */
	public function __construct( Plugin $plugin ) {
		$this->plugin = $plugin;
	}

	/**
	 * Creates or gets an instance for class with class
	 *
	 * *Additional args* can be passed to this method. In this case they will be used to instantiate
	 * the new class. If new class is instance of {@link AbsSingleton} then additional args will be
	 * discarded. If class to be instantiated has $plugin property then the plugin instance is added
	 * to the head of additional args. In that case the class constructor should have `Plugin $plugin`
	 * argument first.
	 *
	 * **IMPORTANT** If class is instance of {@link AbsSingleton} then {@link AbsSingleton::getInstance()}
	 * is used. In that case any additional args will be discarded. If this is not the case then a new
	 * instance of class is returned.
	 *
	 * @param string $className baseNamespace must be omitted. eg. `$className = 'MyBaceNamespaceChildren\MyClass'
	 *
	 * @return object An instance of [baseNamespace]\$className
	 * @throws Exception If class not found or isn't instantiable or is plugin class has same name as one in core and
	 *                   doesn't extend this core class.
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function createOrGet( $className ) {
		if ( $this->existsInPlugin( $className ) ) {
			if ( $this->coreClassExists( $className ) && ! $this->isCoreExtension( $className ) ) {
				throw new Exception( 'Classes that have core name should ALWAYS extend core classes. Class name: ' . $className );
			}
			$class = $this->getPluginClassName( $className );
		} elseif ( $this->coreClassExists( $className ) ) {
			$class = $this->getCoreClassName( $className );
		} else {
			throw new Exception( 'Class ' . $className . ' doesn\'t seem to exists!' );
		}

		$args = func_get_args();
		array_shift( $args );

		$reflection = new \ReflectionClass( $class );

		if ( ! $reflection || ( ! $reflection->isSubclassOf( $this->getCoreClassName( 'Abs\\AbsSingleton' ) ) && ! $reflection->isInstantiable() ) ) {
			throw new Exception( 'Trying to instantiate non-instantiable class ' . $class );
		}

		if ( $reflection->isSubclassOf( $this->getCoreClassName( 'Abs\\AbsSingleton' ) ) ) {
			/* @var AbsSingleton $class */
			$instance = $class::getInstance($this->plugin);
		} else {
			if ( $reflection->hasProperty( 'plugin' )
			     && ( empty( $args ) || ( isset( $args[0] ) && ! ( $args[0] instanceof Plugin ) ) )
			) {
				array_unshift( $args, $this->plugin );
			}
			$instance = $reflection->newInstanceArgs( $args );
		}

		return $instance;
	}

	/**
	 * @return Paths
	 * @throws Exception
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public final function paths() {
		return $this->createOrGet( 'Helpers\\Paths' );
	}

	/**
	 * @return HooksFactory
	 * @throws Exception
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public final function hooksFactory() {
		return $this->createOrGet( 'Hooks\\HooksFactory' );
	}

	/**
	 * @return Initializer
	 * @throws Exception
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public final function initializer() {
		return $this->createOrGet( 'Plugin\\Initializer' );
	}

	/**
	 * @return Installer
	 * @throws Exception
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public final function installer() {
		return $this->createOrGet( 'Plugin\\Installer' );
	}

	/**
	 * @return ShortCode
	 * @throws Exception
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public final function shortCode() {
		return $this->createOrGet( 'Plugin\\ShortCode' );
	}

	/**
	 * @return Widget
	 * @throws Exception
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public final function widget() {
		return $this->createOrGet( 'Plugin\\Widget' );
	}

	/**
	 * Checks if class exists in plugin
	 *
	 * @param string $coreClassName
	 *
	 * @return bool True iff class exists in plugin
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public final function existsInPlugin( $coreClassName ) {
		return class_exists( $this->getPluginClassName( $coreClassName ) );
	}

	/**
	 * Checks if a class is plugin class and extends a core class with the same name
	 *
	 * @param string $className
	 *
	 * @return bool
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function isCoreExtension( $className ) {
		$reflection = new \ReflectionClass( $this->getPluginClassName( $className ) );

		return $reflection && $reflection->isSubclassOf( $this->getCoreClassName( $className ) );
	}

	/**
	 * Checks if core class with $className exists
	 *
	 * @param string $className
	 *
	 * @return bool
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public final function coreClassExists( $className ) {
		return class_exists( $this->getCoreClassName( $className ) );
	}

	/**
	 * Get a core class name fully namespaced.
	 *
	 * **IMPORTANT** core baseNamespace must be ommited
	 *
	 * @param $className
	 *
	 * @return string
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public final function getCoreClassName( $className ) {
		return '\\' . __NAMESPACE__ . '\\' . $className;
	}

	/**
	 * Get a plugin class name fully namespaced.
	 *
	 * **IMPORTANT** plugin baseNamespace must be omitted
	 *
	 * @param $className
	 *
	 * @return string
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public final function getPluginClassName( $className ) {
		return '\\' . $this->plugin->getBaseNamespace() . '\\' . $className;
	}

	/**
	 * @return Plugin
	 */
	public function getPlugin() {
		return $this->plugin;
	}

}