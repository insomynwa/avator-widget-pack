<?php

/**
 * Class WPML_WidgetPack_Scrollnav
 */
class WPML_WidgetPack_Scrollnav extends WPML_Elementor_Module_With_Items {

	/**
	 * @return string
	 */
	public function get_items_field() {
		return 'navs';
	}

	/**
	 * @return array
	 */
	public function get_fields() {
		return array( 'nav_title' );
	}

	/**
	 * @param string $field
	 * @return string
	 */
	protected function get_title( $field ) {
		switch( $field ) {

			case 'nav_title':
				return esc_html__( 'Nav Title', 'avator-widget-pack' );

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
			case 'nav_title':
				return 'LINE';

			default:
				return '';
		}
	}

}
