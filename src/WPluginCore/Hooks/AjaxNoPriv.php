<?php
/**
 * Project: wp-plugins-core.dev
 * File: AjaxNoPriv.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 25/10/2015
 * Time: 8:00 μμ
 * Since: TODO ${VERSION}
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace WPluginCore003\Hooks;


use WPluginCore003\Plugin\Plugin;

/**
 * Class AjaxNoPriv
 *
 * @package WPluginCore003\Hooks
 * @author  Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @since   TODO ${VERSION}
 */
class AjaxNoPriv extends Ajax{
	/**
	 * @param Plugin $plugin
	 * @param        $tag
	 * @param        $callback
	 * @param int    $priority
	 * @param int    $acceptedArgs
	 */
	public function __construct( Plugin $plugin, $tag, $callback, $priority = 10, $acceptedArgs = 0 ) {
		if ( strpos( $tag, 'wp_ajax' ) !== 0 ) {
			$tag = 'nopriv_' . $tag;
		}
		parent::__construct( $plugin, $tag, $callback, $priority, $acceptedArgs );
	}
}