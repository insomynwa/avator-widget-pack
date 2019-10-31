<?php

/**
 * Class WPML_WidgetPack_GoogleMaps
 */
class WPML_WidgetPack_GoogleMaps extends WPML_Elementor_Module_With_Items {

	/**
	 * @return string
	 */
	public function get_items_field() {
		return 'marker';
	}

	/**
	 * @return array
	 */
	public function get_fields() {
		return array( 'marker_lat', 'marker_lng', 'marker_title', 'marker_content' );
	}

	/**
	 * @param string $field
	 * @return string
	 */
	protected function get_title( $field ) {
		switch( $field ) {

			case 'marker_lat':
				return esc_html__( 'Latitude', 'avator-widget-pack' );

			case 'marker_lng':
				return esc_html__( 'Longitude', 'avator-widget-pack' );

			case 'marker_title':
				return esc_html__( 'Title', 'avator-widget-pack' );

			case 'marker_content':
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
			case 'marker_lat':
				return 'LINE';

			case 'marker_lng':
				return 'LINE';

			case 'marker_title':
				return 'LINE';

			case 'marker_content':
				return 'AREA';

			default:
				return '';
		}
	}

}
