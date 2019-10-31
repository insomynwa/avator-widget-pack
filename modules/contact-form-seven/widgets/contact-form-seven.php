<?php
namespace WidgetPack\Modules\ContactFormSeven\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Box_Shadow;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Contact_Form_Seven extends Widget_Base {

	protected $_has_template_content = false;

	public function get_name() {
		return 'avt-contact-form-7';
	}

	public function get_title() {
		return AWP . esc_html__( 'Contact Form 7', 'avator-widget-pack' );
	}

	public function get_icon() {
		return 'avt-wi-contact-form-7';
	}

	public function get_categories() {
		return [ 'widget-pack' ];
	}

	public function get_keywords() {
		return [ 'contact', 'form', 'email' ];
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_content_layout',
			[
				'label' => esc_html__( 'Layout', 'avator-widget-pack' ),
			]
		);


		$cf7 = get_posts( 'post_type="wpcf7_contact_form"&numberposts=-1' );

		$contact_forms = array();
		if ( $cf7 ) {
			foreach ( $cf7 as $cform ) {
				$contact_forms[ $cform->ID ] = $cform->post_title;
			}
		} else {
			$contact_forms[ esc_html__( 'No contact forms found', 'avator-widget-pack' ) ] = 0;
		}

		$this->add_control(
			'contact_form',
			[
				'label'     => esc_html__( 'Select Form', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => $contact_forms,
			]
		);

		$this->add_responsive_control(
			'space_between',
			[
				'label'   => __( 'Space Between', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0
				],
				'selectors' => [
					'{{WRAPPER}} .wpcf7-form > p:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};'
				]
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
			'label_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wpcf7-form label' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'label_typography',
				'label' => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .wpcf7-form label',
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
					'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input::placeholder' => 'color: {{VALUE}};',
					'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap textarea::placeholder' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'input_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input' => 'color: {{VALUE}};',
					'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap .wpcf7-textarea' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'others_type_input_text_color',
			[
				'label'     => esc_html__( 'Others Type Input Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'      => '#666666',
				'selectors' => [
					'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap.select-state' => 'color: {{VALUE}};',
					'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap.select-gender' => 'color: {{VALUE}};',
					'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap.accept-this-1' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'input_text_background',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap .wpcf7-textarea' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'textarea_height',
			[
				'label' => esc_html__( 'Textarea Height', 'avator-widget-pack' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 125,
				],
				'range' => [
					'px' => [
						'min' => 30,
						'max' => 500,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wpcf7-form .wpcf7-textarea' => 'height: {{SIZE}}{{UNIT}}; display: block;',
				],
				'separator' => 'before',

			]
		);

		$this->add_control(
			'input_padding',
			[
				'label' => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input, {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap .wpcf7-textarea, {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap .wpcf7-select' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'input_space',
			[
				'label' => esc_html__( 'Element Space', 'avator-widget-pack' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 25,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wpcf7-form-control' => 'margin-top: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .wpcf7-form' => 'margin-top: -{{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'input_border_show',
			[
				'label' => esc_html__( 'Border Style', 'avator-widget-pack' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'label_on' => 'Hide',
				'label_off' => 'Show',
				'return_value' => 'yes',
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(), [
				'name'        => 'input_border',
				'label'       => esc_html__( 'Border', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input, {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap textarea, {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap .wpcf7-select',
				'condition' => [
					'input_border_show' => 'yes',
				],
			]
		);

		$this->add_control(
			'input_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'avator-widget-pack' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap textarea' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap .wpcf7-select' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'section_style_submit_button',
			[
				'label' => esc_html__( 'Submit Button', 'avator-widget-pack' ),
				'tab' => Controls_Manager::TAB_STYLE,
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
				'label' => esc_html__( 'Text Color', 'avator-widget-pack' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .wpcf7-form .wpcf7-submit' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'background_color',
			[
				'label' => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wpcf7-form .wpcf7-submit' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'label' => esc_html__( 'Border', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default' => '1px',
				'selector' => '{{WRAPPER}} .wpcf7-form .wpcf7-submit',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'avator-widget-pack' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .wpcf7-form .wpcf7-submit' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'button_box_shadow',
				'selector' => '{{WRAPPER}} .wpcf7-submit',
			]
		);

		$this->add_control(
			'text_padding',
			[
				'label' => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .wpcf7-form .wpcf7-submit' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'button_typography',
				'label' => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .wpcf7-form .wpcf7-submit',
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
				'label' => esc_html__( 'Text Color', 'avator-widget-pack' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wpcf7-form .wpcf7-submit:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_hover_color',
			[
				'label' => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wpcf7-form .wpcf7-submit:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label' => esc_html__( 'Border Color', 'avator-widget-pack' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .wpcf7-form .wpcf7-submit:hover' => 'border-color: {{VALUE}};',
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
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_control(
			'fullwidth_input',
			[
				'label' => esc_html__( 'Fullwidth Input', 'avator-widget-pack' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'avator-widget-pack' ),
				'label_off' => esc_html__( 'Off', 'avator-widget-pack' ),
				'selectors' => [
					'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="text"]'   => 'width: 100%;',
					'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="email"]'  => 'width: 100%;',
					'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="url"]'    => 'width: 100%;',
					'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="number"]' => 'width: 100%;',
					'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="tel"]'    => 'width: 100%;',
					'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="date"]'   => 'width: 100%;',
					'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap .wpcf7-select'         => 'width: 100%;',
				],
			]
		);
		
		$this->add_control(
			'fullwidth_textarea',
			[
				'label' => esc_html__( 'Fullwidth Texarea', 'avator-widget-pack' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'avator-widget-pack' ),
				'label_off' => esc_html__( 'Off', 'avator-widget-pack' ),
				'selectors' => [
					'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap textarea' => 'width: 100%;',
				],
			]
		);
		
		$this->add_control(
			'fullwidth_button',
			[
				'label' => esc_html__( 'Fullwidth Button', 'avator-widget-pack' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'avator-widget-pack' ),
				'label_off' => esc_html__( 'Off', 'avator-widget-pack' ),
				'selectors' => [
					'{{WRAPPER}} .wpcf7-form .wpcf7-submit' => 'width: 100%;',
				],
			]
		);

		$this->end_controls_section();

	}

	private function get_shortcode() {
		$settings = $this->get_settings();

		if (!$settings['contact_form']) {
			return '<div class="avt-alert avt-alert-warning">'.__('Please select a Contact Form From Setting!', 'avator-widget-pack').'</div>';
		}

		$attributes = [
			'id'	=> $settings['contact_form'],
		];

		$this->add_render_attribute( 'shortcode', $attributes );

		$shortcode   = [];
		$shortcode[] = sprintf( '[contact-form-7 %s]', $this->get_render_attribute_string( 'shortcode' ) );

		return implode("", $shortcode);
	}

	public function render() {
		echo do_shortcode( $this->get_shortcode() );
	}

	public function render_plain_content() {
		echo $this->get_shortcode();
	}
}
