<?php
/**
 * Project: wp-plugins-core.dev
 * File: AdminScript.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 5/10/2015
 * Time: 9:03 πμ
 * Since: TODO ${VERSION}
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace WPluginCore002\Scripts;


class AdminScript extends Script{
	protected $hook = array('admin_enqueue_scripts');
}