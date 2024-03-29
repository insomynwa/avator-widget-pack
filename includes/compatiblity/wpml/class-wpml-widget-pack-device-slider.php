<?php

/**
 * Class WPML_Jet_Elements_Device_Slider
 */
class WPML_WidgetPack_Device_Slider extends WPML_Elementor_Module_With_Items {

	/**
	 * @return string
	 */
	public function get_items_field() {
		return 'slides';
	}

	/**
	 * @return array
	 */
	public function get_fields() {
		return array( 'title', 'video_link', 'youtube_link' );
	}

	/**
	 * @param string $field
	 * @return string
	 */
	protected function get_title( $field ) {
		switch( $field ) {
			case 'title':
				return esc_html__( 'Title', 'avator-widget-pack' );

			case 'video_link':
				return esc_html__( 'Video Link', 'avator-widget-pack' );

			case 'youtube_link':
				return esc_html__( 'Youtube Link', 'avator-widget-pack' );

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
			case 'title':
				return 'LINE';

			case 'video_link':
				return 'LINE';

			case 'youtube_link':
				return 'LINE';

			default:
				return '';
		}
	}

}
