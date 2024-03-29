<?php

/**
 * Class WPML_Jet_Elements_Marker
 */
class WPML_WidgetPack_Marker extends WPML_Elementor_Module_With_Items {

	/**
	 * @return string
	 */
	public function get_items_field() {
		return 'markers';
	}

	/**
	 * @return array
	 */
	public function get_fields() {
		return array( 'marker_title' );
	}

	/**
	 * @param string $field
	 * @return string
	 */
	protected function get_title( $field ) {
		switch( $field ) {
			case 'marker_title':
				return esc_html__( 'Title', 'avator-widget-pack' );

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
			case 'marker_title':
				return 'LINE';

			default:
				return '';
		}
	}

}
