<?php
/**
 * Project: wp-plugins-core.dev
 * File: Random.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 14/10/2015
 * Time: 3:23 μμ
 * Since: 0.0.2
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace WPluginCore002\Helpers;


use RandomLib\Factory;
use RandomLib\Generator;
use SecurityLib\Strength;

/**
 * Class Random
 *
 * @package WPluginCore002\Helpers
 * @author  Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @since   0.0.2
 */
class Random {
	/**
	 * This represents Non-Cryptographic strengths.  It should not be used any time
	 * that security or confidentiality is at stake
	 */
	const VERYLOW_STRENGTH = 1;

	/**
	 * This represents the bottom line of Cryptographic strengths.  It may be used
	 * for low security uses where some strength is required.
	 */
	const LOW_STRENGTH = 3;

	/**
	 * This is the general purpose Cryptographical strength.  It should be suitable
	 * for all uses except the most sensitive.
	 */
	const MEDIUM_STRENGTH = 5;

	/**
	 * This is the highest strength available.  It should not be used unless the
	 * high strength is needed, due to hardware constraints (and entropy
	 * limitations).
	 */
	const HIGH_STRENGTH = 7;

	/**
	 * @const Flag for uppercase letters
	 */
	const CHAR_UPPER = 1;

	/**
	 * @const Flag for lowercase letters
	 */
	const CHAR_LOWER = 2;

	/**
	 * @const Flag for alpha characters (combines UPPER + LOWER)
	 */
	const CHAR_ALPHA = 3; // CHAR_UPPER | CHAR_LOWER

	/**
	 * @const Flag for digits
	 */
	const CHAR_DIGITS = 4;

	/**
	 * @const Flag for alpha numeric characters
	 */
	const CHAR_ALNUM = 7; // CHAR_ALPHA | CHAR_DIGITS

	/**
	 * @const Flag for uppercase hexadecimal symbols
	 */
	const CHAR_UPPER_HEX = 12; // 8 | CHAR_DIGITS

	/**
	 * @const Flag for lowercase hexidecimal symbols
	 */
	const CHAR_LOWER_HEX = 20; // 16 | CHAR_DIGITS

	/**
	 * @const Flag for base64 symbols
	 */
	const CHAR_BASE64 = 39; // 32 | CHAR_ALNUM

	/**
	 * @const Flag for additional symbols accessible via the keyboard
	 */
	const CHAR_SYMBOLS = 64;

	/**
	 * @const Flag for brackets
	 */
	const CHAR_BRACKETS = 128;

	/**
	 * @const Flag for punctuation marks
	 */
	const CHAR_PUNCT = 256;

	/**
	 * @const Flag for upper/lower-case and digits but without "B8G6I1l|0OQDS5Z2"
	 */
	const EASY_TO_READ = 512;

	/**
	 * @param int $length
	 * @param int $chars
	 *
	 * @return string
	 * @static * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public static function lowStrengthRandomString( $length, $chars = self::CHAR_ALPHA ) {
		return self::randomString( $length, $chars, self::LOW_STRENGTH );
	}

	/**
	 * @param $length
	 * @param $chars
	 * @param $strength
	 *
	 * @return string
	 * @static * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	public static function randomString( $length, $chars, $strength ) {
		return self::getRandomGenerator( $strength )->generateString( $length, $chars );
	}

	/**
	 * @param int|Strength $strength
	 *
	 * @return Generator
	 * @static * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	protected static function getRandomGenerator( $strength ) {
		$factory = new Factory();

		if ( is_integer( $strength ) ) {
			$strength = new Strength( $strength );
		}

		return $factory->getGenerator( new Strength( $strength ) );
	}

	/**
	 * @return Strength
	 * @static * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	protected static function lowStrength() {
		return new Strength( self::LOW_STRENGTH );
	}

	/**
	 * @return Strength
	 * @static * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	protected static function medStrength() {
		return new Strength( self::MEDIUM_STRENGTH );
	}

	/**
	 * @return Strength
	 * @static * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  0.0.2
	 */
	protected static function highStrength() {
		return new Strength( self::HIGH_STRENGTH );
	}
}