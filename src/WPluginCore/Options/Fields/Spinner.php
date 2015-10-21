<?php
/**
 * Project: wp-plugins-core.dev
 * File: Spinner.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 14/10/2015
 * Time: 10:05 μμ
 * Since: 0.0.2
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace WPluginCore003\Options\Fields;


use WPluginCore003\Abs\AbsOptionsNumField;

/**
 * Class Spinner
 *
 * @package WPluginCore003\Options\Fields
 * @author  Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @since   0.0.2
 */
class Spinner extends AbsOptionsNumField {
	/**
	 * @var string
	 */
	protected $type = 'spinner';
}