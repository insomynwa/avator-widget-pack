<?php

/**
 * Class WPML_Jet_Elements_Custom_Carousel
 */
class WPML_WidgetPack_Custom_Carousel extends WPML_Elementor_Module_With_Items {

	/**
	 * @return string
	 */
	public function get_items_field() {
		return 'skin_template_slides';
	}

	/**
	 * @return array
	 */
	public function get_fields() {
		return array( 'editor_content' );
	}

	/**
	 * @param string $field
	 * @return string
	 */
	protected function get_title( $field ) {
		switch( $field ) {
			case 'editor_content':
				return esc_html__( 'Slides', 'avator-widget-pack' );

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
			case 'editor_content':
				return 'AREA';

			default:
				return '';
		}
	}

}
