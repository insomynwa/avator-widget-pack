<?php

/**
 * Class WPML_Jet_Elements_Price_List
 */
class WPML_WidgetPack_Price_List extends WPML_Elementor_Module_With_Items {

	/**
	 * @return string
	 */
	public function get_items_field() {
		return 'price_list';
	}

	/**
	 * @return array
	 */
	public function get_fields() {
		return array( 'price', 'title', 'item_description' );
	}

	/**
	 * @param string $field
	 * @return string
	 */
	protected function get_title( $field ) {
		switch( $field ) {
			case 'price':
				return esc_html__( 'Price', 'avator-widget-pack' );

			case 'title':
				return esc_html__( 'Title', 'avator-widget-pack' );

			case 'item_description':
				return esc_html__( 'Description', 'avator-widget-pack' );

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
			case 'price':
				return 'LINE';

			case 'title':
				return 'LINE';

			case 'item_description':
				return 'AREA';

			default:
				return '';
		}
	}

}
