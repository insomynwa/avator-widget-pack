<?php
namespace WidgetPack\Modules\CustomGallery\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Utils;

use WidgetPack\Modules\CustomGallery\Skins;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Custom_Gallery extends Widget_Base {

	public function get_name() {
		return 'avt-custom-gallery';
	}

	public function get_title() {
		return AWP . esc_html__( 'Custom Gallery', 'avator-widget-pack' );
	}

	public function get_icon() {
		return 'avt-wi-custom-gallery';
	}

	public function get_categories() {
		return [ 'widget-pack' ];
	}

	public function get_keywords() {
		return [ 'custom', 'gallery', 'photo', 'image' ];
	}

	public function get_script_depends() {
		return [ 'imagesloaded', 'avt-uikit-icons', 'tilt' ];
	}

	public function _register_skins() {
		$this->add_skin( new Skins\Skin_Abetis( $this ) );
		$this->add_skin( new Skins\Skin_Fedara( $this ) );
	}

	public function _register_controls() {
		$this->start_controls_section(
			'section_custom_gallery_content',
			[
				'label' => esc_html__( 'Custom Gallery', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'gallery',
			[
				'label' => esc_html__( 'Gallery Items', 'avator-widget-pack' ),
				'type' => Controls_Manager::REPEATER,
				'default' => [
					[
						'image_title'   => esc_html__( 'Image #1', 'avator-widget-pack' ),
						'image_text'    => esc_html__( 'I am item content. Click edit button to change this text.', 'avator-widget-pack' ),
						'gallery_image' => ['url' => AWP_ASSETS_URL . 'images/gallery/item-1.png'],

					],
					[
						'image_title'   => esc_html__( 'Image #2', 'avator-widget-pack' ),
						'image_text'    => esc_html__( 'I am item content. Click edit button to change this text.', 'avator-widget-pack' ),
						'gallery_image' => ['url' => AWP_ASSETS_URL . 'images/gallery/item-2.png'],
					],
					[
						'image_title'   => esc_html__( 'Image #3', 'avator-widget-pack' ),
						'image_text'    => esc_html__( 'I am item content. Click edit button to change this text.', 'avator-widget-pack' ),
						'gallery_image' => ['url' => AWP_ASSETS_URL . 'images/gallery/item-3.png'],
					],
					[
						'image_title'   => esc_html__( 'Image #4', 'avator-widget-pack' ),
						'image_text'    => esc_html__( 'I am item content. Click edit button to change this text.', 'avator-widget-pack' ),
						'gallery_image' => ['url' => AWP_ASSETS_URL . 'images/gallery/item-4.png'],
					],
					[
						'image_title'   => esc_html__( 'Image #5', 'avator-widget-pack' ),
						'image_text'    => esc_html__( 'I am item content. Click edit button to change this text.', 'avator-widget-pack' ),
						'gallery_image' => ['url' => AWP_ASSETS_URL . 'images/gallery/item-5.png'],
					],
					[
						'image_title'   => esc_html__( 'Image #6', 'avator-widget-pack' ),
						'image_text'    => esc_html__( 'I am item content. Click edit button to change this text.', 'avator-widget-pack' ),
						'gallery_image' => ['url' => AWP_ASSETS_URL . 'images/gallery/item-6.png'],
					],
				],
				'fields' => [
					[
						'name'    => 'image_title',
						'label'   => esc_html__( 'Title', 'avator-widget-pack' ),
						'type'    => Controls_Manager::TEXT,
						'dynamic' => [ 'active' => true ],
						'default' => esc_html__( 'Slide Title' , 'avator-widget-pack' ),
					],
					
					[
						'name'    => 'gallery_image',
						'label'   => esc_html__( 'Image', 'avator-widget-pack' ),
						'type'    => Controls_Manager::MEDIA,
						'dynamic' => [ 'active' => true ],
						'default' => [
							'url' => AWP_ASSETS_URL . 'images/gallery/item-'.rand(1,8).'.png',
						],
					],

					[
						'name'    => 'image_text',
						'label'   => esc_html__( 'Content', 'avator-widget-pack' ),
						'type'    => Controls_Manager::TEXTAREA,
						'dynamic' => [ 'active' => true ],
						'default' => esc_html__( 'Slide Content', 'avator-widget-pack' ),
					],

					[
						'name'    => 'image_link_type',
						'label'       => esc_html__( 'Lightbox/Link', 'avator-widget-pack' ),
						'type'        => Controls_Manager::SELECT,
						'default'     => '',
						'label_block' => true,
						'options'     => [
							''           => esc_html__( 'Selected Image', 'avator-widget-pack' ),
							'website'    => esc_html__( 'Website', 'avator-widget-pack' ),
							'video'      => esc_html__( 'Video', 'avator-widget-pack' ),
							'youtube'    => esc_html__( 'YouTube', 'avator-widget-pack' ),
							'vimeo'      => esc_html__( 'Vimeo', 'avator-widget-pack' ),
							'google-map' => esc_html__( 'Google Map', 'avator-widget-pack' ),
						],
					],

					[
						'name'          => 'image_link_video',
						'label'         => __( 'Video Source', 'avator-widget-pack' ),
						'type'          => Controls_Manager::URL,
						'show_external' => false,
						'default'       => [
							'url' => '//clips.vorwaerts-gmbh.de/big_buck_bunny.mp4',
						],
						'placeholder'   => '//example.com/video.mp4',
						'label_block'   => true,
						'condition'     => [
							'image_link_type' => 'video',
						],
						'dynamic'     => [ 'active' => true ],
					],
					[
						'name'          => 'image_link_youtube',
						'label'         => __( 'YouTube Source', 'avator-widget-pack' ),
						'type'          => Controls_Manager::URL,
						'show_external' => false,
						'default'       => [
							'url' => 'https://www.youtube.com/watch?v=YE7VzlLtp-4',
						],
						'placeholder'   => 'https://youtube.com/watch?v=xyzxyz',
						'label_block'   => true,
						'condition'     => [
							'image_link_type' => 'youtube',
						],
						'dynamic'     => [ 'active' => true ],
					],
					[
						'name'          => 'image_link_vimeo',
						'label'         => __( 'Vimeo Source', 'avator-widget-pack' ),
						'type'          => Controls_Manager::URL,
						'show_external' => false,
						'default'       => [
							'url' => 'https://vimeo.com/1084537',
						],
						'placeholder'   => 'https://vimeo.com/123123',
						'label_block'   => true,
						'condition'     => [
							'image_link_type' => 'vimeo',
						],
						'dynamic'     => [ 'active' => true ],
					],
					[
						'name'          => 'image_link_google_map',
						'label'         => __( 'Goggle Map Embed URL', 'avator-widget-pack' ),
						'type'          => Controls_Manager::URL,
						'show_external' => false,
						'default'       => [
							'url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4740.819266853735!2d9.99008871708242!3d53.550454675412404!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x3f9d24afe84a0263!2sRathaus!5e0!3m2!1sde!2sde!4v1499675200938',
						],
						'placeholder'   => '//google.com/maps/embed?pb',
						'label_block'   => true,
						'condition'     => [
							'image_link_type' => 'google-map',
						],
						'dynamic'     => [ 'active' => true ],
					],
					
					[
						'name'          => 'image_link_website',
						'label'         => esc_html__( 'Custom Link', 'avator-widget-pack' ),
						'type'          => Controls_Manager::URL,
						'show_external' => false,
						'condition'     => [
							'image_link_type' => 'website',
						],
						'dynamic' => [ 'active' => true ],
					],
				],
				'title_field' => '{{{ image_title }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_custom_gallery_layout',
			[
				'label' => esc_html__( 'Layout', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'columns',
			[
				'label'          => esc_html__( 'Columns', 'avator-widget-pack' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => '3',
				'tablet_default' => '2',
				'mobile_default' => '1',
				'options'        => [
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6',
				],
				'frontend_available' => true,
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'         => 'thumbnail_size',
				'label'        => esc_html__( 'Image Size', 'avator-widget-pack' ),
				'exclude'      => [ 'custom' ],
				'default'      => 'medium',
				'prefix_class' => 'avt-custom-gallery--thumbnail-size-',
			]
		);

		$this->add_control(
			'masonry',
			[
				'label' => esc_html__( 'Masonry', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_responsive_control(
			'item_ratio',
			[
				'label'   => esc_html__( 'Item Height', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 265,
				],
				'range' => [
					'px' => [
						'min'  => 50,
						'max'  => 500,
						'step' => 5,
					],
				],
				'selectors' => [
					'#avt-custom-gallery-{{ID}} .avt-gallery-thumbnail img' => 'height: {{SIZE}}px',
				],
				'condition' => [
					'masonry!' => 'yes',
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_layout_additional',
			[
				'label' => esc_html__( 'Additional', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'overlay_animation',
			[
				'label'   => esc_html__( 'Overlay Animation', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'fade',
				'options' => widget_pack_transition_options(),
                'conditions'   => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name'     => 'show_title',
                            'value'    => 'yes',
                        ],
                        [
                            'name'     => 'show_text',
                            'value'    => 'yes',
                        ],
                        [
                            'name'     => 'show_lightbox',
                            'value'    => 'yes',
                        ],
                    ],
                ],
			]
		);

		$this->add_control(
			'show_title',
			[
				'label'   => esc_html__( 'Title', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'title_tag',
			[
				'label'     => esc_html__( 'Title HTML Tag', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => widget_pack_title_tags(),
				'default'   => 'h3',
				'condition' => [
					'show_title' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_text',
			[
				'label'   => esc_html__( 'Text', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_lightbox',
			[
				'label'   => esc_html__( 'Lightbox', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'direct_link',
			[
				'label'   => esc_html__( 'Lightbox Link as Image Link', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
                'condition' => [
                    'show_lightbox' => '',
                ],
			]
		);

		$this->add_control(
			'external_link',
			[
				'label'   => esc_html__( 'Show in new Tab', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
                'condition' => [
                    'show_lightbox' => '',
                    'direct_link'   => 'yes',
                ],
			]
		);

		$this->add_control(
			'link_type',
			[
				'label'   => esc_html__( 'Link Type', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'icon',
				'options' => [
					'icon' => esc_html__('Icon', 'avator-widget-pack'),
					'text' => esc_html__('Text', 'avator-widget-pack'),
				],
				'condition' => [
					'show_lightbox' => 'yes',
				]
			]
		);

		$this->add_control(
			'icon',
			[
				'label'   => esc_html__( 'Icon', 'avator-widget-pack' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'plus',
				'options' => [
					'search' => [
						'icon' => 'fas fa-search-plus',
					],
					'plus-circle' => [
						'icon' => 'fas fa-plus-circle',
					],
					'plus' => [
						'icon' => 'fas fa-plus',
					],
					'link' => [
						'icon' => 'fas fa-link',
					],
					'play-circle' => [
						'icon' => 'far fa-play-circle',
					],
					'play' => [
						'icon' => 'fas fa-play',
					],
				],
				'conditions' => [
					'terms'    => [
						[
							'name'  => 'show_lightbox',
							'value' => 'yes'
						],
						[
							'name'     => 'link_type',
							'value'    => 'icon'
						]
					]
				]
			]
		);

		$this->add_control(
			'tilt_show',
			[
				'label'   => esc_html__( 'Tilt Effect', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'tilt_scale',
			[
				'label' => esc_html__( 'Tilt Scale', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 2,
						'step'=> 0.1,
					],
				],
				'condition' => [
					'tilt_show' => 'yes',
				],
			]
		);

		$this->add_control(
			'lightbox_animation',
			[
				'label'   => esc_html__( 'Lightbox Animation', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'slide',
				'options' => [
					'slide' => esc_html__( 'Slide', 'avator-widget-pack' ),
					'fade'  => esc_html__( 'Fade', 'avator-widget-pack' ),
					'scale' => esc_html__( 'Scale', 'avator-widget-pack' ),
				],
				'separator' => 'before',
				'condition' => [
					'show_lightbox' => 'yes',
				]
			]
		);

		$this->add_control(
			'lightbox_autoplay',
			[
				'label'   => __( 'Lightbox Autoplay', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'condition' => [
					'show_lightbox' => 'yes',
				]
			]
		);

		$this->add_control(
			'lightbox_pause',
			[
				'label'   => __( 'Lightbox Pause on Hover', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'condition' => [
					'show_lightbox' => 'yes',
					'lightbox_autoplay' => 'yes'
				],

			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_design_layout',
			[
				'label' => esc_html__( 'Items', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'item_gap',
			[
				'label'   => esc_html__( 'Column Gap', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 10,
				],
				'range' => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 5,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-custom-gallery.avt-grid'     => 'margin-left: -{{SIZE}}px',
					'{{WRAPPER}} .avt-custom-gallery.avt-grid > *' => 'padding-left: {{SIZE}}px',
				],
			]
		);

		$this->add_responsive_control(
			'row_gap',
			[
				'label'   => esc_html__( 'Row Gap', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 10,
				],
				'range' => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 5,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-custom-gallery.avt-grid'     => 'margin-top: -{{SIZE}}px',
					'{{WRAPPER}} .avt-custom-gallery.avt-grid > *' => 'margin-top: {{SIZE}}px',
				],
			]
		);

		$this->add_control(
			'overlay_content_alignment',
			[
				'label'   => __( 'Overlay Content Alignment', 'avator-widget-pack' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'avator-widget-pack' ),
						'icon'  => 'fas fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'avator-widget-pack' ),
						'icon'  => 'fas fa-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'avator-widget-pack' ),
						'icon'  => 'fas fa-align-right',
					],
				],
				'default' => 'center',
				'prefix_class' => 'avt-custom-gallery-skin-fedara-style-',
				'selectors' => [
					'{{WRAPPER}} .avt-custom-gallery .avt-overlay' => 'text-align: {{VALUE}}',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'overlay_content_position',
			[
				'label'       => __( 'Overlay Content Vertical Position', 'avator-widget-pack' ),
				'type'        => Controls_Manager::CHOOSE,
				'options'     => [
					'top' => [
						'title' => __( 'Top', 'avator-widget-pack' ),
						'icon'  => 'eicon-v-align-top',
					],
					'middle' => [
						'title' => __( 'Middle', 'avator-widget-pack' ),
						'icon'  => 'eicon-v-align-middle',
					],
					'bottom' => [
						'title' => __( 'Bottom', 'avator-widget-pack' ),
						'icon'  => 'eicon-v-align-bottom',
					],
				],
				'selectors_dictionary' => [
					'top'    => 'flex-start',
					'middle' => 'center',
					'bottom' => 'flex-end',
				],
				'default' => 'middle',
				'selectors' => [
					'{{WRAPPER}} .avt-custom-gallery .avt-overlay' => 'justify-content: {{VALUE}}',
				],
				'separator' => 'after',
			]
		);

		$this->add_control(
			'item_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-custom-gallery .avt-gallery-thumbnail, {{WRAPPER}} .avt-custom-gallery .avt-overlay' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'_skin' => '',
				],
			]
		);

		$this->add_control(
			'item_skin_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-custom-gallery .avt-gallery-item'      => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .avt-custom-gallery .avt-overlay'           => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} 0 0;',
					'{{WRAPPER}} .avt-custom-gallery .avt-gallery-thumbnail' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} 0 0;',
				],
				'condition' => [
					'_skin!' => '',
				],
			]
		);

		$this->add_control(
			'overlay_background',
			[
				'label'     => esc_html__( 'Overlay Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-custom-gallery .avt-gallery-item .avt-overlay' => 'background-color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'overlay_gap',
			[
				'label' => esc_html__( 'Overlay Gap', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-custom-gallery .avt-gallery-item .avt-overlay' => 'margin: {{SIZE}}px',
				],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Title Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-custom-gallery .avt-gallery-item .avt-gallery-item-title' => 'color: {{VALUE}};',
				],
				'condition' => [
					'show_title' => 'yes',
					'_skin'      => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'title_typography',
				'label'     => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'    => Scheme_Typography::TYPOGRAPHY_1,
				'selector'  => '{{WRAPPER}} .avt-gallery-item .avt-gallery-item-title',
				'condition' => [
					'show_title' => 'yes',
					'_skin'      => '',
				],
			]
		);

		$this->add_control(
			'text_color',
			[
				'label'     => esc_html__( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-custom-gallery .avt-gallery-item .avt-gallery-item-text' => 'color: {{VALUE}};',
				],
				'condition' => [
					'show_text' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'text_typography',
				'label'     => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'    => Scheme_Typography::TYPOGRAPHY_1,
				'selector'  => '{{WRAPPER}} .avt-gallery-item .avt-gallery-item-text',
				'condition' => [
					'show_text' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_button',
			[
				'label'     => esc_html__( 'Link Style', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_lightbox' => 'yes',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_button_style' );

		$this->start_controls_tab(
			'tab_button_normal',
			[
				'label' => esc_html__( 'Normal', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'button_text_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-custom-gallery .avt-gallery-item-link span'    => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'background_color',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-custom-gallery .avt-gallery-item-link' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'border',
				'label'       => esc_html__( 'Border', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-custom-gallery .avt-gallery-item-link',
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'button_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-custom-gallery .avt-gallery-item-link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_box_shadow',
				'selector' => '{{WRAPPER}} .avt-custom-gallery .avt-gallery-item-link',
			]
		);

		$this->add_control(
			'button_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-custom-gallery .avt-gallery-item-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'typography',
				'label'     => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
				'selector'  => '{{WRAPPER}} .avt-custom-gallery .avt-gallery-item-link',
				'condition' => [
					'show_lightbox' => 'yes',
					'link_type'     => 'text',
				]
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			[
				'label' => esc_html__( 'Hover', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'hover_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-custom-gallery .avt-gallery-item-link:hover span'    => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_hover_color',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-custom-gallery .avt-gallery-item-link:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-custom-gallery .avt-gallery-item-link:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}
	
	public function render_thumbnail( $item, $element_key) {
        $settings = $this->get_settings();
        $thumb_url = Group_Control_Image_Size::get_attachment_image_src( $item['gallery_image']['id'], 'thumbnail_size', $settings);

        if ( ! $thumb_url ) {
        	$thumb_url = $item['gallery_image']['url'];
        }

		?>

        <div class="avt-gallery-thumbnail">
           
            <img src="<?php echo esc_url( $thumb_url); ?>" alt="<?php echo esc_html( $item['image_title'] ); ?>">

        </div>
        <?php
	}
	
	public function render_title( $title ) {
		if ( ! $this->get_settings( 'show_title' ) ) {
			return;
		}

		$tag = $this->get_settings( 'title_tag' );
		?>
		<<?php echo esc_html($tag) ?> class="avt-gallery-item-title avt-transition-slide-top-small">
			<?php echo esc_html($title['image_title']); ?>
		</<?php echo esc_html($tag) ?>>
		<?php
	}
	
	public function render_text( $text) {
		if ( ! $this->get_settings( 'show_text' ) ) {
			return;
		}

		?>
		<div class="avt-gallery-item-text avt-transition-slide-bottom-small"><?php echo esc_html($text['image_text']); ?></div>
		<?php
	}

	public function rendar_link($content, $element_key) {

        $image_url = wp_get_attachment_image_src( $content['gallery_image']['id'], 'full');

        $this->add_render_attribute( $element_key, 'data-elementor-open-lightbox', 'no' );

		if ( $content['image_link_type'] ) {
			if ('google-map' == $content['image_link_type'] and '' != $content['image_link_google_map'] ) {
				$this->add_render_attribute( $element_key, 'href', $content['image_link_google_map']['url'] );
				$this->add_render_attribute( $element_key, 'data-type', 'iframe' );
			} elseif ('video' == $content['image_link_type'] and '' != $content['image_link_video'] ) {
				$this->add_render_attribute( $element_key, 'href', $content['image_link_video']['url'] );
				$this->add_render_attribute( $element_key, 'data-type', 'video' );
			} elseif ('youtube' == $content['image_link_type'] and '' != $content['image_link_youtube'] ) {
				$this->add_render_attribute( $element_key, 'href', $content['image_link_youtube']['url'] );
				$this->add_render_attribute( $element_key, 'data-type', false );
			} elseif ('vimeo' == $content['image_link_type'] and '' != $content['image_link_vimeo'] ) {
				$this->add_render_attribute( $element_key, 'href', $content['image_link_vimeo']['url'] );
				$this->add_render_attribute( $element_key, 'data-type', false );
			} else {
				$this->add_render_attribute( $element_key, 'href', $content['image_link_website']['url'] );
				$this->add_render_attribute( $element_key, 'data-type', 'iframe' );
			}
		} else {
			if ( ! $image_url ) {
				$this->add_render_attribute( $element_key, 'href', $content['gallery_image']['url'] );
			} else {
				$this->add_render_attribute( $element_key, 'href', $image_url[0] );
			}
		}
	}

	public function render_overlay( $content, $element_key) {
        $settings = $this->get_settings();

        if ( ! $settings['show_title'] and ! $settings['show_text'] and ! $settings['show_lightbox'] ) {
            return;
        }

		$this->add_render_attribute( 'overlay-settings', 'class', ['avt-overlay', 'avt-overlay-default', 'avt-position-cover'], true );
		
		if ($settings['overlay_animation']) {
			$this->add_render_attribute( 'overlay-settings', 'class', 'avt-transition-' . $settings['overlay_animation'] );
		}

        $image_url = wp_get_attachment_image_src( $content['gallery_image']['id'], 'full');


		?>
		<div <?php echo $this->get_render_attribute_string( 'overlay-settings' ); ?>>
			<div class="avt-custom-gallery-content">
				<div class="avt-custom-gallery-content-inner">
					
					

					<?php if ( $settings['show_lightbox'] )  :

						$this->rendar_link( $content, $element_key );

						
						$this->add_render_attribute( $element_key, 'class', ['avt-gallery-item-link', 'avt-gallery-lightbox-item'] );
						
						$this->add_render_attribute( $element_key, 'data-caption', $content['image_title'] );

						$icon = $settings['icon'] ? : 'plus';
						
						?>
						<div class="avt-flex-inline avt-gallery-item-link-wrapper">
							<a <?php echo $this->get_render_attribute_string( $element_key ); ?>>
								<?php if ( 'icon' == $settings['link_type'] ) : ?>
									<span avt-icon="icon: <?php echo esc_attr( $icon); ?>; ratio: 1.6"></span>
								<?php elseif ( 'text' == $settings['link_type'] ) : ?>
									<span class="avt-text"><?php esc_html_e( 'ZOOM', 'avator-widget-pack' ); ?></span>
								<?php endif;?>
							</a>
						</div>
					<?php endif; ?>

					<?php 
					$this->render_title( $content);
					$this->render_text( $content);
					?>

				</div>
			</div>
		</div>
		<?php
	}

	public function render_header( $skin = 'default') {
		$settings = $this->get_settings();
		$id       = $this->get_id();

		$this->add_render_attribute('custom-gallery', 'id', 'avt-custom-gallery-' . $id );
		$this->add_render_attribute('custom-gallery', 'class', ['avt-custom-gallery', 'avt-custom-gallery-skin-' . esc_attr( $skin)] );
		$this->add_render_attribute('custom-gallery', 'class', ['avt-grid', 'avt-grid-small'] );
		
		if ( 'yes' === $settings['masonry'] ) {
			$this->add_render_attribute('custom-gallery', 'avt-grid', 'masonry: true');
		}

		if ( $settings['show_lightbox'] ) {
			$this->add_render_attribute('custom-gallery', 'avt-lightbox', 'toggle: .avt-gallery-lightbox-item; animation:' . $settings['lightbox_animation'] . ';');
			if ( $settings['lightbox_autoplay'] ) {
				$this->add_render_attribute('custom-gallery', 'avt-lightbox', 'autoplay: 500;');
				
				if ( $settings['lightbox_pause'] ) {
					$this->add_render_attribute('custom-gallery', 'avt-lightbox', 'pause-on-hover: true;');
				}
			}
		}

		?>
		<div <?php echo $this->get_render_attribute_string( 'custom-gallery' ); ?>>
		<?php
	}

	public function render_footer() {
		$settings = $this->get_settings();

		?>
		</div>
		<?php
	}

	public function render() {
		$settings = $this->get_settings();

		$this->add_render_attribute('custom-gallery-item', 'class', ['avt-gallery-item', 'avt-transition-toggle'] );
		$this->add_render_attribute('custom-gallery-item', 'class', 'avt-width-1-'. $settings['columns_mobile'] );
		$this->add_render_attribute('custom-gallery-item', 'class', 'avt-width-1-'. $settings['columns_tablet'] .'@s');
		$this->add_render_attribute('custom-gallery-item', 'class', 'avt-width-1-'. $settings['columns'] .'@m');
		
		$this->add_render_attribute('custom-gallery-inner', 'class', 'avt-custom-gallery-inner');

		if ('yes' === $settings['tilt_show'] ) {
			$this->add_render_attribute('custom-gallery-inner', 'data-tilt', '');
		}

		$this->render_header();
		foreach ( $settings['gallery'] as $index => $item ) :

			?>
			<div <?php echo $this->get_render_attribute_string( 'custom-gallery-item' ); ?>>
				<div <?php echo $this->get_render_attribute_string( 'custom-gallery-inner' ); ?>>
					
					<?php $this->rendar_link($item, 'gallery-item-' . $index); ?>

					<?php if ('yes' !== $settings['show_lightbox'] and  $settings['direct_link']) : ?>

						<?php 
							if ( $settings['external_link'] ) {
								$this->add_render_attribute( 'gallery-item-' . $index, 'target', '_blank' );
							} 
						?>

						<a <?php echo $this->get_render_attribute_string( 'gallery-item-' . $index ); ?>>
					<?php endif; ?>

					<?php 
						$this->render_thumbnail( $item, 'gallery-item-' . $index );
						$this->render_overlay( $item, 'overlay-item-' . $index );
					?>
					
					<?php if ('yes' !== $settings['show_lightbox'] and $settings['direct_link']) : ?>
						</a>
					<?php endif; ?>
				</div>
			</div>

		<?php endforeach; ?>
		<?php $this->render_footer( $item);
	}		
}
