<?php
/**
 * Project: wp-plugins-core.dev
 * File: MenuPage.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 14/10/2015
 * Time: 10:47 πμ
 * Since: 0.0.2
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace WPluginCore003\Options\MenuPages;


use WPluginCore003\Abs\AbsOptionsPage;
use WPluginCore003\Plugin\Plugin;

/**
 * Class MenuPage
 *
 * @package WPluginCore003\Options\MenuPages
 * @author  Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @since   0.0.2
 */
class MenuPage extends AbsOptionsPage {
	/**
	 * @param Plugin $plugin
	 */
	public function __construct( Plugin $plugin ) {
		parent::__construct( $plugin, 'menu' );
	}
}