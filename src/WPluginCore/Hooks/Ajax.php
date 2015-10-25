<?php
/**
 * Project: wp-plugins-core.dev
 * File: Ajax.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 25/10/2015
 * Time: 7:54 μμ
 * Since: TODO ${VERSION}
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace WPluginCore003\Hooks;


use WPluginCore003\Abs\AbsHook;
use WPluginCore003\Plugin\Plugin;

/**
 * Class Ajax
 *
 * @package WPluginCore003\Hooks
 * @author  Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @since   TODO ${VERSION}
 */
class Ajax extends AbsHook {
	/**
	 * @param Plugin $plugin
	 * @param        $tag
	 * @param        $callback
	 * @param int    $priority
	 * @param int    $acceptedArgs
	 */
	public function __construct( Plugin $plugin, $tag, $callback, $priority = 10, $acceptedArgs = 0 ) {
		if ( strpos( $tag, 'wp_ajax' ) !== 0 ) {
			$tag = 'wp_ajax_' . $tag;
		}
		parent::__construct( $plugin, $tag, $callback, $priority, $acceptedArgs );
	}

	/**
	 * Uses {@link wp_send_json_success()} to send a response
	 *
	 * @see wp_send_json_success()
	 * @param mixed $data
	 *
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function sendJSONSuccess($data){
		wp_send_json_success($data);
	}

	/**
	 * Uses {@link wp_send_json_error()} to send a response
	 *
	 * @see wp_send_json_error()
	 * @param mixed $data
	 *
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function sendJSONError($data){
		wp_send_json_error($data);
	}
}