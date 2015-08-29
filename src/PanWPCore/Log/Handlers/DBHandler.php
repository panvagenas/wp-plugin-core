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
use PanWPCore\Plugin;

class DBHandler extends AbstractProcessingHandler {
	private $statement;
	private $logName;
	private $logs = [ ];

	public function __construct( $logName, $level = Logger::DEBUG, $bubble = true ) {
		$this->logName = $logName;
		$this->logs    = (array) get_option( $this->logName );
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