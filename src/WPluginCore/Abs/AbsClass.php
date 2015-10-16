<?php
/**
 * Project: wp-plugins-core.dev
 * File: AbsClass.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 9/10/2015
 * Time: 12:06 πμ
 * Since: TODO ${VERSION}
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace WPluginCore002\Abs;


use WPluginCore002\Plugin\Plugin;

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