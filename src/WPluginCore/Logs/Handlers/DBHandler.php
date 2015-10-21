<?php
/**
 * Project: wp-plugins-core.dev
 * File: DBHandler.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 5/10/2015
 * Time: 8:47 πμ
 * Since: TODO ${VERSION}
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace WPluginCore002\Logs\Handlers;

use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;

/**
 * Class DBHandler
 *
 * @package WPluginCore002\Logs\Handlers
 * @author  Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @since   TODO ${VERSION}
 */
class DBHandler extends AbstractProcessingHandler {
	/**
	 * @var int
	 */
	private $logName;
	/**
	 * @var array
	 */
	private $logs = array();

	/**
	 * @param int       $logName
	 * @param bool|int  $level
	 * @param bool|true $bubble
	 */
	public function __construct( $logName, $level = Logger::DEBUG, $bubble = true ) {
		$this->logName = $logName;

		$log        = get_option( $this->logName );
		$this->logs = is_array( $log ) ? $log : array();

		parent::__construct( $level, $bubble );
	}

	/**
	 * @param array $record
	 *
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	protected function write( array $record ) {
		/* @var \DateTime $datetime */
		$datetime = $record['datetime'];

		$this->logs[] = array(
			'channel' => $record['channel'],
			'level'   => $record['level'],
			'message' => $record['formatted'],
			'time'    => $datetime->format( 'U' ),
		);
		update_option( $this->logName, $this->logs );
	}
}