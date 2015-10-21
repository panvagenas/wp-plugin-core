<?php
/**
 * Project: wp-plugins-core.dev
 * File: SubMenuPage.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 14/10/2015
 * Time: 10:49 πμ
 * Since: 0.0.2
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace WPluginCore002\Options\MenuPages;


use WPluginCore002\Abs\AbsOptionsPage;
use WPluginCore002\Plugin\Plugin;

/**
 * Class SubMenuPage
 *
 * @package WPluginCore002\Options\MenuPages
 * @author  Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @since   0.0.2
 */
class SubMenuPage extends AbsOptionsPage {
	/**
	 * @param Plugin $plugin
	 * @param string $pageParent
	 */
	public function __construct( Plugin $plugin, $pageParent = 'options-general.php' ) {
		parent::__construct( $plugin, 'submenu' );
		$this->page_parent = $pageParent;
	}
}