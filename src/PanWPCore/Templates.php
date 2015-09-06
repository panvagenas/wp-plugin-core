<?php
/**
 * Project: pan-wp-core
 * File: Templates.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 6/9/2015
 * Time: 8:00 πμ
 * Since: TODO ${VERSION}
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace PanWPCore;


class Templates extends Core{
	/**
	 * @param $file
	 *
	 * @return string Empty if file not found, absolute path otherwise
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function findTemplate($file){
		$file = $this->Paths->removeDots($file);

		foreach ( $this->Paths->whereTemplatesMayReside as $dir ) {
			if(file_exists($path = $dir . DIRECTORY_SEPARATOR . $file) && is_readable($path)){
				return $path;
			}
		}

		return '';
	}

	/**
	 * @param            $file
	 * @param array|null $viewData
	 * @param bool|false $echo
	 *
	 * @return string
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function view($file, Array $viewData = null, $echo = false){
		( $viewData ) ? extract( $viewData ) : null;

		ob_start();
		require $this->findTemplate( $file );
		$content = ob_get_clean();
		if ( ! $echo ) {
			return $content;
		}
		echo $content;
	}
}