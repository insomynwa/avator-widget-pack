<?php
namespace WidgetPack\Modules\Scrollnav\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Icons_Manager;
use Elementor\Core\Files\Assets\Svg\Svg_Handler;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Scrollnav extends Widget_Base {
	public function get_name() {
		return 'avt-scrollnav';
	}

	public function get_title() {
		return AWP . __( 'Scroll Navigation', 'avator-widget-pack' );
	}

	public function get_icon() {
		return 'avt-wi-scroll-navigation';
	}

	public function get_categories() {
		return [ 'widget-pack' ];
	}

	public function get_keywords() {
		return [ 'scrollnav', 'menu' ];
	}

	public function get_script_depends() {
		return [ 'popper', 'tippyjs' ];
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'section_content_scrollnav',
			[
				'label' => __( 'Scrollnav', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'navs',
			[
				'label' => __( 'Nav Items', 'avator-widget-pack' ),
				'type' => Controls_Manager::REPEATER,
				'default' => [
					[
						'nav_title' => __( 'Nav #1', 'avator-widget-pack' ),
						'nav_link'  => [
							'url' => '#section-1',
						] 
					],
					[
						'nav_title'   => __( 'Nav #2', 'avator-widget-pack' ),
						'nav_link'  => [
							'url' => '#section-2',
						]
					],
					[
						'nav_title'   => __( 'Nav #3', 'avator-widget-pack' ),
						'nav_link'  => [
							'url' => '#section-3',
						]
					],
					[
						'nav_title'   => __( 'Nav #4', 'avator-widget-pack' ),
						'nav_link'  => [
							'url' => '#section-4',
						]
					],
					[
						'nav_title'   => __( 'Nav #5', 'avator-widget-pack' ),
						'nav_link'  => [
							'url' => '#section-5',
						]
					],
				],
				'fields' => [
					[
						'name'    => 'nav_title',
						'label'   => __( 'Nav Title', 'avator-widget-pack' ),
						'type'    => Controls_Manager::TEXT,
						'dynamic' => [ 'active' => true ],
						'default' => __( 'Nav Title' , 'avator-widget-pack' ),
					],
					[
						'name'        => 'nav_link',
						'label'       => __( 'Link', 'avator-widget-pack' ),
						'type'        => Controls_Manager::URL,
						'dynamic'     => [ 'active' => true ],
						'default'     => [ 'url' => '#' ],
						'description' => 'Add your section id WITH the # key. e.g: #my-id also you can add internal/external URL',
					],
					[
						'name'  => 'scroll_nav_icon',
						'label' => __( 'Icon', 'avator-widget-pack' ),
						'type'        => Controls_Manager::ICONS,
						'fa4compatibility' => 'nav_icon',
					],		
				],
				'title_field' => '{{{ nav_title }}}',
			]
		);

		$this->add_control(
			'nav_style',
			[
				'label'     => __( 'Nav View', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SELECT,
				'separator' => 'before',
				'default'   => 'default',
				'options'   => [
					'default' => __( 'Text', 'avator-widget-pack' ),
					'dot'     => __( 'Dots', 'avator-widget-pack' ),
				]
			]
		);

		$this->add_control(
			'vertical_nav',
			[
				'label' => __( 'Vertical Nav', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'fixed_nav',
			[
				'label'        => __( 'Fixed Nav', 'avator-widget-pack' ),
				'type'         => Controls_Manager::SWITCHER,
				'prefix_class' => 'avt-scrollnav-fixed-',
				'render_type'  => 'template',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_additional',
			[
				'label' => __( 'Additional', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'alignment',
			[
				'label'       => __( 'Alignment', 'avator-widget-pack' ),
				'type'        => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options'     => [
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
				'default'   => 'left',
				'condition' => [
					'fixed_nav!' => 'yes',
				]
			]
		);

		$this->add_control(
			'nav_position',
			[
				'label'     => __( 'Nav Position', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'center-left',
				'options'   => widget_pack_position(),
				'condition' => [
					'fixed_nav' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'nav_offset',
			[
				'label' => __( 'Nav Offset', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min'  => 0,
						'max'  => 250,
						'step' => 5,
					],
				],
				'condition' => [
					'fixed_nav' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-scrollnav div[class*="avt-navbar"]' => 'margin: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'nav_spacing',
			[
				'label'      => __( 'Nav Spacing', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-scrollnav ul li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'menu_height',
			[
				'label' => __( 'Menu Height', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 20,
						'max' => 150,
					],
				],
				'size_units' => [ 'px'],
				'selectors'  => [
					'{{WRAPPER}} .avt-navbar-nav > li > a' => 'min-height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'nav_style' => 'default'
				]
			]
		);

		$this->add_control(
			'icon_align',
			[
				'label'     => __( 'Icon Position', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SELECT,
				'separator' => 'before',
				'default'   => 'right',
				'options'   => [
					'left'  => __( 'Before', 'avator-widget-pack' ),
					'right' => __( 'After', 'avator-widget-pack' ),
				],
				'condition' => [
					'nav_style' => 'default',
				],
			]
		);

		$this->add_responsive_control(
			'icon_indent',
			[
				'label'   => __( 'Icon Spacing', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 8,
				],
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-scrollnav .avt-button-icon-align-right' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .avt-scrollnav .avt-button-icon-align-left'  => 'margin-right: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'nav_style' => 'default',
				],
			]
		);

		$this->add_control(
			'content_offset',
			[
				'label'       => __( 'Target Offset', 'avator-widget-pack' ),
				'description' => __( 'This offset work when you click and go to targeted location', 'avator-widget-pack' ),
				'separator'   => 'before',
				'type'        => Controls_Manager::SLIDER,
				'range'       => [
					'px' => [
						'min'  => -250,
						'max'  => 250,
						'step' => 5
					]
				],
				'default' => [
					'size' => 0
				]
			]
		);

		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_content_tooltip',
			[
				'label'     => __( 'Tooltip', 'avator-widget-pack' ),
				'condition' => [
					'nav_style' => 'dot',
				]
			]
		);

		

		$this->add_control(
			'dotnav_tooltip_animation',
			[
				'label'   => __( 'Animation', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'shift-toward',
				'options' => [
					'shift-away'   => __( 'Shift-Away', 'avator-widget-pack' ),
					'shift-toward' => __( 'Shift-Toward', 'avator-widget-pack' ),
					'fade'         => __( 'Fade', 'avator-widget-pack' ),
					'scale'        => __( 'Scale', 'avator-widget-pack' ),
					'perspective'  => __( 'Perspective', 'avator-widget-pack' ),
				],
				'render_type'  => 'template',
			]
		);



		$this->add_control(
			'dotnav_tooltip_placement',
			[
				'name'    => 'marker_tooltip_placement',						
				'label'   => __( 'Placement', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'right',
				'options' => [
					'top'    => __( 'Top', 'avator-widget-pack' ),
					'bottom' => __( 'Bottom', 'avator-widget-pack' ),
					'left'   => __( 'Left', 'avator-widget-pack' ),
					'right'  => __( 'Right', 'avator-widget-pack' ),
				],
			]
		);

		$this->add_control(
			'dotnav_tooltip_x_offset',
			[
				'label'   => __( 'Offset', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
			]
		);

		$this->add_control(
			'dotnav_tooltip_y_offset',
			[
				'label'   => __( 'Distance', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
			]
		);

		$this->add_control(
			'dotnav_tooltip_arrow',
			[
				'label'        => __( 'Arrow', 'avator-widget-pack' ),
				'type'         => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'dotnav_tooltip_trigger',
			[
				'label'       => __( 'Trigger on Click', 'avator-widget-pack' ),
				'description' => __( 'Don\'t set yes when you set lightbox image with marker.', 'avator-widget-pack' ),
				'type'        => Controls_Manager::SWITCHER,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_nav',
			[
				'label'     => __( 'Default Nav', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'nav_style' => 'default',
				],
			]
		);

		$this->add_control(
			'navbar_style',
			[
				'label'   => __( 'Navbar Style', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					''  => __( 'Select Style', 'avator-widget-pack' ),
					'1' => __( 'Style 1', 'avator-widget-pack' ),
					'2' => __( 'Style 2', 'avator-widget-pack' ),
					'3' => __( 'Style 3', 'avator-widget-pack' ),
				],
				'prefix_class' => 'avt-navbar-style-',
			]
		);

		$this->start_controls_tabs( 'tabs_nav_style' );

		$this->start_controls_tab(
			'tab_nav_normal',
			[
				'label' => __( 'Normal', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'nav_color',
			[
				'label'     => __( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-scrollnav ul li > a' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-scrollnav ul li > a svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'nav_background_color',
			[
				'label'     => __( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-scrollnav ul li > a' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'nav_border',
				'label'       => __( 'Border', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-scrollnav ul li > a',
			]
		);

		$this->add_responsive_control(
			'nav_border_radius',
			[
				'label'      => __( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-scrollnav ul li > a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'nav_shadow',
				'selector' => '{{WRAPPER}} .avt-scrollnav ul li > a',
			]
		);

		$this->add_responsive_control(
			'nav_padding',
			[
				'label'      => __( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-scrollnav ul li > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'nav_margin',
			[
				'label'      => __( 'Margin', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-scrollnav ul li > a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'nav_typography',
				'label'    => __( 'Typography', 'avator-widget-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .avt-scrollnav ul li > a',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_nav_hover',
			[
				'label' => __( 'Hover', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'navbar_hover_style_color',
			[
				'label'     => __( 'Style Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-navbar-nav > li:hover > a:before' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .avt-navbar-nav > li:hover > a:after'  => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'navbar_style!' => '',
				],
			]
		);

		$this->add_control(
			'nav_hover_color',
			[
				'label'     => __( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-scrollnav ul li > a:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-scrollnav ul li > a:hover svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'nav_hover_background_color',
			[
				'label'     => __( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-scrollnav ul li > a:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'nav_hover_border_color',
			[
				'label'     => __( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'nav_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-scrollnav ul li > a:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_nav_active',
			[
				'label' => __( 'Active', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'navbar_active_style_color',
			[
				'label'     => __( 'Style Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-navbar-nav > li.avt-active > a:before' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .avt-navbar-nav > li.avt-active > a:after'  => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'navbar_style!' => '',
				],
			]
		);

		$this->add_control(
			'nav_active_color',
			[
				'label'     => __( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-scrollnav ul li.avt-active > a' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-scrollnav ul li.avt-active > a svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'nav_active_background_color',
			[
				'label'     => __( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-scrollnav ul li.avt-active > a' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'nav_active_border_color',
			[
				'label'     => __( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'nav_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-scrollnav ul li.avt-active > a' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_dot_nav',
			[
				'label'     => __( 'Dot Nav', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'nav_style' => 'dot',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_nav_style_dot' );

		$this->start_controls_tab(
			'tab_dot_nav_normal',
			[
				'label' => __( 'Normal', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'dot_nav_size',
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
					'{{WRAPPER}} .avt-scrollnav .avt-dotnav>*>*' => 'height: {{SIZE}}{{UNIT}};width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'dot_nav_background_color',
			[
				'label'     => __( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-scrollnav .avt-dotnav > li > a' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'dot_nav_border',
				'label'       => __( 'Border', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-scrollnav .avt-dotnav > li > a',
			]
		);

		$this->add_responsive_control(
			'dot_nav_border_radius',
			[
				'label'      => __( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-scrollnav .avt-dotnav > li > a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'dot_nav_shadow',
				'selector' => '{{WRAPPER}} .avt-scrollnav .avt-dotnav > li > a',
			]
		);

		$this->add_responsive_control(
			'dot_nav_padding',
			[
				'label'      => __( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-scrollnav .avt-dotnav > li > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_dot_nav_hover',
			[
				'label' => __( 'Hover', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'dot_nav_hover_background_color',
			[
				'label'     => __( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-scrollnav .avt-dotnav > li > a:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'dot_nav_hover_border_color',
			[
				'label'     => __( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'dot_nav_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-scrollnav .avt-dotnav > li > a:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_dot_nav_active',
			[
				'label' => __( 'Active', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'dot_nav_active_background_color',
			[
				'label'     => __( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-scrollnav .avt-dotnav > li.avt-active > a' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'dot_nav_active_border_color',
			[
				'label'     => __( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'dot_nav_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-scrollnav .avt-dotnav > li.avt-active > a' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'dotnav_tooltip_styles_tab',
			[
				'label'     => __( 'Tooltip', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'nav_style' => 'dot',
				],
			]
		);

		$this->add_responsive_control(
			'dotnav_tooltip_width',
			[
				'label'      => __( 'Width', 'avator-widget-pack' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [
					'px', 'em',
				],
				'range'      => [
					'px' => [
						'min' => 50,
						'max' => 500,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .tippy-tooltip' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'dotnav_tooltip_typography',
				'selector' => '{{WRAPPER}} .tippy-tooltip .tippy-content',
			]
		);

		$this->add_control(
			'dotnav_tooltip_color',
			[
				'label'     => __( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tippy-tooltip' => 'color: {{VALUE}}',
				]
			]
		);

		$this->add_control(
			'dotnav_tooltip_text_align',
			[
				'label'   => __( 'Text Alignment', 'avator-widget-pack' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
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
				'selectors' => [
					'{{WRAPPER}} .tippy-tooltip .tippy-content' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'dotnav_tooltip_background',
				'selector' => '{{WRAPPER}} .tippy-tooltip, {{WRAPPER}} .tippy-tooltip .tippy-backdrop',
			]
		);

		$this->add_control(
			'dotnav_tooltip_arrow_color',
			[
				'label'  => __( 'Arrow Color', 'avator-widget-pack' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tippy-popper[x-placement^=left] .tippy-arrow'  => 'border-left-color: {{VALUE}}',
					'{{WRAPPER}} .tippy-popper[x-placement^=right] .tippy-arrow' => 'border-right-color: {{VALUE}}',
					'{{WRAPPER}} .tippy-popper[x-placement^=top] .tippy-arrow'   => 'border-top-color: {{VALUE}}',
					'{{WRAPPER}} .tippy-popper[x-placement^=bottom] .tippy-arrow'=> 'border-bottom-color: {{VALUE}}',
				],
				'condition' => [
					'dotnav_tooltip_arrow' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'dotnav_tooltip_padding',
			[
				'label'      => __( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tippy-tooltip' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'dotnav_tooltip_border',
				'label'       => __( 'Border', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .tippy-tooltip',
			]
		);

		$this->add_responsive_control(
			'dotnav_tooltip_border_radius',
			[
				'label'      => __( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tippy-tooltip' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'dotnav_tooltip_shadow',
				'selector' => '{{WRAPPER}} .tippy-tooltip',
			]
		);

		$this->end_controls_section();
	}

	public function render_dotnav_tooltip($settings) {    		
		
		// Tooltip settings
		$this->add_render_attribute( 'nav-link', 'class', 'avt-tippy-tooltip', true );
		$this->add_render_attribute( 'nav-link', 'data-tippy', '', true );

		if ($settings['dotnav_tooltip_placement']) {
			$this->add_render_attribute( 'nav-link', 'data-tippy-placement', $settings['dotnav_tooltip_placement'], true );
		}

		if ($settings['dotnav_tooltip_animation']) {
			$this->add_render_attribute( 'nav-link', 'data-tippy-animation', $settings['dotnav_tooltip_animation'], true );
		}

		if ($settings['dotnav_tooltip_x_offset']['size'] or $settings['dotnav_tooltip_y_offset']['size']) {
			$this->add_render_attribute( 'nav-link', 'data-tippy-offset', $settings['dotnav_tooltip_x_offset']['size'] .','. $settings['dotnav_tooltip_y_offset']['size'], true );
		}

		if ('yes' == $settings['dotnav_tooltip_arrow']) {
			$this->add_render_attribute( 'nav-link', 'data-tippy-arrow', 'true', true );
		}

		if ('yes' == $settings['dotnav_tooltip_trigger']) {
			$this->add_render_attribute( 'nav-link', 'data-tippy-trigger', 'click', true );
		}
	}

	public function render_loop_nav_list($list) {
		$settings = $this->get_settings();
		$this->add_render_attribute(
			[
				'nav-link' => [
					//'id'     => 'avt-tooltip-' . $this->get_id(),
					'href'   => esc_attr($list['nav_link']['url']),
					'target' => $list['nav_link']['is_external'] ? '_blank' : '_self',
					'rel'    => $list['nav_link']['nofollow'] ? 'rel="nofollow"' : '',
					'data-tippy-content'  => ( 'dot' == $settings['nav_style'] ) ? esc_html($list["nav_title"]) : '',
				]
			], '', '', true
		);
		if ( 'dot' == $settings['nav_style'] ) {
			$this->render_dotnav_tooltip( $settings );
		}

		if ( ! isset( $list['nav_icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
			// add old default
			$list['nav_icon'] = 'fas fa-home';
		}

		$migrated  = isset( $list['__fa4_migrated']['scroll_nav_icon'] );
		$is_new    = empty( $list['nav_icon'] ) && Icons_Manager::is_migration_allowed();

		?>
	    <li>
			<a <?php echo ( $this->get_render_attribute_string( 'nav-link' ) ); ?>>
				<?php echo esc_attr($list['nav_title']); ?>
				<?php if ($list['scroll_nav_icon']['value']) : ?>
					<span class="avt-button-icon-align-<?php echo esc_attr($settings['icon_align']); ?>">

						<?php if ( $is_new || $migrated ) :
							Icons_Manager::render_icon( $list['scroll_nav_icon'], [ 'aria-hidden' => 'true', 'class' => 'fa-fw' ] );
						else : ?>
							<i class="<?php echo esc_attr( $list['nav_icon'] ); ?>" aria-hidden="true"></i>
						<?php endif; ?>

					</span>
				<?php endif; ?>
			</a>
		</li>
		<?php
	}

	public function render() {
		$settings          = $this->get_settings();

		if ( 'dot' !== $settings['nav_style'] ) :
			$this->add_render_attribute(
				[
					'nav-style' => [
						'class' => $settings['vertical_nav'] ? 'avt-nav avt-nav-default' : 'avt-navbar-nav',
					]
				]
			);
		else :
			$this->add_render_attribute(
				[
					'nav-style' => [
						'class' => $settings['vertical_nav'] ? 'avt-dotnav avt-dotnav-vertical' : 'avt-dotnav',
					]
				]
			);
		endif;

		$this->add_render_attribute( 'nav-style', 'avt-scrollspy-nav', 'closest: li; scroll: true; offset: ' . $settings["content_offset"]["size"] . ';' );

		$this->add_render_attribute(
			[
				'scrollnav' => [
					'class' => [
						'avt-scrollnav',
						'avt-navbar-container',
						'avt-navbar-transparent',
						'avt-navbar',
						$settings['fixed_nav'] ? 'avt-position-' . esc_attr($settings['nav_position']) . ' avt-position-z-index' : '',
					],
					'avt-navbar' => ''
				]
			]
		);

		?>
		<div <?php echo $this->get_render_attribute_string( 'scrollnav' ); ?>>
			<div class="avt-navbar-<?php echo esc_attr($settings['alignment']); ?>">
				<ul <?php echo $this->get_render_attribute_string( 'nav-style' ); ?>>
					<?php
					foreach ($settings['navs'] as $key => $nav) : 
						$this->render_loop_nav_list($nav);
					endforeach;
					?>
				</ul>
			</div>
		</div>
	    <?php
	}
}
