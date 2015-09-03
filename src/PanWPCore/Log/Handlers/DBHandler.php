<?php
/**
 * Created by PhpStorm.
 * User: vagenas
 * Date: 29/8/2015
 * Time: 7:53 μμ
 */

namespace PanWPCore\Log\Handlers;


use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;

class DBHandler extends AbstractProcessingHandler {
	private $logName;
	private $logs = array();

	public function __construct( $logName, $level = Logger::DEBUG, $bubble = true ) {
		$this->logName = $logName;

		$log        = get_option( $this->logName );
		$this->logs = is_array( $log ) ? $log : array();

		parent::__construct( $level, $bubble );
	}

	protected function write( array $record ) {
		$this->logs[] = array(
			'channel' => $record['channel'],
			'level'   => $record['level'],
			'message' => $record['formatted'],
			'time'    => $record['datetime']->format( 'U' ),
		);
		update_option( $this->logName, $this->logs );
	}
}