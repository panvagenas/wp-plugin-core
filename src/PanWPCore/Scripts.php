<?php
/**
 * Project: pan-wp-core
 * File: Scripts.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 6/9/2015
 * Time: 8:25 πμ
 * Since: TODO ${VERSION}
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace PanWPCore;


class Scripts extends Core{
	/**
	 * @param $file
	 *
	 * @return string
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function findScriptFile($file){
		$file = $this->Paths->removeDots($file);

		foreach ( $this->Paths->whereScriptsMayReside as $dir ) {
			if(file_exists($path = $dir . DIRECTORY_SEPARATOR . $file) && is_readable($path)){
				return $path;
			}
		}

		return '';
	}

	/**
	 * @param $file
	 *
	 * @return string
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function findStyleFile($file){
		$file = $this->Paths->removeDots($file);

		foreach ( $this->Paths->whereStylesMayReside as $dir ) {
			if(file_exists($path = $dir . DIRECTORY_SEPARATOR . $file) && is_readable($path)){
				return $path;
			}
		}

		return '';
	}

	/**
	 * @param            $handle
	 * @param            $src
	 * @param array      $deps
	 * @param bool|false $ver
	 * @param string     $media
	 *
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function registerStyle($handle, $src, $deps = array(), $ver = false, $media = 'all'){
		if(!$ver){
			$ver = $this->Plugin->getVersion();
		}
		wp_register_style($handle, $src, $deps, $ver, $media);
	}

	/**
	 * @param            $handle
	 * @param            $src
	 * @param array      $deps
	 * @param bool|false $ver
	 * @param bool|false $inFooter
	 *
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function registerScript($handle, $src, $deps = array(), $ver = false, $inFooter = false){
		if(!$ver){
			$ver = $this->Plugin->getVersion();
		}
		wp_register_script($handle, $src, $deps, $ver, $inFooter);
	}

	/**
	 * @param $handle
	 *
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function enqueueStyle($handle){
		if(!wp_style_is($handle, 'enqueued') && wp_style_is($handle, 'registered')){
			wp_enqueue_style($handle);
		}
	}

	/**
	 * @param $handle
	 *
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function enqueueScript($handle){
		if(!wp_script_is($handle, 'enqueued') && wp_script_is($handle, 'registered')){
			wp_enqueue_script($handle);
		}
	}

	/**
	 * @param string $baseHandle
	 *
	 * @return string
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function getScriptHandle($baseHandle){
		return $this->Plugin->getSlug() . $baseHandle;
	}

	/**
	 * @param string $fileAbsPath
	 *
	 * @return string
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function getUrl($fileAbsPath){
		return get_home_url() . '/' . str_replace(ABSPATH, '', $fileAbsPath);
	}
}