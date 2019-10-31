<?php

/**
 * Class WPML_WidgetPack_Slideshow
 */
class WPML_WidgetPack_Slideshow extends WPML_Elementor_Module_With_Items {

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
		return array( 'pre_title', 'title', 'post_title', 'video_link', 'youtube_link', 'text' );
	}

	/**
	 * @param string $field
	 * @return string
	 */
	protected function get_title( $field ) {
		switch( $field ) {

			case 'pre_title':
				return esc_html__( 'Pre Title', 'avator-widget-pack' );

			case 'title':
				return esc_html__( 'Title', 'avator-widget-pack' );

			case 'post_title':
				return esc_html__( 'Post Title', 'avator-widget-pack' );

			case 'video_link':
				return esc_html__( 'Post Title', 'avator-widget-pack' );

			case 'youtube_link':
				return esc_html__( 'Post Title', 'avator-widget-pack' );

			case 'text':
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
			case 'pre_title':
				return 'LINE';

			case 'title':
				return 'LINE';

			case 'post_title':
				return 'LINE';

			case 'video_link':
				return 'LINE';

			case 'youtube_link':
				return 'LINE';

			case 'text':
				return 'AREA';

			default:
				return '';
		}
	}

}
