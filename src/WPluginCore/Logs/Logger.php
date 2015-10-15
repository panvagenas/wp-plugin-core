<?php
/**
 * Project: wp-plugins-core.dev
 * File: Logger.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 5/10/2015
 * Time: 8:39 πμ
 * Since: TODO ${VERSION}
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace WPluginCore002\Logs;


use Monolog\Handler\StreamHandler;
use WPluginCore002\Abs\AbsClass;
use WPluginCore002\Logs\Handlers\DBHandler;
use WPluginCore002\Plugin\Plugin;

class Logger extends AbsClass {
	/**
	 * @var \Monolog\Logger
	 */
	protected $logger;
	/**
	 * @var string
	 */
	protected $logFilePath;

	/**
	 * @param Plugin $plugin
	 */
	public function __construct( Plugin $plugin ) {
		parent::__construct( $plugin );

		$this->logger = new \Monolog\Logger( $plugin->getSlug() );
	}

	/**
	 * @param resource|string $stream
	 * @param integer         $level          The minimum logging level at which this handler will be triggered
	 * @param Boolean         $bubble         Whether the messages that are handled can bubble up the stack or not
	 * @param int|null        $filePermission Optional file permissions (default (0644) are only for owner read/write)
	 * @param Boolean         $useLocking     Try to lock log file before doing any writes
	 */
	public function addFileHandler(
		$stream,
		$level = \Monolog\Logger::DEBUG,
		$bubble = true,
		$filePermission = null,
		$useLocking = false
	) {
		if ( empty( $stream ) ) {
			$stream = $this->logFilePath;
		}
		$this->logger->pushHandler( new StreamHandler( $stream, $level, $bubble, $filePermission, $useLocking ) );
	}

	/**
	 * @param resource $stream
	 * @param integer  $level  The minimum logging level at which this handler will be triggered
	 * @param Boolean  $bubble Whether the messages that are handled can bubble up the stack or not
	 */
	public function addDBHandler( $stream = null, $level = \Monolog\Logger::DEBUG, $bubble = true ) {
		if ( empty( $stream ) ) {
			$stream = new DBHandler( $this->logger->getName() . '_log', $level, $bubble );
		}
		$this->logger->pushHandler( $stream );
	}

	/**
	 * Adds a log record at the DEBUG level.
	 *
	 * @param  string $message The log message
	 * @param  array  $context The log context
	 *
	 * @return Boolean Whether the record has been processed
	 */
	public function addDebug( $message, array $context = array() ) {
		return $this->addRecord( \Monolog\Logger::DEBUG, $message, $context );
	}

	/**
	 * Adds a log record at the INFO level.
	 *
	 * @param  string $message The log message
	 * @param  array  $context The log context
	 *
	 * @return Boolean Whether the record has been processed
	 */
	public function addInfo( $message, array $context = array() ) {
		return $this->addRecord( \Monolog\Logger::INFO, $message, $context );
	}

	/**
	 * Adds a log record at the NOTICE level.
	 *
	 * @param  string $message The log message
	 * @param  array  $context The log context
	 *
	 * @return Boolean Whether the record has been processed
	 */
	public function addNotice( $message, array $context = array() ) {
		return $this->addRecord( \Monolog\Logger::NOTICE, $message, $context );
	}

	/**
	 * Adds a log record at the WARNING level.
	 *
	 * @param  string $message The log message
	 * @param  array  $context The log context
	 *
	 * @return Boolean Whether the record has been processed
	 */
	public function addWarning( $message, array $context = array() ) {
		return $this->addRecord( \Monolog\Logger::WARNING, $message, $context );
	}

	/**
	 * Adds a log record at the ERROR level.
	 *
	 * @param  string $message The log message
	 * @param  array  $context The log context
	 *
	 * @return Boolean Whether the record has been processed
	 */
	public function addError( $message, array $context = array() ) {
		return $this->addRecord( \Monolog\Logger::ERROR, $message, $context );
	}

	/**
	 * Adds a log record at the CRITICAL level.
	 *
	 * @param  string $message The log message
	 * @param  array  $context The log context
	 *
	 * @return Boolean Whether the record has been processed
	 */
	public function addCritical( $message, array $context = array() ) {
		return $this->addRecord( \Monolog\Logger::CRITICAL, $message, $context );
	}

	/**
	 * Adds a log record at the ALERT level.
	 *
	 * @param  string $message The log message
	 * @param  array  $context The log context
	 *
	 * @return Boolean Whether the record has been processed
	 */
	public function addAlert( $message, array $context = array() ) {
		return $this->addRecord( \Monolog\Logger::ALERT, $message, $context );
	}

	/**
	 * Adds a log record at the EMERGENCY level.
	 *
	 * @param  string $message The log message
	 * @param  array  $context The log context
	 *
	 * @return Boolean Whether the record has been processed
	 */
	public function addEmergency( $message, array $context = array() ) {
		return $this->addRecord( \Monolog\Logger::EMERGENCY, $message, $context );
	}

	/**
	 * Adds a log record.
	 *
	 * @param  integer $level   The logging level
	 * @param  string  $message The log message
	 * @param  array   $context The log context
	 *
	 * @return Boolean Whether the record has been processed
	 */
	public function addRecord( $level, $message, array $context = array() ) {
		return $this->logger->addRecord( $level, $message, $context );
	}
}