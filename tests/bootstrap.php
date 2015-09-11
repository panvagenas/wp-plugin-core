<?php

$_tests_dir = getenv( 'WP_TESTS_DIR' );
if ( ! $_tests_dir ) {
	$_tests_dir = '/tmp/wordpress-tests-lib';
}


if ( ! defined( 'AUTH_KEY' ) ) {
	define( 'AUTH_KEY', '(C4XMfGbE@,AG~C[ Zt%41EzI?</L]QEU~<$fIa|#`N~yYUD^[(&wcwe,DX_K27F' );
}
if ( ! defined( 'SECURE_AUTH_KEY' ) ) {
	define( 'SECURE_AUTH_KEY', '=Mcv1;Gxb-WY5xg;wHE|s^lg%1eUuu+_qExGP{oM@y4caWh~z4&c@6LK@Yb~K_iP' );
}

require_once $_tests_dir . '/includes/functions.php';

function _manually_load_plugin() {
	require_once dirname( dirname( __FILE__ ) ) . '/vendor/autoload.php';

	global $plugin;
	$plugin = new \PanWPCore\Plugin( __NAMESPACE__, __FILE__, 'Pan WP Plugins Core', '0.0.1-dev', 'pan-core', 'pan_core' );
}

tests_add_filter( 'muplugins_loaded', '_manually_load_plugin' );

require $_tests_dir . '/includes/bootstrap.php';
