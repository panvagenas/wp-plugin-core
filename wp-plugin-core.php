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

namespace PanWPCore;

if ( ! defined( 'WPINC' ) ) {
	die;
}
require_once dirname( __FILE__ ) . '/vendor/autoload.php';

$plugin = new Plugin( __NAMESPACE__, __FILE__, 'Pan WP Plugins Core', '0.0.1-dev', 'pan-core', 'pan_core' );