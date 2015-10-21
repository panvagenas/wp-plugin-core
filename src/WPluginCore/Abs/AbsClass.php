<?php
/**
 * Project: wp-plugins-core.dev
 * File: AbsClass.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 9/10/2015
 * Time: 12:06 πμ
 * Since: 0.0.2
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace WPluginCore003\Abs;


use WPluginCore003\Plugin\Plugin;

/**
 * Class AbsClass
 *
 * @package WPluginCore003\Abs
 * @author  Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @since   0.0.2
 */
abstract class AbsClass {
	/**
	 * @var Plugin
	 */
	protected $plugin;

	/**
	 * @param Plugin $plugin
	 */
	public function __construct( Plugin $plugin ) {
		$this->plugin = $plugin;
	}

	/**
	 * @return Plugin
	 */
	public function getPlugin() {
		return $this->plugin;
	}
}