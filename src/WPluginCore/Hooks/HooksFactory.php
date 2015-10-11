<?php
/**
 * Project: wp-plugins-core.dev
 * File: HooksFactory.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 28/9/2015
 * Time: 7:41 μμ
 * Since: TODO ${VERSION}
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace WPluginCore002\Hooks;


use WPluginCore002\Abs\AbsFactory;
use WPluginCore002\Abs\AbsHook;
use WPluginCore002\Diagnostics\Exception;

class HooksFactory extends AbsFactory {
	protected static $pool = array();

	/**
	 * See {@link WPluginCore002\Hooks\HooksFactory::createOrGetHook()}
	 *
	 * @param string $tag
	 * @param mixed  $callback
	 * @param int    $priority
	 * @param int    $acceptedArgs
	 *
	 * @return Filter
	 * @throws Exception
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function filter( $tag, $callback, $priority = 10, $acceptedArgs = 1 ) {
		return $this->createOrGetHook( 'Filter', $tag, $callback, $priority, $acceptedArgs );
	}

	/**
	 * See {@link WPluginCore002\Hooks\HooksFactory::createOrGetHook()}
	 *
	 * @param string $tag
	 * @param mixed  $callback
	 * @param int    $priority
	 * @param int    $acceptedArgs
	 *
	 * @return Action
	 * @throws Exception
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function action( $tag, $callback, $priority = 10, $acceptedArgs = 1 ) {
		return $this->createOrGetHook( 'Action', $tag, $callback, $priority, $acceptedArgs );
	}

	/**
	 * @param string $type
	 * @param string $tag
	 * @param mixed  $callback
	 * @param int    $priority
	 * @param int    $acceptedArgs
	 *
	 * @return Filter|Action
	 * @throws Exception If unique ID for filter fails. This is depended on {@link _wp_filter_build_unique_id()}
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	protected function createOrGetHook( $type, $tag, $callback, $priority = 10, $acceptedArgs = 1 ) {
		if ( ! in_array( $type, array( 'Filter', 'Action' ) ) ) {
			throw new Exception( "Invalid hook type: $type" );
		}

		if ( $callback ) {
			$id = $this->alreadySet( $tag, $callback );
			if ( $id && ( $exists = $this->getFromPool( $id, $tag, $priority ) ) ) {
				return $exists;
			}
			if ( $id === false ) {
				throw new Exception( 'Could\'t create new hook. ID generation failed.' );
			}
		}

		$class   = __NAMESPACE__ . '\\' . $type;
		$newHook = new $class( $tag, $callback, $priority, $acceptedArgs );

		if ( isset( $id ) && $id && $callback ) {
			$this->addToPool( $id, $newHook );
		}

		return $newHook;
	}

	/**
	 * @param $tag
	 * @param $callback
	 *
	 * @return false|string
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function alreadySet( $tag, $callback ) {
		return _wp_filter_build_unique_id( $tag, $callback, false );
	}

	/**
	 * @param string $id
	 * @param string $tag
	 * @param int    $priority
	 *
	 * @return bool
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function getFromPool( $id, $tag, $priority = 10 ) {
		return isset( self::$pool[ $tag ][ $priority ][ $id ] ) ? self::$pool[ $tag ][ $priority ][ $id ] : false;
	}

	/**
	 * @param string|int $id
	 * @param AbsHook    $hook
	 *
	 * @return AbsHook
	 * @throws Exception
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function addToPool( $id, AbsHook $hook ) {
		if ( ! ( is_int( $id ) || is_string( $id ) ) ) {
			throw new Exception( "Key: $id is not a valid array key" );
		}

		if ( ! isset( self::$pool[ $hook->getTag() ] ) ) {
			self::$pool[ $hook->getTag() ] = array();
		}

		if ( ! isset( self::$pool[ $hook->getTag() ][ $hook->getPriority() ] ) ) {
			self::$pool[ $hook->getTag() ][ $hook->getPriority() ] = array();
		}

		return self::$pool[ $hook->getTag() ][ $hook->getPriority() ][ $id ] = $hook;
	}

	/**
	 * @param string $tag
	 * @param int    $priority
	 *
	 * @return true
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function removeAll( $tag, $priority = - 1 ) {
		$priority = $priority < 0 ? false : $priority;

		if ( $priority === false && isset( self::$pool[ $tag ] ) ) {
			self::$pool[ $tag ] = array();
		} elseif ( isset( self::$pool[ $tag ][ $priority ] ) ) {
			self::$pool[ $tag ][ $priority ] = array();
		}

		return remove_all_filters( $tag, $priority );
	}
}