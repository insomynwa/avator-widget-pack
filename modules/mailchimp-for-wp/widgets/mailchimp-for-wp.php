<?php
namespace WidgetPack\Modules\MailchimpForWP\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Box_Shadow;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Mailchimp_For_WP extends Widget_Base {

	public function get_name() {
		return 'avt-mailchimp-for-wp';
	}

	public function get_title() {
		return AWP . esc_html__( 'Mailchimp for WP', 'avator-widget-pack' );
	}

	public function get_icon() {
		return 'avt-wi-mailchimp-for-wp';
	}

	public function get_categories() {
		return [ 'widget-pack' ];
	}

	public function get_keywords() {
		return [ 'mailchimp', 'email', 'marketing', 'newsletter', 'mc4wp' ];
	}

	public function get_custom_help_url() {
		return 'https://youtu.be/hClaXvxvkXM';
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'section_content_layout',
			[
				'label' => esc_html__( 'Layout', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'mailchimp_id',
			[
				'label'       => esc_html__( 'Type Mailchimp ID', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( '978', 'avator-widget-pack' ),
				'description' => esc_html__( 'For show ID <a href="admin.php?page=mailchimp-for-wp-forms" target="_blank"> Click here </a>', 'avator-widget-pack' ),
				'label_block' => true,
				'separator'   => 'before',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_input',
			[
				'label' => esc_html__( 'Input', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'input_placeholder_color',
			[
				'label'     => esc_html__( 'Placeholder Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mc4wp-form input[type*="text"]::placeholder'  => 'color: {{VALUE}};',
					'{{WRAPPER}} .mc4wp-form input[type*="email"]::placeholder' => 'color: {{VALUE}};',
					'{{WRAPPER}} .mc4wp-form select[name*="_mc4wp_lists"]'      => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'input_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mc4wp-form input[type*="text"]'  => 'color: {{VALUE}};',
					'{{WRAPPER}} .mc4wp-form input[type*="email"]' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'input_text_background',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mc4wp-form input[type  *="text"]'         => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .mc4wp-form input[type  *="email"]'        => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .mc4wp-form select[name *="_mc4wp_lists"]' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'input_border_show',
			[
				'label'        => esc_html__( 'Border Style', 'avator-widget-pack' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'separator'    => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(), [
				'name'        => 'input_border',
				'label'       => esc_html__( 'Border', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .mc4wp-form input[type*="text"], {{WRAPPER}} .mc4wp-form input[type*="email"], {{WRAPPER}} .mc4wp-form select[name*="_mc4wp_lists"]',
				'condition' => [
					'input_border_show' => 'yes',
				],
			]
		);

		$this->add_control(
			'input_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .mc4wp-form input[type*="text"]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .mc4wp-form input[type*="email"]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .mc4wp-form select[name*="_mc4wp_lists"]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'input_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .mc4wp-form input[type*="text"], {{WRAPPER}} .mc4wp-form input[type*="email"], 
					{{WRAPPER}} .mc4wp-form select[name*="_mc4wp_lists"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);
		
		$this->add_control(
			'fullwidth_input',
			[
				'label'     => esc_html__( 'Fullwidth Input', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'selectors' => [
					'{{WRAPPER}} .mc4wp-form input[type*="email"]'         => 'width: 100%;',
					'{{WRAPPER}} .mc4wp-form input[type*="text"]'          => 'width: 100%;',
					'{{WRAPPER}} .mc4wp-form select[name*="_mc4wp_lists"]' => 'width: 100%;',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_label',
			[
				'label' => esc_html__( 'Label', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_control(
			'label_position_top',
			[
				'label'     => esc_html__( 'Label Position Top', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'selectors' => [
					'{{WRAPPER}} .mc4wp-form label'  => 'display: block;',
				],
			]
		);

		$this->add_control(
			'label_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mc4wp-form label' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'label_margin',
			[
				'label'      => esc_html__( 'Margin', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .mc4wp-form label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'label_typography',
				'label'    => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .mc4wp-form label',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_button',
			[
				'label' => esc_html__( 'Button', 'avator-widget-pack' ),
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
					'{{WRAPPER}} .mc4wp-form input[type*="submit"]' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'background_color',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mc4wp-form input[type*="submit"]' => 'background-color: {{VALUE}};',
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
				'selector'    => '{{WRAPPER}} .mc4wp-form input[type*="submit"]',
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
					'{{WRAPPER}} .mc4wp-form input[type*="submit"]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_box_shadow',
				'selector' => '{{WRAPPER}} .mc4wp-form input[type*="submit"]',
			]
		);

		$this->add_control(
			'text_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .mc4wp-form input[type*="submit"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);
		
		$this->add_control(
			'fullwidth_button',
			[
				'label'     => esc_html__( 'Fullwidth Button', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'selectors' => [
					'{{WRAPPER}} .mc4wp-form input[type*="submit"]'  => 'width: 100%;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'button_typography',
				'label'     => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
				'selector'  => '{{WRAPPER}} .mc4wp-form input[type*="submit"]',
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
					'{{WRAPPER}} .mc4wp-form input[type*="submit"]:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_hover_color',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mc4wp-form input[type*="submit"]:hover' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .mc4wp-form input[type*="submit"]:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_additional_option',
			[
				'label' => esc_html__( 'Additional Option', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'others_type_input_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#666666',
				'selectors' => [
					'{{WRAPPER}} .mc4wp-form label span' => 'color: {{VALUE}};',
					'{{WRAPPER}} .mc4wp-form p'          => 'color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'others_type_input_text_color_typography',
				'label'    => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .mc4wp-form label span',
				'selector' => '{{WRAPPER}} .mc4wp-form p',
			]
		);

		$this->end_controls_section();
	}

	private function get_shortcode() {

		$settings = $this->get_settings();

		$attributes = [
			'id' => $settings['mailchimp_id'],
		];

		$this->add_render_attribute( 'shortcode', $attributes );

		$shortcode   = [];
		$shortcode[] = sprintf( '[mc4wp_form  %s]', $this->get_render_attribute_string( 'shortcode' ) );

		return implode("", $shortcode);
	}

	public function render() {
		echo do_shortcode( $this->get_shortcode() );
	}

	public function render_plain_content() {
		echo $this->get_shortcode();
	}
}
