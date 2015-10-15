<?php
/**
 * Project: wp-plugins-core.dev
 * File: AbsHook.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 28/9/2015
 * Time: 7:41 μμ
 * Since: TODO ${VERSION}
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace WPluginCore002\Abs;


use WPluginCore002\Hooks\HooksFactory;

abstract class AbsHook {
	/**
	 * @var
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
	 * @param     $tag
	 * @param     $callback
	 * @param int $priority
	 * @param int $acceptedArgs
	 */
	public function __construct( $tag, $callback, $priority = 10, $acceptedArgs = 1 ) {
		$this->tag          = $tag;
		$this->callBack     = $callback;
		$this->priority     = $priority;
		$this->acceptedArgs = $acceptedArgs;
	}

	/**
	 * @return true|void
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function add() {
		return add_filter( $this->tag, $this->callBack, $this->priority, $this->acceptedArgs );
	}

	/**
	 * @return false|int
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function has() {
		return has_filter( $this->tag, $this->callBack );
	}

	/**
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function remove() {
		remove_filter( $this->tag, $this->callBack, $this->priority );
	}

	/**
	 * @return true
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function removeAll() {
		$hookFactory = new HooksFactory();

		return $hookFactory->removeAll( $this->tag, $this->priority );
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