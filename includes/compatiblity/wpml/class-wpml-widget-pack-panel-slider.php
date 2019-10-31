<?php

/**
 * Class WPML_Jet_Elements_Panel_Slider
 */
class WPML_WidgetPack_Panel_Slider extends WPML_Elementor_Module_With_Items {

	/**
	 * @return string
	 */
	public function get_items_field() {
		return 'tabs';
	}

	/**
	 * @return array
	 */
	public function get_fields() {
		return array( 'tab_title', 'tab_content', 'button_text' );
	}

	/**
	 * @param string $field
	 * @return string
	 */
	protected function get_title( $field ) {
		switch( $field ) {
			case 'tab_title':
				return esc_html__( 'Title', 'avator-widget-pack' );

			case 'tab_content':
				return esc_html__( 'Content', 'avator-widget-pack' );

			case 'button_text':
				return esc_html__( 'Text', 'avator-widget-pack' );

			default:
				return '';
		}
	}

	/**
	 * @param string $field
	 * @return string
	 */
	protected function get_editor_type( $field ) {
		switch( $field ) {
			case 'tab_title':
				return 'LINE';

			case 'tab_content':
				return 'AREA';

			case 'button_text':
				return 'LINE';

			default:
				return '';
		}
	}

}
