<?php
namespace WidgetPack\Modules\UserLogin\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Scheme_Color;

use Elementor\Icons_Manager;
use Elementor\Core\Files\Assets\Svg\Svg_Handler;

use WidgetPack\Modules\UserLogin\Module;
use WidgetPack\Modules\UserLogin\Skins;
use WidgetPack\Widget_Pack_Loader;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class User_Login extends Widget_Base {

	public function get_name() {
		return 'avt-user-login';
	}

	public function get_title() {
		return AWP . esc_html__( 'User Login', 'avator-widget-pack' );
	}

	public function get_icon() {
		return 'avt-wi-user-login';
	}

	public function get_categories() {
		return [ 'widget-pack' ];
	}

	public function get_keywords() {
		return [ 'user', 'login', 'form' ];
	}

	public function get_style_depends() {
		return [ 'widget-pack-font' ];
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
				'default' => esc_html__( 'Log In', 'avator-widget-pack' ),
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
				'condition' => [
					'_skin!' => ['avt-modal'],
				],
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
			'redirect_after_login',
			[
				'label' => esc_html__( 'Redirect After Login', 'avator-widget-pack' ),
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
					'redirect_after_login' => 'yes',
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

		if ( get_option( 'users_can_register' ) ) {
			$this->add_control(
				'show_register',
				[
					'label'   => esc_html__( 'Register', 'avator-widget-pack' ),
					'type'    => Controls_Manager::SWITCHER,
					'default' => 'yes',
				]
			);

			$this->add_control(
				'custom_register',
				[
					'label'   => esc_html__( 'Custom Register URL', 'avator-widget-pack' ),
					'type'    => Controls_Manager::SWITCHER,
                    'condition'     => [
                        'show_register' => 'yes',
                    ],
				]
			);
            $this->add_control(
                'custom_register_url',
                [
                    'type'          => Controls_Manager::URL,
                    'show_label'    => false,
                    'show_external' => false,
                    'separator'     => false,
                    'placeholder'   => 'http://your-link.com/',
                    'condition'     => [
                        'custom_register' => 'yes',
                    ],
                ]
            );
		}

		$this->add_control(
			'show_remember_me',
			[
				'label'   => esc_html__( 'Remember Me', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
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
			'show_custom_message',
			[
				'label'   => esc_html__( 'Custom Welcome Message', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
                'condition' => [
                    'show_logged_in_message'   => 'yes',
                ],
			]
		);

        $this->add_control(
            'logged_in_custom_message',
            [
                'label'     => esc_html__( 'Custom Message', 'avator-widget-pack' ),
                'type'      => Controls_Manager::TEXT,
                'default'   => esc_html__( 'Hey,', 'avator-widget-pack' ),
                'condition' => [
                    'show_logged_in_message'   => 'yes',
                    'show_custom_message'   => 'yes',
                ],
            ]
        );

		$this->add_control(
			'show_avatar_in_button',
			[
				'label'   => esc_html__( 'Avatar in Button', 'avator-widget-pack' ),
				'description'   => esc_html__( 'When user logged in this avatar shown in dropdown/modal button.', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
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
			'user_label',
				[
				'label'     => esc_html__( 'Username Label', 'avator-widget-pack' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Username or Email', 'avator-widget-pack' ),
				'condition' => [
					'show_labels'   => 'yes',
					'custom_labels' => 'yes',
				],
			]
		);

		$this->add_control(
			'user_placeholder',
			[
				'label'     => esc_html__( 'Username Placeholder', 'avator-widget-pack' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Username or Email', 'avator-widget-pack' ),
				'condition' => [
					'show_labels'   => 'yes',
					'custom_labels' => 'yes',
				],
			]
		);

		$this->add_control(
			'password_label',
			[
				'label'     => esc_html__( 'Password Label', 'avator-widget-pack' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Password', 'avator-widget-pack' ),
				'condition' => [
					'show_labels'   => 'yes',
					'custom_labels' => 'yes',
				],
			]
		);

		$this->add_control(
			'password_placeholder',
			[
				'label'     => esc_html__( 'Password Placeholder', 'avator-widget-pack' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Password', 'avator-widget-pack' ),
				'condition' => [
					'show_labels'   => 'yes',
					'custom_labels' => 'yes',
				],
			]
		);


		$this->add_responsive_control(
			'dropdown_width',
			[
				'label' => esc_html__( 'Dropdown Width', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 180,
						'max' => 450,
					],
				],
				'separator' => 'before',
				'condition' => [
					'_skin' => ['avt-dropdown'],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-user-login-skin-dropdown .avt-dropdown' => 'min-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'dropdown_offset',
			[
				'label' => esc_html__( 'Dropdown Offset', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				//'separator' => 'before',
				'condition' => [
					'_skin' => ['avt-dropdown', 'avt-modal'],
				],
			]
		);

		$this->add_control(
			'dropdown_position',
			[
				'label'   => esc_html__( 'Dropdown Position', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'bottom-right',
				'options' => widget_pack_drop_position(),
				'condition' => [
					'_skin' => ['avt-dropdown', 'avt-modal'],
				],
			]
		);

		$this->add_control(
			'dropdown_mode',
			[
				'label'   => esc_html__( 'Dropdown Mode', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'hover',
				'options' => [
					'hover' => esc_html__('Hover', 'avator-widget-pack'),
					'click' => esc_html__('Clicked', 'avator-widget-pack'),
				],
				'condition' => [
					'_skin' => ['avt-dropdown', 'avt-modal'],
				],
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'section_content_custom_nav',
			[
				'label' => esc_html__( 'Logged Dropdown Menu', 'avator-widget-pack' ),
				'condition' => [
					'_skin' => ['avt-dropdown', 'avt-modal'],
				],
			]
		);

		$this->add_control(
			'custom_navs',
			[
				'label'   => esc_html__( 'Dropdown Menus', 'avator-widget-pack' ),
				'type'    => Controls_Manager::REPEATER,
				'default' => [
					[
						'custom_nav_title' => esc_html__( 'Billing', 'avator-widget-pack' ),
						'custom_nav_icon'  => ['value' => 'fas fa-dollar-sign', 'library' => 'fa-solid'],
						'custom_nav_link'  => [
							'url' => esc_html__( '#', 'avator-widget-pack' ),
						] 
					],
					[
						'custom_nav_title' => esc_html__( 'Settings', 'avator-widget-pack' ),
						'custom_nav_icon'  => ['value' => 'fas fa-cog', 'library' => 'fa-solid'],
						'custom_nav_link'  => [
							'url' => esc_html__( '#', 'avator-widget-pack' ),
						]
					],
					[
						'custom_nav_title' => esc_html__( 'Support', 'avator-widget-pack' ),
						'custom_nav_icon'  => ['value' => 'far fa-life-ring', 'library' => 'fa-regular'],
						'custom_nav_link'  => [
							'url' => esc_html__( '#', 'avator-widget-pack' ),
						]
					],
				],
				'fields' => [
					[
						'name'    => 'custom_nav_title',
						'label'   => esc_html__( 'Title', 'avator-widget-pack' ),
						'type'    => Controls_Manager::TEXT,
						'default' => esc_html__( 'Title' , 'avator-widget-pack' ),
						'dynamic'     => [ 'active' => true ],
					],
					[
						'name'    => 'custom_nav_icon',
						'label'   => esc_html__( 'Icon', 'avator-widget-pack' ),
						'type'        => Controls_Manager::ICONS,
						'fa4compatibility' => 'icon',
					],
					[
						'name'        => 'custom_nav_link',
						'label'       => esc_html__( 'Link', 'avator-widget-pack' ),
						'type'        => Controls_Manager::URL,
						'default'     => [ 'url' => '#' ],
						'dynamic'     => [ 'active' => true ],
					],
				],
				'title_field' => '{{{ custom_nav_title }}}',
			]
		);

		$this->add_control(
			'show_edit_profile',
			[
				'label'   => __('Edit Profile', 'avator-widget-pack'),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes'
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
					'#avt-user-login{{ID}} .avt-field-group:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'links_color',
			[
				'label'     => esc_html__( 'Links Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'#avt-user-login{{ID}} .avt-field-group > a' => 'color: {{VALUE}};',
					'#avt-user-login{{ID}} .avt-user-login-password a:not(:last-child):after' => 'background-color: {{VALUE}};',
				],
				'scheme' => [
					'type'  => Scheme_Color::get_type(),
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
					'#avt-user-login{{ID}} .avt-field-group > a:hover' => 'color: {{VALUE}};',
				],
				'scheme' => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_4,
				],
			]
		);

		$this->add_control(
			'checkbox_color',
			[
				'label'     => esc_html__( 'Checkbox Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-form-stacked .avt-field-group .avt-checkbox' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'checkbox_active_color',
			[
				'label'     => esc_html__( 'Checkbox Active Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-user-login .avt-form-stacked .avt-field-group .avt-checkbox:checked' => 'background-color: {{VALUE}};',
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
					'#avt-user-login{{ID}} .avt-field-group > label' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'label_color',
			[
				'label'     => esc_html__( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'#avt-user-login{{ID}} .avt-form-label' => 'color: {{VALUE}};',
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
				'selector' => '#avt-user-login{{ID}} .avt-form-label',
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
					'#avt-user-login{{ID}} .avt-field-group .avt-input' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'field_placeholder_color',
			[
				'label'     => esc_html__( 'Placeholder Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'#avt-user-login{{ID}} .avt-field-group .avt-input::placeholder'      => 'color: {{VALUE}};',
					'#avt-user-login{{ID}} .avt-field-group .avt-input::-moz-placeholder' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'field_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'#avt-user-login{{ID}} .avt-field-group .avt-input,
					#avt-user-login{{ID}} .avt-field-group .avt-checkbox' => 'background-color: {{VALUE}};',
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
				'selector'    => '#avt-user-login{{ID}} .avt-field-group .avt-input',
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
					'#avt-user-login{{ID}} .avt-field-group .avt-input' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'field_box_shadow',
				'selector' => '#avt-user-login{{ID}} .avt-field-group .avt-input',
			]
		);

		$this->add_control(
			'field_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'#avt-user-login{{ID}} .avt-field-group .avt-input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; height: auto;',
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
				'selector'  => '#avt-user-login{{ID}} .avt-field-group .avt-input',
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
					'#avt-user-login{{ID}} .avt-field-group .avt-input:focus' => 'border-color: {{VALUE}};',
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
					'#avt-user-login{{ID}} .avt-button' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'button_typography',
				'selector' => '#avt-user-login{{ID}} .avt-button',
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
					'#avt-user-login{{ID}} .avt-button' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(), [
				'name'        => 'button_border',
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '#avt-user-login{{ID}} .avt-button',
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
					'#avt-user-login{{ID}} .avt-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'#avt-user-login{{ID}} .avt-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'#avt-user-login{{ID}} .avt-button:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_hover_color',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'#avt-user-login{{ID}} .avt-button:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'#avt-user-login{{ID}} .avt-button:hover' => 'border-color: {{VALUE}};',
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
			'section_dropdown_style',
			[
				'label' => esc_html__( 'Dropdown Style', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'_skin' => ['avt-dropdown', 'avt-modal'],
				],
			]
		);

		$this->add_control(
			'dropdown_text_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-user-login .avt-dropdown' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'dropdown_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-user-login .avt-dropdown' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(), [
				'name'        => 'dropdown_border',
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-user-login .avt-dropdown',
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'dropdown_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-user-login .avt-dropdown' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'dropdown_text_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-user-login .avt-dropdown, {{WRAPPER}} .avt-user-login .avt-dropdown .avt-user-card-small' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .avt-user-login .avt-dropdown .avt-user-card-small' => 'margin-top: -{{TOP}}{{UNIT}}; margin-right: -{{RIGHT}}{{UNIT}}; margin-left: -{{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'dropdown_link_color',
			[
				'label'     => esc_html__( 'Link Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-user-login .avt-dropdown a' => 'color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'dropdown_link_hover_color',
			[
				'label'     => esc_html__( 'Link Hover Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-user-login .avt-dropdown a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		
		$this->end_controls_section();

		$this->start_controls_section(
			'section_logged_style',
			[
				'label' => esc_html__( 'Logged Style', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'_skin!' => ['avt-dropdown', 'avt-modal'],
				],
			]
		);

		$this->add_control(
			'looged_text_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-user-login' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'looged_link_color',
			[
				'label'     => esc_html__( 'Link Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-user-login a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'looged_link_hover_color',
			[
				'label'     => esc_html__( 'Link Hover Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-user-login a:hover' => 'color: {{VALUE}};',
				],
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
					'name' => 'wp-submit',
				],
				'user_label' => [
					'for'   => 'user' . esc_attr($id),
					'class' => [
						'avt-form-label',
					]
				],
				'password_label' => [
					'for'   => 'password' . esc_attr($id),
					'class' => [
						'avt-form-label',
					]
				],
				'user_input' => [
					'type'        => 'text',
					'name'        => 'user_login',
					'id'          => 'user' . esc_attr($id),
					'placeholder' => $settings['user_placeholder'],
					'class'       => [
						'avt-input',
						'avt-form-' . $settings['input_size'],
					],
				],
				'password_input' => [
					'type'        => 'password',
					'name'        => 'user_password',
					'id'          => 'password' . esc_attr($id),
					'placeholder' => $settings['password_placeholder'],
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

	public function render_loop_custom_nav_list($list) {

		$this->add_render_attribute( 'custom-nav-item', 'title', $list["custom_nav_title"], true );
		$this->add_render_attribute( 'custom-nav-item', 'href', $list['custom_nav_link']['url'], true );
		
		if ( $list['custom_nav_link']['is_external'] ) {
			$this->add_render_attribute( 'custom-nav-item', 'target', '_blank', true );
		}

		if ( $list['custom_nav_link']['nofollow'] ) {
			$this->add_render_attribute( 'custom-nav-item', 'rel', 'nofollow', true );
		}

		if ( ! isset( $list['icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
			// add old default
			$list['icon'] = 'fas fa-user';
		}

		$migrated  = isset( $list['__fa4_migrated']['custom_nav_icon'] );
		$is_new    = empty( $list['icon'] ) && Icons_Manager::is_migration_allowed();
		
		?>
	    <li class="avt-user-login-custom-item">
			<a <?php echo $this->get_render_attribute_string( 'custom-nav-item' ); ?>>
				<?php if ($list['custom_nav_icon']['value']) : ?>

					<span class="avt-ul-custom-nav-icon">

						<?php if ( $is_new || $migrated ) :
						Icons_Manager::render_icon( $list['custom_nav_icon'], [ 'aria-hidden' => 'true', 'class' => 'fa-fw' ] );
						else : ?>
							<i class="<?php echo esc_attr( $list['icon'] ); ?>" aria-hidden="true"></i>
						<?php endif; ?>

					</span>

				<?php endif; ?>

				<?php echo wp_kses( $list['custom_nav_title'], widget_pack_allow_tags('title') ); ?>
			</a>
		</li>
		<?php
	}

	public function user_dropdown_menu() {
		$settings        = $this->get_settings();
		$current_user    = wp_get_current_user();
		$dropdown_offset = $settings['dropdown_offset'];
		$current_url     = remove_query_arg( 'fake_arg' );

		$this->add_render_attribute(
			[
				'dropdown-settings' => [
					'avt-dropdown' => [
						wp_json_encode(array_filter([
							"mode"   => $settings["dropdown_mode"],
							"pos"    => $settings["dropdown_position"],
							"offset" => $dropdown_offset["size"]
						]))
					]
				]
			]
		);

		$this->add_render_attribute( 'dropdown-settings', 'class', 'avt-dropdown avt-text-left avt-overflow-hidden' );

		?>

		<div <?php echo $this->get_render_attribute_string('dropdown-settings'); ?>>
			<div class="avt-user-card-small">
				<div class="avt-grid-small avt-flex-middle" avt-grid>
		            <div class="avt-width-auto">
		                <?php echo get_avatar( $current_user->user_email, 48 ); ?>
		            </div>
		            <div class="avt-width-expand">
		                <div class="avt-card-title"><?php echo esc_html($current_user->display_name); ?></div>
		                <p class="avt-text-meta avt-margin-remove-top">
		                	<a href="<?php echo esc_url($current_user->user_url); ?>" target="_blank">
		                		<?php echo esc_url($current_user->user_url); ?>
		                	</a>
		                </p>
		            </div>
		        </div>
	        </div>
		    <ul class="avt-nav avt-dropdown-nav">
		    	<?php if ( $settings['show_edit_profile'] ) : ?>
			        <li><a href="<?php echo get_edit_user_link(); ?>"><span class="avt-ul-custom-nav-icon"><i class="ep-edit fa-fw"></i></span> <?php esc_html_e( 'Edit Profile', 'avator-widget-pack' ); ?></a></li>
			    <?php endif; ?>
		        
		        <?php
		        foreach ($settings['custom_navs'] as $key => $nav) : 
		        	$this->render_loop_custom_nav_list($nav);
		        endforeach;
		        ?>

		        <li class="avt-nav-divider"></li>
		        <li><a href="<?php echo wp_logout_url( $current_url ); ?>" class="avt-ul-logout-menu"><span class="avt-ul-custom-nav-icon"><i class="ep-lock fa-fw"></i></span> <?php esc_html_e( 'Logout', 'avator-widget-pack' ); ?></a></li>
		    </ul>
		</div>

		<?php
	}

	public function render() {
		$settings    = $this->get_settings();
		$current_url = remove_query_arg( 'fake_arg' );


		if ( is_user_logged_in() && ! Widget_Pack_Loader::elementor()->editor->is_edit_mode() ) {
			if ( $settings['show_logged_in_message'] ) {
				$current_user = wp_get_current_user();

				?>
				<div class="avt-user-login avt-text-center">
					<ul class="avt-list avt-list-divider">
						<li class="avt-user-avatar avt-margin-large-bottom">
			        		<?php echo get_avatar( $current_user->user_email, 128 ); ?>
						</li>
                        <li>
                            <?php if ( $settings['show_logged_in_message'] ) : ?>
                                <span class="avt-user-name">
                                <?php if ($settings['show_custom_message'] and $settings['logged_in_custom_message']) : ?>
                                    <?php echo esc_html($settings['logged_in_custom_message']); ?>
                                <?php else : ?>
                                    <?php esc_html_e( 'Hi', 'avator-widget-pack' ); ?>,
                                <?php endif; ?>
                                    <a href="<?php echo get_edit_user_link(); ?>"><?php echo esc_html($current_user->display_name); ?></a>
                            </span>
                            <?php endif; ?>
                        </li>


						<li class="avt-user-website">
							<?php esc_html_e( 'Website:', 'avator-widget-pack' ); ?> <a href="<?php echo esc_url($current_user->user_url); ?>" target="_blank"><?php echo esc_url($current_user->user_url); ?></a>
						</li>

						<li class="avt-user-bio">
							<?php esc_html_e( 'Description:', 'avator-widget-pack' ); ?> <?php echo esc_html($current_user->user_description); ?>
						</li>

						<li class="avt-user-logged-out">
							<a href="<?php echo wp_logout_url( $current_url ); ?>" class="avt-button avt-button-primary"><?php esc_html_e( 'Logout', 'avator-widget-pack' ); ?></a>
						</li>
					</ul>

				</div>
       			
				<?php					    
			}
			return;
		}			

		$this->form_fields_render_attributes();

		?>
		<div class="avt-user-login avt-user-login-skin-default">
			<div class="elementor-form-fields-wrapper">
				<?php $this->user_login_form(); ?>
			</div>
		</div>

		<?php

		$this->user_login_ajax_script();		
	}

	public function user_login_form() {
		$settings    = $this->get_settings();

		$current_url = remove_query_arg( 'fake_arg' );
		$id          = $this->get_id();

		?>
		<form id="avt-user-login<?php echo esc_attr($id); ?>" class="avt-form-stacked avt-width-1-1" method="post" action="login">
			<input type="hidden" name="action" value="widget_pack_ajax_login">
			<div class="avt-user-login-status"></div>
			<div <?php echo $this->get_render_attribute_string( 'field-group' ); ?>>
				<?php
				if ( $settings['show_labels'] ) {
					echo '<label ' . $this->get_render_attribute_string( 'user_label' ) . '>' . $settings['user_label'] . '</label>';
				}
				echo '<div class="avt-form-controls">';
				echo '<input ' . $this->get_render_attribute_string( 'user_input' ) . ' required>';
				echo '</div>';

				?>
			</div>

			<div <?php echo $this->get_render_attribute_string( 'field-group' ); ?>>
				<?php
				if ( $settings['show_labels'] ) :
					echo '<label ' . $this->get_render_attribute_string( 'password_label' ) . '>' . $settings['password_label'] . '</label>';
				endif;
				echo '<div class="avt-form-controls">';
				echo '<input ' . $this->get_render_attribute_string( 'password_input' ) . ' required>';
				echo '</div>';
				?>
			</div>

			<?php if ( $settings['show_remember_me'] ) : ?>
				<div class="avt-field-group avt-remember-me">
					<label for="remember-me-<?php echo esc_attr($id); ?>" class="avt-form-label">
						<input type="checkbox" id="remember-me-<?php echo esc_attr($id); ?>" class="avt-checkbox" name="rememberme" value="forever"> 
						<?php esc_html_e( 'Remember Me', 'avator-widget-pack' ); ?>
					</label>
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
			$show_register      = get_option( 'users_can_register' ) && $settings['show_register'];

			if ( $show_lost_password || $show_register ) : ?>
				<div class="avt-field-group avt-width-1-1 avt-margin-remove-bottom avt-user-login-password">
					   
					<?php if ( $show_lost_password ) : ?>
						<a class="avt-lost-password" href="<?php echo wp_lostpassword_url( $current_url ); ?>">
							<?php esc_html_e( 'Lost password?', 'avator-widget-pack' ); ?>
						</a>
					<?php endif; ?>

					<?php if ( $show_register ) : ?>
                        <?php
                            if ( $settings['custom_register'] and $settings['custom_register_url']['url'] ) {
                                $register_url = esc_url( $settings['custom_register_url']['url'] );
                            } else {
                                $register_url = wp_registration_url();
                            }
                        ?>
						<a class="avt-register" href="<?php echo esc_url($register_url); ?>">
							<?php esc_html_e( 'Register', 'avator-widget-pack' ); ?>
						</a>
					<?php endif; ?>
					
				</div>
			<?php endif; ?>
			
			<?php wp_nonce_field( 'ajax-login-nonce', 'avt-user-login-sc' ); ?>

		</form>
		<?php
	}

	public function user_login_ajax_script() { 
		$settings    = $this->get_settings();
		$current_url = remove_query_arg( 'fake_arg' );
		$id          = $this->get_id();

		if ( $settings['redirect_after_login'] && ! empty( $settings['redirect_url']['url'] ) ) {
			$redirect_url = $settings['redirect_url']['url'];
		} else {
			$redirect_url = $current_url;
		}

		?>
		<script type="text/javascript">
			jQuery(document).ready(function($) {
				"use strict";
				var login_form = 'form#avt-user-login<?php echo esc_attr($id); ?>';
			    // Perform AJAX login on form submit
			    $(login_form).on('submit', function(e){
			        avtUIkit.notification({message: '<div avt-spinner></div> ' + widget_pack_ajax_login_config.loadingmessage, timeout: false});
			        $.ajax({
			            type: 'POST',
			            dataType: 'json',
			            url: widget_pack_ajax_login_config.ajaxurl,
			            data: $(login_form).serialize(),
			            success: function(data) {
			                if (data.loggedin == true){
			                	avtUIkit.notification.closeAll();
			                	avtUIkit.notification({message: '<span avt-icon=\'icon: check\'></span> ' + data.message, status: 'primary'});
			                    document.location.href = '<?php echo esc_url( $redirect_url ); ?>';
			                } else {
			                	avtUIkit.notification.closeAll();
			                	avtUIkit.notification({message: '<span avt-icon=\'icon: warning\'></span> ' + data.message, status: 'warning'});
			                }
			            },
			            error: function(data) {
			            	avtUIkit.notification.closeAll();
			            	avtUIkit.notification({message: '<span avt-icon=\'icon: warning\'></span> <?php esc_html_e('Unknown error, make sure access is correct!', 'avator-widget-pack') ?>', status: 'warning'});
			            }
			        });
			        e.preventDefault();
			    });

			});
		</script>
		<?php
	}
}