<?php
namespace WidgetPack\Modules\Mailchimp\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Icons_Manager;
use Elementor\Core\Files\Assets\Svg\Svg_Handler;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Mailchimp extends Widget_Base {

	public function get_name() {
		return 'avt-mailchimp';
	}

	public function get_title() {
		return AWP . esc_html__( 'Mailchimp', 'avator-widget-pack' );
	}

	public function get_icon() {
		return 'avt-wi-mailchimp';
	}

	public function get_categories() {
		return [ 'widget-pack' ];
	}

	public function get_keywords() {
		return [ 'mailchimp', 'email', 'marketing', 'newsletter' ];
	}

	public function get_script_depends() {
		return [ 'avt-uikit-icons' ];
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'section_content_layout',
			[
				'label' => esc_html__( 'Layout', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'show_before_icon',
			[
				'label' => esc_html__( 'Before Icon', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'mailchimp_before_icon',
			[
				'label'       => __( 'Choose Icon', 'avator-widget-pack' ),
				'type'        => Controls_Manager::ICONS,
				'fa4compatibility' => 'before_icon',
				'default' => [
					'value' => 'far fa-envelope-open',
					'library' => 'fa-regular',
				],
				// 'label_block' => true,
				'condition'   => [
					'show_before_icon' => 'yes'
				]
			]
		);

		$this->add_control(
			'before_text',
			[
				'label'       => esc_html__( 'Before Text', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => esc_html__( 'Before Text', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'email_field_placeholder',
			[
				'label'       => esc_html__( 'Email Field Placeholder', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
				'default'     => esc_html__( 'Email *', 'avator-widget-pack' ),
				'placeholder' => esc_html__( 'Email *', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'after_text',
			[
				'label'       => esc_html__( 'After Text', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => esc_html__( 'After Text', 'avator-widget-pack' ),
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label'        => __( 'Alignment', 'avator-widget-pack' ),
				'type'         => Controls_Manager::CHOOSE,
				'prefix_class' => 'elementor%s-align-',
				'default'      => '',
				'options'      => [
					'left'    => [
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
					'justify' => [
						'title' => __( 'Justified', 'avator-widget-pack' ),
						'icon'  => 'fas fa-align-justify',
					],
				],
				'conditions'   => [
					'relation' => 'or',
					'terms' => [
						[
							'name'     => 'before_text',
							'operator' => '!=',
							'value'    => '',
						],
						[
							'name'     => 'after_text',
							'operator' => '!=',
							'value'    => '',
						],
					],
				],
			]
		);

		$this->add_control(
			'space',
			[
				'label'   => __( 'Space Between', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					''         => __( 'Default', 'avator-widget-pack' ),
					'small'    => __( 'Small', 'avator-widget-pack' ),
					'medium'   => __( 'Medium', 'avator-widget-pack' ),
					'large'    => __( 'Large', 'avator-widget-pack' ),
					'collapse' => __( 'Collapse', 'avator-widget-pack' ),
				],
			]
		);

		$this->add_control(
			'fullwidth_input',
			[
				'label' => esc_html__( 'Fullwidth Email Field', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'fullwidth_button',
			[
				'label'     => esc_html__( 'Fullwidth Button', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'selectors' => [
					'{{WRAPPER}} .avt-newsletter-wrapper .avt-newsletter-signup-wrapper' => 'width: 100%;',
				],
				'condition' => [
					'fullwidth_input' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_button',
			[
				'label' => esc_html__( 'Signup Button', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'button_text',
			[
				'label'       => esc_html__( 'Button Text', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => esc_html__( 'SIGNUP', 'avator-widget-pack' ),
				'default'     => esc_html__( 'SIGNUP', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'mailchimp_button_icon',
			[
				'label'       => __( 'Icon', 'avator-widget-pack' ),
				'type'        => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				// 'label_block' => true,
			]
		);

		$this->add_control(
			'icon_align',
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
					'mailchimp_button_icon[value]!' => '',
				],
			]
		);

		$this->add_control(
			'icon_indent',
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
					'mailchimp_button_icon[value]!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-newsletter-btn .avt-flex-align-right'  => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .avt-newsletter-btn .avt-flex-align-left'   => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .avt-newsletter-btn .avt-flex-align-top'    => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .avt-newsletter-btn .avt-flex-align-bottom' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_before_icon',
			[
				'label'     => __( 'Before Icon', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_before_icon' => 'yes',
					'mailchimp_before_icon[value]!'     => '',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_before_icon_style' );

		$this->start_controls_tab(
			'tab_before_icon_normal',
			[
				'label' => __( 'Normal', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'before_icon_color',
			[
				'label'     => __( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-newsletter-before-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-newsletter-before-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'before_icon_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .avt-newsletter-before-icon',
				'separator' => 'after',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'before_icon_border',
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-newsletter-before-icon',
			]
		);

		$this->add_responsive_control(
			'before_icon_margin',
			[
				'label'      => __( 'Margin', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-newsletter-before-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'before_icon_padding',
			[
				'label'      => __( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-newsletter-before-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'before_icon_radius',
			[
				'label'      => __( 'Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-newsletter-before-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'before_icon_shadow',
				'selector' => '{{WRAPPER}} .avt-newsletter-before-icon',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'before_icon_typography',
				'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
				'selector'  => '{{WRAPPER}} .avt-newsletter-before-icon',
				'separator' => 'before',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_before_icon_hover',
			[
				'label' => __( 'Hover', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'before_icon_hover_color',
			[
				'label'     => __( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-newsletter-before-icon:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-newsletter-before-icon:hover svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'before_icon_hover_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .avt-newsletter-before-icon:hover',
				'separator' => 'after',
			]
		);

		$this->add_control(
			'before_icon_hover_border_color',
			[
				'label'     => __( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'before_icon_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-newsletter-before-icon:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_input',
			[
				'label' => esc_html__( 'Email Field', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'input_placeholder_color',
			[
				'label'     => esc_html__( 'Placeholder Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-newsletter-wrapper input[type*="email"]::placeholder' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'input_color',
			[
				'label'     => esc_html__( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-newsletter-wrapper input[type*="email"]' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'input_background',
			[
				'label'     => esc_html__( 'Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-newsletter-wrapper input[type *="email"]' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'input_border_show',
			[
				'label'     => esc_html__( 'Border Style', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(), [
				'name'        => 'input_border',
				'label'       => esc_html__( 'Border', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-newsletter-wrapper input[type*="email"]',
				'condition' => [
					'input_border_show' => 'yes',
				],
			]
		);

		$this->add_control(
			'input_radius',
			[
				'label'      => esc_html__( 'Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-newsletter-wrapper input[type*="email"]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'input_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-newsletter-wrapper input[type*="email"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_button',
			[
				'label' => esc_html__( 'Sign Up Button', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
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
					'{{WRAPPER}} .avt-newsletter-wrapper .avt-button.avt-button-primary' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'background_color',
			[
				'label'     => esc_html__( 'Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-newsletter-wrapper .avt-button.avt-button-primary' => 'background-color: {{VALUE}};',
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
				'selector'    => '{{WRAPPER}} .avt-newsletter-wrapper .avt-button.avt-button-primary',
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'radius',
			[
				'label'      => esc_html__( 'Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-newsletter-wrapper .avt-button.avt-button-primary' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_shadow',
				'selector' => '{{WRAPPER}} .avt-newsletter-wrapper .avt-button.avt-button-primary',
			]
		);

		$this->add_responsive_control(
			'text_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-newsletter-wrapper .avt-button.avt-button-primary' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'button_typography',
				'label'     => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
				'selector'  => '{{WRAPPER}} .avt-newsletter-wrapper .avt-button.avt-button-primary',
				'separator' => 'before',
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
					'{{WRAPPER}} .avt-newsletter-wrapper .avt-button.avt-button-primary:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_hover_color',
			[
				'label'     => esc_html__( 'Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-newsletter-wrapper .avt-button.avt-button-primary:hover' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .avt-newsletter-wrapper .avt-button.avt-button-primary:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'hover_animation',
			[
				'label' => __( 'Hover Animation', 'avator-widget-pack' ),
				'type'  => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_icon',
			[
				'label'     => __( 'Signup Button Icon', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'mailchimp_button_icon[value]!' => '',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_signup_btn_icon_style' );

		$this->start_controls_tab(
			'tab_signup_btn_icon_normal',
			[
				'label' => __( 'Normal', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'signup_btn_icon_color',
			[
				'label'     => __( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-newsletter-btn .avt-newsletter-btn-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-newsletter-btn .avt-newsletter-btn-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'signup_btn_icon_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .avt-newsletter-btn .avt-newsletter-btn-icon:after',
				'separator' => 'after',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'signup_btn_icon_border',
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-newsletter-btn .avt-newsletter-btn-icon:after',
			]
		);

		$this->add_responsive_control(
			'signup_btn_icon_padding',
			[
				'label'      => __( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-newsletter-btn .avt-newsletter-btn-icon:after' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'signup_btn_icon_radius',
			[
				'label'      => __( 'Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-newsletter-btn .avt-newsletter-btn-icon:after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'signup_btn_icon_shadow',
				'selector' => '{{WRAPPER}} .avt-newsletter-btn .avt-newsletter-btn-icon:after',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'signup_btn_icon_typography',
				'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
				'selector'  => '{{WRAPPER}} .avt-newsletter-btn .avt-newsletter-btn-icon',
				'separator' => 'before',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_signup_btn_icon_hover',
			[
				'label' => __( 'Hover', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'signup_btn_icon_hover_color',
			[
				'label'     => __( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-newsletter-btn:hover .avt-newsletter-btn-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-newsletter-btn:hover .avt-newsletter-btn-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'signup_btn_icon_hover_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .avt-newsletter-btn:hover .avt-newsletter-btn-icon:after',
				'separator' => 'after',
			]
		);

		$this->add_control(
			'icon_hover_border_color',
			[
				'label'     => __( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'icon_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-newsletter-btn:hover .avt-newsletter-btn-icon:after' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_before_text',
			[
				'label'     => __( 'Before Text', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'before_text!' => '',
				],
			]
		);

		$this->add_control(
			'before_text_color',
			[
				'label'     => __( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-newsletter-wrapper .avt-newsletter-before-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'before_text_spacing',
			[
				'label' => __( 'Spacing', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-newsletter-wrapper .avt-newsletter-before-text'   => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'before_text_typography',
				'label'    => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .avt-newsletter-wrapper .avt-newsletter-before-text',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_after_text',
			[
				'label'     => __( 'After Text', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'after_text!' => '',
				],
			]
		);

		$this->add_control(
			'after_text_color',
			[
				'label'     => __( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-newsletter-wrapper .avt-newsletter-after-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'after_text_spacing',
			[
				'label' => __( 'Spacing', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-newsletter-wrapper .avt-newsletter-after-text'   => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'after_text_typography',
				'label'    => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .avt-newsletter-wrapper .avt-newsletter-after-text',
			]
		);

		$this->end_controls_section();
	}

	public function render_text($settings) {

		$this->add_render_attribute( 'content-wrapper', 'class', 'avt-newsletter-btn-content-wrapper' );

		if ( 'left' == $settings['icon_align'] or 'right' == $settings['icon_align'] ) {
			$this->add_render_attribute( 'content-wrapper', 'class', 'avt-flex avt-flex-middle' );
		}

		$this->add_render_attribute( 'content-wrapper', 'class', ( 'top' == $settings['icon_align'] ) ? 'avt-flex avt-flex-column avt-flex-center' : '' );
		$this->add_render_attribute( 'content-wrapper', 'class', ( 'bottom' == $settings['icon_align'] ) ? 'avt-flex avt-flex-column-reverse avt-flex-center' : '' );

		$this->add_render_attribute( 'icon-align', 'class', 'elementor-align-icon-' . $settings['icon_align'] );
		$this->add_render_attribute( 'icon-align', 'class', 'avt-newsletter-btn-icon' );

		$this->add_render_attribute( 'text', 'class', ['avt-newsletter-btn-text', 'avt-display-inline-block'] );
		$this->add_inline_editing_attributes( 'text', 'none' );

		if ( ! isset( $settings['icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
			// add old default
			$settings['icon'] = 'fas fa-arrow-right';
		}

		$migrated  = isset( $settings['__fa4_migrated']['mailchimp_button_icon'] );
		$is_new    = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();

		?>
		<div <?php echo $this->get_render_attribute_string( 'content-wrapper' ); ?>>
			<?php if ( ! empty( $settings['mailchimp_button_icon']['value'] ) ) : ?>
				<div class="avt-newsletter-btn-icon avt-flex-align-<?php echo esc_attr($settings['icon_align']); ?>">
						
						<?php if ( $is_new || $migrated ) :
							Icons_Manager::render_icon( $settings['mailchimp_button_icon'], [ 'aria-hidden' => 'true', 'class' => 'fa-fw' ] );
						else : ?>
							<i class="<?php echo esc_attr( $settings['icon'] ); ?>" aria-hidden="true"></i>
						<?php endif; ?>

				</div>
			<?php endif; ?>
			<div <?php echo $this->get_render_attribute_string( 'text' ); ?>><?php echo wp_kses( $settings['button_text'], widget_pack_allow_tags('title') ); ?></div>
		</div>
		<?php
	}

	public function render() {
		$settings = $this->get_settings();
		$id       = 'avt-mailchimp-' . $this->get_id();

		$space = ( '' !== $settings['space'] ) ? ' avt-grid-' . $settings['space'] : '';

		if ($settings['button_text']) {
			$button_text = $settings['button_text'];
		} else {
			$button_text = esc_html__( 'Subscribe', 'avator-widget-pack' );
		}

		$this->add_render_attribute( 'input-wrapper', 'class', 'avt-newsletter-input-wrapper' );

		if ($settings['fullwidth_input']) {
			$this->add_render_attribute( 'input-wrapper', 'class', 'avt-width-1-1' );
		} else {
			$this->add_render_attribute( 'input-wrapper', 'class', 'avt-width-expand' );
		}

		if ( ! isset( $settings['before_icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
			// add old default
			$settings['before_icon'] = 'fas fa-envelope-open';
		}

		$migrated  = isset( $settings['__fa4_migrated']['mailchimp_before_icon'] );
		$is_new    = empty( $settings['before_icon'] ) && Icons_Manager::is_migration_allowed();
		
		?>
		<div class="avt-newsletter-wrapper">

	        <?php if ( ! empty( $settings['before_text'] ) ) : ?>
	           <div class="avt-newsletter-before-text"><?php echo esc_attr($settings['before_text']); ?></div>
	        <?php endif; ?>

			<form action="<?php echo site_url() ?>/wp-admin/admin-ajax.php" class="avt-mailchimp avt-grid<?php echo esc_attr($space); ?> avt-flex-middle" avt-grid>
				
				<?php if ( $settings['show_before_icon'] and ! empty( $settings['mailchimp_before_icon']['value'] ) ) : ?>
					<div class="avt-width-auto">
						<div class="avt-newsletter-before-icon">

							<?php if ( $is_new || $migrated ) :
								Icons_Manager::render_icon( $settings['mailchimp_before_icon'], [ 'aria-hidden' => 'true', 'class' => 'fa-fw' ] );
							else : ?>
								<i class="<?php echo esc_attr( $settings['before_icon'] ); ?>" aria-hidden="true"></i>
							<?php endif; ?>

						</div>
					</div>
				<?php endif; ?>

				<div <?php echo $this->get_render_attribute_string( 'input-wrapper' ); ?>>
					<input type="email" name="email" placeholder="<?php echo esc_attr($settings['email_field_placeholder']); ?>" required class="avt-input" />
					<input type="hidden" name="action" value="widget_pack_mailchimp_subscribe" />
					<!-- we need action parameter to receive ajax request in WordPress -->
				</div>
				<?php


				$this->add_render_attribute( 'signup_button', 'class', ['avt-newsletter-btn', 'avt-button', 'avt-button-primary', 'avt-width-1-1'] );				

				if ( $settings['hover_animation'] ) {
					$this->add_render_attribute( 'signup_button', 'class', 'elementor-animation-' . $settings['hover_animation'] );
				}

				?>
				<div class="avt-newsletter-signup-wrapper avt-width-auto">
					<button <?php echo $this->get_render_attribute_string( 'signup_button' ); ?>>
						<?php $this->render_text($settings); ?>
					</button>
				</div>
			</form>

	        <!-- after text -->
	        <?php if ( ! empty( $settings['after_text'] ) ) : ?>
	            <div class="avt-newsletter-after-text"><?php echo esc_attr($settings['after_text']); ?></div>
	        <?php endif; ?>

		</div><!-- end newsletter-signup -->

		
        <?php
	}
}
