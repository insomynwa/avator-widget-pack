<?php

namespace WidgetPack\Includes;

/**
 * Widget_Pack_WPML class
 */
class Widget_Pack_WPML {

	/**
	 * A reference to an instance of this class.
	 * @since 3.1.0
	 * @var   object
	 */
	private static $instance = null;

	/**
	 * Constructor for the class
	 */
	public function init() {

		// WPML String Translation plugin exist check
		if ( defined( 'WPML_ST_VERSION' ) ) {

			if ( class_exists( 'WPML_Elementor_Module_With_Items' ) ) {
				$this->load_wpml_modules();
			}

			add_filter( 'wpml_elementor_widgets_to_translate', array( $this, 'add_translatable_nodes' ) );
		}

	}

	/**
	 * Load wpml required repeater class files.
	 * @return void
	 */
	public function load_wpml_modules() {
		require_once( AWP_INC_PATH . 'compatiblity/wpml/class-wpml-widget-pack-member.php' );
		require_once( AWP_INC_PATH . 'compatiblity/wpml/class-wpml-widget-pack-accordion.php' );
		require_once( AWP_INC_PATH . 'compatiblity/wpml/class-wpml-widget-pack-google-maps.php' );
		require_once( AWP_INC_PATH . 'compatiblity/wpml/class-wpml-widget-pack-business-hours.php' );
		require_once( AWP_INC_PATH . 'compatiblity/wpml/class-wpml-widget-pack-chart.php' );
		require_once( AWP_INC_PATH . 'compatiblity/wpml/class-wpml-widget-pack-circle-menu.php' );
		require_once( AWP_INC_PATH . 'compatiblity/wpml/class-wpml-widget-pack-custom-carousel.php' );
		require_once( AWP_INC_PATH . 'compatiblity/wpml/class-wpml-widget-pack-custom-gallery.php' );
		require_once( AWP_INC_PATH . 'compatiblity/wpml/class-wpml-widget-pack-device-slider.php' );
		require_once( AWP_INC_PATH . 'compatiblity/wpml/class-wpml-widget-pack-iconnav.php' );
		require_once( AWP_INC_PATH . 'compatiblity/wpml/class-wpml-widget-pack-marker.php' );
		require_once( AWP_INC_PATH . 'compatiblity/wpml/class-wpml-widget-pack-open-street-map.php' );
		require_once( AWP_INC_PATH . 'compatiblity/wpml/class-wpml-widget-pack-panel-slider.php' );
		require_once( AWP_INC_PATH . 'compatiblity/wpml/class-wpml-widget-pack-price-list.php' );
		require_once( AWP_INC_PATH . 'compatiblity/wpml/class-wpml-widget-pack-scrollnav.php' );
		require_once( AWP_INC_PATH . 'compatiblity/wpml/class-wpml-widget-pack-slider.php' );
		require_once( AWP_INC_PATH . 'compatiblity/wpml/class-wpml-widget-pack-slideshow.php' );
		require_once( AWP_INC_PATH . 'compatiblity/wpml/class-wpml-widget-pack-social-share.php' );
		require_once( AWP_INC_PATH . 'compatiblity/wpml/class-wpml-widget-pack-timeline.php' );
		require_once( AWP_INC_PATH . 'compatiblity/wpml/class-wpml-widget-pack-tabs.php' );
		require_once( AWP_INC_PATH . 'compatiblity/wpml/class-wpml-widget-pack-user-login.php' );
		require_once( AWP_INC_PATH . 'compatiblity/wpml/class-wpml-widget-pack-video-gallery.php' );
	}

	/**
	 * Add widget pack translation nodes
	 * @param array $nodes_to_translate
	 * @return array
	 */
	public function add_translatable_nodes( $nodes_to_translate ) {

		$nodes_to_translate[ 'avt-accordion' ] = [
			'conditions' => [ 'widgetType' => 'avt-accordion' ],
			'fields'     => [],
			'integration-class' => 'WPML_WidgetPack_Accordion',
		];
		
		$nodes_to_translate[ 'avt-advanced-button' ] = [
			'conditions' => [ 'widgetType' => 'avt-advanced-button' ],
			'fields'     => [
				[
					'field'       => 'text',
					'type'        => esc_html__( 'Button Text', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				
			],
		];
		
		$nodes_to_translate[ 'avt-advanced-gmap' ] = [
			'conditions' => [ 'widgetType' => 'avt-advanced-gmap' ],
			'fields'     => [
				[
					'field'       => 'avd_google_map_style',
					'type'        => esc_html__( 'Style Json Code', 'avator-widget-pack' ),
					'editor_type' => 'AREA',
				],
			],
			'integration-class' => 'WPML_WidgetPack_GoogleMaps',
		];

		$nodes_to_translate[ 'avt-advanced-heading' ] = [
			'conditions' => [ 'widgetType' => 'avt-advanced-heading' ],
			'fields'     => [
				[
					'field'       => 'sub_heading',
					'type'        => esc_html__( 'Sub Heading', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'main_heading',
					'type'        => esc_html__( 'Main Heading', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],

			],
		];

		$nodes_to_translate[ 'avt-advanced-icon-box' ] = [
			'conditions' => [ 'widgetType' => 'avt-advanced-icon-box' ],
			'fields'     => [
				[
					'field'       => 'title_text',
					'type'        => esc_html__( 'Title', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'description_text',
					'type'        => esc_html__( 'Description', 'avator-widget-pack' ),
					'editor_type' => 'AREA',
				],
				[
					'field'       => 'readmore_text',
					'type'        => esc_html__( 'Readmore Text', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'onclick_event',
					'type'        => esc_html__( 'OnClick Event', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'badge_text',
					'type'        => esc_html__( 'Badge Text', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'icon_radius_advanced',
					'type'        => esc_html__( 'Radius', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
			],
		];

		$nodes_to_translate[ 'avt-advanced-image-gallery' ] = [
			'conditions' => [ 'widgetType' => 'avt-advanced-image-gallery' ],
			'fields'     => [
				[
					'field'       => 'gallery_link_text',
					'type'        => esc_html__( 'Link Text', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
			],
		];

		$nodes_to_translate[ 'avt-animated-heading' ] = [
			'conditions' => [ 'widgetType' => 'avt-animated-heading' ],
			'fields'     => [
				[
					'field'       => 'pre_heading',
					'type'        => esc_html__( 'Prefix Heading', 'avator-widget-pack' ),
					'editor_type' => 'AREA',
				],
				[
					'field'       => 'animated_heading',
					'type'        => esc_html__( 'Heading', 'avator-widget-pack' ),
					'editor_type' => 'AREA',
				],
				[
					'field'       => 'post_heading',
					'type'        => esc_html__( 'Post Heading', 'avator-widget-pack' ),
					'editor_type' => 'AREA',
				],
			],
		];

		$nodes_to_translate[ 'avt-audio-player' ] = [
			'conditions' => [ 'widgetType' => 'avt-audio-player' ],
			'fields'     => [
				[
					'field'       => 'title',
					'type'        => esc_html__( 'Audio Title', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'author_name',
					'type'        => esc_html__( 'Author Name', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
			],
		];

		$nodes_to_translate[ 'avt-business-hours' ] = [
			'conditions' => [ 'widgetType' => 'avt-business-hours' ],
			'fields'     => [],
			'integration-class' => 'WPML_WidgetPack_Business_Hours',
		];

		$nodes_to_translate[ 'avt-call-out' ] = [
			'conditions' => [ 'widgetType' => 'avt-call-out' ],
			'fields'     => [
				[
					'field'       => 'title',
					'type'        => esc_html__( 'Title', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'description',
					'type'        => esc_html__( 'Description', 'avator-widget-pack' ),
					'editor_type' => 'AREA',
				],
				[
					'field'       => 'button_text',
					'type'        => esc_html__( 'Text', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
			],
		];

		$nodes_to_translate[ 'avt-carousel' ] = [
			'conditions' => [ 'widgetType' => 'avt-carousel' ],
			'fields'     => [
				[
					'field'       => 'read_more_text',
					'type'        => esc_html__( 'Read More Text', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
			],
		];

		$nodes_to_translate[ 'avt-chart' ] = [
			'conditions' => [ 'widgetType' => 'avt-chart' ],
			'fields'     => [
				[
					'field'       => 'labels',
					'type'        => esc_html__( 'Label Values', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'single_label',
					'type'        => esc_html__( 'Label', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'single_datasets',
					'type'        => esc_html__( 'Data', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
			],
			'integration-class' => 'WPML_WidgetPack_Chart',
		];

		$nodes_to_translate[ 'avt-circle-menu' ] = [
			'conditions' => [ 'widgetType' => 'avt-circle-menu' ],
			'fields'     => [],
			'integration-class' => 'WPML_WidgetPack_Circle_Menu',
		];

		$nodes_to_translate[ 'avt-contact-form' ] = [
			'conditions' => [ 'widgetType' => 'avt-contact-form' ],
			'fields'     => [
				[
					'field'       => 'button_text',
					'type'        => esc_html__( 'Text', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'user_name_label',
					'type'        => esc_html__( 'Label', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'user_name_placeholder',
					'type'        => esc_html__( 'Placeholder', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'contact_label',
					'type'        => esc_html__( 'Label', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'contact_placeholder',
					'type'        => esc_html__( 'Placeholder', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'subject_label',
					'type'        => esc_html__( 'Label', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'subject_placeholder',
					'type'        => esc_html__( 'Placeholder', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'email_address_label',
					'type'        => esc_html__( 'Label', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'email_placeholder',
					'type'        => esc_html__( 'Placeholder', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'message_label',
					'type'        => esc_html__( 'Label', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'message_placeholder',
					'type'        => esc_html__( 'Placeholder', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'additional_message',
					'type'        => esc_html__( 'Message', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
			],
		];

		$nodes_to_translate[ 'avt-cookie-consent' ] = [
			'conditions' => [ 'widgetType' => 'avt-cookie-consent' ],
			'fields'     => [
				[
					'field'       => 'message',
					'type'        => esc_html__( 'Message', 'avator-widget-pack' ),
					'editor_type' => 'AREA',
				],
				[
					'field'       => 'button_text',
					'type'        => esc_html__( 'Button Text', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'learn_more_text',
					'type'        => esc_html__( 'Learn More Text', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
			],
		];

		$nodes_to_translate[ 'avt-countdown' ] = [
			'conditions' => [ 'widgetType' => 'avt-countdown' ],
			'fields'     => [
				[
					'field'       => 'label_days',
					'type'        => esc_html__( 'Days', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'label_hours',
					'type'        => esc_html__( 'Hours', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'label_minutes',
					'type'        => esc_html__( 'Minutes', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'label_seconds',
					'type'        => esc_html__( 'Seconds', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
			],
		];

		$nodes_to_translate[ 'avt-custom-carousel' ] = [
			'conditions' => [ 'widgetType' => 'avt-custom-carousel' ],
			'fields'     => [],
			'integration-class' => 'WPML_WidgetPack_Custom_Carousel',
		];

		$nodes_to_translate[ 'avt-custom-gallery' ] = [
			'conditions' => [ 'widgetType' => 'avt-custom-gallery' ],
			'fields'     => [],
			'integration-class' => 'WPML_WidgetPack_Custom_Gallery',
		];

		$nodes_to_translate[ 'avt-device-slider' ] = [
			'conditions' => [ 'widgetType' => 'avt-device-slider' ],
			'fields'     => [],
			'integration-class' => 'WPML_WidgetPack_Device_Slider',
		];

		$nodes_to_translate[ 'avt-download-monitor' ] = [
			'conditions' => [ 'widgetType' => 'avt-download-monitor' ],
			'fields'     => [
				[
					'field'       => 'alt_title',
					'type'        => esc_html__( 'Alternative Title', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
			],
		];

		$nodes_to_translate[ 'avt-dropbar' ] = [
			'conditions' => [ 'widgetType' => 'avt-dropbar' ],
			'fields'     => [
				[
					'field'       => 'button_text',
					'type'        => esc_html__( 'Text', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
			],
		];

		$nodes_to_translate[ 'avt-dual-button' ] = [
			'conditions' => [ 'widgetType' => 'avt-dual-button' ],
			'fields'     => [
				[
					'field'       => 'middle_text',
					'type'        => esc_html__( 'Text', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'button_a_text',
					'type'        => esc_html__( 'Text', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'button_a_onclick_event',
					'type'        => esc_html__( 'OnClick Event', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'button_b_text',
					'type'        => esc_html__( 'Text', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'button_b_onclick_event',
					'type'        => esc_html__( 'OnClick Event', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
			],
		];

		$nodes_to_translate[ 'avt-faq' ] = [
			'conditions' => [ 'widgetType' => 'avt-faq' ],
			'fields'     => [
				[
					'field'       => 'more_button_button_text',
					'type'        => esc_html__( 'Text', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
			],
		];

		$nodes_to_translate[ 'avt-flip-box' ] = [
			'conditions' => [ 'widgetType' => 'avt-flip-box' ],
			'fields'     => [
				[
					'field'       => 'front_title_text',
					'type'        => esc_html__( 'Title', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'front_description_text',
					'type'        => esc_html__( 'Description', 'avator-widget-pack' ),
					'editor_type' => 'AREA',
				],
				[
					'field'       => 'back_title_text',
					'type'        => esc_html__( 'Title', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'back_description_text',
					'type'        => esc_html__( 'Description', 'avator-widget-pack' ),
					'editor_type' => 'AREA',
				],
				[
					'field'       => 'button_text',
					'type'        => esc_html__( 'Button Text', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
			],
		];

		$nodes_to_translate[ 'avt-helpdesk' ] = [
			'conditions' => [ 'widgetType' => 'avt-helpdesk' ],
			'fields'     => [
				[
					'field'       => 'helpdesk_title',
					'type'        => esc_html__( 'Main Icon Title', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'messenger_title',
					'type'        => esc_html__( 'Title', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'messenger_onclick_event',
					'type'        => esc_html__( 'OnClick Event', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'whatsapp_title',
					'type'        => esc_html__( 'Title', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'whatsapp_onclick_event',
					'type'        => esc_html__( 'OnClick Event', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'telegram_title',
					'type'        => esc_html__( 'Title', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'telegram_onclick_event',
					'type'        => esc_html__( 'OnClick Event', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'custom_title',
					'type'        => esc_html__( 'Title', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'custom_onclick_event',
					'type'        => esc_html__( 'OnClick Event', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'mailto_title',
					'type'        => esc_html__( 'Title', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'mailto_subject',
					'type'        => esc_html__( 'Subject', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'mailto_body',
					'type'        => esc_html__( 'Body Text', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'mailto_onclick_event',
					'type'        => esc_html__( 'OnClick Event', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
			],
		];

		$nodes_to_translate[ 'avt-iconnav' ] = [
			'conditions' => [ 'widgetType' => 'avt-iconnav' ],
			'fields'     => [],
			'integration-class' => 'WPML_WidgetPack_IconNav',
		];

		$nodes_to_translate[ 'avt-image-compare' ] = [
			'conditions' => [ 'widgetType' => 'avt-image-compare' ],
			'fields'     => [
				[
					'field'       => 'before_label',
					'type'        => esc_html__( 'Before Label', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'after_label',
					'type'        => esc_html__( 'After Label', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
			],
		];

		$nodes_to_translate[ 'avt-instagram' ] = [
			'conditions' => [ 'widgetType' => 'avt-instagram' ],
			'fields'     => [
				[
					'field'       => 'username',
					'type'        => esc_html__( 'Username', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'follow_me_text',
					'type'        => esc_html__( 'Follow Me Text', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
			],
		];

		$nodes_to_translate[ 'avt-instagram-feed' ] = [
			'conditions' => [ 'widgetType' => 'avt-instagram-feed' ],
			'fields'     => [
				[
					'field'       => 'buttontext',
					'type'        => esc_html__( 'Button Text', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'followtext',
					'type'        => esc_html__( 'Follow Text', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
			],
		];

		$nodes_to_translate[ 'lightbox' ] = [
			'conditions' => [ 'widgetType' => 'lightbox' ],
			'fields'     => [
				[
					'field'       => 'button_text',
					'type'        => esc_html__( 'Button Text', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'content_caption',
					'type'        => esc_html__( 'Content Caption', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
			],
		];

		$nodes_to_translate[ 'avt-mailchimp' ] = [
			'conditions' => [ 'widgetType' => 'avt-mailchimp' ],
			'fields'     => [
				[
					'field'       => 'before_text',
					'type'        => esc_html__( 'Before Text', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'email_field_placeholder',
					'type'        => esc_html__( 'Email Field Placeholder', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'after_text',
					'type'        => esc_html__( 'After Text', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'button_text',
					'type'        => esc_html__( 'Button Text', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
			],
		];

		$nodes_to_translate[ 'avt-marker' ] = [
			'conditions' => [ 'widgetType' => 'avt-marker' ],
			'fields'     => [
				[
					'field'       => 'caption',
					'type'        => esc_html__( 'Caption', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
			],
			'integration-class' => 'WPML_WidgetPack_Marker',
		];

		$nodes_to_translate[ 'avt-member' ] = [
			'conditions' => [ 'widgetType' => 'avt-member' ],
			'fields'     => [
				[
					'field'       => 'name',
					'type'        => esc_html__( 'Member Name', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'description_text',
					'type'        => esc_html__( 'Member Description', 'avator-widget-pack' ),
					'editor_type' => 'AREA',
				],
				[
					'field'       => 'role',
					'type'        => esc_html__( 'Member Role', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],

			],
			'integration-class' => 'WPML_WidgetPack_Team_Member',
		];

		$nodes_to_translate[ 'avt-modal' ] = [
			'conditions' => [ 'widgetType' => 'avt-modal' ],
			'fields'     => [
				[
					'field'       => 'modal_custom_id',
					'type'        => esc_html__( 'Modal Selector', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'button_text',
					'type'        => esc_html__( 'Text', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'header',
					'type'        => esc_html__( 'Header', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'content',
					'type'        => esc_html__( 'Content', 'avator-widget-pack' ),
					'editor_type' => 'AREA',
				],
				[
					'field'       => 'footer',
					'type'        => esc_html__( 'Footer', 'avator-widget-pack' ),
					'editor_type' => 'AREA',
				],
			],
		];

		$nodes_to_translate[ 'avt-news-ticker' ] = [
			'conditions' => [ 'widgetType' => 'avt-news-ticker' ],
			'fields'     => [
				[
					'field'       => 'news_label',
					'type'        => esc_html__( 'Label', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
			],
		];

		$nodes_to_translate[ 'avt-offcanvas' ] = [
			'conditions' => [ 'widgetType' => 'avt-offcanvas' ],
			'fields'     => [
				[
					'field'       => 'offcanvas_custom_id',
					'type'        => esc_html__( 'Offcanvas Selector', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'custom_content_before',
					'type'        => esc_html__( 'Custom Content Before', 'avator-widget-pack' ),
					'editor_type' => 'AREA',
				],
				[
					'field'       => 'custom_content_after',
					'type'        => esc_html__( 'Custom Content After', 'avator-widget-pack' ),
					'editor_type' => 'AREA',
				],
				[
					'field'       => 'button_text',
					'type'        => esc_html__( 'Button Text', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
			],
		];

		$nodes_to_translate[ 'avt-open-street-map' ] = [
			'conditions' => [ 'widgetType' => 'avt-open-street-map' ],
			'fields'     => [],
			'integration-class' => 'WPML_WidgetPack_Open_Street_Map',
		];

		$nodes_to_translate[ 'avt-panel-slider' ] = [
			'conditions' => [ 'widgetType' => 'avt-panel-slider' ],
			'fields'     => [],
			'integration-class' => 'WPML_WidgetPack_Panel_Slider',
		];

		$nodes_to_translate[ 'avt-post-block' ] = [
			'conditions' => [ 'widgetType' => 'avt-post-block' ],
			'fields'     => [
				[
					'field'       => 'read_more_text',
					'type'        => esc_html__( 'Read More Text', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
			],
		];

		$nodes_to_translate[ 'avt-post-block-modern' ] = [
			'conditions' => [ 'widgetType' => 'avt-post-block-modern' ],
			'fields'     => [
				[
					'field'       => 'read_more_text',
					'type'        => esc_html__( 'Read More Text', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
			],
		];
		
		$nodes_to_translate[ 'avt-post-card' ] = [
			'conditions' => [ 'widgetType' => 'avt-post-card' ],
			'fields'     => [
				[
					'field'       => 'button_text',
					'type'        => esc_html__( 'Text', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
			],
		];

		$nodes_to_translate[ 'avt-post-grid' ] = [
			'conditions' => [ 'widgetType' => 'avt-post-grid' ],
			'fields'     => [
				[
					'field'       => 'readmore_text',
					'type'        => esc_html__( 'Read More Text', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
			],
		];

		$nodes_to_translate[ 'avt-post-grid-tab' ] = [
			'conditions' => [ 'widgetType' => 'avt-post-grid-tab' ],
			'fields'     => [
				[
					'field'       => 'readmore_text',
					'type'        => esc_html__( 'Read More Text', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
			],
		];

		$nodes_to_translate[ 'avt-post-slider' ] = [
			'conditions' => [ 'widgetType' => 'avt-post-slider' ],
			'fields'     => [
				[
					'field'       => 'button_text',
					'type'        => esc_html__( 'Button Text', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
			],
		];

		$nodes_to_translate[ 'avt-price-list' ] = [
			'conditions' => [ 'widgetType' => 'avt-price-list' ],
			'fields'     => [],
			'integration-class' => 'WPML_WidgetPack_Price_List',
		];

		$nodes_to_translate[ 'avt-price-table' ] = [
			'conditions' => [ 'widgetType' => 'avt-price-table' ],
			'fields'     => [
				[
					'field'       => 'heading',
					'type'        => esc_html__( 'Title', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'sub_heading',
					'type'        => esc_html__( 'Subtitle', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'currency_symbol_custom',
					'type'        => esc_html__( 'Custom Symbol', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'price',
					'type'        => esc_html__( 'Price', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'period',
					'type'        => esc_html__( 'Period', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'item_text',
					'type'        => esc_html__( 'Text', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'tooltip_text',
					'type'        => esc_html__( 'Text', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'button_text',
					'type'        => esc_html__( 'Button Text', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'footer_additional_info',
					'type'        => esc_html__( 'Additional Info', 'avator-widget-pack' ),
					'editor_type' => 'AREA',
				],
				[
					'field'       => 'ribbon_title',
					'type'        => esc_html__( 'Title', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
			],
		];

		$nodes_to_translate[ 'avt-progress-pie' ] = [
			'conditions' => [ 'widgetType' => 'avt-progress-pie' ],
			'fields'     => [
				[
					'field'       => 'percent',
					'type'        => esc_html__( 'Percent', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'title',
					'type'        => esc_html__( 'Progress Pie Title', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'before',
					'type'        => esc_html__( 'Before Text', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'text',
					'type'        => esc_html__( 'Middle Text', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'after',
					'type'        => esc_html__( 'After Text', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
			],
		];

		$nodes_to_translate[ 'avt-protected-content' ] = [
			'conditions' => [ 'widgetType' => 'avt-protected-content' ],
			'fields'     => [
				[
					'field'       => 'content_password',
					'type'        => esc_html__( 'Set Password', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'protected_custom_content',
					'type'        => esc_html__( 'Custom Content', 'avator-widget-pack' ),
					'editor_type' => 'AREA',
				],
				[
					'field'       => 'warning_message_template',
					'type'        => esc_html__( 'Enter Template ID', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'warning_message_anywhere_template',
					'type'        => esc_html__( 'Enter Template ID', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'warning_message_text',
					'type'        => esc_html__( 'Custom Message', 'avator-widget-pack' ),
					'editor_type' => 'AREA',
				],
			],
		];

		$nodes_to_translate[ 'avt-qrcode' ] = [
			'conditions' => [ 'widgetType' => 'avt-qrcode' ],
			'fields'     => [
				[
					'field'       => 'text',
					'type'        => esc_html__( 'Content', 'avator-widget-pack' ),
					'editor_type' => 'AREA',
				],
				[
					'field'       => 'label',
					'type'        => esc_html__( 'Text', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
			],
		];

		$nodes_to_translate[ 'avt-scroll-button' ] = [
			'conditions' => [ 'widgetType' => 'avt-scroll-button' ],
			'fields'     => [
				[
					'field'       => 'scroll_button_text',
					'type'        => esc_html__( 'Button Text', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'section_id',
					'type'        => esc_html__( 'Section ID', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
			],
		];

		$nodes_to_translate[ 'avt-scroll-image' ] = [
			'conditions' => [ 'widgetType' => 'avt-scroll-image' ],
			'fields'     => [
				[
					'field'       => 'caption',
					'type'        => esc_html__( 'Caption', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'badge_text',
					'type'        => esc_html__( 'Badge Text', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
			],
		];

		$nodes_to_translate[ 'avt-scrollnav' ] = [
			'conditions' => [ 'widgetType' => 'avt-scrollnav' ],
			'fields'     => [],
			'integration-class' => 'WPML_WidgetPack_Scrollnav',
		];

		$nodes_to_translate[ 'avt-search' ] = [
			'conditions' => [ 'widgetType' => 'avt-search' ],
			'fields'     => [
				[
					'field'       => 'placeholder',
					'type'        => esc_html__( 'Placeholder', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
			],
		];

		$nodes_to_translate[ 'avt-slider' ] = [
			'conditions' => [ 'widgetType' => 'avt-slider' ],
			'fields'     => [
				[
					'field'       => 'button_text',
					'type'        => esc_html__( 'Button Text', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
			],
			'integration-class' => 'WPML_WidgetPack_Slider',
		];

		$nodes_to_translate[ 'avt-slideshow' ] = [
			'conditions' => [ 'widgetType' => 'avt-slideshow' ],
			'fields'     => [
				[
					'field'       => 'button_text',
					'type'        => esc_html__( 'Button Text', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
			],
			'integration-class' => 'WPML_WidgetPack_Slideshow',
		];

		$nodes_to_translate[ 'avt-social-share' ] = [
			'conditions' => [ 'widgetType' => 'avt-social-share' ],
			'fields'     => [],
			'integration-class' => 'WPML_WidgetPack_Social_Share',
		];

		$nodes_to_translate[ 'avt-switcher' ] = [
			'conditions' => [ 'widgetType' => 'avt-switcher' ],
			'fields'     => [
				[
					'field'       => 'switch_a_title',
					'type'        => esc_html__( 'Title', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'switch_b_title',
					'type'        => esc_html__( 'Title', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'switch_a_content',
					'type'        => esc_html__( 'Content', 'avator-widget-pack' ),
					'editor_type' => 'AREA',
				],
				[
					'field'       => 'switch_b_content',
					'type'        => esc_html__( 'Content', 'avator-widget-pack' ),
					'editor_type' => 'AREA',
				],
			],
		];

		$nodes_to_translate[ 'avt-table' ] = [
			'conditions' => [ 'widgetType' => 'avt-table' ],
			'fields'     => [
				[
					'field'       => 'content',
					'type'        => esc_html__( 'Content', 'avator-widget-pack' ),
					'editor_type' => 'AREA',
				],
			],
		];

		$nodes_to_translate[ 'avt-table-of-content' ] = [
			'conditions' => [ 'widgetType' => 'avt-table-of-content' ],
			'fields'     => [
				[
					'field'       => 'button_text',
					'type'        => esc_html__( 'Button Text', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'context',
					'type'        => esc_html__( 'Index Area (any class/id selector)', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'toc_index_header',
					'type'        => esc_html__( 'Index Header Text', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'toc_sticky_edge',
					'type'        => esc_html__( 'Scroll Until', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
			],
		];

		$nodes_to_translate[ 'avt-tabs' ] = [
			'conditions' => [ 'widgetType' => 'avt-tabs' ],
			'fields'     => [],
			'integration-class' => 'WPML_WidgetPack_Tabs',
		];

		$nodes_to_translate[ 'avt-thumb-gallery' ] = [
			'conditions' => [ 'widgetType' => 'avt-thumb-gallery' ],
			'fields'     => [
				[
					'field'       => 'button_text',
					'type'        => esc_html__( 'Button Text', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
			],
		];

		$nodes_to_translate[ 'avt-timeline' ] = [
			'conditions' => [ 'widgetType' => 'avt-timeline' ],
			'fields'     => [
				[
					'field'       => 'readmore_text',
					'type'        => esc_html__( 'Read More Text', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
			],
			'integration-class' => 'WPML_WidgetPack_Timeline',
		];

		$nodes_to_translate[ 'avt-toggle' ] = [
			'conditions' => [ 'widgetType' => 'avt-toggle' ],
			'fields'     => [
				[
					'field'       => 'toggle_title',
					'type'        => esc_html__( 'Normal Title', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'toggle_open_title',
					'type'        => esc_html__( 'Opened Title', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'toggle_content',
					'type'        => esc_html__( 'Content', 'avator-widget-pack' ),
					'editor_type' => 'AREA',
				],
			],
		];

		$nodes_to_translate[ 'avt-trailer-box' ] = [
			'conditions' => [ 'widgetType' => 'avt-trailer-box' ],
			'fields'     => [
				[
					'field'       => 'pre_title',
					'type'        => esc_html__( 'Pre Title', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'title',
					'type'        => esc_html__( 'Title', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'content',
					'type'        => esc_html__( 'Content', 'avator-widget-pack' ),
					'editor_type' => 'AREA',
				],
				[
					'field'       => 'button_text',
					'type'        => esc_html__( 'Text', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
			],
		];

		$nodes_to_translate[ 'avt-user-login' ] = [
			'conditions' => [ 'widgetType' => 'avt-user-login' ],
			'fields'     => [
				[
					'field'       => 'button_text',
					'type'        => esc_html__( 'Text', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'logged_in_custom_message',
					'type'        => esc_html__( 'Custom Message', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'user_label',
					'type'        => esc_html__( 'Username Label', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'user_placeholder',
					'type'        => esc_html__( 'Username Placeholder', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'password_label',
					'type'        => esc_html__( 'Password Label', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'password_placeholder',
					'type'        => esc_html__( 'Password Placeholder', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
			],
			'integration-class' => 'WPML_WidgetPack_User_Login',
		];

		$nodes_to_translate[ 'avt-user-register' ] = [
			'conditions' => [ 'widgetType' => 'avt-user-register' ],
			'fields'     => [
				[
					'field'       => 'button_text',
					'type'        => esc_html__( 'Text', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'first_name_label',
					'type'        => esc_html__( 'First Name Label', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'first_name_placeholder',
					'type'        => esc_html__( 'First Name Placeholder', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'last_name_label',
					'type'        => esc_html__( 'Last Name Label', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'last_name_placeholder',
					'type'        => esc_html__( 'Last Name Placeholder', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'email_label',
					'type'        => esc_html__( 'Email Label', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'email_placeholder',
					'type'        => esc_html__( 'Email Placeholder', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'additional_message',
					'type'        => esc_html__( 'Additional Message', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
			],
		];

		$nodes_to_translate[ 'avt-video-gallery' ] = [
			'conditions' => [ 'widgetType' => 'avt-video-gallery' ],
			'fields'     => [],
			'integration-class' => 'WPML_WidgetPack_Video_Gallery',
		];

		$nodes_to_translate[ 'avt-video-player' ] = [
			'conditions' => [ 'widgetType' => 'avt-video-player' ],
			'fields'     => [
				[
					'field'       => 'title',
					'type'        => esc_html__( 'Title', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'source',
					'type'        => esc_html__( 'Video Source', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
			],
		];

		$nodes_to_translate[ 'avt-weather' ] = [
			'conditions' => [ 'widgetType' => 'avt-weather' ],
			'fields'     => [
				[
					'field'       => 'location',
					'type'        => esc_html__( 'Location', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'country',
					'type'        => esc_html__( 'Country (optional)', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
			],
		];
		
		$nodes_to_translate[ 'avt-wc-slider' ] = [
			'conditions' => [ 'widgetType' => 'avt-wc-slider' ],
			'fields'     => [
				[
					'field'       => 'readmore_text',
					'type'        => esc_html__( 'Read More Text', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'button_text',
					'type'        => esc_html__( 'Button Text', 'avator-widget-pack' ),
					'editor_type' => 'LINE',
				],
			],
		];


		return $nodes_to_translate;
	}

	/**
	 * Returns the instance.
	 * @since  3.1.0
	 * @return object
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}
}
