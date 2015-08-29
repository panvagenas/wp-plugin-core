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

$redux = new \PanWPCore\Redux( $plugin, [ ] );
$redux->addSection( 'A section', 'a-section' );
$redux->addField( 'a-section', [
	'id'       => 'opt-checkbox',
	'type'     => 'checkbox',
	'title'    => __( 'Checkbox Option', 'redux-framework-demo' ),
	'subtitle' => __( 'No validation can be done on this field type', 'redux-framework-demo' ),
	'desc'     => __( 'This is the description field, again good for additional info.', 'redux-framework-demo' ),
	'default'  => '1'// 1 = on | 0 = off
] );

$redux->addField( 'a-section', [
	'id'       => 'opt-checkbox2',
	'type'     => 'checkbox',
	'title'    => __( 'Checkbox Option 2', 'redux-framework-demo' ),
	'subtitle' => __( 'No validation can be done on this field type', 'redux-framework-demo' ),
	'desc'     => __( 'This is the description field, again good for additional info.', 'redux-framework-demo' ),
	'default'  => '1'// 1 = on | 0 = off
] );

