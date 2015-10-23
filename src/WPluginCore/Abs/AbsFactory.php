<?php
/**
 * Project: wp-plugins-core.dev
 * File: AbsFactory.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 28/9/2015
 * Time: 7:39 μμ
 * Since: 0.0.2
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace WPluginCore003\Abs;

use WPluginCore003\Core\Constants;
use WPluginCore003\Diagnostics\Exception;
use WPluginCore003\Plugin\Plugin;


/**
 * Class AbsFactory
 *
 * @package WPluginCore003\Abs
 * @author  Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @since   0.0.2
 */
abstract class AbsFactory extends AbsClass {
	/**
	 * @var string
	 */
	protected $namespace;

	/**
	 * @param Plugin $plugin
	 */
	public function __construct( Plugin $plugin ) {
		parent::__construct( $plugin );
		$ref             = new \ReflectionClass( get_class( $this ) );
		$this->namespace = $ref->getNamespaceName();
	}
	/**
	 * Creates or gets an instance for class with class
	 *
	 * *Additional args* can be passed to this method. In this case they will be used to instantiate
	 * the new class. If new class is instance of {@link AbsPluginSingleton} or {@link AbsCoreSingleton}
	 * then additional args will be discarded. If class to be instantiated has $plugin property then the plugin
	 * instance is added to the head of additional args. In that case the class constructor should have `Plugin $plugin`
	 * argument first.
	 *
	 * **IMPORTANT** If class is instance of {@link AbsPluginSingleton} or {@link AbsCoreSingleton} then
	 * {@link AbsPluginSingleton::getInstance()} or {@link AbsCoreSingleton::getInstance()}
	 * is used. In that case any additional args will be discarded. If this is not the case then a new
	 * instance of class is returned.
	 *
	 * @param string $className baseNamespace must be omitted. eg. `$className = 'MyBaceNamespaceChildren\MyClass'
	 *
	 * @return object An instance of [baseNamespace]\$className
	 * @throws Exception If class not found or isn't instantiable or is plugin class has same name as one in core and
	 *                   doesn't extend this core class.
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
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

		if ( ! $reflection
		     ||
		     (
			     ! (
				     $reflection->isSubclassOf( $this->getCoreClassNameFromBase( 'Abs\\AbsPluginSingleton' ) )
				     ||
				     $reflection->isSubclassOf( $this->getCoreClassNameFromBase( 'Abs\\AbsCoreSingleton' ) )
			     )
			     &&
			     ! $reflection->isInstantiable()
		     )
		) {
			throw new Exception( 'Trying to instantiate non-instantiable class ' . $class );
		}

		if ( $reflection->isSubclassOf( $this->getCoreClassNameFromBase( 'Abs\\AbsPluginSingleton' ) ) ) {
			/* @var AbsPluginSingleton $class */
			$instance = $class::getInstance( $this->plugin );
		} elseif ( $reflection->isSubclassOf( $this->getCoreClassNameFromBase( 'Abs\\AbsCoreSingleton' ) ) ) {
			/* @var AbsCoreSingleton $class */
			$instance = $class::getInstance();
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
	 * Get a core class name from base fully namespaced.
	 *
	 * **IMPORTANT** core baseNamespace must be omitted
	 *
	 * @param string $className eg. 'Options\\Options'
	 *
	 * @return string
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public final function getCoreClassNameFromBase( $className ) {
		return '\\' . Constants::CORE_BASE_NS . '\\' . $className;
	}

	/**
	 * Get a plugin class name fully namespaced.
	 *
	 * **IMPORTANT** plugin baseNamespace must be omitted
	 *
	 * @param string $className eg. 'Options\\Options'
	 *
	 * @return string
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public final function getPluginClassNameFromBase( $className ) {
		return '\\' . $this->plugin->getBaseNamespace() . '\\' . $className;
	}

	/**
	 * Get a core class name fully namespaced.
	 *
	 * **IMPORTANT** core baseNamespace must be omitted
	 *
	 * @param string $className
	 *
	 * @return string
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public final function getCoreClassName( $className ) {
		return '\\' . $this->namespace . '\\' . $className;
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
	 * @since  0.0.2
	 */
	public final function getPluginClassName( $className ) {
		return str_replace(
			Constants::CORE_BASE_NS,
			$this->plugin->getBaseNamespace(),
			$this->getCoreClassName( $className )
		);
	}

	/**
	 * Checks if class exists in plugin
	 *
	 * @param string $coreClassName
	 *
	 * @return bool True iff class exists in plugin
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
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
	 * @since  0.0.2
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
	 * @since  0.0.2
	 */
	public final function coreClassExists( $className ) {
		return class_exists( $this->getCoreClassName( $className ) );
	}
}