<?php
/**
 * Project: wp-plugins-core.dev
 * File: AdminScript.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 5/10/2015
 * Time: 9:03 πμ
 * Since: 0.0.2
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace WPluginCore003\Scripts;


/**
 * Class AdminScript
 *
 * @package WPluginCore003\Scripts
 * @author  Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @since   0.0.2
 */
class AdminScript extends Script {
	/**
	 * @var array
	 */
	protected $hook = array( 'admin_enqueue_scripts' );
}