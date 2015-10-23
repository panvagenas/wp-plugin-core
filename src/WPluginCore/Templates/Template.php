<?php
/**
 * Project: wp-plugins-core.dev
 * File: Template.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 16/10/2015
 * Time: 2:07 μμ
 * Since: 0.0.2
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace WPluginCore003\Templates;


use WPluginCore003\Abs\AbsClass;

/**
 * Class Template
 *
 * @package WPluginCore003\Templates
 * @author  Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @since   0.0.2
 */
class Template extends AbsClass {
	/**
	 * @param string $templateName
	 * @param array  $viewData
	 * @param bool   $echo
	 *
	 * @return string
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
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
	 * @since  0.0.2
	 */
	public function locate( $templateName ) {
		$fileObj  = $this->plugin->getFactory()->fcrHelpers()->file();
		$pathsObj = $this->plugin->getFactory()->fcrPlugin()->paths();

		return $fileObj->locate( $templateName, $pathsObj->getWhereTemplatesMayReside(), 'php', $this->plugin );
	}
}