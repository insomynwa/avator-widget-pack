<?php
namespace WidgetPack\Modules\Iconnav\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Icons_Manager;
use Elementor\Core\Files\Assets\Svg\Svg_Handler;
use WidgetPack\Modules\Iconnav\ep_offcanvas_walker;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Iconnav extends Widget_Base {
	public function get_name() {
		return 'avt-iconnav';
	}

	public function get_title() {
		return AWP . esc_html__( 'Icon Nav', 'avator-widget-pack' );
	}

	public function get_icon() {
		return 'avt-wi-icon-nav';
	}

	public function get_categories() {
		return [ 'widget-pack' ];
	}

	public function get_keywords() {
		return [ 'iconnav', 'navigation', 'menu' ];
	}

	public function get_style_depends() {
		return [ 'widget-pack-font' ];
	}

	public function get_script_depends() {
		return [ 'popper', 'tippyjs' ];
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'section_content_iconnav',
			[
				'label' => esc_html__( 'Iconnav', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'iconnavs',
			[
				'label'   => esc_html__( 'Iconnav Items', 'avator-widget-pack' ),
				'type'    => Controls_Manager::REPEATER,
				'default' => [
					[
						'iconnav_title' => esc_html__( 'Homepage', 'avator-widget-pack' ),
						'iconnav_icon'  => ['value' => 'fas fa-home', 'library' => 'fa-solid'],
						'iconnav_link'  => [
							'url' => esc_html__( '#', 'avator-widget-pack' ),
						] 
					],
					[
						'iconnav_title' => esc_html__( 'Product', 'avator-widget-pack' ),
						'iconnav_icon'  => ['value' => 'fas fa-shopping-bag', 'library' => 'fa-solid'],
						'iconnav_link'  => [
							'url' => esc_html__( '#', 'avator-widget-pack' ),
						]
					],
					[
						'iconnav_title' => esc_html__( 'Support', 'avator-widget-pack' ),
						'iconnav_icon'  => ['value' => 'fas fa-wrench', 'library' => 'fa-solid'],
						'iconnav_link'  => [
							'url' => esc_html__( '#', 'avator-widget-pack' ),
						]
					],
					[
						'iconnav_title' => esc_html__( 'Blog', 'avator-widget-pack' ),
						'iconnav_icon'  => ['value' => 'fas fa-book', 'library' => 'fa-solid'],
						'iconnav_link'  => [
							'url' => esc_html__( '#', 'avator-widget-pack' ),
						]
					],
					[
						'iconnav_title' => esc_html__( 'About Us', 'avator-widget-pack' ),
						'iconnav_icon'  => ['value' => 'fas fa-envelope', 'library' => 'fa-solid'],
						'iconnav_link'  => [
							'url' => esc_html__( '#', 'avator-widget-pack' ),
						]
					],
				],
				'fields' => [
					[
						'name'    => 'iconnav_icon',
						'label'   => esc_html__( 'Icon', 'avator-widget-pack' ),
						'type'        => Controls_Manager::ICONS,
						'fa4compatibility' => 'icon',
						'default' => [
							'value' => 'fas fa-home',
							'library' => 'fa-solid',
						],
					],
					[
						'name'    => 'iconnav_title',
						'label'   => esc_html__( 'Iconnav Title', 'avator-widget-pack' ),
						'type'    => Controls_Manager::TEXT,
						'default' => esc_html__( 'Iconnav Title' , 'avator-widget-pack' ),
						'dynamic'     => [ 'active' => true ],
					],
					[
						'name'        => 'iconnav_link',
						'label'       => esc_html__( 'Link', 'avator-widget-pack' ),
						'type'        => Controls_Manager::URL,
						'default'     => [ 'url' => '#' ],
						'description' => 'Add your section id WITH the # key. e.g: #my-id also you can add internal/external URL',
						'dynamic'     => [ 'active' => true ],
					],
				],
				'title_field' => '{{{ iconnav_title }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_offcanvas_layout',
			[
				'label' => esc_html__( 'Offcanvas Menu', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'navbar',
			[
				'label'       => esc_html__( 'Select Menu', 'avator-widget-pack' ),
				'description' => esc_html__( 'Child menu not visible in off-canvas for some design issue.', 'avator-widget-pack' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '0',
				'options'     => widget_pack_get_menu(),
			]
		);

		$this->add_control(
			'navbar_level',
			[
				'label'       => esc_html__( 'Max Menu Level', 'avator-widget-pack' ),
				'description' => esc_html__( 'You can set max 3 level menu because of design issue.', 'avator-widget-pack' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 1,
				'options'     => [
					1  => esc_html__( 'Level 1', 'avator-widget-pack' ),
					2  => esc_html__( 'Level 2', 'avator-widget-pack' ),
					3  => esc_html__( 'Level 3', 'avator-widget-pack' ),
				],
			]
		);

		$this->add_control(
			'offcanvas_overlay',
			[
				'label'        => esc_html__( 'Overlay', 'avator-widget-pack' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'condition'    => [
					'navbar!' => '0',
				],
			]
		);

		$this->add_control(
			'offcanvas_animations',
			[
				'label'     => esc_html__( 'Animations', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'slide',
				'options'   => [
					'slide'  => esc_html__( 'Slide', 'avator-widget-pack' ),
					'push'   => esc_html__( 'Push', 'avator-widget-pack' ),
					'reveal' => esc_html__( 'Reveal', 'avator-widget-pack' ),
					'none'   => esc_html__( 'None', 'avator-widget-pack' ),
				],
				'condition' => [
					'navbar!' => '0',
				],
			]
		);

		$this->add_control(
			'offcanvas_flip',
			[
				'label'        => esc_html__( 'Flip', 'avator-widget-pack' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'true',
				'condition'    => [
					'navbar!' => '0',
				],
			]
		);

		$this->add_control(
			'offcanvas_close_button',
			[
				'label'     => esc_html__( 'Close Button', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'condition' => [
					'navbar!' => '0',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_branding',
			[
				'label' => esc_html__( 'Branding', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'show_branding',
			[
				'label'   => __( 'Show Branding', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'branding_image',
			[
				'label'     => __( 'Choose Branding Image', 'avator-widget-pack' ),
				'type'      => Controls_Manager::MEDIA,
				'condition' => [
					'show_branding' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'brading_space',
			[
				'label'   => __( 'Space', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 30,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-icon-nav .avt-icon-nav-branding'     => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_additional_settings',
			[
				'label' => esc_html__( 'Additional Settings', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'menu_text',
			[
				'label'   => esc_html__('Menu Text', 'avator-widget-pack'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'show_as_tooltip',
				'options' => [
					'show_as_tooltip' => esc_html__('Show as Tooltip', 'avator-widget-pack'),
					'show_under_icon' => esc_html__('Show Under Icon', 'avator-widget-pack'),
				]
			]
		);

		$this->add_responsive_control(
			'iconnav_width',
			[
				'label' => esc_html__( 'Iconnav Width', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min'  => 48,
						'max'  => 120,
						'step' => 2,
					],
				],
				'default' => [
					'size' => 48,
				],
				'selectors' => [
					'{{WRAPPER}} .avt-icon-nav .avt-icon-nav-container'     => 'width: {{SIZE}}{{UNIT}};',
					'body:not(.avt-offcanvas-flip) #avt-offcanvas{{ID}}.avt-offcanvas.avt-icon-nav-left' => 'left: {{SIZE}}{{UNIT}};',
					'body.avt-offcanvas-flip #avt-offcanvas{{ID}}.avt-offcanvas.avt-icon-nav-right' => 'right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'iconnav_position',
			[
				'label'   => esc_html__( 'Iconnav Position', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'left',
				'options' => [
					'left'  => esc_html__( 'Left', 'avator-widget-pack' ),
					'right' => esc_html__( 'Right', 'avator-widget-pack' ),
				],
			]
		);

		$this->add_responsive_control(
			'iconnav_top_offset',
			[
				'label'   => __( 'Top Offset', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 80,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-icon-nav .avt-icon-nav-container'     => 'padding-top: {{SIZE}}{{UNIT}};',
					'#avt-offcanvas{{ID}}.avt-offcanvas .avt-offcanvas-bar' => 'padding-top: calc({{SIZE}}{{UNIT}} + {{brading_space.SIZE}}px + 50px);',
				],
			]
		);

		$this->add_responsive_control(
			'iconnav_gap',
			[
				'label' => __( 'Icon Gap', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-icon-nav-container ul.avt-icon-nav.avt-icon-nav-vertical li + li'     => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'iconnav_tooltip_spacing',
			[
				'label'   => __( 'Tooltip Spacing', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 5,
				],
				'separator' => 'before',
				'condition' => [
					'menu_text' => 'show_as_tooltip',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_iconnav',
			[
				'label' => esc_html__( 'Iconnav', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'iconnav_background',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-icon-nav .avt-icon-nav-container' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'iconnav_border',
				'label'       => esc_html__( 'Border', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-icon-nav .avt-icon-nav-container',
			]
		);

		$this->add_responsive_control(
			'iconnav_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-icon-nav .avt-icon-nav-container' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'iconnav_shadow',
				'selector' => '{{WRAPPER}} .avt-icon-nav .avt-icon-nav-container',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_iconnav_icon',
			[
				'label' => esc_html__( 'Icon', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
	
		$this->start_controls_tabs( 'tabs_iconnav_icon_style' );

		$this->start_controls_tab(
			'tab_iconnav_icon_normal',
			[
				'label' => esc_html__( 'Normal', 'avator-widget-pack' ),
			]
		);

		$this->add_responsive_control(
			'iconnav_icon_size',
			[
				'label' => esc_html__( 'Size', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min'  => 10,
						'max'  => 48,
					],
				],
				'default' => [
					'size' => 16,
				],
				'selectors' => [
					'{{WRAPPER}} .avt-icon-nav .avt-icon-nav-icon-wrapper .avt-icon-nav-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'iconnav_icon_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-icon-nav .avt-icon-nav-icon-wrapper .avt-icon-nav-icon i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-icon-nav .avt-icon-nav-icon-wrapper .avt-icon-nav-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'iconnav_icon_background',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-icon-nav .avt-icon-nav-icon-wrapper' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'iconnav_icon_border',
				'label'       => esc_html__( 'Border', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-icon-nav .avt-icon-nav-icon-wrapper',
			]
		);

		$this->add_responsive_control(
			'iconnav_icon_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-icon-nav .avt-icon-nav-icon-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'iconnav_icon_shadow',
				'selector' => '{{WRAPPER}} .avt-icon-nav .avt-icon-nav-icon-wrapper',
			]
		);

		$this->add_responsive_control(
			'iconnav_icon_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-icon-nav .avt-icon-nav-icon-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'iconnav_icon_margin',
			[
				'label'      => esc_html__( 'Margin', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-icon-nav .avt-icon-nav-icon-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'iconnav_icon_hover',
			[
				'label' => esc_html__( 'Hover', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'iconnav_icon_hover_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-icon-nav .avt-icon-nav-icon-wrapper:hover .avt-icon-nav-icon > i' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'iconnav_icon_hover_background',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-icon-nav .avt-icon-nav-icon-wrapper:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'iconnav_icon_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'iconnav_icon_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-icon-nav .avt-icon-nav-icon-wrapper:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'iconnav_icon_active',
			[
				'label' => esc_html__( 'Active', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'iconnav_icon_active_background',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-icon-nav .avt-icon-nav-icon-wrapper' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'iconnav_icon_active_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'iconnav_icon_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-icon-nav .avt-icon-nav-icon-wrapper' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_tooltip',
			[
				'label'     => esc_html__( 'Tooltip', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'menu_text' => 'show_as_tooltip',
				],
			]
		);

		$this->add_control(
			'tooltip_background',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-icon-nav .tippy-backdrop' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'tooltip_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-icon-nav .tippy-backdrop' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'tooltip_border',
				'label'       => esc_html__( 'Border', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-icon-nav .tippy-tooltip',
			]
		);

		$this->add_responsive_control(
			'tooltip_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-icon-nav .tippy-tooltip' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'tooltip_shadow',
				'selector' => '{{WRAPPER}} .avt-icon-nav .tippy-tooltip',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'tooltip_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .avt-icon-nav .tippy-backdrop',
			]
		);
		
		$this->add_control(
			'tooltip_animation',
			[
				'label'   => esc_html__( 'Tooltip Animation', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					''             => esc_html__( 'Default', 'avator-widget-pack' ),
					'shift-toward' => esc_html__( 'Shift Toward', 'avator-widget-pack' ),
					'fade'         => esc_html__( 'Fade', 'avator-widget-pack' ),
					'scale'        => esc_html__( 'Scale', 'avator-widget-pack' ),
					'perspective'  => esc_html__( 'Perspective', 'avator-widget-pack' ),
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'tooltip_size',
			[
				'label'   => esc_html__( 'Tooltip Size', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					''      => esc_html__( 'Default', 'avator-widget-pack' ),
					'large' => esc_html__( 'Large', 'avator-widget-pack' ),
					'small' => esc_html__( 'small', 'avator-widget-pack' ),
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_menu_text',
			[
				'label'     => esc_html__( 'Menu Text', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'menu_text!' => 'show_as_tooltip',
				],
			]
		);

		$this->add_control(
			'menu_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-icon-nav .avt-menu-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'menu_text_spacing',
			[
				'label'     => esc_html__( 'Space', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .avt-icon-nav .avt-menu-text' => 'margin-top: {{SIZE}}px;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'menu_text_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .avt-icon-nav .avt-menu-text',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_offcanvas_content',
			[
				'label'     => esc_html__( 'Offcanvas', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'navbar!' => '0',
				],
			]
		);

		$this->add_control(
			'offcanvas_content_color',
			[
				'label'     => esc_html__( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'#avt-offcanvas{{ID}}.avt-offcanvas .avt-offcanvas-bar *' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'offcanvas_content_link_color',
			[
				'label'     => esc_html__( 'Link Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'#avt-offcanvas{{ID}}.avt-offcanvas .avt-offcanvas-bar ul > li a'   => 'color: {{VALUE}};',
					'#avt-offcanvas{{ID}}.avt-offcanvas .avt-offcanvas-bar a *' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'offcanvas_content_link_hover_color',
			[
				'label'     => esc_html__( 'Link Hover Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'#avt-offcanvas{{ID}}.avt-offcanvas .avt-offcanvas-bar ul > li a:hover' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'offcanvas_content_link_active_color',
			[
				'label'     => esc_html__( 'Link Active Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'#avt-offcanvas{{ID}}.avt-offcanvas .avt-offcanvas-bar ul > li.avt-active a:before' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'offcanvas_content_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'#avt-offcanvas{{ID}}.avt-offcanvas .avt-offcanvas-bar' => 'background-color: {{VALUE}} !important;',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'offcanvas_content_box_shadow',
				'selector'  => '#avt-offcanvas{{ID}}.avt-offcanvas .avt-offcanvas-bar',
			]
		);

		$this->add_responsive_control(
			'offcanvas_content_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'#avt-offcanvas{{ID}}.avt-offcanvas .avt-offcanvas-bar' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_branding',
			[
				'label'     => esc_html__( 'Branding', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_branding' => 'yes',
				],
			]
		);

		$this->add_control(
			'branding_background',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-icon-nav .avt-icon-nav-branding' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'branding_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-icon-nav .avt-icon-nav-branding' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'branding_border',
				'label'       => esc_html__( 'Border', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-icon-nav .avt-icon-nav-branding',
			]
		);

		$this->add_responsive_control(
			'branding_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-icon-nav .avt-icon-nav-branding' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'branding_shadow',
				'selector' => '{{WRAPPER}} .avt-icon-nav .avt-icon-nav-branding',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'branding_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .avt-icon-nav .avt-icon-nav-branding',
			]
		);

		$this->end_controls_section();

	}

	public function render_loop_iconnav_list($list) {
		$settings      = $this->get_settings();
		
		$scroll_active = (preg_match("/(#\s*([a-z]+)\s*)/", $list['iconnav_link']['url'])) ? 'avt-scroll' : '';

		$this->add_render_attribute( 'iconnav-item-link', 'class', 'avt-icon-nav-icon-wrapper avt-flex-middle avt-flex-center', true );
		$this->add_render_attribute( 'iconnav-item-link', 'href', $list['iconnav_link']['url'], true );
		
		if ( $list['iconnav_link']['is_external'] ) {
			$this->add_render_attribute( 'iconnav-item-link', 'target', '_blank', true );
		}

		if ( $list['iconnav_link']['nofollow'] ) {
			$this->add_render_attribute( 'iconnav-item-link', 'rel', 'nofollow', true );
		}

		$this->add_render_attribute( 'iconnav-item', 'class', 'avt-icon-nav-item' );

		// Tooltip settings
		if ( 'show_as_tooltip' == $settings['menu_text'] ) {
			$this->add_render_attribute( 'iconnav-item', 'class', 'avt-tippy-tooltip', true );
			$this->add_render_attribute( 'iconnav-item', 'data-tippy', '', true );
			$this->add_render_attribute( 'iconnav-item', 'data-tippy-content', $list["iconnav_title"], true );
			if ($settings['tooltip_animation']) {
				$this->add_render_attribute( 'iconnav-item', 'data-tippy-animation', $settings['tooltip_animation'], true );
			}
			if ($settings['tooltip_size']) {
				$this->add_render_attribute( 'iconnav-item', 'data-tippy-size', $settings['tooltip_size'], true );
			}
			if ($settings['iconnav_tooltip_spacing']['size']) {
				$this->add_render_attribute( 'iconnav-item', 'data-tippy-distance', $settings['iconnav_tooltip_spacing']['size'], true );
			}
			$this->add_render_attribute( 'iconnav-item', 'data-tippy-placement', 'left', true );
		} else {
			$this->add_render_attribute( 'iconnav-item-link', 'title', $list["iconnav_title"], true );
		}

		if ( ! isset( $settings['icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
			// add old default
			$settings['icon'] = 'fas fa-home';
		}		

		$migrated  = isset( $list['__fa4_migrated']['iconnav_icon'] );
		$is_new    = empty( $list['icon'] ) && Icons_Manager::is_migration_allowed();

		?>
	    <li <?php echo $this->get_render_attribute_string( 'iconnav-item' ); ?>>
			<a <?php echo $this->get_render_attribute_string( 'iconnav-item-link' ); ?> <?php echo esc_url($scroll_active); ?>>

				<?php if ($list['iconnav_icon']['value']) : ?>
					<span class="avt-icon-nav-icon">
						
						<?php if ( $is_new || $migrated ) :
							Icons_Manager::render_icon( $list['iconnav_icon'], [ 'aria-hidden' => 'true', 'class' => 'fa-fw' ] );
						else : ?>
							<i class="<?php echo esc_attr( $list['icon'] ); ?>" aria-hidden="true"></i>
						<?php endif; ?>

					</span>
				<?php endif; ?>
				
				<?php if ('show_under_icon' == $settings['menu_text']) : ?>
					<span class="avt-menu-text avt-display-block avt-text-small"><?php echo esc_attr($list["iconnav_title"]); ?></span>
				<?php endif; ?>
			</a>
		</li>
		<?php
	}

	protected function render() {
		$settings = $this->get_settings();
		$id       = $this->get_id();

		$this->add_render_attribute( 'icon-nav', 'class', 'avt-icon-nav' );
		$this->add_render_attribute( 'icon-nav', 'id', 'avt-icon-nav-' . $id );

		$this->add_render_attribute( 'nav-container', 'class', ['avt-icon-nav-container', 'avt-icon-nav-' . $settings['iconnav_position']] );
		
		?>
		<div <?php echo $this->get_render_attribute_string( 'icon-nav' ); ?>>
			<div <?php echo $this->get_render_attribute_string( 'nav-container' ); ?>>
				<div class="avt-icon-nav-branding">
					<?php if ( $settings['show_branding']) : ?>
						<?php if ( ! empty( $settings['branding_image']['url'] ) ) : ?>
							<div class="avt-logo-image"><img src="<?php echo esc_url( $settings['branding_image']['url'] ); ?>" alt="<?php echo get_bloginfo( 'name' ); ?>"></div>
						<?php else : ?>
							<?php
								$string          = get_bloginfo( 'name' );
								$words           = explode(" ", $string);
								$letters         = "";
								foreach ($words as $value) {
									$letters .= substr($value, 0, 1);
								}
							?>
							<div><div class="avt-logo-txt">
								<a href="<?php echo esc_url(home_url('/')); ?>" title="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"><?php echo esc_attr( $letters ); ?></a></div></div>
						<?php endif; ?>
					<?php endif; ?>

				</div>
				<ul class="avt-icon-nav avt-icon-nav-vertical">
					<?php if ( $settings['navbar'] ) : ?>
						<li>
							<a class="avt-icon-nav-icon-wrapper" href="#" avt-toggle="target: #avt-offcanvas<?php echo esc_attr($id); ?>">
								<span class="avt-icon-nav-icon">
									<i class="ep-menu"></i>
								</span>
							</a>
						</li>
					<?php endif; ?>

					<?php
					foreach ($settings['iconnavs'] as $key => $nav) : 
						$this->render_loop_iconnav_list($nav);
					endforeach;
					?>
				</ul>
			</div>
		</div>

	   <?php if ( $settings['navbar'] ) : ?>
		    <?php $this->offcanvas($settings); ?>
		<?php endif;
	}

	private function offcanvas($settings) {
		$id = $this->get_id();

		$this->add_render_attribute(
			[
				'offcanvas-settings' => [
					'id'            => 'avt-offcanvas' . $id,
					'class'         => [
						'avt-offcanvas',
						'avt-icon-nav-offcanvas',
						'avt-icon-nav-' . $settings['iconnav_position']
					],
				]
			]
		);

		$this->add_render_attribute( 'offcanvas-settings', 'avt-offcanvas', 'mode: ' . $settings['offcanvas_animations'] . ';' );

		if ($settings['offcanvas_overlay']) {
			$this->add_render_attribute( 'offcanvas-settings', 'avt-offcanvas', 'overlay: true;' );
		}

		if ($settings['offcanvas_flip']) {
			$this->add_render_attribute( 'offcanvas-settings', 'avt-offcanvas', 'flip: true;' );
		}

		$nav_menu    = ! empty( $settings['navbar'] ) ? wp_get_nav_menu_object( $settings['navbar'] ) : false;
		$navbar_attr = [];
	    if ( ! $nav_menu ) {
	    	return;
	    }

	    if (1 < $settings['navbar_level']) {
	    	$nav_class = 'avt-nav avt-nav-default avt-nav-parent-icon';
	    } else {
	    	$nav_class = 'avt-nav avt-nav-default';
	    }

	    $nav_menu_args = array(
	    	'fallback_cb'    => false,
	    	'container'      => false,
	    	'items_wrap'     => '<ul id="%1$s" class="%2$s" avt-nav>%3$s</ul>',
	    	'menu_id'        => 'avt-navmenu',
	    	'menu_class'     => $nav_class,
	    	'theme_location' => 'default_navmenu', // creating a fake location for better functional control
	    	'menu'           => $nav_menu,
	    	'echo'           => true,
	    	'depth'          => $settings['navbar_level'],
	    	'walker'         => new ep_offcanvas_walker
	    );

		?>		
	    <div <?php echo $this->get_render_attribute_string( 'offcanvas-settings' ); ?>>
	        <div class="avt-offcanvas-bar">
				
				<?php if ($settings['offcanvas_close_button']) : ?>
	        		<button class="avt-offcanvas-close" type="button" avt-close></button>
	        	<?php endif; ?>
				
				<div id="avt-navbar-<?php echo esc_attr($id); ?>" class="avt-navbar-wrapper">
					<?php wp_nav_menu( apply_filters( 'widget_nav_menu_args', $nav_menu_args, $nav_menu, $settings ) ); ?>
				</div>
	        </div>
	    </div>
		<?php
	}

	protected function _content_template() {
		$id = $this->get_id();
		?>

		<#
		view.addRenderAttribute( 'icon-nav', 'class', 'avt-icon-nav' );
		view.addRenderAttribute( 'nav-container', 'class', ['avt-icon-nav-container', 'avt-icon-nav-' + settings.iconnav_position] );

		var iconHTML = {},
			migrated = {};
		
		#>
		<div <# print(view.getRenderAttributeString( 'icon-nav')); #>>
			<div <# print(view.getRenderAttributeString( 'nav-container')); #>>
				<div class="avt-icon-nav-branding">
					<# if ( settings.show_branding) { #>
						<# if ( settings.branding_image.url ) { #>
							<div class="avt-logo-image"><img src="{{{settings.branding_image.url}}}"></div>
						<# } else { #>
							<#
								var letters = 'WP';
							#>
							<div><div class="avt-logo-txt">
								<a href="<?php echo esc_url(home_url('/')); ?>" title="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">{{{letters}}}</a></div></div>
						<# } #>
					<# } #>

				</div>
				<ul class="avt-icon-nav avt-icon-nav-vertical">
					<# if ( settings.navbar ) { #>
						<li>
							<a class="avt-icon-nav-icon-wrapper" href="#" avt-toggle="target: #avt-offcanvas<?php echo esc_attr($id); ?>">
								<span class="avt-icon-nav-icon">
									<i class="ep-menu"></i>
								</span>
							</a>
						</li>
					<# } #>

					<# _.each( settings.iconnavs, function( item, index ) { 

					view.addRenderAttribute( 'iconnav-item-link', 'class', 'avt-icon-nav-icon-wrapper avt-flex-middle avt-flex-center', true );
					view.addRenderAttribute( 'iconnav-item-link', 'href', item.iconnav_link.url, true );
					
					if ( item.iconnav_link.is_external ) {
						view.addRenderAttribute( 'iconnav-item-link', 'target', '_blank', true );
					}

					if ( item.iconnav_link.nofollow ) {
						view.addRenderAttribute( 'iconnav-item-link', 'rel', 'nofollow', true );
					}

					view.addRenderAttribute( 'iconnav-item', 'class', 'avt-icon-nav-item' );

					if ( 'show_as_tooltip' == settings.menu_text ) {
						view.addRenderAttribute( 'iconnav-item', 'class', 'avt-tippy-tooltip', true );
						view.addRenderAttribute( 'iconnav-item', 'data-tippy', '', true );
						view.addRenderAttribute( 'iconnav-item', 'title', item.iconnav_title, true );

						if (settings.tooltip_animation) {
							view.addRenderAttribute( 'iconnav-item', 'data-tippy-animation', settings.tooltip_animation, true );
						}
						if (settings.tooltip_size) {
							view.addRenderAttribute( 'iconnav-item', 'data-tippy-size', settings.tooltip_size, true );
						}
						if (settings.iconnav_tooltip_spacing.size) {
							view.addRenderAttribute( 'iconnav-item', 'data-tippy-distance', settings.iconnav_tooltip_spacing.size, true );
						}
						view.addRenderAttribute( 'iconnav-item', 'data-tippy-placement', 'left', true );
					} else {
						view.addRenderAttribute( 'iconnav-item-link', 'title', item.iconnav_title, true );
					}		

					iconHTML[ index ] = elementor.helpers.renderIcon( view, item.iconnav_icon, { 'aria-hidden': true }, 'i' , 'object' );

					migrated[ index ] = elementor.helpers.isIconMigrated( item, 'iconnav_icon' );

					#>
				    <li <# print(view.getRenderAttributeString( 'iconnav-item' )); #>>
						<a <# print(view.getRenderAttributeString( 'iconnav-item-link' )); #>>
							<# if (item.iconnav_icon.value) { #>
								<span class="avt-icon-nav-icon">
									
									<# if ( iconHTML[ index ] && iconHTML[ index ].rendered && ( ! item.icon || migrated[ index ] ) ) { #>
										{{{ iconHTML[ index ].value }}}
									<# } else { #>
										<i class="{{ item.icon }}" aria-hidden="true"></i>
									<# } #>

								</span>
							<# } #>
							
							<# if ('show_under_icon' == settings.menu_text) { #>
								<span class="avt-menu-text avt-display-block avt-text-small">{{{item.iconnav_title}}}</span>
							<# } #>
						</a>
					</li>
				<# }); #>

				</ul>
			</div>
		</div>

	   <# if ( settings.navbar ) { #>
		   
		    
		<# } #>

		<?php
	}
}
