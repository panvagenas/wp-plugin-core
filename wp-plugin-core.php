<?php
/**
 * Plugin Name:     Pan WP Plugins Core
 * Plugin URI:      http://plugin-name.com/ // TODO
 * Description:     Pan WordPress Plugins Core
 * Version:         0.0.1-dev
 * Author:          Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Author URI:      http://gr.linkedin.com/in/panvagenas
 * Text Domain:     pan-core
 * Domain Path:     /lang
 * License:         GPL-3.0+
 */

namespace WPluginCore;

if ( ! defined( 'WPINC' ) ) {
	die;
}
require_once dirname( __FILE__ ) . '/vendor/autoload.php';

class Plugin extends \WPluginCore002\Plugin\Plugin {
}

new Plugin( 'Pan WP Plugins Core', '0.0.1-dev', __FILE__ );