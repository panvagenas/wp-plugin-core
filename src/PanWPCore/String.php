<?php
/**
 * Created by PhpStorm.
 * User: vagenas
 * Date: 28/8/2015
 * Time: 6:19 μμ
 */

namespace PanWPCore;


class String extends \Stringy\Stringy{
	/**
	 * Alias for $this->__toString
	 * @return string
	 */
	public function toString(){
		return $this->__toString();
	}
}