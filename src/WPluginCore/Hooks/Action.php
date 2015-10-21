<?php
/**
 * Project: wp-plugins-core.dev
 * File: Action.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 28/9/2015
 * Time: 7:41 μμ
 * Since: 0.0.2
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace WPluginCore003\Hooks;


use WPluginCore003\Abs\AbsHook;

/**
 * Class Action
 *
 * @package WPluginCore003\Hooks
 * @author  Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @since   0.0.2
 */
class Action extends AbsHook {
	/**
	 * @return mixed
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function perform() {
		$args = func_get_args();
		array_unshift( $args, $this->tag );

		return call_user_func_array( 'do_action', $args );
	}

	/**
	 * @return int|void
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function did() {
		return did_action( $this->tag );
	}
}