<?php
/**
 * Project: wp-plugins-core.dev
 * File: MultiSelect.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 14/10/2015
 * Time: 10:21 μμ
 * Since: TODO ${VERSION}
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace WPluginCore002\Options\Fields;


/**
 * Class MultiSelect
 *
 * @package WPluginCore002\Options\Fields
 * @author  Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @since   TODO ${VERSION}
 */
class MultiSelect extends Select {
	/**
	 * Flag to set the multi-select variation of the field
	 *
	 * @var bool
	 */
	protected $multi = true;
}