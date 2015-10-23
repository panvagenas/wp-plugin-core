<?php
/**
 * Project: wp-plugins-core.dev
 * File: FcrOptions.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 23/10/2015
 * Time: 9:28 πμ
 * Since: TODO ${VERSION}
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace WPluginCore003\Options;


use WPluginCore003\Abs\AbsFactory;
use WPluginCore003\Options\Components\HelpTab;
use WPluginCore003\Options\Components\Section;
use WPluginCore003\Options\Components\SubSection;
use WPluginCore003\Options\Fields\AceEditor;
use WPluginCore003\Options\Fields\Checkbox;
use WPluginCore003\Options\Fields\Color;
use WPluginCore003\Options\Fields\ColorGradient;
use WPluginCore003\Options\Fields\Date;
use WPluginCore003\Options\Fields\Divide;
use WPluginCore003\Options\Fields\Editor;
use WPluginCore003\Options\Fields\Info;
use WPluginCore003\Options\Fields\MultiSelect;
use WPluginCore003\Options\Fields\Radio;
use WPluginCore003\Options\Fields\Raw;
use WPluginCore003\Options\Fields\Select;
use WPluginCore003\Options\Fields\Slider;
use WPluginCore003\Options\Fields\Spinner;
use WPluginCore003\Options\Fields\SwitchField;
use WPluginCore003\Options\Fields\Text;
use WPluginCore003\Options\Fields\TextArea;

/**
 * Class FcrOptions
 *
 * @package WPluginCore003\Options
 * @author  Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @since   TODO ${VERSION}
 */
class FcrOptions extends AbsFactory {
	/**
	 * @return Options
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function options() {
		return Options::getInstance( $this->plugin );
	}

	/**
	 * @param string $title
	 * @param string $content
	 * @param string $tabId
	 *
	 * @return HelpTab
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function cmpHelpTab( $title, $content, $tabId = '' ) {
		return new HelpTab( $this->plugin, $title, $content, $tabId );
	}

	/**
	 * @param string $title
	 *
	 * @return Section
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function cmpSection( $title ) {
		return new Section( $this->plugin, $title );
	}

	/**
	 * @param string $title
	 *
	 * @return SubSection
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function cmpSubSection( $title ) {
		return new SubSection( $this->plugin, $title );
	}

	/**
	 * @param string $fieldId
	 * @param string $title
	 *
	 * @return AceEditor
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function fldAceEditor( $fieldId, $title ) {
		return new AceEditor( $this->plugin, $fieldId, $title );
	}

	/**
	 * @param string $fieldId
	 * @param string $title
	 * @param array  $options
	 *
	 * @return Checkbox
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function fldCheckBox( $fieldId, $title, $options = array() ) {
		return new Checkbox( $this->plugin, $fieldId, $title, $options );
	}

	/**
	 * @param string $fieldId
	 * @param string $title
	 *
	 * @return Color
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function fldColor( $fieldId, $title ) {
		return new Color( $this->plugin, $fieldId, $title );
	}

	/**
	 * @param string $fieldId
	 * @param string $title
	 *
	 * @return ColorGradient
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function fldColorGradient( $fieldId, $title ) {
		return new ColorGradient( $this->plugin, $fieldId, $title );
	}

	/**
	 * @param string $fieldId
	 * @param string $title
	 *
	 * @return Date
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function fldDate( $fieldId, $title ) {
		return new Date( $this->plugin, $fieldId, $title );
	}

	/**
	 * @param string $fieldId
	 *
	 * @return Divide
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function fldDivide( $fieldId ) {
		return new Divide( $this->plugin, $fieldId );
	}

	/**
	 * @param string $fieldId
	 * @param string $title
	 *
	 * @return Editor
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function fldEditor( $fieldId, $title ) {
		return new Editor( $this->plugin, $fieldId, $title );
	}

	/**
	 * @param string $fieldId
	 *
	 * @return Info
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function fldInfo( $fieldId ) {
		return new Info( $this->plugin, $fieldId );
	}

	/**
	 * @param string $fieldId
	 * @param string $title
	 *
	 * @return MultiSelect
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function fldMultiSelect( $fieldId, $title ) {
		return new MultiSelect( $this->plugin, $fieldId, $title );
	}

	/**
	 * @param string $fieldId
	 * @param string $title
	 * @param array  $options
	 *
	 * @return Radio
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function fldRadio( $fieldId, $title, $options = array() ) {
		return new Radio( $this->plugin, $fieldId, $title, $options );
	}

	/**
	 * @param string $fieldId
	 *
	 * @return Raw
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function fldRaw( $fieldId ) {
		return new Raw( $this->plugin, $fieldId );
	}

	/**
	 * @param string $fieldId
	 * @param string $title
	 *
	 * @return Select
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function fldSelect( $fieldId, $title ) {
		return new Select( $this->plugin, $fieldId, $title );
	}

	/**
	 * @param string $fieldId
	 * @param string $title
	 *
	 * @return Slider
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function fldSlider( $fieldId, $title ) {
		return new Slider( $this->plugin, $fieldId, $title );
	}

	/**
	 * @param string $fieldId
	 * @param string $title
	 *
	 * @return Spinner
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function fldSpinner( $fieldId, $title ) {
		return new Spinner( $this->plugin, $fieldId, $title );
	}

	/**
	 * @param string $fieldId
	 * @param string $title
	 *
	 * @return SwitchField
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function fldSwitchField( $fieldId, $title ) {
		return new SwitchField( $this->plugin, $fieldId, $title );
	}

	/**
	 * @param string $fieldId
	 * @param string $title
	 *
	 * @return Text
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function fldText( $fieldId, $title ) {
		return new Text( $this->plugin, $fieldId, $title );
	}

	/**
	 * @param string $fieldId
	 * @param string $title
	 *
	 * @return TextArea
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  TODO ${VERSION}
	 */
	public function fldTextArea( $fieldId, $title ) {
		return new TextArea( $this->plugin, $fieldId, $title );
	}
}