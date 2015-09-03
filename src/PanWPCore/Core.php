<?php
/**
 * Created by PhpStorm.
 * User: vagenas
 * Date: 28/8/2015
 * Time: 6:17 μμ
 */

namespace PanWPCore;


class Core {
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
		if ( property_exists( $this, $property ) ) {
			return $this->{$property};
		}

		if ( class_exists( $class = $this->_getPluginClassName( $property ) ) ) {
			return $this->{$property} = new $class( $this->Plugin );
		} elseif ( class_exists( $class = $this->_getCoreClassName( $property ) ) ) {
			return $this->{$property} = new $class( $this->Plugin );
		} else {
			throw new \Exception( 'Undefined Class ' . $property );
		}
	}

	/**
	 * @param $method
	 * @param $args
	 *
	 * @return mixed|null|object
	 */
	public function __call( $method, $args ) {
		if ( method_exists( $this, $method ) ) {
			return call_user_func_array( array( $this, $method ), $args );
		} else if ( method_exists( $this->Plugin, $method ) ) {
			return call_user_func_array( array( $this->Plugin, $method ), $args );
		}

		if ( class_exists( $class = $this->_getPluginClassName( $method ) ) ) {
			$reflection = new \ReflectionClass( $class );

			return $reflection->newInstanceArgs( $args );
		} elseif ( class_exists( $class = $this->_getCoreClassName( $method ) ) ) {
			$reflection = new \ReflectionClass( $class );

			return $reflection->newInstanceArgs( $args );
		}

		return null;
	}

	/**
	 * @param $class
	 *
	 * @return string
	 */
	protected function _getCoreClassName( $class ) {
		$class = str_replace('__', '\\', $class);
		return '\\' . __NAMESPACE__ . '\\' . $class;
	}

	/**
	 * @param $class
	 *
	 * @return string
	 */
	protected function _getPluginClassName( $class ) {
		$class = str_replace('__', '\\', $class);
		return '\\' . $this->Plugin->baseNamespace . '\\' . $class;
	}
}