<?php
namespace WidgetPack\Modules\PanelSlider\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Icons_Manager;
use Elementor\Core\Files\Assets\Svg\Svg_Handler;

use WidgetPack\Modules\PanelSlider\Skins;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Class Panel Slider
 */
class Panel_Slider extends Widget_Base {

	public function get_name() {
		return 'avt-panel-slider';
	}

	public function get_title() {
		return AWP . esc_html__( 'Panel Slider', 'avator-widget-pack' );
	}

	public function get_icon() {
		return 'avt-wi-panel-slider';
	}

	public function get_categories() {
		return [ 'widget-pack' ];
	}

	public function get_keywords() {
		return [ 'panel', 'slider' ];
	}

	public function get_style_depends() {
		return [ 'wipa-panel-slider' ];
	}

	public function get_script_depends() {
		return [ 'imagesloaded', 'avt-uikit-icons', 'wipa-panel-slider' ];
	}

	public function get_custom_help_url() {
		return 'https://youtu.be/_piVTeJd0g4';
	}

	protected function _register_skins() {
		$this->add_skin( new Skins\Skin_Middle( $this ) );
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_content_layout',
			[
				'label' => esc_html__( 'Layout', 'avator-widget-pack' ),
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
				'condition' => [
					'_skin' => '',
				],
			]
		);

		$this->add_responsive_control(
			'skin_columns',
			[
				'label'          => esc_html__( 'Columns', 'avator-widget-pack' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => '4',
				'tablet_default' => '2',
				'mobile_default' => '2',
				'options'        => [
					'2' => '2',
					'4' => '4',
					'6' => '6',
					'8' => '8',
					'10' => '10',
				],
				'condition' => [
					'_skin!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'column_space',
			[
				'label' => esc_html__('Column Space', 'avator-widget-pack'),
				'type'  => Controls_Manager::SLIDER,
			]
		);

		$this->add_responsive_control(
			'slider_height',
			[
				'label'      => esc_html__('Slider Height', 'avator-widget-pack'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px', 'vh' ],
				'range'      => [
					'px' => [
						'min'  => 100,
						'step' => 20,
						'max'  => 1600
					],
					'vh' => [
						'min'  => 1,
						'step' => 1,
						'max'  => 100
					]
				],
				'default' => [
					'size'  => 620,
				],
				'selectors' => [
					'{{WRAPPER}} .swiper-wrapper' => 'height: {{SIZE}}{{UNIT}};'
				]
			]
		);

		$this->add_control(
			'show_title',
			[
				'label'   => esc_html__( 'Show Title', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'global_link',
			[
				'label'        => esc_html__( 'Global Link', 'avator-widget-pack' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => 'If it apply then button link wii not work',
				'prefix_class' => 'avt-global-link-',
			]
		);

		$this->add_control(
			'button',
			[
				'label'       => esc_html__( 'Show Button', 'avator-widget-pack' ),
				'type'        => Controls_Manager::SWITCHER,
				'default'     => 'yes',
				'description' => 'It will work when link field no null.',
				'conditions' => [
					'terms'    => [
						[
							'name'  => '_skin',
							'value' => ''
						],
						[
							'name'     => 'global_link',
							'operator' => '!=',
							'value'    => 'yes'
						]
					]
				]
			]
		);

		$this->add_control(
			'navigation',
			[
				'label'   => esc_html__( 'Navigation', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'arrows',
				'options' => [
					'both'   => esc_html__( 'Arrows and Dots', 'avator-widget-pack' ),
					'arrows' => esc_html__( 'Arrows', 'avator-widget-pack' ),
					'dots'   => esc_html__( 'Dots', 'avator-widget-pack' ),
					'none'   => esc_html__( 'None', 'avator-widget-pack' ),
				],
				'frontend_available' => true,
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label'   => esc_html__( 'Alignment', 'avator-widget-pack' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'left'    => [
						'title' => esc_html__( 'Left', 'avator-widget-pack' ),
						'icon' => 'fas fa-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'avator-widget-pack' ),
						'icon' => 'fas fa-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'avator-widget-pack' ),
						'icon' => 'fas fa-align-right',
					],
					'justify' => [
						'title' => esc_html__( 'Justified', 'avator-widget-pack' ),
						'icon' => 'fas fa-align-justify',
					],
				],
				'prefix_class' => 'elementor%s-align-',
				'default' => '',
			]
		);

		$this->add_control(
			'slide_skew',
			[
				'label'   => esc_html__( 'Slide Skew', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min'  => 0,
						'max'  => 30,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-panel-slider .avt-panel-slide-item' => 'transform: skew(-{{SIZE}}deg);',
					'{{WRAPPER}} .avt-panel-slider .avt-panel-slide-desc' => 'transform: skew({{SIZE}}deg);',
					'{{WRAPPER}} .avt-panel-slider .avt-panel-slide-link' => 'transform: skew(-{{SIZE}}deg);',
					'{{WRAPPER}} .avt-panel-slider span'                  => 'transform: skew({{SIZE}}deg); display: inline-block;',
				],
				'condition' => [
					'_skin' => ''
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_sliders',
			[
				'label' => esc_html__( 'Sliders', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'tabs',
			[
				'label' => esc_html__( 'Slider Items', 'avator-widget-pack' ),
				'type' => Controls_Manager::REPEATER,
				'default' => [
					[
						'tab_title'   => esc_html__( 'Slide #1', 'avator-widget-pack' ),
						'tab_content' => esc_html__( 'I am item content. Click edit button to change this text.', 'avator-widget-pack' ),
					],
					[
						'tab_title'   => esc_html__( 'Slide #2', 'avator-widget-pack' ),
						'tab_content' => esc_html__( 'I am item content. Click edit button to change this text.', 'avator-widget-pack' ),
					],
					[
						'tab_title'   => esc_html__( 'Slide #3', 'avator-widget-pack' ),
						'tab_content' => esc_html__( 'I am item content. Click edit button to change this text.', 'avator-widget-pack' ),
					],
					[
						'tab_title'   => esc_html__( 'Slide #4', 'avator-widget-pack' ),
						'tab_content' => esc_html__( 'I am item content. Click edit button to change this text.', 'avator-widget-pack' ),
					],
				],
				'fields' => [
					[
						'name'        => 'tab_title',
						'label'       => esc_html__( 'Title', 'avator-widget-pack' ),
						'type'        => Controls_Manager::TEXT,
						'dynamic'     => [ 'active' => true ],
						'default'     => esc_html__( 'Slide Title' , 'avator-widget-pack' ),
						'label_block' => true,
					],
					[
						'name'        => 'tab_image',
						'label'       => esc_html__( 'Image', 'avator-widget-pack' ),
						'type'        => Controls_Manager::MEDIA,
						'dynamic'     => [ 'active' => true ],
						'description' => __('Use same size ratio image', 'avator-widget-pack'),
					],
					[
						'name'       => 'tab_content',
						'label'      => esc_html__( 'Content', 'avator-widget-pack' ),
						'type'       => Controls_Manager::WYSIWYG,
						'dynamic'     => [ 'active' => true ],
						'default'    => esc_html__( 'Slide Content', 'avator-widget-pack' ),
						'show_label' => false,
					],
					[
						'name'        => 'tab_link',
						'label'       => esc_html__( 'Link', 'avator-widget-pack' ),
						'type'        => Controls_Manager::URL,
						'dynamic'     => [ 'active' => true ],
						'placeholder' => 'http://your-link.com',
						'default'     => [
							'url' => '#',
						],
					],
				],
				'title_field' => '{{{ tab_title }}}',
			]
		);
		
		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'thumbnail_size',
				'label'     => esc_html__( 'Image Size', 'avator-widget-pack' ),
				'exclude'   => [ 'custom' ],
				'default'   => 'full',
				'separator' => 'before'
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_button',
			[
				'label'     => esc_html__( 'Button', 'avator-widget-pack' ),
				'condition' => [
					'button' => 'yes',
				],
			]
		);

		$this->add_control(
			'button_text',
			[
				'label'       => esc_html__( 'Text', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Read More', 'avator-widget-pack' ),
				'placeholder' => esc_html__( 'Read More', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'panel_slider_icon',
			[
				'label'       => esc_html__( 'Icon', 'avator-widget-pack' ),
				'type'             => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
			]
		);

		$this->add_control(
			'icon_align',
			[
				'label'   => esc_html__( 'Icon Position', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'right',
				'options' => [
					'left' => esc_html__( 'Before', 'avator-widget-pack' ),
					'right' => esc_html__( 'After', 'avator-widget-pack' ),
				],
				'condition' => [
					'panel_slider_icon[value]!' => '',
				],
			]
		);

		$this->add_control(
			'icon_indent',
			[
				'label'   => esc_html__( 'Icon Spacing', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 8,
				],
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'condition' => [
					'panel_slider_icon[value]!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-panel-slider .avt-button-icon-align-right' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .avt-panel-slider .avt-button-icon-align-left' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_slider_settings',
			[
				'label' => esc_html__( 'Slider Settings', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label'   => esc_html__( 'Autoplay', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
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
			'loop',
			[
				'label'   => esc_html__( 'Loop', 'avator-widget-pack' ),
				'default' => 'yes',
				'type'    => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'pauseonhover',
			[
				'label' => esc_html__( 'Pause on Hover', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'infinite',
			[
				'label'   => esc_html__( 'Infinite Loop', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'speed',
			[
				'label'   => esc_html__( 'Animation Speed', 'avator-widget-pack' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 500,
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
			'centered_slide',
			[
				'label'       => esc_html__( 'Centered Slide', 'avator-widget-pack' ),
				'type'        => Controls_Manager::SWITCHER,
				'description' => esc_html__( 'If you turn on this option so set column even number for good looking', 'avator-widget-pack' ),
				'condition'   => [
					'_skin' => ''
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_slider',
			[
				'label' => esc_html__( 'Slider', 'avator-widget-pack' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'slider_background_color',
			[
				'label'     => esc_html__( 'Overlay Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-panel-slide-item .avt-overlay-gradient' => 'background: linear-gradient(to bottom, rgba(255, 255, 255, 0) 40%, {{VALUE}} 100%);',
				],
			]
		);

		$this->add_control(
			'slider_opacity',
			[
				'label'   => esc_html__( 'Opacity', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0.4,
				],
				'range' => [
					'px' => [
						'min'  => 0,
						'max'  => 1,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-panel-slider .avt-panel-slide-item .avt-panel-slide-thumb img' => 'opacity: {{SIZE}};',
					'{{WRAPPER}} .avt-panel-slider.avt-skin-middle .swiper-slide:not(.swiper-slide-active):hover .avt-panel-slide-thumb img' => 'opacity: {{SIZE}} !important;',

				],
			]
		);

		$this->add_responsive_control(
			'desc_padding',
			[
				'label'     => esc_html__( 'Description Padding', 'avator-widget-pack' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .avt-panel-slider .avt-panel-slide-desc' => 'padding: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
				],
			]
		);

		$this->add_control(
			'shadow_mode',
			[
				'label'        => esc_html__( 'Shadow Mode', 'avator-widget-pack' ),
				'type'         => Controls_Manager::SWITCHER,
				'prefix_class' => 'avt-wipa-shadow-mode-',
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
			'section_style_button',
			[
				'label'      => esc_html__( 'Button', 'avator-widget-pack' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'conditions' => [
					'terms' => [
						[
							'name'  => 'button',
							'value' => 'yes'
						],
						[
							'name'  => '_skin',
							'value' => ''
						],
						[
							'name'     => 'global_link',
							'operator' => '!=',
							'value'    => 'yes'
						],
					]
				]
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
				'label'     => esc_html__( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-panel-slide-item .avt-panel-slide-link' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-panel-slide-item .avt-panel-slide-link svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'background_color',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-panel-slide-item .avt-panel-slide-link' => 'background-color: {{VALUE}};',
				],
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
				'label'     => esc_html__( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-panel-slide-item .avt-panel-slide-link:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-panel-slide-item .avt-panel-slide-link:hover svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_hover_color',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-panel-slide-item .avt-panel-slide-link:hover' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .avt-panel-slide-item .avt-panel-slide-link:hover' => 'border-color: {{VALUE}};',
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

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'border',
				'label'       => esc_html__( 'Border', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-panel-slide-item .avt-panel-slide-link',
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-panel-slide-item .avt-panel-slide-link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_box_shadow',
				'selector' => '{{WRAPPER}} .avt-panel-slide-item .avt-panel-slide-link',
			]
		);

		$this->add_control(
			'button_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-panel-slide-item .avt-panel-slide-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'typography',
				'label'    => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .avt-panel-slide-item .avt-panel-slide-link',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_title',
			[
				'label'     => esc_html__( 'Title', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_title' =>'yes',
				],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-panel-slide-item .avt-panel-slide-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'label'    => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .avt-panel-slide-item .avt-panel-slide-title',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_text',
			[
				'label' => esc_html__( 'Text', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'text_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-panel-slide-item .avt-panel-slide-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'text_typography',
				'label'    => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .avt-panel-slide-item .avt-panel-slide-text',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_navigation',
			[
				'label'     => esc_html__( 'Navigation', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'navigation' => [ 'arrows', 'dots', 'both' ],
				],
			]
		);

		$this->add_control(
			'heading_style_arrows',
			[
				'label'     => esc_html__( 'Arrows', 'avator-widget-pack' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
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
					'navigation' => [ 'arrows', 'both' ],
				],				
			]
		);

		$this->add_control(
			'arrows_position',
			[
				'label' => esc_html__( 'Arrows Position', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => -100,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-panel-slider .avt-navigation-next' => 'right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .avt-panel-slider .avt-navigation-prev' => 'left: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'arrows_size',
			[
				'label' => esc_html__( 'Arrows Size', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 25,
						'max' => 80,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-navigation-prev svg, {{WRAPPER}} .avt-navigation-next svg' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}',
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
					'{{WRAPPER}} .avt-navigation-prev, {{WRAPPER}} .avt-navigation-next' => 'background-color: {{VALUE}}',
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
					'{{WRAPPER}} .avt-navigation-prev:hover, {{WRAPPER}} .avt-navigation-next:hover' => 'background-color: {{VALUE}}',
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
					'{{WRAPPER}} .avt-navigation-prev svg, {{WRAPPER}} .avt-navigation-next svg' => 'color: {{VALUE}}',
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
					'{{WRAPPER}} .avt-navigation-prev:hover svg, {{WRAPPER}} .avt-navigation-next:hover svg' => 'color: {{VALUE}}',
				],
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
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
					'{{WRAPPER}} .avt-navigation-prev, {{WRAPPER}} .avt-navigation-next' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'arrows_border_radius',
			[
				'label'      => __( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'separator'  => 'after',
				'selectors'  => [
					'{{WRAPPER}} .avt-navigation-prev, {{WRAPPER}} .avt-navigation-next' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'heading_style_dots',
			[
				'label'     => esc_html__( 'Dots', 'avator-widget-pack' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => [
					'navigation' => [ 'dots', 'both' ],
				],
			]
		);

		$this->add_control(
			'dots_position',
			[
				'label' => esc_html__( 'Dots Position', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => -80,
						'max' => 80,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-panel-slider .swiper-pagination-bullets' => 'bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'navigation' => [ 'dots', 'both' ],
				],
			]
		);

		$this->add_control(
			'dots_size',
			[
				'label' => esc_html__( 'Dots Size', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 5,
						'max' => 10,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-panel-slider .swiper-pagination-bullet' => 'height: {{SIZE}}{{UNIT}};width: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .swiper-pagination-bullet' => 'background-color: {{VALUE}}; opacity: 1;',
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
				'selectors' => [
					'{{WRAPPER}} .swiper-pagination-bullet-active' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'navigation' => [ 'dots', 'both' ],
				],
			]
		);

		$this->end_controls_section();

	}
	
	protected function render_header() {
		$id              = 'avt-panel-slider-' . $this->get_id();
		$settings        = $this->get_settings_for_display();
		$skin_class      = '';
		
		$elementor_vp_lg = get_option( 'elementor_viewport_lg' );
		$elementor_vp_md = get_option( 'elementor_viewport_md' );
		$viewport_lg     = ! empty($elementor_vp_lg) ? $elementor_vp_lg : 1025;
		$viewport_md     = ! empty($elementor_vp_md) ? $elementor_vp_md : 768;
		
		$columns         = $settings['_skin'] ? $settings['skin_columns'] : $settings['columns'];
		$columns_tablet  = $settings['_skin'] ? $settings['skin_columns_tablet'] : $settings['columns_tablet'];
		$columns_mobile  = $settings['_skin'] ? $settings['skin_columns_mobile'] : $settings['columns_mobile'];

		if ($settings['_skin']) {
			$skin_class = 'avt-skin-middle';
		} else {
			$skin_class = 'avt-skin-default';
		}

		$this->add_render_attribute(
			[
				'panel-slider' => [
					'data-settings' => [
						wp_json_encode(array_filter([
							"autoplay"       => $settings["autoplay"] ? [ "delay" => $settings["autoplay_speed"] ] : false,
							"loop"           => $settings["loop"] ? true : false,
							"speed"          => $settings["speed"]["size"],
							"pauseOnHover"   => $settings["pauseonhover"] ? true : false,
							"slidesPerView"  => (int) $columns,
							"observer"       => $settings["observer"] ? true : false,
							"observeParents" => $settings["observer"] ? true : false,
							"spaceBetween"   => $settings['column_space']['size'] ? : 0,
							"centeredSlides" => ( $settings["centered_slide"] or "avt-middle" == $settings["_skin"] ) ? true : false,
							"breakpoints"    => [
								(int) $viewport_lg => [
									"slidesPerView" => (int) $columns_tablet,
								],
								(int) $viewport_md => [
									"slidesPerView" => (int) $columns_mobile,
								]
					      	],
			      	        "navigation" => [
			      				"nextEl" => "#" . $id . " .avt-navigation-next",
			      				"prevEl" => "#" . $id . " .avt-navigation-prev",
			      			],
			      			"pagination" => [
			      			  "el"         => "#" . $id . " .swiper-pagination",
			      			  "type"       => "bullets",
			      			  "clickable"  => true,
			      			],
				        ]))
					],
					'class' => [
						'avt-panel-slider',
						$skin_class,
					],
					'id' => $id
				]
			]
		);

		?>
		<div <?php echo $this->get_render_attribute_string( 'panel-slider' ); ?>>
			<div class="swiper-container">
		<?php
	}

	protected function render_footer($settings) {

		$hide_on_mobile = $settings['hide_arrow_on_mobile'] ? ' avt-visible@m' : '';

			?>
			</div>
			<?php if ( 'none' !== $settings['navigation'] ) : ?>
				<?php if ( 'arrows' !== $settings['navigation'] ) : ?>
					<div class="swiper-pagination"></div>
				<?php endif; ?>

				<?php if ( 'dots' !== $settings['navigation'] ) : ?>

					<a class="avt-navigation-next avt-icon avt-position-z-index avt-position-center-right<?php echo esc_attr( $hide_on_mobile ); ?>" avt-icon="icon: chevron-right; ratio: 1.9"></a>	

					<a class="avt-navigation-prev avt-icon avt-position-z-index avt-position-center-left<?php echo esc_attr( $hide_on_mobile ); ?>" avt-icon="icon: chevron-left; ratio: 1.9"></a>	

				<?php endif; ?>
			<?php endif; ?>
		</div>
		<?php
	}

	public function render() {
		$settings = $this->get_settings_for_display();
		$this->render_header();
		$counter   = 1;

		?>
		<div class="swiper-wrapper">
			<?php 
			foreach ( $settings['tabs'] as $item ) :

				$image_src = Group_Control_Image_Size::get_attachment_image_src( $item['tab_image']['id'], 'thumbnail_size', $settings );
				$image_url =  $image_src ? : AWP_ASSETS_URL. '/images/panel-slider.svg';

				$this->add_render_attribute(
					[
						'button-attr' => [
							'class' => [
								'avt-panel-slide-link',
								'avt-transition-slide-top',
								$settings['button_hover_animation'] ? 'elementor-animation-' . $settings['button_hover_animation'] : ''
							],
							'href'   => $item['tab_link']['url'] ? esc_url($item['tab_link']['url']) : '',
							'target' => $item['tab_link']['is_external'] ? '_blank' : '_self',
						]
					], '', '', true
				);
				
				$this->add_render_attribute( 'panel-slide-item', 'class', ['avt-panel-slide-item', 'swiper-slide', 'avt-transition-toggle'], true );

				if ('yes' == $settings['global_link'] and $item['tab_link']['url']) {

					$target = $item['tab_link']['is_external'] ? '_blank' : '_self';

					$this->add_render_attribute( 'panel-slide-item', 'onclick', "window.open('" . $item['tab_link']['url'] . "', '$target')", true );
				}

				if ( ! isset( $settings['icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
					// add old default
					$settings['icon'] = 'fas fa-arrow-right';
				}

				$migrated  = isset( $settings['__fa4_migrated']['panel_slider_icon'] );
				$is_new    = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();

				?>
				<div <?php echo $this->get_render_attribute_string( 'panel-slide-item' ); ?>>
		        	<div class="avt-panel-slide-thumb avt-background-cover" style="background-image: url(<?php echo esc_url($image_url); ?>);"></div>
		        	<div class="avt-panel-slide-desc avt-position-bottom-left avt-position-z-index">
			        	<?php if (!empty( $item['tab_link']['url']))  : ?>
				        	<?php if ($settings['button'] and '' == $settings['_skin'])  : ?>
								<a <?php echo $this->get_render_attribute_string( 'button-attr' ); ?>>
									<span>
										<?php echo esc_html($settings['button_text']); ?>
									</span>
									<?php if ($settings['panel_slider_icon']['value']) : ?>
										<span class="avt-button-icon-align-<?php echo esc_attr($settings['icon_align']); ?>">

											<?php if ( $is_new || $migrated ) :
												Icons_Manager::render_icon( $settings['panel_slider_icon'], [ 'aria-hidden' => 'true', 'class' => 'fa-fw' ] );
											else : ?>
												<i class="<?php echo esc_attr( $settings['icon'] ); ?>" aria-hidden="true"></i>
											<?php endif; ?>

										</span>
									<?php endif; ?>
								</a>
							<?php endif; ?>

						<?php endif; ?>

						<?php if ( 'yes' == $settings['show_title'] ) : ?>
							<h3 class="avt-panel-slide-title avt-transition-slide-bottom"><?php echo esc_html($item['tab_title']); ?></h3>
						<?php endif; ?>

						<?php if ( '' !== $item['tab_content'] ) : ?>
							<div class="avt-panel-slide-text avt-transition-slide-bottom"><?php echo $this->parse_text_editor( $item['tab_content'] ); ?></div>
						<?php endif; ?>
			  		</div>

			  		<?php if ( '' !== $item['tab_content'] or 'yes' == $settings['show_title'] ) : ?>
					<div class="avt-transition-fade avt-position-cover avt-overlay avt-overlay-gradient"></div>
					<?php endif; ?>
				</div>
			<?php
				$counter++;
			endforeach; ?>
		</div>
		
		<?php $this->render_footer($settings);
	}
}
