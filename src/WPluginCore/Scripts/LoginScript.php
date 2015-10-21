<?php
/**
 * Project: wp-plugins-core.dev
 * File: LoginScript.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 5/10/2015
 * Time: 9:01 πμ
 * Since: 0.0.2
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace WPluginCore002\Scripts;


/**
 * Class LoginScript
 *
 * @package WPluginCore002\Scripts
 * @author  Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @since   0.0.2
 */
class LoginScript extends Script {
	/**
	 * @var array
	 */
	protected $hook = array( 'login_enqueue_scripts' );
}