<?php

/**
 * Class WPML_Jet_Elements_Custom_Gallery
 */
class WPML_WidgetPack_Custom_Gallery extends WPML_Elementor_Module_With_Items {

	/**
	 * @return string
	 */
	public function get_items_field() {
		return 'gallery';
	}

	/**
	 * @return array
	 */
	public function get_fields() {
		return array( 'image_title', 'image_text' );
	}

	/**
	 * @param string $field
	 * @return string
	 */
	protected function get_title( $field ) {
		switch( $field ) {
			case 'image_title':
				return esc_html__( 'Title', 'avator-widget-pack' );

			case 'image_title':
				return esc_html__( 'Content', 'avator-widget-pack' );

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
			case 'image_title':
				return 'LINE';

			case 'image_title':
				return 'AREA';

			default:
				return '';
		}
	}

}
