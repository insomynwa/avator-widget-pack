<?php
namespace WidgetPack\Modules\DualButton\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;

use Elementor\Icons_Manager;
use Elementor\Core\Files\Assets\Svg\Svg_Handler;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class DualButton extends Widget_Base {
	public function get_name() {
		return 'avt-dual-button';
	}

	public function get_title() {
		return AWP . __( 'Dual Button', 'avator-widget-pack' );
	}

	public function get_icon() {
		return 'avt-wi-dual-button';
	}

	public function get_categories() {
		return [ 'widget-pack' ];
	}

	public function get_keywords() {
		return [ 'dual', 'button', 'link', 'double' ];
	}

	public function get_style_depends() {
		return [ 'wipa-advanced-button', 'wipa-dual-button' ];
	}

	public function get_custom_help_url() {
		return 'https://youtu.be/7hWWqHEr6s8';
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_content_button',
			[
				'label' => __( 'Button', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'dual_button_size',
			[
				'label'   => __( 'Button Size', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'md',
				'options' => [
					'xs' => __( 'Extra Small', 'avator-widget-pack' ),
					'sm' => __( 'Small', 'avator-widget-pack' ),
					'md' => __( 'Medium', 'avator-widget-pack' ),
					'lg' => __( 'Large', 'avator-widget-pack' ),
					'xl' => __( 'Extra Large', 'avator-widget-pack' ),
				],
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label' => __( 'Alignment', 'avator-widget-pack' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'start' => [
						'title' => __( 'Left', 'avator-widget-pack' ),
						'icon' => 'fas fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'avator-widget-pack' ),
						'icon' => 'fas fa-align-center',
					],
					'end' => [
						'title' => __( 'Right', 'avator-widget-pack' ),
						'icon' => 'fas fa-align-right',
					],
				],
				'prefix_class' => 'avt-element-align%s-',
			]
		);

		$this->add_responsive_control(
			'button_width',
			[
				'label' => __( 'Button Width', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'%' => [
						'max' => 100,
						'min' => 20,
					],
					'px' => [
						'max' => 1200,
						'min' => 300,
					],
				],
				'size_units' => ['%', 'px'],
				'default' => [
					'size' => 40,
					'unit' => '%',
				],
				'tablet_default' => [
					'size' => 80,
					'unit' => '%',
				],
				'mobile_default' => [
					'size' => 100,
					'unit' => '%',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-dual-button'  => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'show_middle_text',
			[
				'label' => __( 'Middle Text', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'middle_text',
			[
				'label'       => __( 'Text', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'default'     => __( 'or', 'avator-widget-pack' ),
				'placeholder' => __( 'or', 'avator-widget-pack' ),
				'condition'   => [
					'show_middle_text' => 'yes',
				],
			]
		);

		$this->add_control(
			'dual_button_gap',
			[
				'label'   => __( 'Button Gap', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 5,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .avt-advanced-button-wrapper .avt-dual-button-a' => 'margin-right: {{SIZE}}px;',
				],
				'condition' => [
					'show_middle_text!' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_button_a',
			[
				'label' => __( 'Button A', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'button_a_text',
			[
				'label'       => __( 'Text', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'default'     => __( 'Click Me', 'avator-widget-pack' ),
				'placeholder' => __( 'Click Me', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'button_a_link',
			[
				'label'       => __( 'Link', 'avator-widget-pack' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => __( 'https://your-link.com', 'avator-widget-pack' ),
				'default'     => [
					'url' => '#',
				],
			]
		);

		$this->add_control(
			'button_a_onclick',
			[
				'label' => esc_html__( 'OnClick', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'button_a_onclick_event',
			[
				'label'       => __( 'OnClick Event', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => 'myFunction()',
				'description' => sprintf( __('For details please look <a href="%s" target="_blank">here</a>'), 'https://www.w3schools.com/jsref/event_onclick.asp' ),
				'condition' => [
					'button_a_onclick' => 'yes'
				]
			]
		);

		$this->add_responsive_control(
			'button_a_align',
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
			]
		);

		$this->add_control(
			'button_a_select_icon',
			[
				'label'       => __( 'Icon', 'avator-widget-pack' ),
				'type'        => Controls_Manager::ICONS,
				'fa4compatibility' => 'button_a_icon',
			]
		);

		$this->add_control(
			'button_a_icon_align',
			[
				'label'   => __( 'Icon Position', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'right',
				'options' => [
					'left'   => __( 'Left', 'avator-widget-pack' ),
					'right'  => __( 'Right', 'avator-widget-pack' ),
					'top'    => __( 'Top', 'avator-widget-pack' ),
					'bottom' => __( 'Bottom', 'avator-widget-pack' ),
				],
				'condition' => [
					'button_a_select_icon[value]!' => '',
				],
			]
		);

		$this->add_control(
			'button_a_icon_indent',
			[
				'label' => __( 'Icon Spacing', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
					'default' => [
						'size' => 8,
					],
				'condition' => [
					'button_a_select_icon[value]!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-advanced-button-wrapper .avt-dual-button-a .avt-flex-align-right'  => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .avt-advanced-button-wrapper .avt-dual-button-a .avt-flex-align-left'   => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .avt-advanced-button-wrapper .avt-dual-button-a .avt-flex-align-top'    => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .avt-advanced-button-wrapper .avt-dual-button-a .avt-flex-align-bottom' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_button_b',
			[
				'label' => __( 'Button B', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'button_b_text',
			[
				'label'       => __( 'Text', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'default'     => __( 'Read More', 'avator-widget-pack' ),
				'placeholder' => __( 'Read More', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'button_b_link',
			[
				'label'       => __( 'Link', 'avator-widget-pack' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => __( 'https://your-link.com', 'avator-widget-pack' ),
				'default'     => [
					'url' => '#',
				],
			]
		);

		$this->add_control(
			'button_b_size',
			[
				'label'   => __( 'Button Size', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'md',
				'options' => [
					'xs' => __( 'Extra Small', 'avator-widget-pack' ),
					'sm' => __( 'Small', 'avator-widget-pack' ),
					'md' => __( 'Medium', 'avator-widget-pack' ),
					'lg' => __( 'Large', 'avator-widget-pack' ),
					'xl' => __( 'Extra Large', 'avator-widget-pack' ),
				],
			]
		);

		$this->add_control(
			'button_b_onclick',
			[
				'label' => esc_html__( 'OnClick', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'button_b_onclick_event',
			[
				'label'       => __( 'OnClick Event', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => 'myFunction()',
				'description' => sprintf( __('For details please look <a href="%s" target="_blank">here</a>'), 'https://www.w3schools.com/jsref/event_onclick.asp' ),
				'condition' => [
					'button_b_onclick' => 'yes'
				]
			]
		);

		$this->add_responsive_control(
			'button_b_align',
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
			]
		);

		$this->add_control(
			'button_b_select_icon',
			[
				'label'       => __( 'Icon', 'avator-widget-pack' ),
				'type'        => Controls_Manager::ICONS,
				'fa4compatibility' => 'button_b_icon',
			]
		);

		$this->add_control(
			'button_b_icon_align',
			[
				'label'   => __( 'Icon Position', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'right',
				'options' => [
					'left'   => __( 'Left', 'avator-widget-pack' ),
					'right'  => __( 'Right', 'avator-widget-pack' ),
					'top'    => __( 'Top', 'avator-widget-pack' ),
					'bottom' => __( 'Bottom', 'avator-widget-pack' ),
				],
				'condition' => [
					'button_b_select_icon[value]!' => '',
				],
			]
		);

		$this->add_control(
			'button_b_icon_indent',
			[
				'label' => __( 'Icon Spacing', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
					'default' => [
						'size' => 8,
					],
				'condition' => [
					'button_b_select_icon[value]!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-advanced-button-wrapper .avt-dual-button-b .avt-flex-align-right'  => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .avt-advanced-button-wrapper .avt-dual-button-b .avt-flex-align-left'   => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .avt-advanced-button-wrapper .avt-dual-button-b .avt-flex-align-top'    => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .avt-advanced-button-wrapper .avt-dual-button-b .avt-flex-align-bottom' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_style',
			[
				'label' => __( 'Button', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'tabs_dual_button_style' );

		$this->start_controls_tab(
			'tab_dual_button_normal',
			[
				'label' => __( 'Normal', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'button_border_style',
			[
				'label'   => __( 'Border Style', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'none',
				'options' => [
					'none'   => __( 'None', 'avator-widget-pack' ),
					'solid'  => __( 'Solid', 'avator-widget-pack' ),
					'dotted' => __( 'Dotted', 'avator-widget-pack' ),
					'dashed' => __( 'Dashed', 'avator-widget-pack' ),
					'groove' => __( 'Groove', 'avator-widget-pack' ),
				],
				'selectors'  => [
					'{{WRAPPER}} .avt-dual-button a' => 'border-style: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'button_border_width',
			[
				'label'      => __( 'Border Width', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'    => 3,
					'right'  => 3,
					'bottom' => 3,
					'left'   => 3,
				],
				'selectors'  => [
					'{{WRAPPER}} .avt-dual-button a' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'button_border_style!' => 'none'
				]
			]
		);

		$this->add_responsive_control(
			'dual_button_radius',
			[
				'label'      => __( 'Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-dual-button a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'dual_button_shadow',
				'selector' => '{{WRAPPER}} .avt-dual-button a',
			]
		);

		$this->add_responsive_control(
			'dual_button_padding',
			[
				'label'      => __( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-dual-button a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'dual_button_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .avt-dual-button a',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_dual_button_hover',
			[
				'label' => __( 'Hover', 'avator-widget-pack' ),
			]
		);

		$this->add_responsive_control(
			'dual_button_hover_radius',
			[
				'label'      => __( 'Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-dual-button a:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'dual_button_hover_shadow',
				'selector' => '{{WRAPPER}} .avt-dual-button a:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_style_a',
			[
				'label' => __( 'Button A', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'button_a_effect',
			[
				'label'   => __( 'Effect', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'a',
				'options' => [
					'a' => __( 'Effect A', 'avator-widget-pack' ),
					'b' => __( 'Effect B', 'avator-widget-pack' ),
					'c' => __( 'Effect C', 'avator-widget-pack' ),
					'd' => __( 'Effect D', 'avator-widget-pack' ),
					'e' => __( 'Effect E', 'avator-widget-pack' ),
					'f' => __( 'Effect F', 'avator-widget-pack' ),
					'g' => __( 'Effect G', 'avator-widget-pack' ),
					'h' => __( 'Effect H', 'avator-widget-pack' ),
					'i' => __( 'Effect I', 'avator-widget-pack' ),
				],
			]
		);

		$this->start_controls_tabs( 'tabs_button_a_style' );

		$this->start_controls_tab(
			'tab_button_a_normal',
			[
				'label' => __( 'Normal', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'button_a_color',
			[
				'label'     => __( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-advanced-button-wrapper .avt-dual-button-a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'button_a_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .avt-advanced-button-wrapper .avt-dual-button-a, 
								{{WRAPPER}} .avt-advanced-button-wrapper .avt-dual-button-a.avt-advanced-button-effect-i .avt-advanced-button-content-wrapper:after,
								{{WRAPPER}} .avt-advanced-button-wrapper .avt-dual-button-a.avt-advanced-button-effect-i .avt-advanced-button-content-wrapper:before',
				'separator' => 'after',
			]
		);

		$this->add_responsive_control(
			'button_a_border_radius',
			[
				'label'      => __( 'Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-advanced-button-wrapper .avt-dual-button-a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'button_a_border_color',
			[
				'label'     => __( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#666',
				'selectors' => [
					'{{WRAPPER}} .avt-advanced-button-wrapper .avt-dual-button-a' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'button_border_style!' => 'none'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_a_shadow',
				'selector' => '{{WRAPPER}} .avt-dual-button a.avt-dual-button-a',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_a_hover',
			[
				'label' => __( 'Hover', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'button_a_hover_color',
			[
				'label'     => __( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-advanced-button-wrapper .avt-dual-button-a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'button_a_hover_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .avt-advanced-button-wrapper .avt-dual-button-a:after, 
								{{WRAPPER}} .avt-advanced-button-wrapper .avt-dual-button-a:hover,
								{{WRAPPER}} .avt-advanced-button-wrapper .avt-dual-button-a.avt-advanced-button-effect-i,
								{{WRAPPER}} .avt-advanced-button-wrapper .avt-dual-button-a.avt-advanced-button-effect-h:after',
				'separator' => 'after',
			]
		);

		$this->add_responsive_control(
			'button_a_hover_border_radius',
			[
				'label'      => __( 'Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-advanced-button-wrapper .avt-dual-button-a:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'button_a_hover_border_color',
			[
				'label'     => __( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-advanced-button-wrapper .avt-dual-button-a:hover' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'button_border_style!' => 'none'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_a_hover_shadow',
				'selector' => '{{WRAPPER}} .avt-dual-button a.avt-dual-button-a:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_style_b',
			[
				'label' => __( 'Button B', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'button_b_effect',
			[
				'label'   => __( 'Effect', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'a',
				'options' => [
					'a' => __( 'Effect A', 'avator-widget-pack' ),
					'b' => __( 'Effect B', 'avator-widget-pack' ),
					'c' => __( 'Effect C', 'avator-widget-pack' ),
					'd' => __( 'Effect D', 'avator-widget-pack' ),
					'e' => __( 'Effect E', 'avator-widget-pack' ),
					'f' => __( 'Effect F', 'avator-widget-pack' ),
					'g' => __( 'Effect G', 'avator-widget-pack' ),
					'h' => __( 'Effect H', 'avator-widget-pack' ),
					'i' => __( 'Effect I', 'avator-widget-pack' ),
				],
			]
		);

		$this->start_controls_tabs( 'tabs_button_b_style' );

		$this->start_controls_tab(
			'tab_button_b_normal',
			[
				'label' => __( 'Normal', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'button_b_color',
			[
				'label'     => __( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-advanced-button-wrapper .avt-dual-button-b' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'button_b_background',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .avt-advanced-button-wrapper .avt-dual-button-b, 
							   {{WRAPPER}} .avt-advanced-button-wrapper .avt-dual-button-b.avt-advanced-button-effect-i .avt-advanced-button-content-wrapper:after, 
							   {{WRAPPER}} .avt-advanced-button-wrapper .avt-dual-button-b.avt-advanced-button-effect-i .avt-advanced-button-content-wrapper:before',
				'separator' => 'after',
			]
		);

		$this->add_responsive_control(
			'button_b_border_radius',
			[
				'label'      => __( 'Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-advanced-button-wrapper .avt-dual-button-b' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'button_b_border_color',
			[
				'label'     => __( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#666',
				'selectors' => [
					'{{WRAPPER}} .avt-advanced-button-wrapper .avt-dual-button-b' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'button_border_style!' => 'none'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_b_shadow',
				'selector' => '{{WRAPPER}} .avt-dual-button a.avt-dual-button-b',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_b_hover',
			[
				'label' => __( 'Hover', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'button_b_hover_color',
			[
				'label'     => __( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-advanced-button-wrapper .avt-dual-button-b:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'button_b_hover_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .avt-advanced-button-wrapper .avt-dual-button-b:after,
								{{WRAPPER}} .avt-advanced-button-wrapper .avt-dual-button-b:hover, 
								{{WRAPPER}} .avt-advanced-button-wrapper .avt-dual-button-b.avt-advanced-button-effect-i,
								{{WRAPPER}} .avt-advanced-button-wrapper .avt-dual-button-b.avt-advanced-button-effect-h:after
								',
				'separator' => 'after',
			]
		);

		$this->add_responsive_control(
			'button_b__hover_border_radius',
			[
				'label'      => __( 'Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-advanced-button-wrapper .avt-dual-button-b:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'button_b_hover_border_color',
			[
				'label'     => __( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-advanced-button-wrapper .avt-dual-button-b:hover' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'button_border_style!' => 'none'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_b_hover_shadow',
				'selector' => '{{WRAPPER}} .avt-dual-button a.avt-dual-button-b:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_button_a_icon',
			[
				'label'     => __( 'Button A Icon', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'button_a_select_icon[value]!' => '',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_button_a_icon_style' );

		$this->start_controls_tab(
			'tab_button_a_icon_normal',
			[
				'label' => __( 'Normal', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'button_a_icon_color',
			[
				'label'     => __( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-advanced-button-wrapper .avt-dual-button-a .avt-dual-button-a-icon i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-advanced-button-wrapper .avt-dual-button-a .avt-dual-button-a-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'button_a_icon_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .avt-advanced-button .avt-dual-button-a-icon .avt-advanced-button-a-icon-inner',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'button_a_icon_border',
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-advanced-button .avt-dual-button-a-icon .avt-advanced-button-a-icon-inner',
			]
		);

		$this->add_control(
			'button_a_icon_padding',
			[
				'label'      => __( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-advanced-button .avt-dual-button-a-icon .avt-advanced-button-a-icon-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'button_a_icon_radius',
			[
				'label'      => __( 'Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-advanced-button .avt-dual-button-a-icon .avt-advanced-button-a-icon-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_a_icon_shadow',
				'selector' => '{{WRAPPER}} .avt-advanced-button .avt-dual-button-a-icon .avt-advanced-button-a-icon-inner',
			]
		);

		$this->add_responsive_control(
			'button_a_icon_size',
			[
				'label' => __( 'Icon Size', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min'  => 10,
						'max'  => 100,
					],
				],				
				'selectors' => [
					'{{WRAPPER}} .avt-advanced-button .avt-dual-button-a-icon .avt-advanced-button-a-icon-inner' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_a_icon_hover',
			[
				'label' => __( 'Hover', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'button_a_icon_hover_color',
			[
				'label'     => __( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-advanced-button-wrapper .avt-dual-button-a:hover .avt-dual-button-a-icon i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-advanced-button-wrapper .avt-dual-button-a:hover .avt-dual-button-a-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'button_a_icon_hover_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .avt-advanced-button:hover .avt-dual-button-a-icon .avt-advanced-button-a-icon-inner',
				'separator' => 'after',
			]
		);

		$this->add_control(
			'button_a_icon_hover_border_color',
			[
				'label'     => __( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'button_a_icon_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-advanced-button:hover .avt-dual-button-a-icon .avt-advanced-button-a-icon-inner' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_button_b_icon',
			[
				'label'     => __( 'Button B Icon', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'button_b_select_icon[value]!' => '',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_button_b_icon_style' );

		$this->start_controls_tab(
			'tab_button_b_icon_normal',
			[
				'label' => __( 'Normal', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'button_b_icon_color',
			[
				'label'     => __( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-advanced-button-wrapper .avt-dual-button-b .avt-dual-button-b-icon i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-advanced-button-wrapper .avt-dual-button-b .avt-dual-button-b-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'button_b_icon_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .avt-advanced-button .avt-dual-button-b-icon .avt-advanced-button-b-icon-inner',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'button_b_icon_border',
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-advanced-button .avt-dual-button-b-icon .avt-advanced-button-b-icon-inner',
			]
		);

		$this->add_control(
			'button_b_icon_padding',
			[
				'label'      => __( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-advanced-button .avt-dual-button-b-icon .avt-advanced-button-b-icon-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'button_b_icon_radius',
			[
				'label'      => __( 'Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-advanced-button .avt-dual-button-b-icon .avt-advanced-button-b-icon-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_b_icon_shadow',
				'selector' => '{{WRAPPER}} .avt-advanced-button .avt-dual-button-b-icon .avt-advanced-button-b-icon-inner',
			]
		);

		$this->add_responsive_control(
			'button_b_icon_size',
			[
				'label' => __( 'Icon Size', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min'  => 10,
						'max'  => 100,
					],
				],				
				'selectors' => [
					'{{WRAPPER}} .avt-advanced-button .avt-dual-button-b-icon .avt-advanced-button-b-icon-inner' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_b_icon_hover',
			[
				'label' => __( 'Hover', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'button_b_icon_hover_color',
			[
				'label'     => __( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-advanced-button-wrapper .avt-dual-button-b:hover .avt-dual-button-b-icon i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-advanced-button-wrapper .avt-dual-button-b:hover .avt-dual-button-b-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'button_b_icon_hover_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .avt-advanced-button:hover .avt-dual-button-b-icon .avt-advanced-button-b-icon-inner',
				'separator' => 'after',
			]
		);

		$this->add_control(
			'button_b_icon_hover_border_color',
			[
				'label'     => __( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'button_b_icon_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-advanced-button:hover .avt-dual-button-b-icon .avt-advanced-button-b-icon-inner' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_middle_text',
			[
				'label'      => __( 'Middle Text', 'avator-widget-pack' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'conditions' => [
					'terms' => [
						[
							'name'     => 'show_middle_text',
							'value'    => 'yes',
						],
						[
							'name'     => 'middle_text',
							'operator' => '!=',
							'value'    => '',
						],
					],
				],
			]

		);

		$this->add_control(
			'middle_text_color',
			[
				'label'     => __( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-dual-button span' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'middle_text_background',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .avt-dual-button span',
				'separator' => 'after',
			]
		);

		$this->add_responsive_control(
			'middle_text_radius',
			[
				'label'      => __( 'Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-dual-button span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'middle_text_shadow',
				'selector' => '{{WRAPPER}} .avt-dual-button span',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'middle_text_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .avt-dual-button span',
			]
		);

		$this->end_controls_section();
	}

	public function render_text_a($settings) {

		$this->add_render_attribute( 'content-wrapper-a', 'class', 'avt-advanced-button-content-wrapper' );

		if ( 'left' == $settings['button_a_icon_align'] or 'right' == $settings['button_a_icon_align'] ) {
			$this->add_render_attribute( 'content-wrapper-a', 'class', 'avt-flex avt-flex-middle' );
		}
		$this->add_render_attribute( 'content-wrapper-a', 'class', 'avt-flex-' . $settings['button_a_align'] );

		$this->add_render_attribute( 'content-wrapper-a', 'class', ( 'top' == $settings['button_a_icon_align'] ) ? 'avt-flex avt-flex-column' : '' );
		$this->add_render_attribute( 'content-wrapper-a', 'class', ( 'bottom' == $settings['button_a_icon_align'] ) ? 'avt-flex avt-flex-column-reverse' : '' );
		$this->add_render_attribute( 'content-wrapper-a', 'data-text', esc_attr($settings['button_a_text']));

		$this->add_render_attribute( 'button-a-text', 'class', 'avt-advanced-button-text' );

		if ( ! isset( $settings['button_a_icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
			// add old default
			$settings['button_a_icon'] = 'fas fa-arrow-left';
		}

		$migrated  = isset( $settings['__fa4_migrated']['button_a_select_icon'] );
		$is_new    = empty( $settings['button_a_icon'] ) && Icons_Manager::is_migration_allowed();

		?>
		<div <?php echo $this->get_render_attribute_string( 'content-wrapper-a' ); ?>>
			<?php if ( ! empty( $settings['button_a_select_icon']['value'] ) ) : ?>
				<div class="avt-advanced-button-icon avt-dual-button-a-icon avt-flex-align-<?php echo esc_attr($settings['button_a_icon_align']); ?>">
					<div class="avt-advanced-button-a-icon-inner">
					
					<?php if ( $is_new || $migrated ) :
						Icons_Manager::render_icon( $settings['button_a_select_icon'], [ 'aria-hidden' => 'true', 'class' => 'fa-fw' ] );
					else : ?>
						<i class="<?php echo esc_attr( $settings['button_a_icon'] ); ?>" aria-hidden="true"></i>
					<?php endif; ?>

					</div>
				</div>
			<?php endif; ?>
			<div <?php echo $this->get_render_attribute_string( 'button-a-text' ); ?>><?php echo wp_kses( $settings['button_a_text'], widget_pack_allow_tags('title') ); ?></div>
		</div>
		<?php
	}

	public function render_text_b($settings) {

		$this->add_render_attribute( 'content-wrapper-b', 'class', 'avt-advanced-button-content-wrapper' );

		if ( 'left' == $settings['button_b_icon_align'] or 'right' == $settings['button_b_icon_align'] ) {
			$this->add_render_attribute( 'content-wrapper-b', 'class', 'avt-flex avt-flex-middle' );
		}
		$this->add_render_attribute( 'content-wrapper-b', 'class', 'avt-flex-' . $settings['button_b_align'] );

		$this->add_render_attribute( 'content-wrapper-b', 'class', ( 'top' == $settings['button_b_icon_align'] ) ? 'avt-flex avt-flex-column' : '' );
		$this->add_render_attribute( 'content-wrapper-b', 'class', ( 'bottom' == $settings['button_b_icon_align'] ) ? 'avt-flex avt-flex-column-reverse' : '' );
		$this->add_render_attribute( 'content-wrapper-b', 'data-text', esc_attr($settings['button_b_text']));

		$this->add_render_attribute( 'button-b-text', 'class', 'avt-advanced-button-text' );

		if ( ! isset( $settings['button_b_icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
			// add old default
			$settings['button_b_icon'] = 'fas fa-arrow-right';
		}

		$migrated  = isset( $settings['__fa4_migrated']['button_b_select_icon'] );
		$is_new    = empty( $settings['button_b_icon'] ) && Icons_Manager::is_migration_allowed();

		?>
		<div <?php echo $this->get_render_attribute_string( 'content-wrapper-b' ); ?>>
			<?php if ( ! empty( $settings['button_b_select_icon']['value'] ) ) : ?>
				<div class="avt-advanced-button-icon avt-dual-button-b-icon avt-flex-align-<?php echo esc_attr($settings['button_b_icon_align']); ?>">
					<div class="avt-advanced-button-b-icon-inner">
					
					<?php if ( $is_new || $migrated ) :
						Icons_Manager::render_icon( $settings['button_b_select_icon'], [ 'aria-hidden' => 'true', 'class' => 'fa-fw' ] );
					else : ?>
						<i class="<?php echo esc_attr( $settings['button_b_icon'] ); ?>" aria-hidden="true"></i>
					<?php endif; ?>

					</div>
				</div>
			<?php endif; ?>
			<div <?php echo $this->get_render_attribute_string( 'button-b-text' ); ?>><?php echo wp_kses( $settings['button_b_text'], widget_pack_allow_tags('title') ); ?></div>
		</div>
		<?php
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'wrapper', 'class', 'avt-dual-button avt-advanced-button-wrapper avt-element' );

		if ( ! empty( $settings['button_a_link']['url'] ) ) {
			$this->add_render_attribute( 'button_a', 'href', $settings['button_a_link']['url'] );

			if ( $settings['button_a_link']['is_external'] ) {
				$this->add_render_attribute( 'button_a', 'target', '_blank' );
			}

			if ( $settings['button_a_link']['nofollow'] ) {
				$this->add_render_attribute( 'button_a', 'rel', 'nofollow' );
			}
		}

		if ( ! empty( $settings['button_b_link']['url'] ) ) {
			$this->add_render_attribute( 'button_b', 'href', $settings['button_b_link']['url'] );

			if ( $settings['button_b_link']['is_external'] ) {
				$this->add_render_attribute( 'button_b', 'target', '_blank' );
			}

			if ( $settings['button_b_link']['nofollow'] ) {
				$this->add_render_attribute( 'button_b', 'rel', 'nofollow' );
			}
		}

		if ( $settings['button_a_link']['nofollow'] ) {
			$this->add_render_attribute( 'button_a', 'rel', 'nofollow' );
		}

		if ( $settings['button_b_link']['nofollow'] ) {
			$this->add_render_attribute( 'button_b', 'rel', 'nofollow' );
		}

		if ( 'yes' === $settings['button_a_onclick'] ) {
			$this->add_render_attribute( 'button_a', 'onclick', $settings['button_a_onclick_event'] );
		}

		if ( 'yes' === $settings['button_b_onclick'] ) {
			$this->add_render_attribute( 'button_b', 'onclick', $settings['button_b_onclick_event'] );
		}

		$this->add_render_attribute( 'button_a', 'class', 'avt-dual-button-a avt-advanced-button' );		
		$this->add_render_attribute( 'button_a', 'class', 'avt-advanced-button-effect-' . esc_attr($settings['button_a_effect']) );
		$this->add_render_attribute( 'button_a', 'class', 'avt-advanced-button-size-' . esc_attr($settings['dual_button_size']) );

		$this->add_render_attribute( 'button_b', 'class', 'avt-dual-button-b avt-advanced-button' );		
		$this->add_render_attribute( 'button_b', 'class', 'avt-advanced-button-effect-' . esc_attr($settings['button_b_effect']) );
		$this->add_render_attribute( 'button_b', 'class', 'avt-advanced-button-size-' . esc_attr($settings['dual_button_size']) );	

		?>
		<div class="avt-element-align-wrapper">
			<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
				<a <?php echo $this->get_render_attribute_string( 'button_a' ); ?>>
					<?php $this->render_text_a($settings); ?>
				</a>

				<?php if ( 'yes' === $settings['show_middle_text'] ) : ?>
					<span><?php echo esc_attr($settings['middle_text']); ?></span>
				<?php endif; ?>

				<a <?php echo $this->get_render_attribute_string( 'button_b' ); ?>>
					<?php $this->render_text_b($settings); ?>
				</a>
			</div>
		</div>
		<?php
	}
}
