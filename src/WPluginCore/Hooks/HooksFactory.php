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
use WPluginCore002\Plugin\Plugin;

class HooksFactory extends AbsFactory {
	const FILTER = 'Filter';
	const ACTION = 'Action';
	const WHERE_TEMPLATES_MAY_RESIDE_FILTER_TAG_SUFFIX = '/WhereTemplatesMayReside';
	const WHERE_SCRIPTS_MAY_RESIDE_FILTER_TAG_SUFFIX = '/WhereScriptsMayReside';
	const WHERE_STYLES_MAY_RESIDE_FILTER_TAG_SUFFIX = '/WhereStylesMayReside';

	protected static $pool = array();

	/**
	 * See {@link WPluginCore002\Hooks\HooksFactory::createOrGetHook()}
	 *
	 * @param string              $tag
	 * @param null|array|callable $callback
	 * @param int                 $priority
	 * @param int                 $acceptedArgs
	 *
	 * @return Filter
	 * @throws Exception
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function filter( $tag, $callback, $priority = 10, $acceptedArgs = 1 ) {
		return $this->createOrGetHook( self::FILTER, $tag, $callback, $priority, $acceptedArgs );
	}

	/**
	 * See {@link WPluginCore002\Hooks\HooksFactory::createOrGetHook()}
	 *
	 * @param string              $tag
	 * @param null|array|callable $callback
	 * @param int                 $priority
	 * @param int                 $acceptedArgs
	 *
	 * @return Action
	 * @throws Exception
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function action( $tag, $callback, $priority = 10, $acceptedArgs = 1 ) {
		return $this->createOrGetHook( self::ACTION, $tag, $callback, $priority, $acceptedArgs );
	}

	/**
	 * @param string              $type
	 * @param string              $tag
	 * @param null|array|callable $callback
	 * @param int                 $priority
	 * @param int                 $acceptedArgs
	 *
	 * @return Filter|Action
	 * @throws Exception If unique ID for filter fails. This is depended on {@link _wp_filter_build_unique_id()}
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	protected function createOrGetHook( $type, $tag, $callback, $priority = 10, $acceptedArgs = 1 ) {
		if ( ! in_array( $type, array( self::FILTER, self::ACTION ) ) ) {
			throw new Exception( "Invalid hook type: $type" );
		}

		if ( $callback ) {
			$hookId = $this->alreadySet( $tag, $callback );
			if ( $hookId && ( $exists = $this->getFromPool( $hookId, $tag, $priority ) ) ) {
				return $exists;
			}
			if ( $hookId === false ) {
				throw new Exception( 'Could\'t create new hook. ID generation failed.' );
			}
		}

		$class   = __NAMESPACE__ . '\\' . $type;
		$newHook = new $class( $tag, $callback, $priority, $acceptedArgs );

		if ( isset( $hookId ) && $hookId && $callback ) {
			$this->addToPool( $hookId, $newHook );
		}

		return $newHook;
	}

	/**
	 * @param              $tag
	 * @param string|array $callback
	 *
	 * @return false|string
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function alreadySet( $tag, $callback ) {
		return _wp_filter_build_unique_id( $tag, $callback, false );
	}

	/**
	 * @param string $hookId
	 * @param string $tag
	 * @param int    $priority
	 *
	 * @return AbsHook|false
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	protected function getFromPool( $hookId, $tag, $priority = 10 ) {
		return isset( self::$pool[ $tag ][ $priority ][ $hookId ] ) ? self::$pool[ $tag ][ $priority ][ $hookId ] : false;
	}

	/**
	 * @param string|int $hookId
	 * @param AbsHook    $hook
	 *
	 * @return AbsHook
	 * @throws Exception
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	protected function addToPool( $hookId, AbsHook $hook ) {
		if ( ! ( is_int( $hookId ) || is_string( $hookId ) ) ) {
			throw new Exception( "Key: $hookId is not a valid array key" );
		}

		if ( ! isset( self::$pool[ $hook->getTag() ] ) ) {
			self::$pool[ $hook->getTag() ] = array();
		}

		if ( ! isset( self::$pool[ $hook->getTag() ][ $hook->getPriority() ] ) ) {
			self::$pool[ $hook->getTag() ][ $hook->getPriority() ] = array();
		}

		return self::$pool[ $hook->getTag() ][ $hook->getPriority() ][ $hookId ] = $hook;
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

	/**
	 * @param Plugin              $plugin
	 * @param null|array|callable $callback
	 * @param int                 $priority
	 * @param int                 $acceptedArgs
	 *
	 * @return Filter
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function getWhereTemplatesMayResideFilter(
		Plugin $plugin,
		$callback = null,
		$priority = 10,
		$acceptedArgs = 1
	) {
		$hookTag = $plugin->getSlug() . self::WHERE_TEMPLATES_MAY_RESIDE_FILTER_TAG_SUFFIX;

		return $this->filter( $hookTag, $callback, $priority, $acceptedArgs );
	}

	/**
	 * @param Plugin              $plugin
	 * @param null|array|callable $callback
	 * @param int                 $priority
	 * @param int                 $acceptedArgs
	 *
	 * @return Filter
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function getWhereScriptsMayResideFilter(
		Plugin $plugin,
		$callback = null,
		$priority = 10,
		$acceptedArgs = 1
	) {
		$hookTag = $plugin->getSlug() . self::WHERE_SCRIPTS_MAY_RESIDE_FILTER_TAG_SUFFIX;

		return $this->filter( $hookTag, $callback, $priority, $acceptedArgs );
	}

	/**
	 * @param Plugin              $plugin
	 * @param null|array|callable $callback
	 * @param int                 $priority
	 * @param int                 $acceptedArgs
	 *
	 * @return Filter
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function getWhereStylesMayResideFilter(
		Plugin $plugin,
		$callback = null,
		$priority = 10,
		$acceptedArgs = 1
	) {
		$hookTag = $plugin->getSlug() . self::WHERE_STYLES_MAY_RESIDE_FILTER_TAG_SUFFIX;

		return $this->filter( $hookTag, $callback, $priority, $acceptedArgs );
	}
}