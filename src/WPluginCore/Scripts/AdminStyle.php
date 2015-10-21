<?php
/**
 * Project: wp-plugins-core.dev
 * File: AdminStyle.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 5/10/2015
 * Time: 9:04 πμ
 * Since: 0.0.2
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace WPluginCore003\Scripts;


/**
 * Class AdminStyle
 *
 * @package WPluginCore003\Scripts
 * @author  Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @since   0.0.2
 */
class AdminStyle extends Style {
	/**
	 * @var array
	 */
	protected $hook = array( 'admin_enqueue_scripts' );
}