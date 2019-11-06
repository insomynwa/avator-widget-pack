<?php
namespace WidgetPack\Modules\AdvancedImageGallery\Widgets;

use Elementor\Widget_Base;
use Elementor\Control_Media;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Utils;
use Elementor\Icons_Manager;
use Elementor\Core\Files\Assets\Svg\Svg_Handler;
use Elementor\Modules\DynamicTags\Module as TagsModule;

use WidgetPack\Modules\AdvancedImageGallery\Skins;


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Advanced_Image_Gallery extends Widget_Base {
	
	public $lightbox_slide_index;

	public function get_name() {
		return 'avt-advanced-image-gallery';
	}

	public function get_title() {
		return AWP . esc_html__( 'Advanced Image Gallery', 'avator-widget-pack' );
	}

	public function get_icon() {
		return 'avt-wi-advanced-image-gallery';
	}

	public function get_categories() {
		return [ 'widget-pack' ];
	}

	public function get_keywords() {
		return [ 'advanced', 'image', 'gallery', 'photo' ];
	}

	public function get_style_depends() {
		return [ 'wipa-advanced-image-gallery', 'widget-pack-font' ];
	}

	public function get_script_depends() {
		return [ 'imagesloaded', 'tilt', 'wipa-justified-gallery' ];
	}

	public function get_custom_help_url() {
		return 'https://youtu.be/se7BovYbDok';
	}

	public function _register_skins() {
		$this->add_skin( new Skins\Skin_Hidden( $this ) );
		$this->add_skin( new Skins\Skin_Carousel( $this ) );
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_gallery',
			[
				'label' => __( 'Image Gallery', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'avd_gallery_images',
			[
				'label'   => __( 'Add Images', 'avator-widget-pack' ),
				'type'    => Controls_Manager::GALLERY,
				'dynamic' => [ 
					'active' => true,
					'categories' => [
						TagsModule::GALLERY_CATEGORY,
					],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'thumbnail',
				'exclude'   => [ 'custom' ],
				'condition' => ['_skin!' => 'avt-hidden'],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_custom_gallery_layout',
			[
				'label'     => esc_html__( 'Gallery Layout', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'grid_type',
			[
				'label'   => __( 'Gallery Mode', 'avator-widget-pack' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'normal' => [
						'title' => __( 'Normal', 'avator-widget-pack' ),
						'icon'  => 'eicon-gallery-grid',
					],
					'masonry' => [
						'title' => __( 'Masonry', 'avator-widget-pack' ),
						'icon'  => 'eicon-gallery-masonry',
					],
					'justified' => [
						'title' => __( 'Justified', 'avator-widget-pack' ),
						'icon'  => 'eicon-gallery-justified',
					],
				],
				'default' => 'normal',
				'condition' => [
					'_skin' => '',
				],
			]
		);



		$this->add_responsive_control(
			'item_ratio',
			[
				'label'   => esc_html__( 'Image Height', 'avator-widget-pack' ),
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
					'{{WRAPPER}} .avt-advanced-image-gallery .avt-gallery-thumbnail img' => 'height: {{SIZE}}px',
				],
				'conditions' => [
					'relation' => 'and',
					'terms' => [
						[
							'name'     => '_skin',
							'operator' => 'in',
							'value'    => ['', 'avt-carousel']
						],
						[
							'name'     => 'grid_type',
							'operator' => '==',
							'value'    => 'normal'
						],
					]
				]
			]
		);

		$this->add_control(
			'gallery_item_height',
			[
				'label'   => esc_html__( 'Image Height', 'avator-widget-pack' ),
				'description'   => esc_html__( 'Some times image height not exactly same because of auto row adjustment.', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 260,
				],
				'range' => [
					'px' => [
						'min'  => 50,
						'max'  => 500,
						'step' => 5,
					],
				],
				'conditions' => [
					'relation' => 'and',
					'terms' => [
						[
							'name'     => '_skin',
							'operator' => '!=',
							'value'    => 'avt-hidden'
						],
						[
							'name'     => 'grid_type',
							'operator' => '==',
							'value'    => ['justified']
						],
					]
				]
			]
		);

		$this->add_responsive_control(
			'columns',
			[
				'label'          => esc_html__( 'Columns', 'avator-widget-pack' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => '4',
				'tablet_default' => '3',
				'mobile_default' => '1',
				'options'        => [
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6',
				],
				'conditions' => [
					'relation' => 'or',
					'terms' => [
						[
							'name'     => '_skin',
							'operator' => '!=',
							'value'    => 'avt-hidden'
						],
						[
							'name'     => 'grid_type',
							'operator' => '==',
							'value'    => ['normal', 'masonry']
						],
					]
				]
			]
		);

		$this->add_responsive_control(
			'row_column_gap',
			[
				'label'   => esc_html__( 'Item Gap', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 5,
					],
				],
				'condition' => [
					'grid_type' => 'justified'
				],
			]
		);

		$this->add_responsive_control(
			'item_gap',
			[
				'label'   => esc_html__( 'Column Gap', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 5,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-advanced-image-gallery.avt-grid'     => 'margin-left: -{{SIZE}}px',
					'{{WRAPPER}} .avt-advanced-image-gallery.avt-grid > *' => 'padding-left: {{SIZE}}px',
				],
				'condition' => [
					'_skin!' => 'avt-hidden',
					'grid_type!' => 'justified'
				],
			]
		);

		$this->add_responsive_control(
			'row_gap',
			[
				'label'   => esc_html__( 'Row Gap', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 5,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-advanced-image-gallery.avt-grid'     => 'margin-top: -{{SIZE}}px',
					'{{WRAPPER}} .avt-advanced-image-gallery.avt-grid > *' => 'margin-top: {{SIZE}}px',
				],
				'condition' => [
					'_skin' => '',
					'grid_type!' => 'justified'
				],
			]
		);

		$this->add_control(
			'show_lightbox',
			[
				'label'     => esc_html__( 'Show Lightbox', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				// 'separator' => 'before',
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
					'_skin!'		=> 'avt-hidden',
				]
			]
		);

		$this->add_control(
			'show_caption',
			[
				'label'       => esc_html__( 'Show Caption', 'avator-widget-pack' ),
				'description' => esc_html__( 'Make sure you set the caption in gallery images when you insert.', 'avator-widget-pack' ),
				'type'        => Controls_Manager::SWITCHER,
				'separator'   => 'before',
				'condition' => ['_skin!' => 'avt-hidden'],
			]
		);

		$this->add_control(
			'caption_all_time',
			[
				'label'     => esc_html__( 'Caption all Time', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => [
					'show_caption' => 'yes',
					'_skin!' => 'avt-hidden',
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_layout_additional',
			[
				'label'     => esc_html__( 'Additional', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
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
				'selectors' => [
					'{{WRAPPER}} .avt-advanced-image-gallery .avt-overlay' => 'text-align: {{VALUE}}',
				],
				'condition' => [
					'show_lightbox' => 'yes',
					'show_caption'  => 'yes',
				],
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
				'default'   => 'middle',
				'selectors' => [
					'{{WRAPPER}} .avt-advanced-image-gallery .avt-overlay' => 'justify-content: {{VALUE}}',
				],
				'condition' => [
					'show_lightbox' => 'yes',
					'show_caption'  => 'yes',
				],
				'separator' => 'after',
			]
		);

		$this->add_control(
			'caption_position',
			[
				'label'     => esc_html__( 'Caption Position', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'options'   => widget_pack_position(),
				'condition' => [
					'show_caption'     => 'yes',
					'caption_all_time' => 'yes',
				],
			]
		);

		$this->add_control(
			'tilt_show',
			[
				'label' => esc_html__( 'Tilt Effect', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SWITCHER,
				'render_type' => 'template',
				'condition' => [
					'_skin!'            => 'avt-hidden',
					'caption_all_time!' => 'yes',
				],
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
					'caption_all_time!' => 'yes',
				],
				'separator' => 'after',
			]
		);


		$this->add_control(
			'lightbox_link_type',
			[
				'label'   => esc_html__( 'Lightbox Link Type', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'simple_text',
				'options' => [
					'simple_text' => esc_html__('Text', 'avator-widget-pack'),
					'link_icon'   => esc_html__('Icon', 'avator-widget-pack'),
					'link_image'  => esc_html__('Image', 'avator-widget-pack'),
				],
				'condition' => ['_skin' => 'avt-hidden'],
			]
		);

		$this->add_control(
			'link_image',
			[
				'label'   => __( 'Link Image', 'avator-widget-pack' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],				
				'condition' => ['lightbox_link_type' => 'link_image'],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'link_image_size',
				'condition' => ['lightbox_link_type' => 'link_image'],
			]
		);
		
		$this->add_control(
			'gallery_link_text',
			[
				'label'       => esc_html__( 'Link Text', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Open Gallery', 'avator-widget-pack' ),
				'placeholder' => esc_html__( 'Link Text', 'avator-widget-pack' ),				
				'condition'   => ['_skin' => 'avt-hidden', 'lightbox_link_type' => 'simple_text'],
			]
		);

		$this->add_control(
			'gallery_link_icon',
			[
				'label'       => esc_html__( 'Link Icon', 'avator-widget-pack' ),
				'type'        => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'default' => [
					'value' => 'fas fa-plus',
					'library' => 'fa-solid',
				],
				'condition'   => ['_skin' => 'avt-hidden', 'lightbox_link_type' => 'link_icon'],
			]
		);

		$this->add_responsive_control(
			'gallery_link_align',
			[
				'label'   => esc_html__( 'Alignment', 'avator-widget-pack' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'avator-widget-pack' ),
						'icon'  => 'fas fa-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'avator-widget-pack' ),
						'icon'  => 'fas fa-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'avator-widget-pack' ),
						'icon'  => 'fas fa-align-right',
					],
				],
				'prefix_class' => 'elementor-align%s-',
				'condition' => ['_skin' => 'avt-hidden'],
				'separator' => 'after',
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
			'section_content_carousel_settins',
			[
				'label'     => esc_html__( 'Carousel Settings', 'avator-widget-pack' ),
				'condition' => [
					'_skin' => 'avt-carousel',
				],
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label'   => esc_html__( 'Auto Play', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'autoplay_interval',
			[
				'label'     => esc_html__( 'Autoplay Interval', 'avator-widget-pack' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 7000,
				'condition' => [
					'autoplay' => 'yes',
				],
			]
		);

		$this->add_control(
			'pause_on_hover',
			[
				'label'   => esc_html__( 'Pause on Hover', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'loop',
			[
				'label'   => esc_html__( 'Loop', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'center_slide',
			[
				'label' => esc_html__( 'Center Slide', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_navigation',
			[
				'label'     => __( 'Navigation', 'avator-widget-pack' ),
				'condition' => [
					'_skin' => 'avt-carousel',
				],
			]
		);

		$this->add_control(
			'navigation',
			[
				'label'   => __( 'Navigation', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'arrows',
				'options' => [
					'both'   => __( 'Arrows and Dots', 'avator-widget-pack' ),
					'arrows' => __( 'Arrows', 'avator-widget-pack' ),
					'dots'   => __( 'Dots', 'avator-widget-pack' ),
					'none'   => __( 'None', 'avator-widget-pack' ),
				],
				'prefix_class' => 'avt-navigation-type-',
				'render_type'  => 'template',				
			]
		);
		
		$this->add_control(
			'both_position',
			[
				'label'     => __( 'Arrows and Dots Position', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'center',
				'options'   => widget_pack_navigation_position(),
				'condition' => [
					'navigation' => 'both',
				],
			]
		);

		$this->add_control(
			'arrows_position',
			[
				'label'     => __( 'Arrows Position', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'center',
				'options'   => widget_pack_navigation_position(),
				'condition' => [
					'navigation' => 'arrows',
				],				
			]
		);

		$this->add_control(
			'dots_position',
			[
				'label'     => __( 'Dots Position', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'bottom-center',
				'options'   => widget_pack_pagination_position(),
				'condition' => [
					'navigation' => 'dots',
				],				
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'section_design_layout',
			[
				'label'     => esc_html__( 'Items', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => ['_skin!' => 'avt-hidden'],
			]
		);

		$this->add_control(
			'overlay_animation',
			[
				'label'   => esc_html__( 'Overlay Animation', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'fade',
				'options' => widget_pack_transition_options(),
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'item_border',
				'label'       => esc_html__( 'Border', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-advanced-image-gallery .avt-gallery-thumbnail',
			]
		);

		$this->add_control(
			'item_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-advanced-image-gallery .avt-gallery-item .avt-advanced-image-gallery-inner, {{WRAPPER}} .avt-advanced-image-gallery .avt-gallery-thumbnail, {{WRAPPER}} .avt-advanced-image-gallery .avt-overlay' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'overlay_background',
			[
				'label'     => esc_html__( 'Overlay Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-advanced-image-gallery .avt-gallery-item .avt-overlay' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .avt-advanced-image-gallery .avt-gallery-item .avt-overlay' => 'margin: {{SIZE}}px',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_caption',
			[
				'label'     => esc_html__( 'Caption', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,				
				'condition' => [
					'show_caption' => 'yes',
				],
			]
		);

		$this->add_control(
			'caption_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-advanced-image-gallery .avt-gallery-item .avt-gallery-item-caption' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'caption_background',
				'separator' => 'before',
				'selector'  => '{{WRAPPER}} .avt-advanced-image-gallery .avt-gallery-item .avt-gallery-item-caption'
			]
		);

		$this->add_responsive_control(
			'caption_padding',
			[
				'label'      => __('Padding', 'avator-widget-pack'),
				'type'       => Controls_Manager::DIMENSIONS,
				'separator'  => 'before',
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-advanced-image-gallery .avt-gallery-item .avt-gallery-item-caption' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_responsive_control(
			'caption_margin',
			[
				'label'      => __('Margin', 'avator-widget-pack'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-advanced-image-gallery .avt-gallery-item .avt-gallery-item-caption' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'caption_border',
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-advanced-image-gallery .avt-gallery-item .avt-gallery-item-caption'
			]
		);

		$this->add_control(
			'caption_radius',
			[
				'label'      => __('Radius', 'avator-widget-pack'),
				'type'       => Controls_Manager::DIMENSIONS,
				'separator'  => 'after',
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-advanced-image-gallery .avt-gallery-item .avt-gallery-item-caption' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'caption_shadow',
				'selector' => '{{WRAPPER}} .avt-advanced-image-gallery .avt-gallery-item .avt-gallery-item-caption'
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'caption_typography',
				'label'    => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .avt-gallery-item .avt-gallery-item-caption',
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
					'{{WRAPPER}} .avt-gallery-item-link span, {{WRAPPER}} .avt-gallery-item-link i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-gallery-item-link svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'background_color',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-gallery-item-link' => 'background-color: {{VALUE}};',
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
				'selector'    => '{{WRAPPER}} .avt-gallery-item-link',
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
					'{{WRAPPER}} .avt-gallery-item-link, {{WRAPPER}} .avt-skin-avt-hidden .avt-hidden-gallery-button img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_box_shadow',
				'selector' => '{{WRAPPER}} .avt-gallery-item-link',
			]
		);

		$this->add_control(
			'button_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-gallery-item-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				'selector'  => '{{WRAPPER}} .avt-gallery-item-link, {{WRAPPER}} .avt-gallery-item-link span',
				'condition' => [
					'show_lightbox' => 'yes',
					'lightbox_link_type!' => 'link_image',
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
					'{{WRAPPER}} .avt-gallery-item-link:hover span, {{WRAPPER}} .avt-gallery-item-link:hover i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-gallery-item-link:hover svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_hover_color',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-gallery-item-link:hover' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .avt-gallery-item-link:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_animation',
			[
				'label' => esc_html__( 'Animation', 'avator-widget-pack' ),
				'type'  => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_navigation',
			[
				'label'      => __( 'Navigation', 'avator-widget-pack' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'conditions' => [
					'terms' => [
						[
							'name'     => '_skin',
							'value'    => 'avt-carousel',
						],
						[
							'name'     => 'navigation',
							'operator' => '!=',
							'value'    => 'none',
						],
					],
				],
			]
		);

		$this->add_control(
			'arrows_size',
			[
				'label' => __( 'Arrows Size', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 20,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-navigation-prev svg,
					{{WRAPPER}} .avt-navigation-next svg' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'arrows_background',
			[
				'label'     => __( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-navigation-prev,
					{{WRAPPER}} .avt-navigation-next' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'arrows_hover_background',
			[
				'label'     => __( 'Hover Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-navigation-prev:hover,
					{{WRAPPER}} .avt-navigation-next:hover' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'arrows_color',
			[
				'label'     => __( 'Arrows Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-navigation-prev svg,
					{{WRAPPER}} .avt-navigation-next svg' => 'color: {{VALUE}}',
				],
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'arrows_hover_color',
			[
				'label'     => __( 'Arrows Hover Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-navigation-prev:hover svg,
					{{WRAPPER}} .avt-navigation-next:hover svg' => 'color: {{VALUE}}',
				],
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'arrows_space',
			[
				'label' => __( 'Space', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-navigation-prev' => 'margin-right: {{SIZE}}px;',
					'{{WRAPPER}} .avt-navigation-next' => 'margin-left: {{SIZE}}px;',
				],
				'conditions'   => [
					'terms' => [
						[
							'name'  => 'navigation',
							'value' => 'both',
						],
						[
							'name'     => 'both_position',
							'operator' => '!=',
							'value'    => 'center',
						],
					],
				],
			]
		);

		$this->add_responsive_control(
			'arrows_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-navigation-prev,
					{{WRAPPER}} .avt-navigation-next' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'border_radius',
			[
				'label'      => __( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'separator'  => 'after',
				'selectors'  => [
					'{{WRAPPER}} .avt-navigation-prev,
					{{WRAPPER}} .avt-navigation-next' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'dots_size',
			[
				'label' => __( 'Dots Size', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 5,
						'max' => 20,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-slider-dotnav a' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'navigation' => [ 'dots', 'both' ],
				],
			]
		);

		$this->add_control(
			'dots_color',
			[
				'label'     => __( 'Dots Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-slider-dotnav a' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'navigation' => [ 'dots', 'both' ],
				],
			]
		);

		$this->add_control(
			'active_dot_color',
			[
				'label'     => __( 'Active Dots Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'separator' => 'after',
				'selectors' => [
					'{{WRAPPER}} .avt-slider-dotnav.avt-active a' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'navigation' => [ 'dots', 'both' ],
				],
			]
		);

		$this->add_control(
			'arrows_ncx_position',
			[
				'label'   => __( 'Horizontal Offset', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'conditions'   => [
					'terms' => [
						[
							'name'  => 'navigation',
							'value' => 'arrows',
						],
						[
							'name'     => 'arrows_position',
							'operator' => '!=',
							'value'    => 'center',
						],
					],
				],
			]
		);

		$this->add_control(
			'arrows_ncy_position',
			[
				'label'   => __( 'Vertical Offset', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 40,
				],
				'range' => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-arrows-container' => 'transform: translate({{arrows_ncx_position.size}}px, {{SIZE}}px);',
				],
				'conditions'   => [
					'terms' => [
						[
							'name'  => 'navigation',
							'value' => 'arrows',
						],
						[
							'name'     => 'arrows_position',
							'operator' => '!=',
							'value'    => 'center',
						],
					],
				],
			]
		);

		$this->add_control(
			'arrows_acx_position',
			[
				'label'   => __( 'Horizontal Offset', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => -60,
				],
				'range' => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-navigation-prev' => 'left: {{SIZE}}px;',
					'{{WRAPPER}} .avt-navigation-next' => 'right: {{SIZE}}px;',
				],
				'conditions' => [
					'terms' => [
						[
							'name'  => 'navigation',
							'value' => 'arrows',
						],
						[
							'name'  => 'arrows_position',
							'value' => 'center',
						],
					],
				],
			]
		);

		$this->add_control(
			'dots_nnx_position',
			[
				'label'   => __( 'Horizontal Offset', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'conditions'   => [
					'terms' => [
						[
							'name'  => 'navigation',
							'value' => 'dots',
						],
						[
							'name'     => 'dots_position',
							'operator' => '!=',
							'value'    => '',
						],
					],
				],
			]
		);

		$this->add_control(
			'dots_nny_position',
			[
				'label'   => __( 'Vertical Offset', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 30,
				],
				'range' => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-dots-container' => 'transform: translate({{dots_nnx_position.size}}px, {{SIZE}}px);',
				],
				'conditions'   => [
					'terms' => [
						[
							'name'  => 'navigation',
							'value' => 'dots',
						],
						[
							'name'     => 'dots_position',
							'operator' => '!=',
							'value'    => '',
						],
					],
				],
			]
		);

		$this->add_control(
			'both_ncx_position',
			[
				'label'   => __( 'Horizontal Offset', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'conditions'   => [
					'terms' => [
						[
							'name'  => 'navigation',
							'value' => 'both',
						],
						[
							'name'     => 'both_position',
							'operator' => '!=',
							'value'    => 'center',
						],
					],
				],
			]
		);

		$this->add_control(
			'both_ncy_position',
			[
				'label'   => __( 'Vertical Offset', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 40,
				],
				'range' => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-arrows-dots-container' => 'transform: translate({{both_ncx_position.size}}px, {{SIZE}}px);',
				],
				'conditions'   => [
					'terms' => [
						[
							'name'  => 'navigation',
							'value' => 'both',
						],
						[
							'name'     => 'both_position',
							'operator' => '!=',
							'value'    => 'center',
						],
					],
				],
			]
		);

		$this->add_control(
			'both_cx_position',
			[
				'label'   => __( 'Arrows Offset', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => -60,
				],
				'range' => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-navigation-prev' => 'left: {{SIZE}}px;',
					'{{WRAPPER}} .avt-navigation-next' => 'right: {{SIZE}}px;',
				],
				'conditions' => [
					'terms' => [
						[
							'name'  => 'navigation',
							'value' => 'both',
						],
						[
							'name'  => 'both_position',
							'value' => 'center',
						],
					],
				],
			]
		);

		$this->add_control(
			'both_cy_position',
			[
				'label'   => __( 'Dots Offset', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 30,
				],
				'range' => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-dots-container' => 'transform: translateY({{SIZE}}px);',
				],
				'conditions' => [
					'terms' => [
						[
							'name'  => 'navigation',
							'value' => 'both',
						],
						[
							'name'  => 'both_position',
							'value' => 'center',
						],
					],
				],
			]
		);

		$this->end_controls_section();
	}

	public function render_header() {

		$settings = $this->get_settings_for_display();
		$id       = $this->get_id();

		$this->add_render_attribute('advanced-image-gallery', 'id', 'avt-avdg-' . esc_attr($id) );

		$this->add_render_attribute('advanced-image-gallery', 'class', ['avt-advanced-image-gallery', 'avt-skin-default'  ] );
		

		if ( '' == $settings['_skin'] and 'justified' == $settings['grid_type'] ) {
		
			$this->add_render_attribute('advanced-image-gallery', 'class', 'jgallery');
			
			if ($settings['gallery_item_height']['size']) {
				$this->add_render_attribute('advanced-image-gallery', 'data-jgallery-jfHeight', esc_attr($settings['gallery_item_height']['size']) );
			}

			if ($settings['row_column_gap']['size']) {
				$this->add_render_attribute('advanced-image-gallery', 'data-jgallery-itemgap', esc_attr($settings['row_column_gap']['size']) );
			}

		} else {

			$this->add_render_attribute('advanced-image-gallery', 'avt-grid', '');
			
			if ('masonry' == $settings['grid_type'] ) {
				$this->add_render_attribute('advanced-image-gallery', 'avt-grid', 'masonry: true');
			}
			
			$this->add_render_attribute('advanced-image-gallery', 'class', ['avt-grid', 'avt-grid-small'] );

			$this->add_render_attribute('advanced-image-gallery', 'class', 'avt-child-width-1-' . esc_attr($settings['columns_mobile']));
			$this->add_render_attribute('advanced-image-gallery', 'class', 'avt-child-width-1-' . esc_attr($settings['columns_tablet']) .'@s');
			$this->add_render_attribute('advanced-image-gallery', 'class', 'avt-child-width-1-' . esc_attr($settings['columns']) .'@m');

		}
		
		if ( $settings['caption_all_time'] ) {
			$this->add_render_attribute('advanced-image-gallery', 'class', 'avt-caption-all-time-yes');
		}
		

		if ($settings['show_lightbox'] or 'avt-hidden' === $settings['_skin'] ) {
			$this->add_render_attribute('advanced-image-gallery', 'avt-lightbox', 'animation: ' . $settings['lightbox_animation'] . ';');
			if ($settings['lightbox_autoplay']) {
				$this->add_render_attribute('advanced-image-gallery', 'avt-lightbox', 'autoplay: 500;');
				
				if ($settings['lightbox_pause']) {
					$this->add_render_attribute('advanced-image-gallery', 'avt-lightbox', 'pause-on-hover: true;');
				}
			}
		}

		


		?>
		<div <?php echo $this->get_render_attribute_string( 'advanced-image-gallery' ); ?>>
		<?php
	}

	private function render_loop_item($settings) {

		$this->add_render_attribute('advanced-image-gallery-item', 'class', ['avt-gallery-item', 'avt-transition-toggle']);

		$this->add_render_attribute('advanced-image-gallery-inner', 'class', 'avt-advanced-image-gallery-inner');
		
		if ($settings['tilt_show']) {
			$this->add_render_attribute('advanced-image-gallery-inner', 'data-tilt', '');
			if ($settings['tilt_scale']['size']) {
				$this->add_render_attribute('advanced-image-gallery-inner', 'data-tilt-scale', $settings['tilt_scale']['size']);
			}
		}

		foreach ( $settings['avd_gallery_images'] as $index => $item ) : ?>

			<div <?php echo $this->get_render_attribute_string( 'advanced-image-gallery-item' ); ?>>
				<div <?php echo $this->get_render_attribute_string( 'advanced-image-gallery-inner' ); ?>>
					<?php
					$this->render_thumbnail($item);
					
					if ($settings['show_lightbox'] or ($settings['show_caption'] and 'yes' !== $settings['caption_all_time'] )  )  :
						$this->render_overlay($item);
					endif;

					?>
				</div>
				<?php if ($settings['show_caption'] and 'yes' == $settings['caption_all_time'])  : ?>
					<?php $this->render_caption($item); ?>
				<?php endif; ?>
			</div>

		<?php endforeach;
	}

	public function render_footer() {
		?>
		</div>
		<?php
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$id       = $this->get_id();

		if ( empty( $settings['avd_gallery_images'] ) ) {
			return;
		}

		$this->render_header($settings, $id, $skin = 'standard');
		$this->render_loop_item($settings);
		$this->render_footer();
	}

	public function render_thumbnail($item) {
		$settings  = $this->get_settings_for_display();
		$image_url = Group_Control_Image_Size::get_attachment_image_src( $item['id'], 'thumbnail', $settings ); 					

		echo '<div class="avt-gallery-thumbnail avt-transition-toggle">
			<img src="'.esc_url($image_url).'" alt="'.esc_attr( Control_Media::get_image_alt( $item ) ).'" class="jgalleryImage">
		</div>';
	}

	public function render_caption($text) {
		$image_caption = get_post($text['id']);
		$settings      = $this->get_settings_for_display();

		$this->add_render_attribute( 'caption', 'class', 'avt-gallery-item-caption avt-display-inline-block', true );
		
		if ($settings['caption_all_time']) {
			$this->add_render_attribute( 'caption', 'class', ( '' != $settings['caption_position'] ) ? 'avt-position-' . $settings['caption_position'] : 'avt-caption-position-default' );
		}

		?>
		<?php if ( ! empty( $image_caption->post_excerpt ) ) : ?>
			<div><div <?php echo $this->get_render_attribute_string( 'caption' ); ?>>
				<?php echo wp_kses_post($image_caption->post_excerpt); ?>
			</div></div>
		<?php endif;
	}

	public function render_overlay($content) {
		$settings                  = $this->get_settings_for_display();
		$image_caption = get_post($content['id']);
		$overlay_settings          = [];
		
		$this->add_render_attribute( 'overlay-settings', 'class', ['avt-position-cover','avt-overlay','avt-overlay-default'], true );
		
		if ($settings['overlay_animation']) {
			$this->add_render_attribute( 'overlay-settings', 'class', 'avt-transition-' . $settings['overlay_animation']);
		}

		?>
		<div <?php echo $this->get_render_attribute_string('overlay-settings'); ?>>
			<div class="avt-advanced-image-gallery-content">
				<div class="avt-advanced-image-gallery-content-inner">
				
					<?php $this->add_render_attribute(
						[
							'overlay-lightbox-attr' => [
								'class' => [
									'avt-gallery-item-link',
									'elementor-clickable',
									'icon-type-' . $settings['link_type'],
								],
								'data-elementor-open-lightbox' => 'no',
								'data-caption'                 => $image_caption->post_excerpt,
							],
						], '', '', true
					);

					$image_url = wp_get_attachment_image_src( $content['id'], 'full' );

					if ( ! $image_url ) {
						$this->add_render_attribute( 'overlay-lightbox-attr', 'href', $content['url'], true );
					} else {
						$this->add_render_attribute( 'overlay-lightbox-attr', 'href', $image_url[0], true );
					}
					
					?>
					<?php if ( 'yes' == $settings['show_lightbox'] )  : ?>
						<div class="avt-flex-inline avt-gallery-item-link-wrapper">
							<a <?php echo $this->get_render_attribute_string( 'overlay-lightbox-attr' ); ?>>
								<?php if ( 'icon' == $settings['link_type'] ) : ?>
									<span class="wipa-plus"></span>
								<?php elseif ( 'text' == $settings['link_type'] ) : ?>
									<span class="avt-text"><?php echo esc_html_x( 'ZOOM', 'Advanced Image Gallery String', 'avator-widget-pack' ); ?></span>
								<?php endif;?>
							</a>
						</div>
					<?php endif; ?>

					<?php if ($settings['show_caption'] and 'yes' != $settings['caption_all_time'])  : ?>
						<?php $this->render_caption($content); ?>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<?php
	}

	public function link_only($content) {
		$settings      = $this->get_settings_for_display();
		$image_caption = get_post($content['id']);
		$link_count    = 1;

		$this->add_render_attribute(
			[
				'lightbox-attributes' => [
					'class' => [
						'elementor-clickable',
						'icon-type-' . $settings['link_type'],
						$settings['button_hover_animation'] ? 'elementor-animation-'.$settings['button_hover_animation'] : '',
					],
					'data-elementor-open-lightbox' => 'no',
					'data-caption'                 => $image_caption->post_excerpt,
				],
			], '', '', true
		);

		$image_url = wp_get_attachment_image_src( $content['id'], 'full' );

		if ( ! $image_url ) {
			$this->add_render_attribute( 'lightbox-attributes', 'href', $content['url'], true );
		} else {
			$this->add_render_attribute( 'lightbox-attributes', 'href', $image_url[0], true );
		}

		$this->lightbox_slide_index++;
		
		if (1 === $this->lightbox_slide_index) {
			$this->add_render_attribute( 'lightbox-attributes', 'class', ['avt-gallery-item-link', 'avt-hidden-gallery-button'] );
			echo '<a ' . $this->get_render_attribute_string( 'lightbox-attributes' ) . '>';

			if ('simple_text' == $settings['lightbox_link_type']) {
				echo '<span>' . $settings['gallery_link_text'] . '</span>';
			} elseif ('link_icon' == $settings['lightbox_link_type']) {
				Icons_Manager::render_icon( $settings['gallery_link_icon'], [ 'aria-hidden' => 'true', 'class' => 'fa-fw' ] );
			} else {
				$link_image_src = Group_Control_Image_Size::get_attachment_image_src( $settings['link_image']['id'], 'link_image_size', $settings );
				$link_image_src = ($link_image_src) ? $link_image_src : $settings['link_image']['url'];
				echo '<img src=' . esc_url($link_image_src) . ' alt="' . get_the_title() . '">';
			}
			echo '</a>';
		} else {
			$this->add_render_attribute( 'lightbox-attributes', 'class', 'avt-hidden' );
			echo '<a ' . $this->get_render_attribute_string( 'lightbox-attributes' ) . '></a>';
		}
	}		
}
