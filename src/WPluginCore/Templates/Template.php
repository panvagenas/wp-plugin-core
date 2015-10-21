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

/**
 * Class Template
 *
 * @package WPluginCore002\Templates
 * @author  Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @since   TODO ${VERSION}
 */
class Template extends AbsClass {
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

		$templatePath = $this->locate( $templateName );

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

	/**
	 * @param $templateName
	 *
	 * @return string
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function locate( $templateName ) {
		$fileObj  = $this->plugin->getFactory()->file();
		$pathsObj = $this->plugin->getFactory()->paths();

		return $fileObj->locate( $templateName, $pathsObj->getWhereTemplatesMayReside(), 'php', $this->plugin );
	}
}