<?php
/**
 * Created by PhpStorm.
 * User: vagenas
 * Date: 29/8/2015
 * Time: 10:21 πμ
 */

namespace PanWPCore;


class Dumper extends Core{
	/**
	 * Dumps passed arguments and dies
	 */
	public static function dd(){
		call_user_func_array('dump', func_get_args());
		die;
	}
}