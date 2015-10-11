<?php
/**
 * Project: wp-plugins-core.dev
 * File: Action.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 28/9/2015
 * Time: 7:41 μμ
 * Since: TODO ${VERSION}
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace WPluginCore002\Hooks;


use WPluginCore002\Abs\AbsHook;

class Action extends AbsHook{
	/**
	 * @return mixed
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function perform(){
		$args = func_get_args();
		array_unshift($args, $this->tag);
		return call_user_func_array('do_action', $args);
	}

	/**
	 * @return int|void
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function did(){
		return did_action($this->tag);
	}
}