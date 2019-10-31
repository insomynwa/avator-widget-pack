<?php

/**
 * Class WPML_WidgetPack_Video_Gallery
 */
class WPML_WidgetPack_Video_Gallery extends WPML_Elementor_Module_With_Items {

	/**
	 * @return string
	 */
	public function get_items_field() {
		return 'video_gallery';
	}

	/**
	 * @return array
	 */
	public function get_fields() {
		return array( 'title', 'desc' );
	}

	/**
	 * @param string $field
	 * @return string
	 */
	protected function get_title( $field ) {
		switch( $field ) {

			case 'title':
				return esc_html__( 'Title', 'avator-widget-pack' );

			case 'desc':
				return esc_html__( 'Women typing keyboard', 'avator-widget-pack' );

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

			case 'desc':
				return 'AREA';

			default:
				return '';
		}
	}

}
