<?php
/**
 * Project: wp-plugins-core.dev
 * File: URL.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 27/10/2015
 * Time: 8:38 πμ
 * Since: TODO ${VERSION}
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace WPluginCore003\Helpers;

use WPluginCore003\Abs\AbsPluginSingleton;
use WPluginCore003\Diagnostics\Exception;

class URL extends AbsPluginSingleton {
	/**
	 * Regex matches a `scheme://`
	 */
	const REGEX_FRAG_SCHEME = '(?:[a-zA-Z0-9]+\:)?\/\/';
	/**
	 * Regex matches a `host` name (TLD optional)
	 */
	const REGEX_FRAG_HOST = '[a-zA-Z0-9]+(?:\-*[a-zA-Z0-9]+)*(?:\.[a-zA-Z0-9]+(?:\-*[a-zA-Z0-9]+)*)*(?:\.[a-zA-Z][a-zA-Z0-9]+)?';
	/**
	 * Regex matches a `host:port` (`:port`, TLD are optional)
	 */
	const REGEX_FRAG_HOST_PORT = '[a-zA-Z0-9]+(?:\-*[a-zA-Z0-9]+)*(?:\.[a-zA-Z0-9]+(?:\-*[a-zA-Z0-9]+)*)*(?:\.[a-zA-Z][a-zA-Z0-9]+)?(?:\:[0-9]+)?';
	/**
	 * Regex matches a `user:pass@host:port` (`user:pass@`, `:port`, TLD are optional)
	 */
	const REGEX_FRAG_USER_HOST_PORT = '(?:[a-zA-Z0-9\-_.~+%]+(?:\:[a-zA-Z0-9\-_.~+%]+)?@)?[a-zA-Z0-9]+(?:\-*[a-zA-Z0-9]+)*(?:\.[a-zA-Z0-9]+(?:\-*[a-zA-Z0-9]+)*)*(?:\.[a-zA-Z][a-zA-Z0-9]+)?(?:\:[0-9]+)?';
	/**
	 * Regex matches a valid `scheme://user:pass@host:port/path/?query#fragment` URL (`scheme:`, `user:pass@`, `:port`,
	 * `TLD`, `path`, `query` and `fragment` are optional)
	 */
	const REGEX_VALID_URL = '/^(?:[a-zA-Z0-9]+\:)?\/\/(?:[a-zA-Z0-9\-_.~+%]+(?:\:[a-zA-Z0-9\-_.~+%]+)?@)?[a-zA-Z0-9]+(?:\-*[a-zA-Z0-9]+)*(?:\.[a-zA-Z0-9]+(?:\-*[a-zA-Z0-9]+)*)*(?:\.[a-zA-Z][a-zA-Z0-9]+)?(?:\:[0-9]+)?(?:\/(?!\/)[a-zA-Z0-9\-_.~+%]*)*(?:\?(?:[a-zA-Z0-9\-_.~+%]+(?:\=[a-zA-Z0-9\-_.~+%&]*)?)*)?(?:#[^\s]*)?$/';

	# -----------------------------------------------------------------------------------------------------------------------------
	# URL parts/components bitmask
	# -----------------------------------------------------------------------------------------------------------------------------
	/**
	 * @var integer Indicates scheme component in a URL.
	 */
	const url_scheme = 1;

	/**
	 * @var integer Indicates user component in a URL.
	 */
	const url_user = 2;

	/**
	 * @var integer Indicates pass component in a URL.
	 */
	const url_pass = 4;

	/**
	 * @var integer Indicates host component in a URL.
	 */
	const url_host = 8;

	/**
	 * @var integer Indicates port component in a URL.
	 */
	const url_port = 16;

	/**
	 * @var integer Indicates path component in a URL.
	 */
	const url_path = 32;

	/**
	 * @var integer Indicates query component in a URL.
	 */
	const url_query = 64;

	/**
	 * @var integer Indicates fragment component in a URL.
	 */
	const url_fragment = 128;

	/**
	 * Regex matches page on the end of a path
	 *
	 * @return string
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function regexWpPaginationPage() {
		return '/(?P<page>\/' . preg_quote(
			$GLOBALS['wp_rewrite']->pagination_base,
			'/'
		) . '\/(?P<page_number>[0-9]+)\/?)(?=[?#]|$)/';
	}

	/**
	 * Gets the current URL (via environment variables)
	 *
	 * @param string $scheme Optional. A scheme to force. (i.e. `https`, `http`).
	 *                       Use `//` to force a cross-protocol compatible scheme.
	 *
	 * @return string The current URL
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function current( $scheme = '' ) {
		if ( isset( $this->static[__FUNCTION__][$scheme] ) ) {
			return $this->static[__FUNCTION__][$scheme];
		}

		$this->static[__FUNCTION__][$scheme] = $this->currentScheme()
		                                       . '://' . $this->currentHost()
		                                       . $this->currentUri();

		if ( $scheme ) {
			$this->static[__FUNCTION__][$scheme] = $this->setScheme(
				$this->static[__FUNCTION__][$scheme],
				$scheme
			);
		}

		return $this->static[__FUNCTION__][$scheme];
	}

	/**
	 * Gets the current scheme (via environment variables)
	 *
	 * @return string The current scheme
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function currentScheme() {
		if ( isset( $this->static[__FUNCTION__] ) ) {
			return $this->static[__FUNCTION__];
		}

		$scheme = $this->plugin->getFactory()->fcrHelpers()->vars()->SERVER( 'REQUEST_SCHEME' );

		if ( !empty( $scheme ) ) {
			$this->static[__FUNCTION__] = $this->normScheme( $scheme );
		} else {
			$this->static[__FUNCTION__] = ( is_ssl() ) ? 'https' : 'http';
		}

		return $this->static[__FUNCTION__];
	}

	/**
	 * Gets the current host name (via environment variables)
	 *
	 * @return string The current host name, else an exception is thrown on failure
	 *
	 * @throws Exception If unable to determine the current host name
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function currentHost() {
		if ( isset( $this->static[__FUNCTION__] ) ) {
			return $this->static[__FUNCTION__];
		}

		$host = $this->plugin->getFactory()->fcrHelpers()->vars()->SERVER( 'HTTP_HOST' );

		if ( empty( $host ) ) {
			throw new Exception( 'Missing required `$_SERVER[\'HTTP_HOST\']`.' );
		}

		return ( $this->static[__FUNCTION__] = $host );
	}

	/**
	 * Gets the current URI (via environment variables).
	 *
	 * @return string The current URI, else an exception is thrown on failure.
	 * @throws Exception If unable to determine the current URI
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function currentUri() {
		if ( isset( $this->static[__FUNCTION__] ) ) {
			return $this->static[__FUNCTION__];
		}

		if ( is_string( $uri = $this->plugin->getFactory()->fcrHelpers()->vars()->SERVER( 'REQUEST_URI' ) ) ) {
			$uri = $this->parseUri( $uri );
		}

		if ( empty( $uri ) ) {
			throw new Exception( 'Missing required `$_SERVER[\'REQUEST_URI\']`.' );
		}

		return ( $this->static[__FUNCTION__] = $uri );
	}

	/**
	 * Parses a URI from a URL (or a URI/query/fragment only)
	 *
	 * @param string    $url_uri_query_fragment A full URL; or a partial URI;
	 *                                          or only a query string, or only a fragment. Any of these can be parsed
	 *                                          here
	 * @param null      $normalize              bitmask. Defaults to NULL (indicating a default bitmask).
	 *                                          Defaults include: {@link fw_constants::url_scheme}, {@link
	 *                                          fw_constants::url_host}, {@link fw_constants::url_path}. However, we DO
	 *                                          allow a trailing slash (even if path is being normalized by this
	 *                                          parameter).
	 * @param bool|true $include_fragment       Defaults to TRUE. Include a possible fragment?
	 *
	 * @return string|null A URI (i.e. a URL path), else NULL on any type of failure.
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function parseUri( $url_uri_query_fragment, $normalize = null, $include_fragment = true ) {
		if ( ( $parts = $this->parseUriParts( $url_uri_query_fragment, $normalize ) ) ) {
			if ( !$include_fragment ) {// Ditch fragment?
				unset( $parts['fragment'] );
			}

			return $this->unParse( $parts, $normalize );
		}

		return null; // Default return value.
	}

	/**
	 * Parses URI parts from a URL (or a URI/query/fragment only)
	 *
	 * @param string       $url_uri_query_fragment A full URL; or a partial URI;
	 *                                             or only a query string, or only a fragment. Any of these can be
	 *                                             parsed here.
	 * @param null|integer $normalize              A bitmask. Defaults to NULL (indicating a default bitmask).
	 *                                             Defaults include: {@link fw_constants::url_scheme}, {@link
	 *                                             fw_constants::url_host}, {@link fw_constants::url_path}. However, we
	 *                                             DO allow a trailing slash (even if path is being normalized by this
	 *                                             parameter).
	 *
	 * @return array|null An array with the following components, else NULL on any type of failure.
	 * <ul>
	 *    <li>`path`(string) Possible URI path.</li>
	 *    <li>`query`(string) A possible query string.</li>
	 *    <li>`fragment`(string) A possible fragment.</li>
	 * </ul>
	 *
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function parseUriParts( $url_uri_query_fragment, $normalize = null ) {
		if ( ( $parts = $this->parse( $url_uri_query_fragment, null, $normalize ) ) ) {
			return array( 'path' => $parts['path'], 'query' => $parts['query'], 'fragment' => $parts['fragment'] );
		}

		return null; // Default return value.
	}

	/**
	 * Unparses a URL (putting it all back together again).
	 *
	 * @param array        $parsed    An array with at least one URL component.
	 *
	 * @param null|integer $normalize A bitmask. Defaults to NULL (indicating a default bitmask).
	 *                                Defaults include: {@link fw_constants::url_scheme}, {@link
	 *                                fw_constants::url_host}, {@link fw_constants::url_path}. However, we DO allow a
	 *                                trailing slash (even if path is being normalized by this parameter).
	 *
	 * @return string A full or partial URL, based on components provided in the `$parsed` array.
	 *    It IS possible to receive an empty string, when/if `$parsed` does NOT contain any portion of a URL.
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function unParse( $parsed, $normalize = null ) {
		$unParsed = ''; // Initialize string value.

		if ( !isset( $normalize ) ) // Use defaults?
		{
			$normalize = $this::url_scheme | $this::url_host | $this::url_path;
		}

		if ( $normalize & $this::url_scheme ) // Normalize scheme?
		{
			if ( !is_string( $parsed['scheme'] ) ) {
				$parsed['scheme'] = '';
			} // No scheme.
			$parsed['scheme'] = $this->normScheme( $parsed['scheme'] );
		}
		if ( !empty( $parsed['scheme'] ) ) {
			$unParsed .= $parsed['scheme'] . '://';
		} else if ( is_string( $parsed['scheme'] ) && !empty( $parsed['host'] ) ) {
			$unParsed .= '//';
		} // Cross-protocol compatible (ONLY if there is a host name also).

		if ( !empty( $parsed['user'] ) ) {
			$unParsed .= $parsed['user'];
			if ( !empty( $parsed['pass'] ) ) {
				$unParsed .= ':' . $parsed['pass'];
			}
			$unParsed .= '@';
		}
		if ( $normalize & $this::url_host ) // Normalize host?
		{
			if ( !is_string( $parsed['host'] ) ) {
				$parsed['host'] = '';
			} // No host.
			$parsed['host'] = $this->normHost( $parsed['host'] );
		}
		if ( !empty( $parsed['host'] ) ) {
			$unParsed .= $parsed['host'];
		}

		if ( is_integer( $parsed['port'] ) && !empty( $parsed['port'] ) ) {
			$unParsed .= ':' . (string)$parsed['port'];
		} // A `0` value is excluded here.
		else if ( !empty( $parsed['port'] ) && (integer)$parsed['port'] ) {
			$unParsed .= ':' . (string)(integer)$parsed['port'];
		} // We also accept string port numbers.

		if ( $normalize & $this::url_path ) // Normalize path?
		{
			if ( !is_string( $parsed['path'] ) ) {
				$parsed['path'] = '/';
			} // Home directory.
			$parsed['path'] = $this->normPathSeps( $parsed['path'], true );
			if ( strpos( $parsed['path'], '/' ) !== 0 ) {
				$parsed['path'] = '/' . $parsed['path'];
			}
		}
		if ( is_string( $parsed['path'] ) ) {
			$unParsed .= $parsed['path'];
		}

		if ( !empty( $parsed['query'] ) ) {
			$unParsed .= '?' . $parsed['query'];
		}

		if ( !empty( $parsed['fragment'] ) ) {
			$unParsed .= '#' . $parsed['fragment'];
		}

		return $unParsed; // Possible empty string.
	}

	/**
	 * Normalizes a URL host name
	 *
	 * @param string $host An input URL host name.
	 *
	 * @return string A normalized URL host name (always lowercase).
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function normHost( $host ) {
		return strtolower( $host ); // Normalized host name.
	}

	/**
	 * Normalizes a URL path from a URL (or a URI/query/fragment only).
	 *
	 * @param string  $url_uri_query_fragment A full URL; or a partial URI;
	 *                                        or only a query string, or only a fragment. Any of these can be
	 *                                        normalized here.
	 * @param boolean $allow_trailing_slash   Defaults to a FALSE value.
	 *                                        If TRUE, and `$url_uri_query_fragment` contains a trailing slash; we'll
	 *                                        leave it there.
	 *
	 * @return string Normalized URL (or a URI/query/fragment only).
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function normPathSeps( $url_uri_query_fragment, $allow_trailing_slash = false ) {
		if ( !strlen( $url_uri_query_fragment ) ) {
			return '';
		}

		if ( !( $parts = $this->parse( $url_uri_query_fragment, null, 0 ) ) ) {
			$parts['path'] = $url_uri_query_fragment;
		}

		if ( strlen( $parts['path'] ) ) {// Normalize directory separators.
			$parts['path'] = $this->plugin->getFactory()->fcrHelpers()->dirs()->n_dir_seps(
				$parts['path'],
				$allow_trailing_slash
			);
		}

		return $this->unParse( $parts, 0 ); // Back together again.
	}

	/**
	 * @param      $url_uri_query_fragment
	 * @param null $component
	 * @param null $normalize
	 *
	 * @return array|mixed|null|string
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function parse( $url_uri_query_fragment, $component = null, $normalize = null ) {
		if ( !isset( $normalize ) ) {
			$normalize = $this::url_scheme | $this::url_host | $this::url_path;
		}

		if ( strpos( $url_uri_query_fragment, '//' ) === 0 && preg_match(
				self::REGEX_VALID_URL,
				$url_uri_query_fragment
			)
		) {
			$url_uri_query_fragment = $this->currentScheme(
				) . ':' . $url_uri_query_fragment; // So URL is parsed properly.
			// Works around a bug in `parse_url()` prior to PHP v5.4.7. See: <http://php.net/manual/en/function.parse-url.php>.
			$x_protocol_scheme = true; // Flag this, so we can remove scheme below.
		} else {
			$x_protocol_scheme = false;
		} // No scheme; or scheme is NOT cross-protocol compatible.

		$parsed = @parse_url( $url_uri_query_fragment, ( ( !isset( $component ) ) ? - 1 : $component ) );

		if ( $x_protocol_scheme ) // Cross-protocol scheme?
		{
			if ( !isset( $component ) && is_array( $parsed ) ) {
				$parsed['scheme'] = '';
			} // No scheme.

			else if ( $component === PHP_URL_SCHEME ) {
				$parsed = '';
			} // No scheme.
		}
		if ( $normalize & $this::url_scheme ) // Normalize scheme?
		{
			if ( !isset( $component ) && is_array( $parsed ) ) {
				if ( !is_string( $parsed['scheme'] ) ) {
					$parsed['scheme'] = '';
				} // No scheme.
				$parsed['scheme'] = $this->normScheme( $parsed['scheme'] );
			} else if ( $component === PHP_URL_SCHEME ) {
				if ( !is_string( $parsed ) ) {
					$parsed = '';
				} // No scheme.
				$parsed = $this->normScheme( $parsed );
			}
		}
		if ( $normalize & $this::url_host ) // Normalize host?
		{
			if ( !isset( $component ) && is_array( $parsed ) ) {
				if ( !is_string( $parsed['host'] ) ) {
					$parsed['host'] = '';
				} // No host.
				$parsed['host'] = $this->normHost( $parsed['host'] );
			} else if ( $component === PHP_URL_HOST ) {
				if ( !is_string( $parsed ) ) {
					$parsed = '';
				} // No scheme.
				$parsed = $this->normHost( $parsed );
			}
		}
		if ( $normalize & $this::url_path ) // Normalize path?
		{
			if ( !isset( $component ) && is_array( $parsed ) ) {
				if ( !is_string( $parsed['path'] ) ) {
					$parsed['path'] = '/';
				} // Home directory.
				$parsed['path'] = $this->normPathSeps( $parsed['path'], true );
				if ( strpos( $parsed['path'], '/' ) !== 0 ) {
					$parsed['path'] = '/' . $parsed['path'];
				}
			} else if ( $component === PHP_URL_PATH ) {
				if ( !is_string( $parsed ) ) {
					$parsed = '/';
				} // Home directory.
				$parsed = $this->normPathSeps( $parsed, true );
				if ( strpos( $parsed, '/' ) !== 0 ) {
					$parsed = '/' . $parsed;
				}
			}
		}
		if ( in_array( gettype( $parsed ), array( 'array', 'string', 'integer' ), true ) ) {
			if ( is_array( $parsed ) ) // An array?
			{
				// Standardize.
				$defaults       = array(
					'fragment' => '',
					'host'     => '',
					'pass'     => '',
					'path'     => '',
					'port'     => 0,
					'query'    => '',
					'scheme'   => '',
					'user'     => ''
				);
				$parsed         = array_merge( $defaults, $parsed );
				$parsed['port'] = (integer)$parsed['port'];
				ksort( $parsed ); // Sort by key.
			}

			return $parsed; // A `string|integer|array`.
		}

		return null; // Default return value.

	}

	/**
	 * Normalizes a URL scheme
	 *
	 * @param string $scheme An input URL scheme
	 *
	 * @return string A normalized URL scheme (always lowercase).
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function normScheme( $scheme ) {
		if ( strpos( $scheme, ':' ) !== false ) {
			$scheme = strstr( $scheme, ':', true );
		}

		return strtolower( $scheme ); // Normalized scheme.
	}

	/**
	 * Sets a particular scheme
	 *
	 * @param string $url    A full URL.
	 * @param string $scheme Optional. The scheme to use (i.e. `//`, `https`, `http`).
	 *                       Use `//` to use a cross-protocol compatible scheme.
	 *                       Defaults to the current scheme
	 *
	 * @return string The full URL w/ `$scheme`.
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function setScheme( $url, $scheme = '' ) {
		if ( !$scheme ) {
			$scheme = $this->currentScheme();
		}

		if ( $scheme !== '//' ) {
			$scheme = $this->normScheme( $scheme ) . '://';
		}

		return preg_replace(
			'/^' . self::REGEX_FRAG_SCHEME . '/',
			$this->plugin->getFactory()->fcrHelpers()->string()->escRefs( $scheme ),
			$url
		);
	}

}