<?php
/**
 * Project: wp-plugins-core.dev
 * File: AbsOptionsPage.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 14/10/2015
 * Time: 8:42 πμ
 * Since: TODO ${VERSION}
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace WPluginCore002\Abs;


use WPluginCore002\Options\Components\HelpTab;
use WPluginCore002\Options\Components\Section;
use WPluginCore002\Plugin\Plugin;

abstract class AbsOptionsPage extends AbsClass {
	protected $allow_tracking = false;
	/**
	 * This is where your data is stored in the database and also becomes your global variable name
	 *
	 * @var string
	 */
	protected $opt_name;
	/**
	 * Name that appears at the top of your panel
	 *
	 * @var string
	 */
	protected $display_name;
	/**
	 * Version that appears at the top of your panel
	 *
	 * @var string
	 */
	protected $display_version;
	/**
	 * Title for WP menu
	 *
	 * @var string
	 */
	protected $menu_title;
	/**
	 * Page title for meta title tag
	 *
	 * @var string
	 */
	protected $page_title;
	/**
	 * Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
	 *
	 * @var string
	 */
	protected $menu_type = 'menu';
	/**
	 * Show the sections below the admin menu item or not
	 *
	 * @link https://developers.google.com/fonts/docs/developer_api#Auth
	 * @var bool
	 */
	protected $allow_sub_menu = true;
	/**
	 * Set it you want google fonts to update weekly. A google_api_key value is required
	 *
	 * @var bool
	 */
	protected $google_api_key = true;
	/**
	 * Must be defined to add google fonts to the typography module
	 *
	 * @var bool
	 */
	protected $google_update_weekly = false;
	/**
	 * Use a asynchronous font on the front end or font string
	 *
	 * @var bool
	 */
	protected $async_typography = true;
	/**
	 * Disable this in case you want to create your own google fonts loader
	 *
	 * @var bool
	 */
	protected $disable_google_fonts_link = false;
	/**
	 * Show the panel pages on the admin bar
	 *
	 * @var bool
	 */
	protected $admin_bar = false;
	/**
	 * Choose an icon for the admin bar menu
	 *
	 * @var string
	 */
	protected $admin_bar_icon = 'dashicons-portfolio';
	/**
	 * Choose an priority for the admin bar menu
	 *
	 * @var int
	 */
	protected $admin_bar_priority = 50;
	/**
	 * Set a different name for your global variable other than the opt_name
	 *
	 * @var string
	 */
	protected $global_variable = '';
	/**
	 * Show the time the page took to load, etc
	 *
	 * @var bool
	 */
	protected $dev_mode = false;
	/**
	 * If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
	 *
	 * @var bool
	 */
	protected $update_notice = true;
	/**
	 * Enable basic customizer support
	 *
	 * @var bool
	 */
	protected $customizer = true;
	/**
	 * Allow you to start the panel in an expanded way initially
	 *
	 * @var bool
	 */
	protected $open_expanded = false;
	/**
	 * Disable the save warning when a user changes a field
	 *
	 * @var bool
	 */
	protected $disable_save_warn = false;
	/**
	 * Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning!
	 *
	 * @var null
	 */
	protected $page_priority = null;
	/**
	 * For a full list of options, visit: {@link http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters}
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
	 * @var string
	 */
	protected $page_parent = '';
	/**
	 * Permissions needed to access the options panel
	 *
	 * @var string
	 */
	protected $page_permissions = 'manage_options';
	/**
	 * Specify a custom URL to an icon
	 *
	 * @var string
	 */
	protected $menu_icon = '';
	/**
	 * Force your panel to always open to a specific tab (by id)
	 *
	 * @var string
	 */
	protected $last_tab = '';
	/**
	 * Icon displayed in the admin panel next to your menu_title
	 *
	 * @var string
	 */
	protected $page_icon = 'icon-themes';
	/**
	 * Page slug used to denote the panel, will be based off page title then menu title then opt_name if not provided
	 *
	 * @var string
	 */
	protected $page_slug = '';
	/**
	 * On load save the defaults to DB before user clicks save or not
	 *
	 * @var bool
	 */
	protected $save_defaults = true;
	/**
	 * If true, shows the default value next to each field that is not the default value
	 *
	 * @var bool
	 */
	protected $default_show = false;
	/**
	 * What to print by the field's title if the value shown is default
	 *
	 * @var string
	 */
	protected $default_mark = '';
	/**
	 * Shows the Import/Export panel when not used as a field
	 *
	 * @var bool
	 */
	protected $show_import_export = true;
	/**
	 * @var int
	 */
	protected $transient_time = 3600;
	/**
	 * Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
	 *
	 * @var bool
	 */
	protected $output = true;
	/**
	 * Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
	 *
	 * @var bool
	 */
	protected $output_tag = true;
	/**
	 * Disable the footer credit of Redux. Please leave if you can help it
	 *
	 * @var bool
	 */
	protected $footer_credit = false;
	/**
	 * If you prefer not to use the CDN for Select2, Ace Editor, and others, you may download the Redux
	 * Vendor Support plugin yourself and run locally or embed it in your code
	 *
	 * @var bool
	 */
	protected $use_cdn = true;
	/**
	 * Hints
	 *
	 * @link https://docs.reduxframework.com/core/the-basics/using-hints-in-fields/
	 * @var array
	 */
	protected $hints = array(
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
	);
	/**
	 * Setup custom links in the admin bar menu as external items
	 *
	 * @var array
	 */
	protected $admin_bar_links = array();
	/**
	 * Setup custom links in the footer for quick links in your panel footer icons
	 *
	 * @var array
	 */
	protected $share_icons = array();
	/**
	 * Intro text -> before the form
	 *
	 * @var string
	 */
	protected $intro_text = '';
	/**
	 * Add content after the form
	 *
	 * @var string
	 */
	protected $footer_text = '';

	/**
	 * @var array
	 */
	protected $sections = array();
	/**
	 * @var array
	 */
	protected $helpTabs = array();
	/**
	 * @var string
	 */
	protected $helpSidebar = '';

	/**
	 * @param Plugin $plugin
	 * @param string $menuType
	 */
	public function __construct( Plugin $plugin, $menuType ) {
		parent::__construct( $plugin );
		$this->opt_name = $plugin->getFactory()->options()->getOptName();

		$this->display_name
			= $this->page_title
			= $plugin->getName() . ' ' . __( 'Options', $this->plugin->getTextDomain() );

		$this->display_version = $plugin->getVersion();

		$this->menu_title = $plugin->getName();

		$this->menu_type = $menuType;
	}

	/**
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function setUpPage() {
		$optName = $this->plugin->getFactory()->options()->getOptName();

		\Redux::setArgs( $optName, $this->toArray() );

		if ( $this->helpTabs ) {
			$tabs = array();
			foreach ( $this->helpTabs as $helpTab ) {
				/* @var HelpTab $helpTab */
				$tabs[] = $helpTab->toArray();
			}
			\Redux::setHelpTab( $optName, $tabs );
		}

		if ( $this->helpSidebar ) {
			\Redux::setHelpSidebar( $optName, $this->helpSidebar );
		}

		foreach ( $this->sections as $section ) {
			/* @var Section $section */
			\Redux::setSection( $optName, $section->toArray() );
		}
	}

	/**
	 * @param Section $section
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function addSection( Section $section ) {
		$this->sections[] = $section;

		return $this;
	}

	/**
	 * @param HelpTab $helpTab
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function addHelpTab( HelpTab $helpTab ) {
		$this->helpTabs[] = $helpTab;

		return $this;
	}

	/**
	 * @param $content
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function setHelpSidebar( $content ) {
		$this->helpSidebar = $content;

		return $this;
	}

	/**
	 * Add custom links in the admin bar menu as external items
	 *
	 * @param string $id
	 * @param string $href
	 * @param string $title
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function addAdminBarLink( $id, $href, $title ) {
		$this->admin_bar_links[] = array(
			'id'    => $id,
			'href'  => $href,
			'title' => $title,
		);

		return $this;
	}

	/**
	 * @param string $url
	 * @param string $title
	 * @param string $icon
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function addShareIcon( $url, $title, $icon ) {
		$this->share_icons[] = array(
			'url'   => $url,
			'title' => $title,
			'icon'  => $icon
		);

		return $this;
	}

	/**
	 * @return string
	 */
	public function getIntroText() {
		return $this->intro_text;
	}

	/**
	 * @param $intro_text
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function setIntroText( $intro_text ) {
		$this->intro_text = $intro_text;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getFooterText() {
		return $this->footer_text;
	}

	/**
	 * @param $footer_text
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function setFooterText( $footer_text ) {
		$this->footer_text = $footer_text;

		return $this;
	}

	/**
	 * @return boolean
	 */
	public function isAllowTracking() {
		return $this->allow_tracking;
	}

	/**
	 * @param $allow_tracking
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function setAllowTracking( $allow_tracking ) {
		$this->allow_tracking = $allow_tracking;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getMenuType() {
		return $this->menu_type;
	}

	/**
	 * @return boolean
	 */
	public function isAllowSubMenu() {
		return $this->allow_sub_menu;
	}

	/**
	 * @param $allow_sub_menu
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function setAllowSubMenu( $allow_sub_menu ) {
		$this->allow_sub_menu = $allow_sub_menu;

		return $this;
	}

	/**
	 * @return boolean
	 */
	public function isGoogleApiKey() {
		return $this->google_api_key;
	}

	/**
	 * @param $google_api_key
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function setGoogleApiKey( $google_api_key ) {
		$this->google_api_key = $google_api_key;

		return $this;
	}

	/**
	 * @return boolean
	 */
	public function isGoogleUpdateWeekly() {
		return $this->google_update_weekly;
	}

	/**
	 * @param $google_update_weekly
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function setGoogleUpdateWeekly( $google_update_weekly ) {
		$this->google_update_weekly = $google_update_weekly;

		return $this;
	}

	/**
	 * @return boolean
	 */
	public function isAsyncTypography() {
		return $this->async_typography;
	}

	/**
	 * @param $async_typography
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function setAsyncTypography( $async_typography ) {
		$this->async_typography = $async_typography;

		return $this;
	}

	/**
	 * @return boolean
	 */
	public function isDisableGoogleFontsLink() {
		return $this->disable_google_fonts_link;
	}

	/**
	 * @param $disable_google_fonts_link
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function setDisableGoogleFontsLink( $disable_google_fonts_link ) {
		$this->disable_google_fonts_link = $disable_google_fonts_link;

		return $this;
	}

	/**
	 * @return boolean
	 */
	public function isAdminBar() {
		return $this->admin_bar;
	}

	/**
	 * @param $admin_bar
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function setAdminBar( $admin_bar ) {
		$this->admin_bar = $admin_bar;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getAdminBarIcon() {
		return $this->admin_bar_icon;
	}

	/**
	 * @param $admin_bar_icon
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function setAdminBarIcon( $admin_bar_icon ) {
		$this->admin_bar_icon = $admin_bar_icon;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getAdminBarPriority() {
		return $this->admin_bar_priority;
	}

	/**
	 * @param $admin_bar_priority
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function setAdminBarPriority( $admin_bar_priority ) {
		$this->admin_bar_priority = $admin_bar_priority;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getGlobalVariable() {
		return $this->global_variable;
	}

	/**
	 * @param $global_variable
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function setGlobalVariable( $global_variable ) {
		$this->global_variable = $global_variable;

		return $this;
	}

	/**
	 * @return boolean
	 */
	public function isDevMode() {
		return $this->dev_mode;
	}

	/**
	 * @param $dev_mode
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function setDevMode( $dev_mode ) {
		$this->dev_mode = $dev_mode;

		return $this;
	}

	/**
	 * @return boolean
	 */
	public function isUpdateNotice() {
		return $this->update_notice;
	}

	/**
	 * @param $update_notice
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function setUpdateNotice( $update_notice ) {
		$this->update_notice = $update_notice;

		return $this;
	}

	/**
	 * @return boolean
	 */
	public function isCustomizer() {
		return $this->customizer;
	}

	/**
	 * @param $customizer
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function setCustomizer( $customizer ) {
		$this->customizer = $customizer;

		return $this;
	}

	/**
	 * @return boolean
	 */
	public function isOpenExpanded() {
		return $this->open_expanded;
	}

	/**
	 * @param $open_expanded
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function setOpenExpanded( $open_expanded ) {
		$this->open_expanded = $open_expanded;

		return $this;
	}

	/**
	 * @return boolean
	 */
	public function isDisableSaveWarn() {
		return $this->disable_save_warn;
	}

	/**
	 * @param $disable_save_warn
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function setDisableSaveWarn( $disable_save_warn ) {
		$this->disable_save_warn = $disable_save_warn;

		return $this;
	}

	/**
	 * @return null
	 */
	public function getPagePriority() {
		return $this->page_priority;
	}

	/**
	 * @param $page_priority
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function setPagePriority( $page_priority ) {
		$this->page_priority = $page_priority;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getPageParent() {
		return $this->page_parent;
	}

	/**
	 * @return string
	 */
	public function getPagePermissions() {
		return $this->page_permissions;
	}

	/**
	 * @param $page_permissions
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function setPagePermissions( $page_permissions ) {
		$this->page_permissions = $page_permissions;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getMenuIcon() {
		return $this->menu_icon;
	}

	/**
	 * @param $menu_icon
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function setMenuIcon( $menu_icon ) {
		$this->menu_icon = $menu_icon;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getLastTab() {
		return $this->last_tab;
	}

	/**
	 * @param $last_tab
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function setLastTab( $last_tab ) {
		$this->last_tab = $last_tab;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getPageIcon() {
		return $this->page_icon;
	}

	/**
	 * @param $page_icon
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function setPageIcon( $page_icon ) {
		$this->page_icon = $page_icon;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getPageSlug() {
		return $this->page_slug;
	}

	/**
	 * @param $page_slug
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function setPageSlug( $page_slug ) {
		$this->page_slug = $page_slug;

		return $this;
	}

	/**
	 * @return boolean
	 */
	public function isSaveDefaults() {
		return $this->save_defaults;
	}

	/**
	 * @param $save_defaults
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function setSaveDefaults( $save_defaults ) {
		$this->save_defaults = $save_defaults;

		return $this;
	}

	/**
	 * @return boolean
	 */
	public function isDefaultShow() {
		return $this->default_show;
	}

	/**
	 * @param $default_show
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function setDefaultShow( $default_show ) {
		$this->default_show = $default_show;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getDefaultMark() {
		return $this->default_mark;
	}

	/**
	 * @param $default_mark
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function setDefaultMark( $default_mark ) {
		$this->default_mark = $default_mark;

		return $this;
	}

	/**
	 * @return boolean
	 */
	public function isShowImportExport() {
		return $this->show_import_export;
	}

	/**
	 * @param $show_import_export
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function setShowImportExport( $show_import_export ) {
		$this->show_import_export = $show_import_export;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getTransientTime() {
		return $this->transient_time;
	}

	/**
	 * @param $transient_time
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function setTransientTime( $transient_time ) {
		$this->transient_time = $transient_time;

		return $this;
	}

	/**
	 * @return boolean
	 */
	public function isOutput() {
		return $this->output;
	}

	/**
	 * @param $output
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function setOutput( $output ) {
		$this->output = $output;

		return $this;
	}

	/**
	 * @return boolean
	 */
	public function isOutputTag() {
		return $this->output_tag;
	}

	/**
	 * @param $output_tag
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function setOutputTag( $output_tag ) {
		$this->output_tag = $output_tag;

		return $this;
	}

	/**
	 * @return boolean
	 */
	public function isFooterCredit() {
		return $this->footer_credit;
	}

	/**
	 * @param $footer_credit
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function setFooterCredit( $footer_credit ) {
		$this->footer_credit = $footer_credit;

		return $this;
	}

	/**
	 * @return boolean
	 */
	public function isUseCdn() {
		return $this->use_cdn;
	}

	/**
	 * @param $use_cdn
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function setUseCdn( $use_cdn ) {
		$this->use_cdn = $use_cdn;

		return $this;
	}

	/**
	 * @return array
	 */
	public function getHints() {
		return $this->hints;
	}

	/**
	 * @param $hints
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function setHints( $hints ) {
		$this->hints = $hints;

		return $this;
	}


	/**
	 * @return array
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function toArray() {
		$out = array();

		$reflect = new \ReflectionClass( $this );
		$props   = $reflect->getProperties( \ReflectionProperty::IS_PUBLIC | \ReflectionProperty::IS_PROTECTED );

		foreach ( $props as $prop ) {
			$out[ $prop->getName() ] = $this->{$prop->getName()};
		}

		return $out;
	}

	/**
	 * @return string
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function getDisplayName() {
		return $this->display_name;
	}

	/**
	 * @param string $display_name
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function setDisplayName( $display_name ) {
		$this->display_name = $display_name;

		return $this;
	}

	/**
	 * @return string
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function getDisplayVersion() {
		return $this->display_version;
	}

	/**
	 * @param string $display_version
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function setDisplayVersion( $display_version ) {
		$this->display_version = $display_version;

		return $this;
	}

	/**
	 * @return string
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function getMenuTitle() {
		return $this->menu_title;
	}

	/**
	 * @param string $menu_title
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function setMenuTitle( $menu_title ) {
		$this->menu_title = $menu_title;

		return $this;
	}

	/**
	 * @return string
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function getPageTitle() {
		return $this->page_title;
	}

	/**
	 * @param string $page_title
	 *
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function setPageTitle( $page_title ) {
		$this->page_title = $page_title;

		return $this;
	}
}