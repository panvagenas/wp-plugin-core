<?php
/**
 * Project: wp-plugins-core.dev
 * File: Factory.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 2/10/2015
 * Time: 9:49 πμ
 * Since: 0.0.2
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace WPluginCore003;


use WPluginCore003\Abs\AbsFactory;
use WPluginCore003\Diagnostics\Exception;
use WPluginCore003\Helpers\FcrHelpers;
use WPluginCore003\Hooks\FcrHooks;
use WPluginCore003\Options\FcrOptions;
use WPluginCore003\Plugin\FcrPlugin;
use WPluginCore003\Scripts\FcrScripts;

/**
 * Class Factory
 *
 * @package WPluginCore003
 * @author  Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @since   0.0.2
 */
class Factory extends AbsFactory {
	/**
	 * @return FcrHooks
	 * @throws Exception
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public final function fcrHooks() {
		return $this->createOrGet( 'Hooks\\FcrHooks' );
	}

	/**
	 * @return FcrOptions
	 * @throws Exception
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public final function fcrOptions() {
		return $this->createOrGet( 'Options\\FcrOptions' );
	}

	/**
	 * @return FcrScripts
	 * @throws Exception
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public final function fcrScripts() {
		return $this->createOrGet( 'Scripts\\FcrScripts' );
	}

	/**
	 * @return FcrPlugin
	 * @throws Exception
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public final function fcrPlugin(){
		return $this->createOrGet( 'Plugin\\FcrPlugin' );
	}

	/**
	 * @return FcrHelpers
	 * @throws Exception
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function fcrHelpers(){
		return $this->createOrGet('Helpers\\FcrHelpers');
	}
}