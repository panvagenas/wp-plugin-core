<?php
/**
 * Project: wp-plugins-core.dev
 * File: LoginStyle.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 5/10/2015
 * Time: 9:03 πμ
 * Since: TODO ${VERSION}
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace WPluginCore002\Scripts;

/**
 * Class LoginStyle
 *
 * @package WPluginCore002\Scripts
 * @author  Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @since   TODO ${VERSION}
 */
class LoginStyle extends Style {
	/**
	 * @var array
	 */
	protected $hook = array( 'login_enqueue_scripts' );
}