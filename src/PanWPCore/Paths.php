<?php
/**
 * Created by PhpStorm.
 * User: vagenas
 * Date: 29/8/2015
 * Time: 7:10 μμ
 */

namespace PanWPCore;


class Paths {
	public $pluginBaseDir;
	public $uploadsBaseDir;
	public $logFilePath;

	/**
	 * @param Plugin $plugin
	 */
	public function __construct( Plugin $plugin ) {
		$this->pluginBaseDir = dirname( $plugin->getFilePath() );

		$uploadsData = wp_upload_dir();

		$this->uploadsBaseDir = isset( $uploadsData['basedir'] )
			? $uploadsData['basedir']
			: $this->pluginBaseDir . '/uploads';

		$logFileName = String::create( $plugin->getName() );

		$this->logFilePath = $this->uploadsBaseDir . '/' . $logFileName->camelize()->toString() . '.log';
	}
}