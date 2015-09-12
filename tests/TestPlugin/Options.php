<?php
/**
 * Project: wp-plugins-core.dev
 * File: Options.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 12/9/2015
 * Time: 9:06 πμ
 * Since: TODO ${VERSION}
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace TestPlugin;


class Options extends \PanWPCore\Options {
	protected $optName = 'TestPluginOptions';
	/**
	 * @var array
	 */
	protected $defaults = array(
		'someName' => - 1
	);
	/**
	 * @var mixed|void
	 */
	protected $options;
	/**
	 * @var array
	 */
	protected $reduxArgs = array();
}