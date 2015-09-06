<?php
/**
 * Created by PhpStorm.
 * User: vagenas
 * Date: 28/8/2015
 * Time: 6:17 μμ
 */

namespace PanWPCore;

/**
 * Class Core
 *
 * @package PanWPCore
 * @author  Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @since   TODO ${VERSION}
 *
 * @property Actions                $Actions
 * @method Actions                  Actions() Actions()
 *
 * @property Dumper                 $Dumper
 * @method Dumper                   Dumper() Dumper()
 *
 * @property Filters                $Filters
 * @method Filters                  Filters() Filters()
 *
 * @property Hooks                  $Hooks
 * @method Hooks                    Hooks() Hooks()
 *
 * @property I18n                   $I18n
 * @method I18n                     I18n() I18n()
 *
 * @property Initializer            $Initializer
 * @method Initializer              Initializer() Initializer()
 *
 * @property Installer              $Installer
 * @method Installer                Installer() Installer()
 *
 * @property Options                $Options
 * @method Options                  Options() Options()
 *
 * @property Paths                  $Paths
 * @method Paths                    Paths() Paths()
 *
 * @property Plugin                 $Plugin
 * @method Plugin                   Plugin() Plugin( string $baseNamespace, string $filePath, string $name, string $version, string $textDomain = '', string $slug = '' )
 *
 * @property Redux                  $Redux
 * @method Redux                    Redux() Redux( Plugin $plugin, Array $args = array() )
 *
 * @property Scripts                $Scripts
 * @method Scripts                  Scripts() Scripts()
 *
 * @property String                 $String
 * @method String                   String() String()
 *
 * @property Templates              $Templates
 * @method Templates                Templates() Templates()
 *
 * @property Log\Logger             $Log__Logger
 * @method Log\Logger               Log__Logger() Log__Logger()
 *
 * @property Log\Handlers\DBHandler $Log__Handlers__DBHandler
 * @method Log\Handlers\DBHandler   Log__Handlers__DBHandler() Log__Handlers__DBHandler( string $logName, int $level = \Monolog\Logger::DEBUG, bool $bubble = true )
 */
abstract class Core {
	protected $Plugin;

	/**
	 * @param Plugin $plugin
	 */
	public function __construct( Plugin $plugin ) {
		$this->Plugin = &$plugin;
	}

	/**
	 * @param $property
	 *
	 * @return bool
	 */
	public function __isset( $property ) {
		$property = (string) $property;

		return isset( $this->{$property} )
		       || isset( $this->Plugin->{$property} )
		       || class_exists( $this->_getCoreClassName( $property ) )
		       || class_exists( $this->_getPluginClassName( $property ) );
	}

	/**
	 * @param $property
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	public function __get( $property ) {
		if ( property_exists( $this->Plugin, $property ) ) {
			return $this->Plugin->{$property};
		}

		if ( class_exists( $class = $this->_getPluginClassName( $property ) ) ) {
			return $this->Plugin->{$property} = $this->{$property}( $this->Plugin );
		} elseif ( class_exists( $class = $this->_getCoreClassName( $property ) ) ) {
			return $this->Plugin->{$property} = $this->{$property}( $this->Plugin );
		} else {
			throw new \Exception( 'Undefined Class ' . $property );
		}
	}

	/**
	 * @param $method
	 * @param $args
	 *
	 * @return mixed|object
	 * @throws \Exception
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function __call( $method, $args ) {
		if ( method_exists( $this, $method ) ) {
			return call_user_func_array( array( $this, $method ), $args );
		}

		if ( class_exists( $class = $this->_getPluginClassName( $method ) ) ) {
			$reflection = new \ReflectionClass( $class );
		} elseif ( class_exists( $class = $this->_getCoreClassName( $method ) ) ) {
			$reflection = new \ReflectionClass( $class );
		} else {
			$reflection = null;
		}

		if(!$reflection || !$reflection->isInstantiable()){
			throw new \Exception( 'Trying to instantiate non-instantiable class ' . $class );
		}

		if(!isset($args[0]) || !($args[0] instanceof Plugin)){
			array_unshift($args, $this->Plugin);
		}

		return $reflection->newInstanceArgs( $args );
	}

	/**
	 * @param string $class
	 *
	 * @return string
	 */
	protected function _getCoreClassName( $class ) {
		$class = str_replace( '__', '\\', $class );

		return '\\' . __NAMESPACE__ . '\\' . $class;
	}

	/**
	 * @param string $class
	 *
	 * @return string
	 */
	protected function _getPluginClassName( $class ) {
		$class = str_replace( '__', '\\', $class );

		return '\\' . $this->Plugin->baseNamespace . '\\' . $class;
	}
}