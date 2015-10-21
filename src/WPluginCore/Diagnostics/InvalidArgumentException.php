<?php
/**
 * Project: wp-plugins-core.dev
 * File: InvalidArgumentException.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 28/9/2015
 * Time: 6:58 πμ
 * Since: 0.0.2
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace WPluginCore002\Diagnostics;

use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

class InvalidArgumentException extends \InvalidArgumentException {
	/**
	 * @param string         $message
	 * @param int            $code
	 * @param Exception|null $previous
	 */
	public function __construct( $message = "", $code = 0, Exception $previous = null ) {
		parent::__construct( $message, $code, $previous );

		if ( WP_DEBUG && WP_DEBUG_DISPLAY ) {
			$run     = new Run();
			$handler = new PrettyPageHandler();
			$run->pushHandler( $handler );
			$run->register();
		}
	}
}