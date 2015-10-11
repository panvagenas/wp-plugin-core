<?php
/**
 * Project: wp-plugins-core.dev
 * File: Paths.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 3/10/2015
 * Time: 5:46 μμ
 * Since: TODO ${VERSION}
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace WPluginCore002\Helpers;


use Stringy\Stringy;
use WPluginCore002\Abs\AbsClass;
use WPluginCore002\Hooks\Filter;
use WPluginCore002\Hooks\HooksFactory;
use WPluginCore002\Plugin\Plugin;

class Paths extends AbsClass {
	/**
	 * @var string
	 */
	protected $pluginBaseDir;
	/**
	 * @var mixed
	 */
	protected $pluginBaseDirRel;
	/**
	 * @var string
	 */
	protected $uploadsBaseDir;
	/**
	 * @var string
	 */
	protected $logFilePath;
	/**
	 * @var string
	 */
	protected $translationsRelDirPath = '/lang';
	/**
	 * @var array
	 */
	protected $whereTemplatesMayReside = array();
	/**
	 * @var array
	 */
	protected $whereStylesMayReside = array();
	/**
	 * @var array
	 */
	protected $whereScriptsMayReside = array();
	/**
	 * @var Filter
	 */
	protected $whereTemplatesMayResideFilter;
	/**
	 * @var Filter
	 */
	protected $whereStylesMayResideFilter;
	/**
	 * @var Filter
	 */
	protected $whereScriptsMayResideFilter;

	/**
	 * @param Plugin $plugin
	 */
	public function __construct( Plugin $plugin ) {
		parent::__construct( $plugin );

		$this->pluginBaseDir = dirname( $plugin->getFilePath() );

		$this->pluginBaseDirRel = preg_replace( '/^' . preg_quote( ABSPATH, '/' ) . '/', '', $this->pluginBaseDir );

		$uploadsData = wp_upload_dir();

		$this->uploadsBaseDir = isset( $uploadsData['basedir'] )
			? $uploadsData['basedir'] . '/' . $plugin->getSlug()
			: $this->pluginBaseDir . '/uploads';

		$logFileName = Stringy::create( $plugin->getName() );

		$this->logFilePath = $this->uploadsBaseDir . '/log/' . (string) $logFileName->camelize() . '.log';

		$templatePluginSlugDir = get_template_directory() . '/' . $plugin->getSlug();

		$hookFactory = new HooksFactory();

		$this->whereTemplatesMayReside       = array(
			$templatePluginSlugDir,
			$this->pluginBaseDir . '/templates',
		);
		$this->whereTemplatesMayResideFilter = $hookFactory->getWhereTemplatesMayResideFilter($plugin);

		$this->whereScriptsMayReside       = array(
			$templatePluginSlugDir . '/js',
			$this->pluginBaseDir . '/assets/js'
		);
		$this->whereScriptsMayResideFilter = $hookFactory->getWhereScriptsMayResideFilter($plugin);

		$this->whereStylesMayReside       = array(
			$templatePluginSlugDir . '/css',
			$this->pluginBaseDir . '/assets/css'
		);
		$this->whereStylesMayResideFilter = $hookFactory->getWhereStylesMayResideFilter($plugin, array());
	}

	/**
	 * @return string
	 */
	public function getPluginBaseDir() {
		return $this->pluginBaseDir;
	}

	/**
	 * @return mixed
	 */
	public function getPluginBaseDirRel() {
		return $this->pluginBaseDirRel;
	}

	/**
	 * @return string
	 */
	public function getUploadsBaseDir() {
		return $this->uploadsBaseDir;
	}

	/**
	 * @return string
	 */
	public function getLogFilePath() {
		return $this->logFilePath;
	}

	/**
	 * @return string
	 */
	public function getTranslationsRelDirPath() {
		return $this->translationsRelDirPath;
	}

	/**
	 * @return array
	 */
	public function getWhereTemplatesMayReside() {
		return $this->whereTemplatesMayResideFilter->apply( $this->whereTemplatesMayReside );
	}

	/**
	 * @return array
	 */
	public function getWhereStylesMayReside() {
		return $this->whereStylesMayResideFilter->apply( $this->whereStylesMayReside );
	}

	/**
	 * @return array
	 */
	public function getWhereScriptsMayReside() {
		return $this->whereScriptsMayResideFilter->apply( $this->whereScriptsMayReside );
	}
}