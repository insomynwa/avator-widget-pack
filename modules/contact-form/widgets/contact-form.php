<?php
namespace WidgetPack\Modules\ContactForm\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Background;
use WidgetPack\Classes\Utils;
use WidgetPack\Widget_Pack_Loader;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Contact_Form extends Widget_Base {

	protected $_has_template_content = false;

	public function get_name() {
		return 'avt-contact-form';
	}

	public function get_title() {
		return AWP . esc_html__( 'Simple Contact Form', 'avator-widget-pack' );
	}

	public function get_icon() {
		return 'avt-wi-simple-contact-form';
	}

	public function get_categories() {
		return [ 'widget-pack' ];
	}

	public function get_keywords() {
		return [ 'simple', 'contact', 'form', 'email' ];
	}

	public function get_script_depends() {

		if (! Widget_Pack_Loader::elementor()->editor->is_edit_mode() ) {
			$ep_api_settings = get_option( 'widget_pack_api_settings' );
			if ( !empty($ep_api_settings['recaptcha_site_key']) and !empty($ep_api_settings['recaptcha_secret_key']) ) {
				return ['recaptcha'];
			}
		}
		return [];
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_forms_layout',
			[
				'label' => esc_html__( 'Forms Layout', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'show_labels',
			[
				'label'   => esc_html__( 'Label', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'contact_number',
			[
				'label' => esc_html__( 'Contact Number Field', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'input_size',
			[
				'label'   => esc_html__( 'Input Size', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default' => esc_html__( 'Default', 'avator-widget-pack' ),
					'small'   => esc_html__( 'Small', 'avator-widget-pack' ),
					'large'   => esc_html__( 'Large', 'avator-widget-pack' ),
				],
			]
		);
		
		$this->add_control(
			'name_email_field_inline',
			[
				'label' => esc_html__( 'Name/Email Field Inline', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_responsive_control(
			'text_align',
			[
				'label'   => esc_html__( 'Text Align', 'avator-widget-pack' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'left',
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
				'selectors'  => [
					'{{WRAPPER}} .avt-contact-form-form'                      => 'text-align: {{VALUE}};',
					'{{WRAPPER}} .avt-contact-form-form input'    => 'text-align: {{VALUE}};',
					'{{WRAPPER}} .avt-contact-form-form textarea' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_submit_button',
			[
				'label' => esc_html__( 'Submit Button', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'button_text',
			[
				'label'   => esc_html__( 'Text', 'avator-widget-pack' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Send Message', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'button_size',
			[
				'label'   => esc_html__( 'Size', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					''           => esc_html__( 'Default', 'avator-widget-pack' ),
					'small'      => esc_html__( 'Small', 'avator-widget-pack' ),
					'large'      => esc_html__( 'Large', 'avator-widget-pack' ),
					'full-width' => esc_html__( 'Full Width', 'avator-widget-pack' ),
				],
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label'   => esc_html__( 'Alignment', 'avator-widget-pack' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => '',
				'options' => [
					'start' => [
						'title' => esc_html__( 'Left', 'avator-widget-pack' ),
						'icon'  => 'fas fa-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'avator-widget-pack' ),
						'icon'  => 'fas fa-align-center',
					],
					'end' => [
						'title' => esc_html__( 'Right', 'avator-widget-pack' ),
						'icon'  => 'fas fa-align-right',
					],
					'stretch' => [
						'title' => esc_html__( 'Justified', 'avator-widget-pack' ),
						'icon'  => 'fas fa-align-justify',
					],
				],
				'prefix_class' => 'elementor%s-button-align-',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_forms_additional_options',
			[
				'label' => esc_html__( 'Additional Options', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'custom_text',
			[
				'label'     => esc_html__( 'Custom Text', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => [
					'show_labels' => 'yes',
				],
			]
		);

		$this->add_control(
			'user_name_heading',
				[
				'label'     => esc_html__( 'Name Field', 'avator-widget-pack' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'show_labels' => 'yes',
					'custom_text' => 'yes',
				],
			]
		);

		$this->add_control(
			'user_name_label',
				[
				'label'       => esc_html__( 'Label', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Name*', 'avator-widget-pack' ),
				'condition'   => [
					'show_labels' => 'yes',
					'custom_text' => 'yes',
				],
			]
		);


		$this->add_control(
			'user_name_placeholder',
			[
				'label'     => esc_html__( 'Placeholder', 'avator-widget-pack' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'John Doe', 'avator-widget-pack' ),
				'condition' => [
					'show_labels' => 'yes',
					'custom_text' => 'yes',
				],
			]
		);

		$this->add_control(
			'contact_heading',
				[
				'label'     => esc_html__( 'Contact Number Field', 'avator-widget-pack' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'show_labels' => 'yes',
					'custom_text' => 'yes',
				],
			]
		);

		$this->add_control(
			'contact_label',
				[
				'label'     => esc_html__( 'Label', 'avator-widget-pack' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Contact Number', 'avator-widget-pack' ),
				'condition' => [
					'show_labels' => 'yes',
					'custom_text' => 'yes',
				],
			]
		);

		$this->add_control(
			'contact_placeholder',
			[
				'label'     => esc_html__( 'Placeholder', 'avator-widget-pack' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Your contact number', 'avator-widget-pack' ),
				'condition' => [
					'show_labels' => 'yes',
					'custom_text' => 'yes',
				],
			]
		);

		$this->add_control(
			'subject_heading',
				[
				'label'     => esc_html__( 'Subject Field', 'avator-widget-pack' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'show_labels' => 'yes',
					'custom_text' => 'yes',
				],
			]
		);

		$this->add_control(
			'subject_label',
				[
				'label'     => esc_html__( 'Label', 'avator-widget-pack' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Subject*', 'avator-widget-pack' ),
				'condition' => [
					'show_labels' => 'yes',
					'custom_text' => 'yes',
				],
			]
		);

		$this->add_control(
			'subject_placeholder',
			[
				'label'     => esc_html__( 'Placeholder', 'avator-widget-pack' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Your message subject', 'avator-widget-pack' ),
				'condition' => [
					'show_labels' => 'yes',
					'custom_text' => 'yes',
				],
			]
		);

		$this->add_control(
			'email_address_heading',
				[
				'label'     => esc_html__( 'Email Field', 'avator-widget-pack' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'show_labels' => 'yes',
					'custom_text' => 'yes',
				],
			]
		);

		$this->add_control(
			'email_address_label',
			[
				'label'     => esc_html__( 'Label', 'avator-widget-pack' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Email*', 'avator-widget-pack' ),
				'condition' => [
					'show_labels' => 'yes',
					'custom_text' => 'yes',
				],
			]
		);

		$this->add_control(
			'email_placeholder',
			[
				'label'     => esc_html__( 'Placeholder', 'avator-widget-pack' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'example@email.com', 'avator-widget-pack' ),
				'condition' => [
					'show_labels' => 'yes',
					'custom_text' => 'yes',
				],
			]
		);

		$this->add_control(
			'message_label_heading',
				[
				'label'     => esc_html__( 'Message Field', 'avator-widget-pack' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'show_labels' => 'yes',
					'custom_text' => 'yes',
				],
			]
		);

		$this->add_control(
			'message_label',
			[
				'label'     => esc_html__( 'Label', 'avator-widget-pack' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Your Message*', 'avator-widget-pack' ),
				'condition' => [
					'show_labels' => 'yes',
					'custom_text' => 'yes',
				],
			]
		);

		$this->add_control(
			'message_placeholder',
			[
				'label'     => esc_html__( 'Placeholder', 'avator-widget-pack' ),
				'type'      => Controls_Manager::TEXT,
				'condition' => [
					'show_labels' => 'yes',
					'custom_text' => 'yes',
				],
				'separator' => 'after',
			]
		);

		$this->add_control(
			'show_additional_message',
			[
				'label'     => esc_html__( 'Additional Bottom Message', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'additional_message',
			[
				'label'     => esc_html__( 'Message', 'avator-widget-pack' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Note: You have to fill-up above all respective field, then click below button for send your message', 'avator-widget-pack' ),
				'condition' => [
					'show_additional_message' => 'yes',
				],
			]
		);

		// $this->add_control(
		// 	'show_recaptcha',
		// 	[
		// 		'label'       => esc_html__( 'reCAPTCHA', 'avator-widget-pack' ),
		// 		'description' => esc_html__( 'Make sure you set the invisible reCAPTCHA key in settings.', 'avator-widget-pack' ),
		// 		'type'        => Controls_Manager::SWITCHER,
		// 	]
		// );

		$this->add_control(
			'hide_recaptcha_badge',
			[
				'label'   => esc_html__( 'Hide reCAPTCHA Bagde', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'prefix_class' => 'avt-hide-recaptcha-badge-',
				// 'condition' => [
				// 	'show_recaptcha' => 'yes',
				// ],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			[
				'label' => esc_html__( 'Form Style', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'row_gap',
			[
				'label'   => esc_html__( 'Field Space', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => '15',
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 60,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-field-group:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};margin-top: 0;',
					'{{WRAPPER}} .avt-name-email-inline + .avt-name-email-inline' => 'padding-left: {{SIZE}}px',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_labels',
			[
				'label'     => esc_html__( 'Label', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_labels!' => '',
				],
			]
		);

		$this->add_control(
			'label_spacing',
			[
				'label' => esc_html__( 'Spacing', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-field-group > label' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'label_color',
			[
				'label'     => esc_html__( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-form-label' => 'color: {{VALUE}};',
				],
				'scheme' => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'label_typography',
				'selector' => '{{WRAPPER}} .avt-form-label',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_field_style',
			[
				'label' => esc_html__( 'Fields', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'tabs_field_style' );

		$this->start_controls_tab(
			'tab_field_normal',
			[
				'label' => esc_html__( 'Normal', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'field_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-field-group .avt-input' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-field-group textarea'   => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'field_placeholder_color',
			[
				'label'     => esc_html__( 'Placeholder Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-field-group .avt-input::placeholder' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-field-group textarea::placeholder'   => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'field_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-field-group .avt-input' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .avt-field-group textarea'   => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'field_border',
				'label'       => esc_html__( 'Border', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-field-group .avt-input, {{WRAPPER}} .avt-field-group textarea',
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'field_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-field-group .avt-input' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .avt-field-group textarea'   => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'field_box_shadow',
				'selector' => '{{WRAPPER}} .avt-field-group .avt-input, {{WRAPPER}} .avt-field-group textarea',
			]
		);

		$this->add_responsive_control(
			'field_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-field-group .avt-input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; height: auto;',
					'{{WRAPPER}} .avt-field-group textarea' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; height: auto;',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'field_typography',
				'label'     => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
				'selector'  => '{{WRAPPER}} .avt-field-group .avt-input, {{WRAPPER}} .avt-field-group textarea',
				'separator' => 'before',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_field_focus',
			[
				'label' => esc_html__( 'Focus', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'field_focus_background',
			[
				'label'     => esc_html__( 'Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-field-group .avt-input:focus' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .avt-field-group textarea:focus'   => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'field_focus_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-field-group .avt-input:focus' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .avt-field-group textarea:focus'   => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'field_border_border!' => '',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_submit_button_style',
			[
				'label' => esc_html__( 'Submit Button', 'avator-widget-pack' ),
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
					'{{WRAPPER}} .avt-button' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'button_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .avt-button',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'button_background_color',
				'separator' => 'before',
				'selector'  => '{{WRAPPER}} .avt-button'
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(), [
				'name'        => 'button_border',
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-button',
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
					'{{WRAPPER}} .avt-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'button_text_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
			'button_hover_color',
			[
				'label'     => esc_html__( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-button:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'button_background_hover_color',
				'separator' => 'before',
				'selector'  => '{{WRAPPER}} .avt-button:hover'
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .avt-button:hover' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'button_border_border!' => '',
				],
			]
		);

		$this->add_control(
			'button_hover_animation',
			[
				'label' => esc_html__( 'Animation', 'avator-widget-pack' ),
				'type' => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_additional_style',
			[
				'label'     => esc_html__( 'Additional Message', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_additional_message!' => '',
				],
			]
		);

		$this->add_control(
			'additional_text_color',
			[
				'name'      => 'additional_text_color',
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),				
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-contact-form-additional-message' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'additional_text_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .avt-contact-form-additional-message',
			]
		);

		$this->end_controls_section();
	}

	public function form_fields_render_attributes() {
		$settings        = $this->get_settings();
		$id              = $this->get_id();
		$ep_api_settings = get_option( 'widget_pack_api_settings' );

		if ( ! empty( $settings['button_size'] ) ) {
			$this->add_render_attribute( 'button', 'class', 'avt-button-' . $settings['button_size'] );
		}

		if ( $settings['button_hover_animation'] ) {
			$this->add_render_attribute( 'button', 'class', 'elementor-animation-' . $settings['button_hover_animation'] );
		}

		$this->add_render_attribute(
			[
				'wrapper' => [
					'class' => [
						'elementor-form-fields-wrapper',
					],
				],
				'field-group' => [
					'class' => [
						'avt-field-group',
						'avt-width-1-1',
					],
				],
				'submit-group' => [
					'class' => [
						'elementor-field-type-submit',
						'avt-field-group',
						'avt-flex',
						'avt-width-1-1',
					],
				],

				'button' => [
					'class' => [
						'elementor-button',
						'avt-button',
						'avt-button-primary',
					],
					'name' => 'submit',
				],
				'user_name_label' => [
					'for'   => 'user_name' . $id,
					'class' => [
						'avt-form-label',
					]
				],
				'contact_label' => [
					'for'   => 'contact' . $id,
					'class' => [
						'avt-form-label',
					]
				],
				'subject_label' => [
					'for'   => 'subject' . $id,
					'class' => [
						'avt-form-label',
					]
				],
				'email_address_label' => [
					'for'   => 'email' . $id,
					'class' => [
						'avt-form-label',
					]
				],
				'message_label' => [
					'for'   => 'message' . $id,
					'class' => [
						'avt-form-label',
					]
				],
				'user_name_input' => [
					'type'        => 'text',
					'name'        => 'name',
					'id'          => 'name' . $id,
					'placeholder' => $settings['user_name_placeholder'],
					'class'       => [
						'avt-input',
						'avt-form-' . $settings['input_size'],
					],
				],
				'contact_input' => [
					'type'        => 'tel',
					'name'        => 'contact',
					'id'          => 'contact' . $id,
					'placeholder' => $settings['contact_placeholder'],
					'class'       => [
						'avt-input',
						'avt-form-' . $settings['input_size'],
					],
				],
				'subject_input' => [
					'type'        => 'text',
					'name'        => 'subject',
					'id'          => 'subject' . $id,
					'placeholder' => $settings['subject_placeholder'],
					'class'       => [
						'avt-input',
						'avt-form-' . $settings['input_size'],
					],
				],
				'email_address_input' => [
					'type'        => 'email',
					'name'        => 'email',
					'id'          => 'email' . $id,
					'placeholder' => $settings['email_placeholder'],
					'class'       => [
						'avt-input',
						'avt-form-' . $settings['input_size'],
					],
				],
				'message_area' => [
					'type'        => 'textarea',
					'name'        => 'message',
					'id'          => 'message' . $id,
					'rows'		  => '5',
					'placeholder' => $settings['message_placeholder'],
					'class'       => [
						'avt-textarea',
						'avt-form-' . $settings['input_size'],
					],
				],
			]
		);

		
		if ( !empty($ep_api_settings['recaptcha_site_key']) and !empty($ep_api_settings['recaptcha_secret_key']) ) {
			$this->add_render_attribute( 'button', 'data-sitekey', $ep_api_settings['recaptcha_site_key']);
			$this->add_render_attribute( 'button', 'data-callback', 'widgetPackGICCB');
			$this->add_render_attribute( 'button', 'class', 'g-recaptcha');
		}
		

		if ( ! $settings['show_labels'] ) {
			$this->add_render_attribute( 'label', 'class', 'elementor-screen-only' );
		}

		$this->add_render_attribute( 'field-group', 'class', 'elementor-field-required' )
			->add_render_attribute( 'input', 'required', true )
			->add_render_attribute( 'input', 'aria-required', 'true' );
	}

	

	public function render() {
		$this->form_fields_render_attributes();

		?>
		<div class="avt-contact-form avt-contact-form-skin-default">
			<div class="elementor-form-fields-wrapper">
				<?php $this->contact_form_html(); ?>
			</div>
		</div>
		<?php
	}

	public function contact_form_html() {
		$settings = $this->get_settings();
		$id       = $this->get_id();

		$this->add_render_attribute( 'contact-form', 'class', ['avt-contact-form-form', 'avt-form-stacked', 'avt-grid', 'avt-grid-small'] );
		$this->add_render_attribute( 'contact-form', 'avt-grid', '' );
		$this->add_render_attribute( 'contact-form', 'action', site_url() . '/wp-admin/admin-ajax.php' );
		$this->add_render_attribute( 'contact-form', 'method', 'post' );
	
		$this->add_render_attribute( 'name-email-field-group', 'class', ['avt-field-group', 'elementor-field-required'] );
		
		if($settings['name_email_field_inline']) {
			$this->add_render_attribute( 'name-email-field-group', 'class', ['avt-width-1-2@m', 'avt-name-email-inline'] );
		} else {
			$this->add_render_attribute( 'name-email-field-group', 'class', 'avt-width-1-1' );
		}

		?>
		<div class="avt-contact-form-wrapper">
			<form <?php echo $this->get_render_attribute_string( 'contact-form' ); ?>>
				<div <?php echo $this->get_render_attribute_string( 'name-email-field-group' ); ?>>
					<?php
					if ( $settings['show_labels'] ) {
						echo '<label ' . $this->get_render_attribute_string( 'user_name_label' ) . '>' . $settings['user_name_label'] . '</label>';
					}
					echo '<div class="avt-form-controls">';
					echo '<input ' . $this->get_render_attribute_string( 'user_name_input' ) . ' required>';
					echo '</div>';

					?>
				</div>

				<div <?php echo $this->get_render_attribute_string( 'name-email-field-group' ); ?>>
					<?php
					if ( $settings['show_labels'] ) :
						echo '<label ' . $this->get_render_attribute_string( 'email_address_label' ) . '>' . $settings['email_address_label'] . '</label>';
					endif;
					echo '<div class="avt-form-controls">';
					echo '<input ' . $this->get_render_attribute_string( 'email_address_input' ) . ' required>';
					echo '</div>';
					?>
				</div>

				<?php if ( $settings['contact_number'] ) : ?>
					<div <?php echo $this->get_render_attribute_string( 'field-group' ); ?>>
						<?php
						if ( $settings['show_labels'] ) {
							echo '<label ' . $this->get_render_attribute_string( 'contact_label' ) . '>' . $settings['contact_label'] . '</label>';
						}
						echo '<div class="avt-form-controls">';
						echo '<input ' . $this->get_render_attribute_string( 'contact_input' ) . '>';
						echo '</div>';

						?>
					</div>
				<?php endif; ?>

				<div <?php echo $this->get_render_attribute_string( 'field-group' ); ?>>
					<?php
					if ( $settings['show_labels'] ) {
						echo '<label ' . $this->get_render_attribute_string( 'subject_label' ) . '>' . $settings['subject_label'] . '</label>';
					}
					echo '<div class="avt-form-controls">';
					echo '<input ' . $this->get_render_attribute_string( 'subject_input' ) . ' required>';
					echo '</div>';

					?>
				</div>

				<div <?php echo $this->get_render_attribute_string( 'field-group' ); ?>>
					<?php
					if ( $settings['show_labels'] ) :
						echo '<label ' . $this->get_render_attribute_string( 'message_label' ) . '>' . $settings['message_label'] . '</label>';
					endif;
					echo '<div class="avt-form-controls">';
					echo '<textarea ' . $this->get_render_attribute_string( 'message_area' ) . ' required></textarea>';
					echo '</div>';
					?>
				</div>
				
				<?php if ( 'yes' === $settings['show_additional_message'] ) : ?>
					<div <?php echo $this->get_render_attribute_string( 'field-group' ); ?>>
						<span class="avt-contact-form-additional-message"><?php echo wp_kses( $settings['additional_message'], widget_pack_allow_tags('title') ); ?></span>
					</div>
				<?php endif; ?>
				
				<div <?php echo $this->get_render_attribute_string( 'submit-group' ); ?>>
					<button type="submit" <?php echo $this->get_render_attribute_string( 'button' ); ?>>
						<?php if ( ! empty( $settings['button_text'] ) ) : ?>
							<span><?php echo esc_html($settings['button_text']); ?></span>
						<?php endif; ?>
					</button>
				</div>		
				
				<input type="hidden" name="action" value="widget_pack_contact_form" />
			</form>
		</div>
		<?php
	}
}
