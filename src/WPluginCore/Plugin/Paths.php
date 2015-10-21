<?php
/**
 * Project: wp-plugins-core.dev
 * File: Paths.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 3/10/2015
 * Time: 5:46 μμ
 * Since: 0.0.2
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace WPluginCore002\Plugin;


use Stringy\Stringy;
use WPluginCore002\Abs\AbsClass;
use WPluginCore002\Diagnostics\Exception;
use WPluginCore002\Hooks\Filter;
use WPluginCore002\Hooks\HooksFactory;

/**
 * Class Paths
 *
 * @package WPluginCore002\Plugin
 * @author  Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @since   0.0.2
 */
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

		/* @var HooksFactory $hookFactory */
		$hookFactory = $this->plugin->getHookFactory();

		$this->whereTemplatesMayReside       = array(
			$templatePluginSlugDir,
			$this->pluginBaseDir . '/templates',
		);
		$this->whereTemplatesMayResideFilter = $hookFactory->getWhereTemplatesMayResideFilter( $plugin );

		$this->whereScriptsMayReside       = array(
			$templatePluginSlugDir . '/js',
			$this->pluginBaseDir . '/assets/js'
		);
		$this->whereScriptsMayResideFilter = $hookFactory->getWhereScriptsMayResideFilter( $plugin );

		$this->whereStylesMayReside       = array(
			$templatePluginSlugDir . '/css',
			$this->pluginBaseDir . '/assets/css'
		);
		$this->whereStylesMayResideFilter = $hookFactory->getWhereStylesMayResideFilter( $plugin, array() );
	}

	/**
	 * @param string $path
	 * @param string $under
	 *
	 * @return bool
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public function verifyPathIsUnder( $path, $under = ABSPATH ) {
		$path  = self::truePath( (string) $path, true );
		$under = self::truePath( (string) $under, true );

		return $path && $under && strpos( $path, $under ) === 0;
	}

	/**
	 * @param string $path
	 * @param bool   $allowFailure
	 *
	 * @return string
	 * @throws Exception
	 * @static
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public static function truePath( $path, $allowFailure = false ) {
		$path = trim( $path );
		// whether $path is unix or not
		$uniPath = strlen( $path ) == 0 || $path{0} != '/';

		$unc = substr( $path, 0, 2 ) == '\\\\' ? true : false;

		// attempts to detect if path is relative in which case, add cwd
		if ( strpos( $path, ':' ) === false && $uniPath && ! $unc ) {
			$path = getcwd() . DIRECTORY_SEPARATOR . $path;
			if ( $path{0} == '/' ) {
				$uniPath = false;
			}
		}

		// resolve path parts (single dot, double dot and double delimiters)
		$path = str_replace( array( '/', '\\' ), DIRECTORY_SEPARATOR, $path );

		$pre = '';
		if ( strpos( $path, '://' ) !== false ) {
			$pre        = substr( $path, 0, strpos( $path, '://' ) + 3 );
			$subPathSuf = substr( $path, strpos( $path, '://' ) + 3 );
			$path       = '/' . preg_replace( '#/+#', DIRECTORY_SEPARATOR, $subPathSuf );
		} else {
			$path = preg_replace( '#/+#', DIRECTORY_SEPARATOR, $path );
		}

		if ( $path === null ) {
			if ( $allowFailure ) {
				return '';
			} else {
				throw new Exception( 'Unresolved path' );
			}
		}

		$parts     = array_filter( explode( DIRECTORY_SEPARATOR, $path ), 'strlen' );
		$absolutes = array();

		foreach ( $parts as $i => $part ) {
			if ( '.' == $part ) {
				continue;
			}
			if ( '..' == $part ) {
				if ( array_pop( $absolutes ) === null ) {
					$slice = array_slice( $parts, $i );
					array_unshift( $slice, '../' );

					return self::truePath( implode( DIRECTORY_SEPARATOR, $slice ) );
				}
			} else {
				$absolutes[] = $part;
			}
		}

		$path = implode( DIRECTORY_SEPARATOR, $absolutes );

		if ( $pre ) {
			$path = $pre . $path;
		}

		// put initial separator that could have been lost
		$path = ! $uniPath ? '/' . $path : $path;
		$path = $unc ? '\\\\' . $path : $path;

		// resolve any symlinks
		if ( function_exists( 'readlink' ) && file_exists( $path ) && is_link( $path ) && linkinfo( $path ) > 0 ) {
			$path = readlink( $path );
			if ( $path === false ) {
				if ( $allowFailure ) {
					return '';
				} else {
					throw new Exception( 'Unresolved path' );
				}
			}
		}

		return $path;
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