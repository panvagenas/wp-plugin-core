<?php
/**
 * Project: wp-plugins-core.dev
 * File: AdminStyle.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 5/10/2015
 * Time: 9:04 πμ
 * Since: TODO ${VERSION}
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace WPluginCore002\Scripts;


/**
 * Class AdminStyle
 *
 * @package WPluginCore002\Scripts
 * @author  Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @since   TODO ${VERSION}
 */
class AdminStyle extends Style {
	/**
	 * @var array
	 */
	protected $hook = array( 'admin_enqueue_scripts' );
}