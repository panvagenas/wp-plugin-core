<?php
/**
 * Project: wp-plugins-core.dev
 * File: Filter.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 28/9/2015
 * Time: 7:41 μμ
 * Since: 0.0.2
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace WPluginCore003\Hooks;


use WPluginCore003\Abs\AbsHook;

/**
 * Class Filter
 *
 * @package WPluginCore003\Hooks
 * @author  Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @since   0.0.2
 */
class Filter extends AbsHook {
	/**
	 * @return mixed
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function apply() {
		$args = func_get_args();
		array_unshift( $args, $this->tag );

		return call_user_func_array( 'apply_filters', $args );
	}
}