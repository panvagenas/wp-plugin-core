<?php
/**
 * Created by PhpStorm.
 * User: vagenas
 * Date: 29/8/2015
 * Time: 8:40 πμ
 */

namespace PanWPCore;


class Redux extends Core {
	protected $optName = '';
	protected $args = array();

	public static $reduxDefaults = array(
		'disable_tracking'     => true,
		// TYPICAL -> Change these values as you need/desire
		'menu_type'            => 'menu',
		//Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
		'allow_sub_menu'       => true,
		// Show the sections below the admin menu item or not
		// Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
		'google_api_key'       => '',
		// Set it you want google fonts to update weekly. A google_api_key value is required.
		'google_update_weekly' => false,
		// Must be defined to add google fonts to the typography module
		'async_typography'     => true,
		// Use a asynchronous font on the front end or font string
		//'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
		'admin_bar'            => false,
		// Show the panel pages on the admin bar
		'admin_bar_icon'       => 'dashicons-portfolio',
		// Choose an icon for the admin bar menu
		'admin_bar_priority'   => 50,
		// Choose an priority for the admin bar menu
		'global_variable'      => '',
		// Set a different name for your global variable other than the opt_name
		'dev_mode'             => false,
		// Show the time the page took to load, etc
		'update_notice'        => true,
		// If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
		'customizer'           => true,
		// Enable basic customizer support
		//'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
		//'disable_save_warn' => true,                    // Disable the save warning when a user changes a field
		// OPTIONAL -> Give you extra features
		'page_priority'        => null,
		// Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
		'page_parent'          => 'options-general.php',
		// For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
		'page_permissions'     => 'manage_options',
		// Permissions needed to access the options panel.
		'menu_icon'            => '',
		// Specify a custom URL to an icon
		'last_tab'             => '',
		// Force your panel to always open to a specific tab (by id)
		'page_icon'            => 'icon-themes',
		// Icon displayed in the admin panel next to your menu_title
		'page_slug'            => '',
		// Page slug used to denote the panel, will be based off page title then menu title then opt_name if not provided
		'save_defaults'        => true,
		// On load save the defaults to DB before user clicks save or not
		'default_show'         => false,
		// If true, shows the default value next to each field that is not the default value.
		'default_mark'         => '',
		// What to print by the field's title if the value shown is default. Suggested: *
		'show_import_export'   => true,
		// Shows the Import/Export panel when not used as a field.
		// CAREFUL -> These options are for advanced use only
		'transient_time'       => 3600,
		'output'               => true,
		// Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
		'output_tag'           => true,
		// Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
		// 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.
		// FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
		'database'             => '',
		// possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
		'use_cdn'              => true,
		// If you prefer not to use the CDN for Select2, Ace Editor, and others, you may download the Redux Vendor Support plugin yourself and run locally or embed it in your code.
		// HINTS
		'hints'                => array(
			'icon'          => 'el el-question-sign',
			'icon_position' => 'right',
			'icon_color'    => 'lightgray',
			'icon_size'     => 'normal',
			'tip_style'     => array(
				'color'   => 'yellow',
				'shadow'  => true,
				'rounded' => false,
				'style'   => '',
			),
			'tip_position'  => array(
				'my' => 'top left',
				'at' => 'bottom right',
			),
			'tip_effect'    => array(
				'show' => array(
					'effect'   => 'slide',
					'duration' => '500',
					'event'    => 'mouseover',
				),
				'hide' => array(
					'effect'   => 'slide',
					'duration' => '500',
					'event'    => 'click mouseleave',
				),
			),
		)
	);

	public function __construct( Plugin $plugin, Array $args = array() ) {
		parent::__construct( $plugin );
		$this->optName = $this->Options->getOptName();

		$pluginSpecificDefaults      = array(
			'opt_name'             => $this->optName,
			// This is where your data is stored in the database and also becomes your global variable name.
			'display_name'         => $plugin->getName() . ' ' . __( 'Options', $plugin->getTextDomain() ),
			// Name that appears at the top of your panel
			'display_version'      => $plugin->getVersion(),
			// Version that appears at the top of your panel
			'menu_title'           => $plugin->getName(),
			'page_title'           => $plugin->getName() . ' ' . __( 'Options', $plugin->getTextDomain() ),
			// You will need to generate a Google API key to use this feature.
			// Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
		);

		$this->args = array_merge( self::$reduxDefaults, $pluginSpecificDefaults, $args );

		$this->reduxSetArgs();
	}

	/**
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since TODO ${VERSION}
	 */
	protected function reduxSetArgs() {
		\Redux::setArgs( $this->optName, $this->args );
	}

	/**
	 * @param $id
	 * @param $href
	 * @param $title
	 *
	 * @return $this
	 */
	public function addAdminBarLinks( $id, $href, $title ) {
		$this->args['admin_bar_links'][] = array(
			'id'    => $id,
			'href'  => $href,
			'title' => $title
		);

		$this->reduxSetArgs();

		return $this;
	}

	/**
	 * @param $url
	 * @param $title
	 * @param $icon
	 *
	 * @return $this
	 */
	public function addShareIcons( $url, $title, $icon ) {
		$this->args['share_icons'][] = array(
			'url'   => $url,
			'title' => $title,
			'icon'  => $icon
		);

		$this->reduxSetArgs();

		return $this;
	}

	/**
	 * @param string $txt
	 *
	 * @return $this
	 */
	public function addFooterText( $txt ) {
		$this->args['footer_text'] = $txt;
		$this->reduxSetArgs();

		return $this;
	}

	/**
	 * @param string $txt
	 *
	 * @return $this
	 */
	public function addIntroText( $txt ) {
		$this->args['intro_text'] = $txt;
		$this->reduxSetArgs();

		return $this;
	}

	public function addHelpTab( $id, $title, $content ) {
		\Redux::setHelpTab( $this->optName, array(
			'id'      => $id,
			'title'   => $title,
			'content' => $content
		) );

		return $this;
	}

	/**
	 * @param $content
	 *
	 * @return $this
	 */
	public function addHelpSidebar( $content ) {
		\Redux::setHelpSidebar( $this->optName, $content );

		return $this;
	}

	/**
	 * @param            $title
	 * @param            $id
	 * @param bool|false $subsection
	 * @param string $desc
	 * @param array $additionalArgs
	 *
	 * @return $this
	 */
	public function addSection( $title, $id, $subsection = false, $desc = '', $additionalArgs = array() ) {
		$section = array(
			'title'      => $title,
			'id'         => $id,
			'subsection' => $subsection,
			'desc'       => $desc
		);

		\Redux::setSection( $this->optName, array_merge( $section, $additionalArgs ) );

		return $this;
	}

	/**
	 * @param       $sectionId
	 * @param array $fieldArgs
	 *
	 * @return $this
	 */
	public function addField( $sectionId, Array $fieldArgs ) {
		\Redux::processFieldsArray( $this->optName, $sectionId, array( $fieldArgs ) );

		return $this;
	}

	/**
	 * @param $name
	 * @param $value
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since TODO ${VERSION}
	 */
	public function setArg( $name, $value ) {
		$this->args[ $name ] = $value;
		$this->reduxSetArgs();

		return $this;
	}

	/**
	 * @param array $args
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since TODO ${VERSION}
	 */
	public function setArgs(Array $args){
		$this->args = array_merge($this->args, $args);
		$this->reduxSetArgs();

		return $this;
	}
}