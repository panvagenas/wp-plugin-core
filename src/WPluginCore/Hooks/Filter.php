<?php
/**
 * Project: wp-plugins-core.dev
 * File: Filter.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 28/9/2015
 * Time: 7:41 μμ
 * Since: TODO ${VERSION}
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace WPluginCore002\Hooks;


use WPluginCore002\Abs\AbsHook;

class Filter extends AbsHook{
	public function apply(){
		$args = func_get_args();
		array_unshift($args, $this->tag);
		return call_user_func_array('apply_filters', $args);
	}
}