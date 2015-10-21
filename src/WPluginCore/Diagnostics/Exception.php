<?php
/**
 * Project: wp-plugins-core.dev
 * File: Exception.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 28/9/2015
 * Time: 6:41 πμ
 * Since: 0.0.2
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace WPluginCore003\Diagnostics;

use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

/**
 * Class Exception
 *
 * @package WPluginCore003\Diagnostics
 * @author  Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @since   0.0.2
 */
class Exception extends \Exception {
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