<?php
/**
 * Project: wp-plugins-core.dev
 * File: LoginScript.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 5/10/2015
 * Time: 9:01 πμ
 * Since: TODO ${VERSION}
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace WPluginCore002\Scripts;


class LoginScript extends Script {
	protected $hook = array( 'login_enqueue_scripts' );
}