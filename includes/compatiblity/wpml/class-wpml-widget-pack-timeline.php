<?php

/**
 * Class WPML_WidgetPack_Timeline
 */
class WPML_WidgetPack_Timeline extends WPML_Elementor_Module_With_Items {

	/**
	 * @return string
	 */
	public function get_items_field() {
		return 'timeline_items';
	}

	/**
	 * @return array
	 */
	public function get_fields() {
		return array( 'timeline_title', 'timeline_date', 'timeline_text', 'timeline_link' );
	}

	/**
	 * @param string $field
	 * @return string
	 */
	protected function get_title( $field ) {
		switch( $field ) {

			case 'timeline_title':
				return esc_html__( 'Title', 'avator-widget-pack' );

			case 'timeline_date':
				return esc_html__( 'Date', 'avator-widget-pack' );

			case 'timeline_text':
				return esc_html__( 'Content', 'avator-widget-pack' );

			case 'timeline_link':
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
			case 'timeline_title':
				return 'LINE';

			case 'timeline_date':
				return 'LINE';

			case 'timeline_text':
				return 'AREA';

			case 'timeline_link':
				return 'LINE';

			default:
				return '';
		}
	}

}
