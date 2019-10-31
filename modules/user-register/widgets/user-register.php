<?php
namespace WidgetPack\Modules\UserRegister\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Scheme_Color;

use WidgetPack\Modules\UserRegister\Skins;
use WidgetPack\Widget_Pack_Loader;

use WidgetPack\Modules\UserRegister\Module;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class User_Register extends Widget_Base {

	public function get_name() {
		return 'avt-user-register';
	}

	public function get_title() {
		return AWP . esc_html__( 'User Register', 'avator-widget-pack' );
	}

	public function get_icon() {
		return 'avt-wi-user-register';
	}

	public function get_categories() {
		return [ 'widget-pack' ];
	}

	public function get_keywords() {
		return [ 'user', 'register', 'form' ];
	}

	public function get_script_depends() {
		return [ 'avt-uikit-icons' ];
	}

	protected function _register_skins() {
		$this->add_skin( new Skins\Skin_Dropdown( $this ) );
		$this->add_skin( new Skins\Skin_Modal( $this ) );
	}

	protected function _register_controls() {
		$this->register_layout_section_controls();
	}

	private function register_layout_section_controls() {
		$this->start_controls_section(
			'section_forms_layout',
			[
				'label' => esc_html__( 'Forms Layout', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'labels_title',
			[
				'label'     => esc_html__( 'Labels', 'avator-widget-pack' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
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
			'fields_title',
			[
				'label' => esc_html__( 'Fields', 'avator-widget-pack' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'input_size',
			[
				'label'   => esc_html__( 'Input Size', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'small'   => esc_html__( 'Small', 'avator-widget-pack' ),
					'default' => esc_html__( 'Default', 'avator-widget-pack' ),
					'large'   => esc_html__( 'Large', 'avator-widget-pack' ),
				],
				'default' => 'default',
			]
		);

		$this->add_control(
			'button_title',
			[
				'label'     => esc_html__( 'Submit Button', 'avator-widget-pack' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'button_text',
			[
				'label'   => esc_html__( 'Text', 'avator-widget-pack' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Register', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'button_size',
			[
				'label'   => esc_html__( 'Size', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'small' => esc_html__( 'Small', 'avator-widget-pack' ),
					''      => esc_html__( 'Default', 'avator-widget-pack' ),
					'large' => esc_html__( 'Large', 'avator-widget-pack' ),
				],
				'default' => '',
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label'   => esc_html__( 'Alignment', 'avator-widget-pack' ),
				'type'    => Controls_Manager::CHOOSE,
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
				'default'      => '',
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
			'redirect_after_register',
			[
				'label' => esc_html__( 'Redirect After Register', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'redirect_url',
			[
				'type'          => Controls_Manager::URL,
				'show_label'    => false,
				'show_external' => false,
				'separator'     => false,
				'placeholder'   => 'http://your-link.com/',
				'description'   => esc_html__( 'Note: Because of security reasons, you can ONLY use your current domain here.', 'avator-widget-pack' ),
				'condition'     => [
					'redirect_after_register' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_lost_password',
			[
				'label'   => esc_html__( 'Lost your password?', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		
		$this->add_control(
			'show_login',
			[
				'label' => esc_html__( 'Login', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);
		

		$this->add_control(
			'show_logged_in_message',
			[
				'label'   => esc_html__( 'Logged in Message', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'custom_labels',
			[
				'label'     => esc_html__( 'Custom Label', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => [
					'show_labels' => 'yes',
				],
			]
		);


		$this->add_control(
			'first_name_label',
				[
				'label'     => esc_html__( 'First Name Label', 'avator-widget-pack' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'First Name', 'avator-widget-pack' ),
				'condition' => [
					'show_labels'   => 'yes',
					'custom_labels' => 'yes',
				],
			]
		);


		$this->add_control(
			'first_name_placeholder',
			[
				'label'     => esc_html__( 'First Name Placeholder', 'avator-widget-pack' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'John', 'avator-widget-pack' ),
				'condition' => [
					'show_labels'   => 'yes',
					'custom_labels' => 'yes',
				],
			]
		);

		$this->add_control(
			'last_name_label',
				[
				'label'     => esc_html__( 'Last Name Label', 'avator-widget-pack' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Last Name', 'avator-widget-pack' ),
				'condition' => [
					'show_labels'   => 'yes',
					'custom_labels' => 'yes',
				],
			]
		);

		$this->add_control(
			'last_name_placeholder',
			[
				'label'     => esc_html__( 'Last Name Placeholder', 'avator-widget-pack' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Doe', 'avator-widget-pack' ),
				'condition' => [
					'show_labels'   => 'yes',
					'custom_labels' => 'yes',
				],
			]
		);

		$this->add_control(
			'email_label',
			[
				'label'     => esc_html__( 'Email Label', 'avator-widget-pack' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Email', 'avator-widget-pack' ),
				'condition' => [
					'show_labels' => 'yes',
					'custom_labels' => 'yes',
				],
			]
		);

		$this->add_control(
			'email_placeholder',
			[
				'label'     => esc_html__( 'Email Placeholder', 'avator-widget-pack' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'example@email.com', 'avator-widget-pack' ),
				'condition' => [
					'show_labels'   => 'yes',
					'custom_labels' => 'yes',
				],
			]
		);


		$this->add_control(
			'show_additional_message',
			[
				'label' => esc_html__( 'Additional Bottom Message', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'additional_message',
			[
				'label'     => esc_html__( 'Additional Message', 'avator-widget-pack' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Note: Your password will be generated automatically and sent to your email address.', 'avator-widget-pack' ),
				'condition' => [
					'show_additional_message' => 'yes',
				],
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

		$this->add_control(
			'row_gap',
			[
				'label'   => esc_html__( 'Rows Gap', 'avator-widget-pack' ),
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
					'#avt-user-register{{ID}} .avt-field-group:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'links_color',
			[
				'label'     => esc_html__( 'Links Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'#avt-user-register{{ID}} .avt-field-group > a'                                 => 'color: {{VALUE}};',
					'#avt-user-register{{ID}} .avt-user-register-password a:not(:last-child):after' => 'background-color: {{VALUE}};',
				],
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				],
			]
		);

		$this->add_control(
			'links_hover_color',
			[
				'label'     => esc_html__( 'Links Hover Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'#avt-user-register{{ID}} .avt-field-group > a:hover' => 'color: {{VALUE}};',
				],
				'scheme' => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_4,
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
					'#avt-user-register{{ID}} .avt-field-group > label' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'label_color',
			[
				'label'     => esc_html__( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'#avt-user-register{{ID}} .avt-form-label' => 'color: {{VALUE}};',
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
				'selector' => '#avt-user-register{{ID}} .avt-form-label',
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
					'#avt-user-register{{ID}} .avt-field-group .avt-input' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'field_placeholder_color',
			[
				'label'     => esc_html__( 'Placeholder Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'#avt-user-register{{ID}} .avt-field-group .avt-input::placeholder'      => 'color: {{VALUE}};',
					'#avt-user-register{{ID}} .avt-field-group .avt-input::-moz-placeholder' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'field_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'#avt-user-register{{ID}} .avt-field-group .avt-input,
					#avt-user-register{{ID}} .avt-field-group .avt-checkbox' => 'background-color: {{VALUE}};',
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
				'selector'    => '#avt-user-register{{ID}} .avt-field-group .avt-input',
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
					'#avt-user-register{{ID}} .avt-field-group .avt-input' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'field_box_shadow',
				'selector' => '#avt-user-register{{ID}} .avt-field-group .avt-input',
			]
		);

		$this->add_control(
			'field_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'#avt-user-register{{ID}} .avt-field-group .avt-input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; height: auto;',
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
				'selector'  => '#avt-user-register{{ID}} .avt-field-group .avt-input',
				'separator' => 'before',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_field_hover',
			[
				'label' => esc_html__( 'Focus', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'field_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'field_border_border!' => '',
				],
				'selectors' => [
					'#avt-user-register{{ID}} .avt-field-group .avt-input:focus' => 'border-color: {{VALUE}};',
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
					'#avt-user-register{{ID}} .avt-button' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'button_typography',
				'selector' => '#avt-user-register{{ID}} .avt-button',
			]
		);

		$this->add_control(
			'button_background_color',
			[
				'label'  => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'   => Controls_Manager::COLOR,
				'scheme' => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_4,
				],
				'selectors' => [
					'#avt-user-register{{ID}} .avt-button' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(), [
				'name'        => 'button_border',
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '#avt-user-register{{ID}} .avt-button',
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
					'#avt-user-register{{ID}} .avt-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'button_text_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'#avt-user-register{{ID}} .avt-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'#avt-user-register{{ID}} .avt-button:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_hover_color',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'#avt-user-register{{ID}} .avt-button:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'#avt-user-register{{ID}} .avt-button:hover' => 'border-color: {{VALUE}};',
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
				'type'  => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_additional_style',
			[
				'label'     => esc_html__( 'Additional', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_additional_message!' => '',
				],
			]
		);

		$this->add_control(
			'additional_text_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'#avt-user-register{{ID}} .avt-register-additional-message' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'additional_text_typography',
				'label'     => esc_html__( 'Additional Message Typography', 'avator-widget-pack' ),
				'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
				'selector'  => '#avt-user-register{{ID}} .avt-register-additional-message',
				'separator' => 'before',
			]
		);

		$this->end_controls_section();
	}


	public function form_fields_render_attributes() {
		$settings = $this->get_settings();
		$id       = $this->get_id();

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
				'first_name_label' => [
					'for'   => 'first_name' . esc_attr($id),
					'class' => [
						'avt-form-label',
					]
				],
				'last_name_label' => [
					'for'   => 'last_name' . esc_attr($id),
					'class' => [
						'avt-form-label',
					]
				],
				'email_label' => [
					'for'   => 'user_email' . esc_attr($id),
					'class' => [
						'avt-form-label',
					]
				],
				'first_name_input' => [
					'type'        => 'text',
					'name'        => 'first_name',
					'id'          => 'first_name' . esc_attr($id),
					'placeholder' => $settings['first_name_placeholder'],
					'class'       => [
						'avt-input',
						'avt-form-' . $settings['input_size'],
					],
				],
				'last_name_input' => [
					'type'        => 'text',
					'name'        => 'last_name',
					'id'          => 'last_name' . esc_attr($id),
					'placeholder' => $settings['last_name_placeholder'],
					'class'       => [
						'avt-input',
						'avt-form-' . $settings['input_size'],
					],
				],
				'email_address_input' => [
					'type'        => 'email',
					'name'        => 'user_email',
					'id'          => 'user_email' . esc_attr($id),
					'placeholder' => $settings['email_placeholder'],
					'class'       => [
						'avt-input',
						'avt-form-' . $settings['input_size'],
					],
				],
			]
		);

		if ( ! $settings['show_labels'] ) {
			$this->add_render_attribute( 'label', 'class', 'elementor-screen-only' );
		}

		$this->add_render_attribute( 'field-group', 'class', 'elementor-field-required' )
			->add_render_attribute( 'input', 'required', true )
			->add_render_attribute( 'input', 'aria-required', 'true' );

	}

	public function render() {
		$settings    = $this->get_settings();
		$current_url = remove_query_arg( 'fake_arg' );

		if ( is_user_logged_in() && ! Widget_Pack_Loader::elementor()->editor->is_edit_mode() ) {
			if ( $settings['show_logged_in_message'] ) {
				$current_user = wp_get_current_user();

				echo '<div class="avt-user-register">' .
					sprintf( __( 'You are Logged in as %1$s (<a href="%2$s">Logout</a>)', 'avator-widget-pack' ), $current_user->display_name, wp_logout_url( $current_url ) ) .
					'</div>';
			}

			return;

		} elseif ( !get_option('users_can_register') ) {
			?>
				<div class="avt-alert avt-alert-warning" avt-alert>
				    <a class="avt-alert-close" avt-close></a>
				    <p><?php esc_html_e( 'Registration option not enbled in your general settings.', 'avator-widget-pack' ); ?></p>
				</div>
			<?php 
			return;
		}		

		$this->form_fields_render_attributes();

		?>
		<div class="avt-user-register avt-user-register-skin-default">
			<div class="elementor-form-fields-wrapper">
				<?php $this->user_register_form(); ?>
			</div>
		</div>

		<?php

		$this->user_register_ajax_script();		
	}

	public function user_register_form() {
		$settings    = $this->get_settings();

		$id          = $this->get_id();
		$current_url = remove_query_arg( 'fake_arg' );

		if ( $settings['redirect_after_register'] && ! empty( $settings['redirect_url']['url'] ) ) {
			$redirect_url = $settings['redirect_url']['url'];
		} else {
			$redirect_url = $current_url;
		}

		?>
		<form id="avt-user-register<?php echo esc_attr($id); ?>" class="avt-form-stacked avt-width-1-1" method="post" action="<?php echo wp_registration_url(); ?>">
			<div <?php echo $this->get_render_attribute_string( 'field-group' ); ?>>
				<?php
				if ( $settings['show_labels'] ) {
					echo '<label ' . $this->get_render_attribute_string( 'first_name_label' ) . '>' . $settings['first_name_label'] . '</label>';
				}
				echo '<div class="avt-form-controls">';
				echo '<input ' . $this->get_render_attribute_string( 'first_name_input' ) . ' required>';
				echo '</div>';

			?>
			</div>

			<div <?php echo $this->get_render_attribute_string( 'field-group' ); ?>>
				<?php
				if ( $settings['show_labels'] ) {
					echo '<label ' . $this->get_render_attribute_string( 'last_name_label' ) . '>' . $settings['last_name_label'] . '</label>';
				}
				echo '<div class="avt-form-controls">';
				echo '<input ' . $this->get_render_attribute_string( 'last_name_input' ) . ' required>';
				echo '</div>';

				?>
			</div>

			<div <?php echo $this->get_render_attribute_string( 'field-group' ); ?>>
				<?php
				if ( $settings['show_labels'] ) :
					echo '<label ' . $this->get_render_attribute_string( 'email_label' ) . '>' . $settings['email_label'] . '</label>';
				endif;
				echo '<div class="avt-form-controls">';
				echo '<input ' . $this->get_render_attribute_string( 'email_address_input' ) . ' required>';
				echo '</div>';
				?>
			</div>
			
			<?php if ( $settings['show_additional_message'] ) : ?>
			<div <?php echo $this->get_render_attribute_string( 'field-group' ); ?>>
				<span class="avt-register-additional-message"><?php echo wp_kses( $settings['additional_message'], widget_pack_allow_tags('text') ); ?></span>
			</div>
			<?php endif; ?>
			
			<div <?php echo $this->get_render_attribute_string( 'submit-group' ); ?>>
				<button type="submit" <?php echo $this->get_render_attribute_string( 'button' ); ?>>
					<?php if ( ! empty( $settings['button_text'] ) ) : ?>
						<span><?php echo wp_kses( $settings['button_text'], widget_pack_allow_tags('title') ); ?></span>
					<?php endif; ?>
				</button>
			</div>

			<?php
			$show_lost_password = $settings['show_lost_password'];
			$show_login         = $settings['show_login'];

			if ( $show_lost_password || $show_login ) : ?>
				<div class="avt-field-group avt-width-1-1 avt-margin-remove-bottom avt-user-register-password">
					   
					<?php if ( $show_lost_password ) : ?>
						<a class="avt-lost-password" href="<?php echo wp_lostpassword_url( $redirect_url ); ?>">
							<?php esc_html_e( 'Lost your password?', 'avator-widget-pack' ); ?>
						</a>
					<?php endif; ?>

					<?php if ( $show_login ) : ?>
						<a class="avt-login" href="<?php echo wp_login_url(); ?>">
							<?php esc_html_e( 'Login', 'avator-widget-pack' ); ?>
						</a>
					<?php endif; ?>
					
				</div>
			<?php endif; ?>
			
			<?php wp_nonce_field( 'ajax-login-nonce', 'avt-user-register-sc' ); ?>

		</form>
		<?php
	}

	public function user_register_ajax_script() { 
		$settings = $this->get_settings();
		$id       = $this->get_id();

		?>
		<script type="text/javascript">
			jQuery(document).ready(function($) {
				"use strict";
				var register_form = 'form#avt-user-register<?php echo esc_attr($id); ?>';
			    // Perform AJAX register on form submit
			    $(register_form).on('submit', function(e){
			        avtUIkit.notification({message: '<div avt-spinner></div> <?php esc_html_e( "We are registering you, please wait...", "avator-widget-pack" ); ?>', timeout: false});
			        $(register_form + ' button.avt-button').attr("disabled", true);
			        $.ajax({
			            type: 'POST',
			            dataType: 'json',
			            url: widget_pack_ajax_login_config.ajaxurl,
			            data: { 
			                'action': 'widget_pack_ajax_register', //calls wp_ajax_nopriv_widget_pack_ajax_register
			                'first_name': $(register_form + ' #first_name<?php echo esc_attr($id); ?>').val(), 
			                'last_name': $(register_form + ' #last_name<?php echo esc_attr($id); ?>').val(), 
			                'email': $(register_form + ' #user_email<?php echo esc_attr($id); ?>').val(), 
			                'security': $(register_form + ' #avt-user-register-sc').val() 
			            },
			            success: function(data) {
			                if (data.registered == true){
			                	avtUIkit.notification.closeAll();
			                	avtUIkit.notification({message: '<div class="avt-flex"><span avt-icon=\'icon: info\'></span><span>' + data.message + '</span></div>', status: 'primary'});
			                	<?php if ( $settings['redirect_after_register'] && ! empty( $settings['redirect_url']['url'] ) ) : ?>
									<?php $redirect_url = $settings['redirect_url']['url']; ?>
			                    	document.location.href = '<?php echo esc_url( $redirect_url ); ?>';
			                	<?php endif; ?>
			                } else {
			                	avtUIkit.notification.closeAll();
			                	avtUIkit.notification({message: '<div class="avt-flex"><span avt-icon=\'icon: warning\'></span><span>' + data.message + '</span></div>', status: 'warning'});
			                }
			        		$(register_form + ' button.avt-button').removeAttr("disabled");
			            },
			        });
			        e.preventDefault();
			    });
			});
		</script>
		<?php
	}
}