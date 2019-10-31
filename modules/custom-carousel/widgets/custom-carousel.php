<?php
namespace WidgetPack\Modules\CustomCarousel\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Embed;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Scheme_Typography;
use Elementor\Utils;

use WidgetPack\Modules\CustomCarousel\Skins;

use WidgetPack\Widget_Pack_Loader;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Custom_Carousel extends Widget_Base {
	private $slide_prints_count = 0;

	public function get_name() {
		return 'avt-custom-carousel';
	}

	public function get_title() {
		return AWP . esc_html__( 'Custom Carousel', 'avator-widget-pack' );
	}

	public function get_icon() {
		return 'avt-wi-custom-carousel';
	}

	public function get_categories() {
		return [ 'widget-pack' ];
	}

	public function get_keywords() {
		return [ 'custom', 'carousel', 'navigatin' ];
	}

	public function get_script_depends() {
		return [ 'avt-uikit-icons' ];
	}

	public function _register_skins() {
		$this->add_skin( new Skins\Skin_Custom_Content( $this ) );
	}

	protected function _register_controls() {

		$slides_per_view = range( 1, 10 );
		$slides_per_view = array_combine( $slides_per_view, $slides_per_view );

		$this->start_controls_section(
			'section_slides',
			[
				'label' => esc_html__( 'Slides', 'avator-widget-pack' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'skin',
			[
				'label'   => esc_html__( 'Layout', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'carousel',
				'options' => [
					'carousel'  => esc_html__( 'Carousel', 'avator-widget-pack' ),
					'coverflow' => esc_html__( 'Coverflow', 'avator-widget-pack' ),
				],
				'prefix_class' => 'avt-custom-carousel-style-',
				'render_type'  => 'template',
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'type',
			[
				'type'    => Controls_Manager::CHOOSE,
				'label'   => esc_html__( 'Type', 'avator-widget-pack' ),
				'default' => 'image',
				'options' => [
					'image' => [
						'title' => esc_html__( 'Image', 'avator-widget-pack' ),
						'icon'  => 'fas fa-image',
					],
					'video' => [
						'title' => esc_html__( 'Video', 'avator-widget-pack' ),
						'icon'  => 'fas fa-video-camera',
					],
				],
				'label_block' => false,
				'toggle'      => false,
			]
		);

		$repeater->add_control(
			'image',
			[
				'label'   => esc_html__( 'Image', 'avator-widget-pack' ),
				'type'    => Controls_Manager::MEDIA,
				'dynamic' => [ 'active' => true ],
			]
		);

		$repeater->add_control(
			'image_link_to_type',
			[
				'label'   => esc_html__( 'Link to', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					''       => esc_html__( 'None', 'avator-widget-pack' ),
					'file'   => esc_html__( 'Media File', 'avator-widget-pack' ),
					'custom' => esc_html__( 'Custom URL', 'avator-widget-pack' ),
				],
				'condition' => [
					'type' => 'image',
				],
			]
		);

		$repeater->add_control(
			'image_link_to',
			[
				'type'        => Controls_Manager::URL,
				'placeholder' => esc_html__( 'http://your-link.com', 'avator-widget-pack' ),
				'dynamic'     => [ 'active' => true ],
				'condition'   => [
					'type'               => 'image',
					'image_link_to_type' => 'custom',
				],
				'separator'  => 'none',
				'show_label' => false,
			]
		);

		$repeater->add_control(
			'video',
			[
				'label'         => esc_html__( 'Video Link', 'avator-widget-pack' ),
				'type'          => Controls_Manager::URL,
				'dynamic'       => [ 'active' => true ],
				'placeholder'   => esc_html__( 'Enter your video link', 'avator-widget-pack' ),
				'description'   => esc_html__( 'Insert YouTube or Vimeo link', 'avator-widget-pack' ),
				'show_external' => false,
				'condition'     => [
					'type'   => 'video',
				],
			]
		);

		$this->add_control(
			'slides',
			[
				'label'     => esc_html__( 'Slides', 'avator-widget-pack' ),
				'type'      => Controls_Manager::REPEATER,
				'fields'    => $repeater->get_controls(),
				'default'   => $this->get_repeater_defaults(),
				'condition' => [
					'_skin' => ''
				],
			]
		);


		$repeater_2 = new Repeater();
		
		$repeater_2->add_control(
			'source',
			[
				'type'    => Controls_Manager::CHOOSE,
				'label'   => esc_html__( 'Source', 'avator-widget-pack' ),
				'default' => 'editor',
				'options' => [
					'editor' => [
						'title' => esc_html__( 'Editor', 'avator-widget-pack' ),
						'icon'  => 'eicon-edit',
					],
					'template' => [
						'title' => esc_html__( 'Template', 'avator-widget-pack' ),
						'icon'  => 'eicon-section',
					],
				],
				'label_block' => false,
				'toggle'      => false,
			]
		);
		

		$repeater_2->add_control(
			'template_source',
			[
				'label'   => esc_html__( 'Select Source', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'elementor',
				'options' => [
					"elementor" => esc_html__( 'Elementor Template', 'avator-widget-pack' ),
					'anywhere'  => esc_html__( 'Anywhere Template', 'avator-widget-pack' ),
				],
				'condition' => [
					'source' => 'template',
				],
			]
		);

		$repeater_2->add_control(
			'elementor_template',
			[
				'label'       => __( 'Select Template', 'avator-widget-pack' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '0',
				'options'     => widget_pack_et_options(),
				'label_block' => 'true',
				'condition'   => [
					'source'          => 'template',
					'template_source' => "elementor"
				],
			]
		);

		$repeater_2->add_control(
			'anywhere_template',
			[
				'label'       => esc_html__( 'Select Template', 'avator-widget-pack' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '0',
				'options'     => widget_pack_ae_options(),
				'label_block' => 'true',
				'condition'   => [
					'source'          => 'template',
					'template_source' => "anywhere"
				],
			]
		);

		$repeater_2->add_control(
			'editor_content',
			[
				'type'       => Controls_Manager::TEXTAREA,
				'dynamic'    => [ 'active' => true ],
				'default'    => __( 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.', 'avator-widget-pack' ),
				'show_label' => false,
				'condition'  => [
					'source' => 'editor',
				],
			]
		);

		$this->add_control(
			'skin_template_slides',
			[
				'label'   => esc_html__( 'Slides', 'avator-widget-pack' ),
				'type'    => Controls_Manager::REPEATER,
				'fields'  => $repeater_2->get_controls(),
				'default' => $this->get_repeater_defaults(),
				'condition' => [
					'_skin' => 'avt-custom-content'
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'image_size',
				'default'   => 'medium',
				'separator' => 'before',
				'condition' => [
					'_skin!' => 'avt-custom-content',
				],
			]
		);

		$this->add_control(
			'image_fit',
			[
				'label'   => esc_html__( 'Image Fit', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					''        => esc_html__( 'Cover', 'avator-widget-pack' ),
					'contain' => esc_html__( 'Contain', 'avator-widget-pack' ),
					'auto'    => esc_html__( 'Auto', 'avator-widget-pack' ),
				],
				'selectors' => [
					'{{WRAPPER}} .swiper-container .avt-custom-carousel-thumbnail' => 'background-size: {{VALUE}}',
				],
				'condition' => [
					'_skin!' => 'avt-custom-content',
				],
			]
		);

		$this->add_responsive_control(
			'slides_per_view',
			[
				'type'           => Controls_Manager::SELECT,
				'label'          => esc_html__( 'Slides Per View', 'avator-widget-pack' ),
				'options'        => $slides_per_view,
				'default'        => '3',
				'tablet_default' => '2',
				'mobile_default' => '1',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_navigation',
			[
				'label' => __( 'Navigation', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'navigation',
			[
				'label'   => __( 'Navigation', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'arrows',
				'options' => [
					'both'            => esc_html__( 'Arrows and Dots', 'avator-widget-pack' ),
					'arrows-fraction' => esc_html__( 'Arrows and Fraction', 'avator-widget-pack' ),
					'arrows'          => esc_html__( 'Arrows', 'avator-widget-pack' ),
					'dots'            => esc_html__( 'Dots', 'avator-widget-pack' ),
					'progressbar'     => esc_html__( 'Progress', 'avator-widget-pack' ),
					'none'            => esc_html__( 'None', 'avator-widget-pack' ),
				],
				'prefix_class' => 'avt-navigation-type-',
				'render_type' => 'template',				
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
			'arrows_fraction_position',
			[
				'label'     => __( 'Arrows and Fraction Position', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'center',
				'options'   => widget_pack_navigation_position(),
				'condition' => [
					'navigation' => 'arrows-fraction',
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

		$this->add_control(
			'progress_position',
			[
				'label'   => __( 'Progress Position', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'bottom',
				'options' => [
					'bottom' => esc_html__('Bottom', 'avator-widget-pack'),
					'top'    => esc_html__('Top', 'avator-widget-pack'),
				],
				'condition' => [
					'navigation' => 'progressbar',
				],
				
			]
		);

		$this->add_control(
			'hide_arrow_on_mobile',
			[
				'label'     => __( 'Hide Arrow on Mobile ?', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'condition' => [
					'navigation' => [ 'arrows-fraction', 'arrows', 'both' ],
				],				
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_additional_options',
			[
				'label' => esc_html__( 'Additional Options', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'speed',
			[
				'label'   => esc_html__( 'Transition Duration', 'avator-widget-pack' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 500,
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label'     => esc_html__( 'Autoplay', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'autoplay_speed',
			[
				'label'     => esc_html__( 'Autoplay Speed', 'avator-widget-pack' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 5000,
				'condition' => [
					'autoplay' => 'yes',
				],
			]
		);

		$this->add_control(
			'pauseonhover',
			[
				'label' => esc_html__( 'Pause on Hover', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SWITCHER,
				'condition' => [
					'autoplay' => 'yes',
				],
			]
		);

		$this->add_control(
			'loop',
			[
				'label'   => esc_html__( 'Infinite Loop', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'centered_slides',
			[
				'label'       => esc_html__( 'Centered Slides', 'avator-widget-pack' ),
				'description' => esc_html__( 'Use even slides for get better look', 'avator-widget-pack' ),
				'type'        => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'observer',
			[
				'label'       => __( 'Observer', 'avator-widget-pack' ),
				'description' => __( 'When you use carousel in any hidden place (in tabs, accordion etc) keep it yes.', 'avator-widget-pack' ),
				'type'        => Controls_Manager::SWITCHER,				
			]
		);

		$this->add_control(
			'overlay',
			[
				'label' => esc_html__( 'Overlay', 'avator-widget-pack' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					''     => esc_html__( 'None', 'avator-widget-pack' ),
					'text' => esc_html__( 'Text', 'avator-widget-pack' ),
					'icon' => esc_html__( 'Icon', 'avator-widget-pack' ),
				],
				'separator' => 'before',
				'condition' => [
					'_skin' => '',
				],
			]
		);

		$this->add_control(
			'caption',
			[
				'label'   => esc_html__( 'Caption', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'title',
				'options' => [
					'title'   => esc_html__( 'Title', 'avator-widget-pack' ),
					'caption' => esc_html__( 'Caption', 'avator-widget-pack' ),
				],
				'condition' => [
					'overlay' => 'text',
					'_skin'   => '',
				],
			]
		);

		$this->add_control(
			'icon',
			[
				'label'   => esc_html__( 'Icon', 'avator-widget-pack' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'plus-circle',
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
				'condition' => [
					'overlay' => 'icon',
					'_skin'   => '',
				],
			]
		);

		$this->add_control(
			'overlay_animation',
			[
				'label'     => esc_html__( 'Animation', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'fade',
				'options'   => widget_pack_transition_options(),
				'condition' => [
					'overlay!' => '',
					'_skin'    => '',
				],
				'separator' => 'after',
			]
		);

		$this->add_control(
			'slides_to_scroll',
			[
				'type'      => Controls_Manager::SELECT,
				'label'     => esc_html__( 'Slides to Scroll', 'avator-widget-pack' ),
				'options'   => $slides_per_view,
				'default'   => '1',
				'condition' => [
					'skin' => 'carousel',
				]
			]
		);

		$this->add_control(
			'slides_per_column',
			[
				'type'      => Controls_Manager::SELECT,
				'label'     => esc_html__( 'Slides Per Column', 'avator-widget-pack' ),
				'options'   => $slides_per_view,
				'default'   => '1',
				'condition' => [
					'skin' => 'carousel',
				]
			]
		);

		$this->add_responsive_control(
			'height',
			[
				'type'       => Controls_Manager::SLIDER,
				'label'      => esc_html__( 'Height', 'avator-widget-pack' ),
				'size_units' => [ 'px', 'vh' ],
				'range'      => [
					'px' => [
						'min' => 100,
						'max' => 1000,
					],
					'vh' => [
						'min' => 20,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .swiper-container .swiper-slide' => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'_skin' => ''
				]
			]
		);

		$this->add_responsive_control(
			'width',
			[
				'type'  => Controls_Manager::SLIDER,
				'label' => esc_html__( 'Width', 'avator-widget-pack' ),
				'range' => [
					'px' => [
						'min' => 100,
						'max' => 1140,
					],
					'%' => [
						'min' => 50,
					],
				],
				'size_units' => [ '%', 'px' ],
				'default' => [
					'unit' => '%',
				],
				'selectors' => [
					'{{WRAPPER}} .swiper-container' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_slides_style',
			[
				'label' => esc_html__( 'Slides', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'space_between',
			[
				'label' => esc_html__( 'Space Between', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'desktop_default' => [
					'size' => 10,
				],
				'tablet_default' => [
					'size' => 10,
				],
				'mobile_default' => [
					'size' => 10,
				],
				'render_type' => 'none',
			]
		);

		$this->add_control(
			'slide_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .swiper-container .swiper-slide' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'slide_border_size',
			[
				'label'     => esc_html__( 'Border Size', 'avator-widget-pack' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .swiper-container .swiper-slide' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'slide_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .swiper-container .swiper-slide' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'slide_padding',
			[
				'label'     => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .swiper-container .swiper-slide' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'slide_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'%' => [
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .swiper-container .swiper-slide' => 'border-radius: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'shadow_mode',
			[
				'label'        => esc_html__( 'Shadow Mode', 'avator-widget-pack' ),
				'type'         => Controls_Manager::SWITCHER,
				'prefix_class' => 'avt-wp-shadow-mode-',
			]
		);

		$this->add_control(
			'shadow_color',
			[
				'label'     => esc_html__( 'Shadow Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'shadow_mode' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-widget-container:before' => 'background: linear-gradient(to right,
					{{VALUE}} 5%,rgba(255,255,255,0) 100%);',
					'{{WRAPPER}} .elementor-widget-container:after'  => 'background: linear-gradient(to right, rgba(255,255,255,0) 0%, {{VALUE}} 95%);',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_navigation',
			[
				'label'     => __( 'Navigation', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'navigation' => [ 'arrows', 'dots', 'both', 'arrows-fraction', 'progressbar' ],
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
					'{{WRAPPER}} .avt-custom-carousel .avt-navigation-prev svg,
					{{WRAPPER}} .avt-custom-carousel .avt-navigation-next svg' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'navigation!' => [ 'dots', 'progressbar', 'none' ],
				],
			]
		);

		$this->add_control(
			'arrows_background',
			[
				'label'     => __( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-custom-carousel .avt-navigation-prev, {{WRAPPER}} .avt-custom-carousel .avt-navigation-next' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'navigation!' => [ 'dots', 'progressbar', 'none' ],
				],
			]
		);

		$this->add_control(
			'arrows_hover_background',
			[
				'label'     => __( 'Hover Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-custom-carousel .avt-navigation-prev:hover, {{WRAPPER}} .avt-custom-carousel .avt-navigation-next:hover' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'navigation!' => [ 'dots', 'progressbar', 'none' ],
				],
			]
		);

		$this->add_control(
			'arrows_color',
			[
				'label'     => __( 'Arrows Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-custom-carousel .avt-navigation-prev svg, {{WRAPPER}} .avt-custom-carousel .avt-navigation-next svg' => 'color: {{VALUE}}',
				],
				'condition' => [
					'navigation!' => [ 'dots', 'progressbar', 'none' ],
				],
			]
		);

		$this->add_control(
			'arrows_hover_color',
			[
				'label'     => __( 'Arrows Hover Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-custom-carousel .avt-navigation-prev:hover svg, {{WRAPPER}} .avt-custom-carousel .avt-navigation-next:hover svg' => 'color: {{VALUE}}',
				],
				'condition' => [
					'navigation!' => [ 'dots', 'progressbar', 'none' ],
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
					'{{WRAPPER}} .avt-custom-carousel .avt-navigation-prev' => 'margin-right: {{SIZE}}px;',
					'{{WRAPPER}} .avt-custom-carousel .avt-navigation-next' => 'margin-left: {{SIZE}}px;',
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
				'label' => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .avt-custom-carousel .avt-navigation-prev, {{WRAPPER}} .avt-custom-carousel .avt-navigation-next' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .avt-custom-carousel .avt-navigation-prev, {{WRAPPER}} .avt-custom-carousel .avt-navigation-next' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'navigation!' => [ 'dots', 'progressbar', 'none' ],
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
					'{{WRAPPER}} .avt-custom-carousel .swiper-pagination-bullet' => 'height: {{SIZE}}{{UNIT}};width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'navigation!' => [ 'arrows', 'arrows-fraction', 'progressbar', 'none' ],
				],
			]
		);

		$this->add_control(
			'dots_color',
			[
				'label'     => __( 'Dots Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-custom-carousel .swiper-pagination-bullet' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'navigation!' => [ 'arrows', 'arrows-fraction', 'progressbar', 'none' ],
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
					'{{WRAPPER}} .avt-custom-carousel .swiper-pagination-bullet-active' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'navigation!' => [ 'arrows', 'arrows-fraction', 'progressbar', 'none' ],
				],
			]
		);

		$this->add_control(
			'fraction_color',
			[
				'label'     => __( 'Fraction Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-custom-carousel .swiper-pagination-fraction' => 'color: {{VALUE}}',
				],
				'condition' => [
					'navigation!' => [ 'arrows', 'dots', 'progressbar', 'none' ],
				],
			]
		);

		$this->add_control(
			'active_fraction_color',
			[
				'label'     => __( 'Active Fraction Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-custom-carousel .swiper-pagination-current' => 'color: {{VALUE}}',
				],
				'condition' => [
					'navigation!' => [ 'arrows', 'dots', 'progressbar', 'none' ],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'fraction_typography',
				'label'     => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
				'selector'  => '{{WRAPPER}} .avt-custom-carousel .swiper-pagination-fraction',
				'condition' => [
					'navigation!' => [ 'arrows', 'dots', 'progressbar', 'none' ],
				],
			]
		);

		$this->add_control(
			'progresbar_color',
			[
				'label'     => __( 'Bar Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-custom-carousel .swiper-pagination-progressbar' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'navigation' => 'progressbar',
				],
			]
		);

		$this->add_control(
			'progres_color',
			[
				'label'     => __( 'Progress Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'separator' => 'after',
				'selectors' => [
					'{{WRAPPER}} .avt-custom-carousel .swiper-pagination-progressbar' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'navigation' => 'progressbar',
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
					'{{WRAPPER}} .avt-custom-carousel .avt-arrows-container' => 'transform: translate({{arrows_ncx_position.size}}px, {{SIZE}}px);',
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
					'{{WRAPPER}} .avt-custom-carousel .avt-navigation-prev' => 'left: {{SIZE}}px;',
					'{{WRAPPER}} .avt-custom-carousel .avt-navigation-next' => 'right: {{SIZE}}px;',
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
					'{{WRAPPER}} .avt-custom-carousel .avt-dots-container' => 'transform: translate({{dots_nnx_position.size}}px, {{SIZE}}px);',
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
					'{{WRAPPER}} .avt-custom-carousel .avt-arrows-dots-container' => 'transform: translate({{both_ncx_position.size}}px, {{SIZE}}px);',
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
					'{{WRAPPER}} .avt-custom-carousel .avt-navigation-prev' => 'left: {{SIZE}}px;',
					'{{WRAPPER}} .avt-custom-carousel .avt-navigation-next' => 'right: {{SIZE}}px;',
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
					'{{WRAPPER}} .avt-custom-carousel .avt-dots-container' => 'transform: translateY({{SIZE}}px);',
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
			'arrows_fraction_ncx_position',
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
							'value' => 'arrows-fraction',
						],
						[
							'name'     => 'arrows_fraction_position',
							'operator' => '!=',
							'value'    => 'center',
						],
					],
				],
			]
		);

		$this->add_control(
			'arrows_fraction_ncy_position',
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
					'{{WRAPPER}} .avt-custom-carousel .avt-arrows-dots-container' => 'transform: translate({{arrows_fraction_ncx_position.size}}px, {{SIZE}}px);',
				],
				'conditions'   => [
					'terms' => [
						[
							'name'  => 'navigation',
							'value' => 'arrows-fraction',
						],
						[
							'name'     => 'arrows_fraction_position',
							'operator' => '!=',
							'value'    => 'center',
						],
					],
				],
			]
		);

		$this->add_control(
			'arrows_fraction_cx_position',
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
					'{{WRAPPER}} .avt-custom-carousel .avt-navigation-prev' => 'left: {{SIZE}}px;',
					'{{WRAPPER}} .avt-custom-carousel .avt-navigation-next' => 'right: {{SIZE}}px;',
				],
				'conditions' => [
					'terms' => [
						[
							'name'  => 'navigation',
							'value' => 'arrows-fraction',
						],
						[
							'name'  => 'arrows_fraction_position',
							'value' => 'center',
						],
					],
				],
			]
		);

		$this->add_control(
			'arrows_fraction_cy_position',
			[
				'label'   => __( 'Fraction Offset', 'avator-widget-pack' ),
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
					'{{WRAPPER}} .avt-custom-carousel .swiper-pagination-fraction' => 'transform: translateY({{SIZE}}px);',
				],
				'conditions' => [
					'terms' => [
						[
							'name'  => 'navigation',
							'value' => 'arrows-fraction',
						],
						[
							'name'  => 'arrows_fraction_position',
							'value' => 'center',
						],
					],
				],
			]
		);

		$this->add_control(
			'progress_y_position',
			[
				'label'   => __( 'Progress Offset', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 15,
				],
				'range' => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-custom-carousel .swiper-pagination-progressbar' => 'transform: translateY({{SIZE}}px);',
				],
				'condition' => [
					'navigation' => 'progressbar',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_overlay',
			[
				'label'     => esc_html__( 'Overlay', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'overlay!' => '',
					'_skin'    => '',
				],
			]
		);

		$this->add_control(
			'overlay_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-custom-carousel-item .avt-overlay' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'overlay_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-custom-carousel-item .avt-overlay' => 'color: {{VALUE}};',
				],
				'condition' => [
					'overlay' => 'text',
				],
			]
		);

		$this->add_control(
			'overlay_icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-custom-carousel-item .avt-overlay' => 'color: {{VALUE}};',
				],
				'condition' => [
					'overlay' => 'icon',
				],
			]
		);

		$this->add_control(
			'icon_size',
			[
				'label'     => esc_html__( 'Icon Size', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .avt-custom-carousel-item .avt-overlay svg' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'overlay' => 'icon',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'caption_typography',
				'label'     => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
				'selector'  => '{{WRAPPER}} .avt-custom-carousel-item .avt-overlay',
				'condition' => [
					'overlay' => 'text',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_lightbox_style',
			[
				'label'     => esc_html__( 'Lightbox', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'_skin'    => '',
				],
			]
		);

		$this->add_control(
			'lightbox_video_width',
			[
				'label'   => esc_html__( 'Video Width', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'units'   => [ '%' ],
				'default' => [
					'unit' => '%',
				],
				'range' => [
					'%' => [
						'min' => 50,
					],
				],
				'selectors' => [
					'.avt-lightbox.avt-open iframe' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function get_default_slides_count() {
		return 5;
	}

	protected function get_repeater_defaults() {
		$placeholder_image_src = Utils::get_placeholder_image_src();

		return array_fill( 0, $this->get_default_slides_count(), [
			'image' => [
				'url' => $placeholder_image_src,
			],
		] );
	}

	protected function get_image_caption( $slide ) {
		$caption_type = $this->get_settings_for_display( 'caption' );

		if ( empty( $caption_type ) ) {
			return '';
		}

		$attachment_post = get_post( $slide['image']['id'] );

		if ( 'caption' === $caption_type ) {
			return $attachment_post->post_excerpt;
		}

		if ( 'title' === $caption_type ) {
			return $attachment_post->post_title;
		}
	}

	protected function get_image_link_to( $slide ) {
		if ( $slide['video']['url'] ) {
			return $slide['image']['url'];
		}

		if ( ! $slide['image_link_to_type'] ) {
			return '';
		}

		if ( 'custom' === $slide['image_link_to_type'] ) {
			return $slide['image_link_to']['url'];
		}

		return $slide['image']['url'];
	}

	protected function print_slide( array $slide, array $settings, $element_key ) {		

		if ( 'avt-custom-content' === $settings['_skin'] ) {
			$this->render_slide_template( $slide, $element_key, $settings );
		} else {
			if ( ! empty( $settings['thumbs_slider'] ) ) {

				$settings['video_play_icon'] = false;
				$this->add_render_attribute( $element_key . '-image', 'class', 'elementor-fit-aspect-ratio' );
			}

			$this->add_render_attribute( $element_key . '-image', [
				'class' => 'avt-custom-carousel-thumbnail',
				'style' => 'background-image: url(' . $this->get_slide_image_url( $slide, $settings ) . ')',
			] );

			$image_link_to = $this->get_image_link_to( $slide );

			if ( $image_link_to ) {

				if ( ('video' !== $slide['type']) && ( '' !== $slide['video']['url']) ) {
					$this->add_render_attribute( $element_key . '_link', 'href', $image_link_to );
				}

				if ( 'custom' === $slide['image_link_to_type'] ) {
					if ( $slide['image_link_to']['is_external'] ) {
						$this->add_render_attribute( $element_key . '_link', 'target', '_blank' );
					}

					if ( $slide['image_link_to']['nofollow'] ) {
						$this->add_render_attribute( $element_key . '_link', 'nofollow', '' );
					}
				} else {
					$this->add_render_attribute( $element_key . '_link', [
						'class'                        => 'avt-custom-carousel-lightbox-item',
						'data-elementor-open-lightbox' => 'no',
						'data-caption'                 => $this->get_image_caption( $slide ),
					] );
				}

				if ( 'video' === $slide['type'] && $slide['video']['url'] ) {
					$this->add_render_attribute( $element_key . '_link', 'href', $slide['video']['url'] );
				}

				echo '<a ' . $this->get_render_attribute_string( $element_key . '_link' ) . '>';
			}

			$this->render_slide_image( $slide, $element_key, $settings );
			
			if ( $image_link_to ) {
				echo '</a>';
			}
		}
	}

	protected function render_slide_template( array $slide, $element_key, array $settings ) {

    	?>
		<div <?php echo $this->get_render_attribute_string( $element_key . '-template' ); ?>>
		<?php

		if ( 'template' == $slide['source'] ) {
			if ( 'elementor' == $slide['template_source'] and ! empty( $slide['elementor_template'] ) ) {
	    		echo Widget_Pack_Loader::elementor()->frontend->get_builder_content_for_display( $slide['elementor_template'] );
	    		echo widget_pack_template_edit_link( $slide['elementor_template'] );
	    	} elseif ('anywhere' == $slide['template_source'] and ! empty( $slide['anywhere_template'] )) {
	    		echo Widget_Pack_Loader::elementor()->frontend->get_builder_content_for_display( $slide['anywhere_template'] );
	    		echo widget_pack_template_edit_link( $slide['anywhere_template'] );
	    	}
		} else {
			echo wp_kses_post( $slide['editor_content'] );
		}

    	?>
		</div>
		<?php
	}

	protected function render_slide_image( array $slide, $element_key, array $settings ) {

		$this->add_render_attribute(
			[
				'overlay-settings' => [
					'class' => [
						'avt-overlay',
						'avt-overlay-default',
						'avt-position-cover',
						'avt-position-small',
						'avt-flex',
						'avt-flex-center',
						'avt-flex-middle',
						$settings['overlay_animation'] ? 'avt-transition-' . $settings['overlay_animation'] : ''
					],
				],
			], '', '', true
		);

		?>
		<div <?php echo $this->get_render_attribute_string( $element_key . '-image' ); ?>></div>
		
		<?php if ( $settings['overlay'] ) : ?>
			<div <?php echo $this->get_render_attribute_string( 'overlay-settings' ); ?>>
				<?php if ( 'text' === $settings['overlay'] ) : ?>
					<?php echo $this->get_image_caption( $slide ); ?>
				<?php else : ?>
					<span class="avt-icon" avt-icon="icon: <?php echo esc_attr($settings['icon']); ?>"></span>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<?php
	}

	protected function render_navigation() {
		$settings = $this->get_settings_for_display();
		$hide_arrow_on_mobile = $settings['hide_arrow_on_mobile'] ? ' avt-visible@m' : '';
		
		if ( 'arrows' == $settings['navigation'] ) : ?>
			<div class="avt-position-z-index avt-position-<?php echo esc_attr( $settings['arrows_position'] . $hide_arrow_on_mobile ); ?>">
				<div class="avt-arrows-container avt-slidenav-container">
					<a href="" class="avt-navigation-prev avt-slidenav-previous avt-icon avt-slidenav" avt-icon="icon: chevron-left; ratio: 1.9"></a>
					<a href="" class="avt-navigation-next avt-slidenav-next avt-icon avt-slidenav" avt-icon="icon: chevron-right; ratio: 1.9"></a>
				</div>
			</div>
		<?php endif;
	}

	protected function render_pagination() {
		$settings = $this->get_settings_for_display();
		
		if ( 'dots' == $settings['navigation'] or 'arrows-fraction' == $settings['navigation'] ) : ?>
			<div class="avt-position-z-index avt-position-<?php echo esc_attr($settings['dots_position']); ?>">
				<div class="avt-dots-container">
					<div class="swiper-pagination"></div>
				</div>
			</div>

		<?php elseif ( 'progressbar' == $settings['navigation'] ) : ?>
			<div class="swiper-pagination avt-position-z-index avt-position-<?php echo esc_attr($settings['progress_position']); ?>"></div>
		<?php endif;
	}

	protected function render_both_navigation() {
		$settings = $this->get_settings_for_display();
		$hide_arrow_on_mobile = $settings['hide_arrow_on_mobile'] ? 'avt-visible@m' : '';
		
		?>
		<div class="avt-position-z-index avt-position-<?php echo esc_attr($settings['both_position']); ?>">
			<div class="avt-arrows-dots-container avt-slidenav-container ">
				
				<div class="avt-flex avt-flex-middle">
					<div class="<?php echo esc_attr( $hide_arrow_on_mobile ); ?>">
						<a href="" class="avt-navigation-prev avt-slidenav-previous avt-icon avt-slidenav" avt-icon="icon: chevron-left; ratio: 1.9"></a>
					</div>

					<?php if ('center' !== $settings['both_position']) : ?>
						<div class="swiper-pagination"></div>
					<?php endif; ?>
					
					<div class="<?php echo esc_attr( $hide_arrow_on_mobile ); ?>">
						<a href="" class="avt-navigation-next avt-slidenav-next avt-icon avt-slidenav" avt-icon="icon: chevron-right; ratio: 1.9"></a>
					</div>
					
				</div>
			</div>
		</div>		
		<?php
	}

	protected function render_arrows_fraction() {
		$settings             = $this->get_settings_for_display();
		$hide_arrow_on_mobile = $settings['hide_arrow_on_mobile'] ? 'avt-visible@m' : '';
		
		?>
		<div class="avt-position-z-index avt-position-<?php echo esc_attr($settings['arrows_fraction_position']); ?>">
			<div class="avt-arrows-dots-container avt-slidenav-container ">
				
				<div class="avt-flex avt-flex-middle">
					<div class="<?php echo esc_attr( $hide_arrow_on_mobile ); ?>">
						<a href="" class="avt-navigation-prev avt-slidenav-previous avt-icon avt-slidenav" avt-icon="icon: chevron-left; ratio: 1.9"></a>
					</div>

					<?php if ('center' !== $settings['arrows_fraction_position']) : ?>
						<div class="swiper-pagination"></div>
					<?php endif; ?>
					
					<div class="<?php echo esc_attr( $hide_arrow_on_mobile ); ?>">
						<a href="" class="avt-navigation-next avt-slidenav-next avt-icon avt-slidenav" avt-icon="icon: chevron-right; ratio: 1.9"></a>
					</div>
					
				</div>
			</div>
		</div>		
		<?php
	}

	protected function render_header() {
		$id         = 'avt-custom-carousel-' . $this->get_id();
		$settings   = $this->get_settings_for_display();
		$skin_class = ( 'avt-custom-content' == $settings['_skin'] ) ? 'custom-content' : 'default';

		$this->add_render_attribute( 'custom-carousel', 'id', $id );
		$this->add_render_attribute( 'custom-carousel', 'class', [ 'avt-custom-carousel', 'elementor-swiper', 'avt-custom-carousel-skin-' . $skin_class ] );
		$this->add_render_attribute( 'custom-carousel', 'avt-lightbox', 'toggle: .avt-custom-carousel-lightbox-item; animation: slide;');

		if ('arrows' == $settings['navigation']) {
			$this->add_render_attribute( 'custom-carousel', 'class', 'avt-arrows-align-'. $settings['arrows_position'] );
		} elseif ('dots' == $settings['navigation']) {
			$this->add_render_attribute( 'custom-carousel', 'class', 'avt-dots-align-'. $settings['dots_position'] );
		} elseif ('both' == $settings['navigation']) {
			$this->add_render_attribute( 'custom-carousel', 'class', 'avt-arrows-dots-align-'. $settings['both_position'] );
		} elseif ('arrows-fraction' == $settings['navigation']) {
			$this->add_render_attribute( 'custom-carousel', 'class', 'avt-arrows-dots-align-'. $settings['arrows_fraction_position'] );
		}

		$elementor_vp_lg = get_option( 'elementor_viewport_lg' );
		$elementor_vp_md = get_option( 'elementor_viewport_md' );
		$viewport_lg     = !empty($elementor_vp_lg) ? $elementor_vp_lg - 1 : 1024;
		$viewport_md     = !empty($elementor_vp_md) ? $elementor_vp_md - 1 : 767;

		if ('arrows-fraction' == $settings['navigation'] ) {
			$pagination_type = 'fraction';
		} elseif ('both' == $settings['navigation'] or 'dots' == $settings['navigation']) {
			$pagination_type = 'bullets';
		} elseif ('progressbar' == $settings['navigation'] ) {
			$pagination_type = 'progressbar';
		} else {
			$pagination_type = '';
		}

		$this->add_render_attribute(
			[
				'custom-carousel' => [
					'data-settings' => [
						wp_json_encode(array_filter([
							"autoplay"        => ( "yes" == $settings["autoplay"] ) ? [ "delay" => $settings["autoplay_speed"] ] : false,
							"loop"            => ($settings["loop"] == "yes") ? true : false,
							"speed"           => $settings["speed"]["size"],
							"pauseOnHover"    => ("yes" == $settings["pauseonhover"]) ? true : false,
							"slidesPerView"   => (int) $settings["slides_per_view"],
							"spaceBetween"    => $settings["space_between"]["size"],
							"centeredSlides"  => ($settings["centered_slides"] === "yes") ? true : false,
							"effect"          => $settings["skin"],
							"slidesPerColumn" => ($settings["slides_per_column"] > 1) ? $settings["slides_per_column"] : false,
							"slidesPerGroup"  => ($settings["slides_to_scroll"] > 1) ? $settings["slides_to_scroll"] : false ,
							"observer"       => ($settings["observer"]) ? true : false,
							"observeParents" => ($settings["observer"]) ? true : false,
							"breakpoints"     => [
								(int) $viewport_lg => [
									"slidesPerView" => (int) $settings["slides_per_view_tablet"],
									"spaceBetween"  => $settings["space_between"]["size"],
								],
								(int) $viewport_md => [
									"slidesPerView" => (int) $settings["slides_per_view_mobile"],
									"spaceBetween"  => $settings["space_between"]["size"],
								]
					      	],
			      	        "navigation" => [
			      				"nextEl" => "#" . $id . " .avt-navigation-next",
			      				"prevEl" => "#" . $id . " .avt-navigation-prev",
			      			],
			      			"pagination" => [
			      				"el"        => "#" . $id . " .swiper-pagination",
			      				"type"      => $pagination_type,
			      				"clickable" => "true",
			      			],
				        ]))
					]
				]
			]
		);


		?>
		<div <?php echo $this->get_render_attribute_string( 'custom-carousel' ); ?>>
			<div class="swiper-container">
				<div class="swiper-wrapper">
		<?php
	}

	protected function render_footer() {
		$settings = $this->get_settings_for_display();

		if ( 'avt-custom-content' == $settings['_skin'] ) {
			$slides_count = count( $settings['skin_template_slides'] );
		} else {
			$slides_count = count( $settings['slides'] );
		}

				?>
				</div> 
			</div>

			<?php if ( 1 < $slides_count ) : ?>
				
				<?php if ('both' == $settings['navigation']) : ?>
					<?php $this->render_both_navigation(); ?>
					<?php if ( 'center' === $settings['both_position'] ) : ?>
						<div class="avt-dots-container">
							<div class="swiper-pagination"></div>
						</div>
					<?php endif; ?>
				<?php elseif ('arrows-fraction' == $settings['navigation']) : ?>
					<?php $this->render_arrows_fraction(); ?>
					<?php if ( 'center' === $settings['arrows_fraction_position'] ) : ?>
						<div class="avt-dots-container">
							<div class="swiper-pagination"></div>
						</div>
					<?php endif; ?>
				<?php else : ?>			
					<?php $this->render_pagination(); ?>
					<?php $this->render_navigation(); ?>
				<?php endif; ?>

			<?php endif; ?>
			
		</div>
		<?php
	}

	protected function render_loop_slides( array $settings = null ) {

		if ( null === $settings ) {
			$settings = $this->get_settings_for_display();
		}

		$default_settings = [ 'video_play_icon' => true ];
		$settings         = array_merge( $default_settings, $settings );

		$slides = [];

		if ( 'avt-custom-content' == $settings['_skin'] ) {
			$slides_count = count( $settings['skin_template_slides'] );
			$slides       = $settings['skin_template_slides'];
		} else {
			$slides_count = count( $settings['slides'] );
			$slides       = $settings['slides'];
		}

		foreach ( $slides as $index => $slide ) :
			$this->slide_prints_count++;
			?>
			<div class="swiper-slide avt-custom-carousel-item avt-transition-toggle">
				<?php $this->print_slide( $slide, $settings, 'slide-' . $index . '-' . $this->slide_prints_count ); ?>
			</div>
			<?php 
		endforeach;
	}

	protected function get_slide_image_url( $slide, array $settings ) {
		$image_url = Group_Control_Image_Size::get_attachment_image_src( $slide['image']['id'], 'image_size', $settings );

		if ( ! $image_url ) {
			$image_url = $slide['image']['url'];
		}

		return $image_url;
	}

	protected function render_slider( array $settings = null ) {
		$this->render_loop_slides( $settings );
	}

	public function render() {
		$this->render_header();
		$this->render_slider();
		$this->render_footer();
	}
}
