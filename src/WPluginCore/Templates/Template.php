<?php
/**
 * Project: wp-plugins-core.dev
 * File: Template.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 16/10/2015
 * Time: 2:07 μμ
 * Since: TODO ${VERSION}
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace WPluginCore002\Templates;


use WPluginCore002\Abs\AbsClass;
use WPluginCore002\Plugin\Paths;

/**
 * Class Template
 *
 * @package WPluginCore002\Templates
 * @author  Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @since   TODO ${VERSION}
 */
class Template extends AbsClass {
	/**
	 * @param $templateName
	 *
	 * @return string
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function locateTemplate( $templateName ) {
		$file = Paths::truePath( $templateName );

		if ( ! preg_match( '/.*\.php$/', $file ) ) {
			$file .= '.php';
		}

		$pathsObj = $this->plugin->getFactory()->paths();

		foreach ( $pathsObj->getWhereTemplatesMayReside() as $k => $path ) {
			$templatePath = Paths::truePath( $path . $file, true );

			if ( ! $templatePath ) {
				continue;
			}

			if (
				$pathsObj->verifyPathIsUnder( $templatePath, $path )
				&& file_exists( $templatePath )
				&& is_readable( $templatePath )
			) {
				return $templatePath;
			}
		}

		return '';
	}

	/**
	 * @param string $templateName
	 * @param array  $viewData
	 * @param bool   $echo
	 *
	 * @return string
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function view( $templateName, $viewData = array(), $echo = false ) {
		$viewData && extract( $viewData );

		$templatePath = $this->locateTemplate( $templateName );

		$content = '';
		if ( $templatePath ) {
			ob_start();
			require $templatePath;
			$content = ob_get_clean();
		}

		if ( $echo ) {
			echo $content;
		}

		return $content;
	}
}