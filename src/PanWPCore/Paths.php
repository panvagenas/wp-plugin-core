<?php
/**
 * Created by PhpStorm.
 * User: vagenas
 * Date: 29/8/2015
 * Time: 7:10 μμ
 */

namespace PanWPCore;


class Paths extends Core {
	/**
	 * @var string
	 */
	public $pluginBaseDir;
	/**
	 * @var mixed
	 */
	public $pluginBaseDirRel;
	/**
	 * @var string
	 */
	public $uploadsBaseDir;
	/**
	 * @var string
	 */
	public $logFilePath;
	/**
	 * @var string
	 */
	public $translationsRelDirPath = '/lang';
	/**
	 * @var array
	 */
	public $whereTemplatesMayReside = array();
	/**
	 * @var array
	 */
	public $whereStylesMayReside = array();
	/**
	 * @var array
	 */
	public $whereScriptsMayReside = array();

	/**
	 * @param Plugin $plugin
	 */
	public function __construct( Plugin $plugin ) {
		parent::__construct( $plugin );

		$this->pluginBaseDir = dirname( $plugin->getFilePath() );

		$this->pluginBaseDirRel = preg_replace( '/^' . preg_quote( ABSPATH, '/' ) . '/', '', $this->pluginBaseDir );

		$uploadsData = wp_upload_dir();

		$this->uploadsBaseDir = isset( $uploadsData['basedir'] )
			? $uploadsData['basedir']
			: $this->pluginBaseDir . '/uploads';

		$logFileName = String::create( $plugin->getName() );

		$this->logFilePath = $this->uploadsBaseDir . '/' . $logFileName->camelize()->toString() . '.log';

		$templatePluginSlugDir = get_template_directory() . '/' . $this->Plugin->getSlug();

		$this->whereTemplatesMayReside = array(
			$templatePluginSlugDir,
			$this->pluginBaseDir . '/templates',
		);

		$this->whereScriptsMayReside = array(
			$templatePluginSlugDir . '/js',
			$this->pluginBaseDir . '/assets/js'
		);

		$this->whereStylesMayReside = array(
			$templatePluginSlugDir . '/css',
			$this->pluginBaseDir . '/assets/css'
		);
	}

	/**
	 * @param string $file
	 *
	 * @return mixed|string
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function removeDots( $file ) {
		$file = (string) $file;
		$file = str_replace( '../', '', $file );
		$file = trim( $file, '\\/' );
		$file = trim( $file );

		return $file;
	}

	/**
	 * @param string $path
	 *
	 * @return string
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function pluginDirRel( $path = '' ) {
		return $this->pluginBaseDirRel . $path;
	}
}