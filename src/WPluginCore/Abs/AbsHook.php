<?php
/**
 * Project: wp-plugins-core.dev
 * File: AbsHook.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 28/9/2015
 * Time: 7:41 μμ
 * Since: 0.0.2
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace WPluginCore003\Abs;


use WPluginCore003\Plugin\Plugin;

/**
 * Class AbsHook
 *
 * @package WPluginCore003\Abs
 * @author  Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @since   0.0.2
 */
abstract class AbsHook extends AbsClass{
	/**
	 * Hook tag. See {@link https://codex.wordpress.org/Plugin_API/Action_Reference} and
	 * {@link https://codex.wordpress.org/Plugin_API/Filter_Reference}.
	 *
	 * @var string
	 */
	protected $tag;
	/**
	 * @var
	 */
	protected $callBack;
	/**
	 * @var int
	 */
	protected $priority;
	/**
	 * @var int
	 */
	protected $acceptedArgs;

	/**
	 * @param Plugin $plugin
	 * @param        $tag
	 * @param        $callback
	 * @param int    $priority
	 * @param int    $acceptedArgs
	 */
	public function __construct( Plugin $plugin, $tag, $callback, $priority = 10, $acceptedArgs = 1 ) {
		parent::__construct($plugin);
		$this->tag          = $tag;
		$this->callBack     = $callback;
		$this->priority     = $priority;
		$this->acceptedArgs = $acceptedArgs;
	}

	/**
	 * @return true|void
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function add() {
		return add_filter( $this->tag, $this->callBack, $this->priority, $this->acceptedArgs );
	}

	/**
	 * @return false|int
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function has() {
		return has_filter( $this->tag, $this->callBack );
	}

	/**
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function remove() {
		remove_filter( $this->tag, $this->callBack, $this->priority );
	}

	/**
	 * @return true
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function removeAll() {
		return $this->plugin->getHookFactory()->removeAll( $this->tag, $this->priority );
	}

	/**
	 * @return mixed
	 */
	public function getTag() {
		return $this->tag;
	}

	/**
	 * @return mixed
	 */
	public function getCallBack() {
		return $this->callBack;
	}

	/**
	 * @return int
	 */
	public function getPriority() {
		return $this->priority;
	}

	/**
	 * @return int
	 */
	public function getAcceptedArgs() {
		return $this->acceptedArgs;
	}
}