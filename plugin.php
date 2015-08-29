<?php

/**
 * @wordpress-plugin
 * Plugin Name:     Pan WordPress Plugin Core
 * Plugin URI:      http://plugin-name.com/
 * Description:     Pan WordPress Plugin Core for developing WordPress plugins.
 * Version:         0.0.1-dev
 * Author:          Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Author URI:      http://gr.linkedin.com/in/panvagenas
 * Text Domain:     pan-core
 * Domain Path:     /lang
 * License:         GPL-3.0+
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

require_once __DIR__ . '/vendor/autoload.php';

$plugin = new \PanWPCore\Plugin( __FILE__, 'Pan WordPress Plugin Core', '0.0.1-dev', 'pan-core', 'pan.core' );