<?php
namespace WidgetPack\Modules\Helpdesk\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Icons_Manager;
use Elementor\Core\Files\Assets\Svg\Svg_Handler;
use WidgetPack\Modules\Navbar\ep_menu_walker;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Helpdesk extends Widget_Base {
	public function get_name() {
		return 'avt-helpdesk';
	}

	public function get_title() {
		return AWP . esc_html__( 'Help Desk', 'avator-widget-pack' );
	}

	public function get_icon() {
		return 'avt-wi-helpdesk';
	}

	public function get_categories() {
		return [ 'widget-pack' ];
	}

	public function get_keywords() {
		return [ 'help', 'desk', 'livechat', 'messanger', 'telegram', 'email', 'whatsapp' ];
	}

	public function get_style_depends() {
		return [ 'widget-pack-font', 'wipa-helpdesk' ];
	}

	public function get_script_depends() {
		return [ 'popper', 'tippyjs', 'wipa-helpdesk' ];
	}

	public function get_custom_help_url() {
		return 'https://youtu.be/bO__skhy4yk';
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'section_helpdesk_layout',
			[
				'label' => esc_html__( 'Layout', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'helpdesk_position',
			[
				'label'   => __( 'Position', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'left'  => __( 'Left', 'avator-widget-pack' ),
					'right' => __( 'Right', 'avator-widget-pack' ),
				],
				'default'   => 'right',
				'selectors' => [
					'{{WRAPPER}} .avt-helpdesk-icons' => '{{VALUE}} : 30px;',
				],
			]
		);

		$this->add_control(
			'helpdesk_select_icon',
			[
				'label'       => esc_html__( 'Icon', 'avator-widget-pack' ),
				'type'             => Controls_Manager::ICONS,
				'fa4compatibility' => 'helpdesk_icon',
				'default' => [
					'value' => 'far fa-life-ring',
					'library' => 'fa-regular',
				],
			]
		);

		$this->add_responsive_control(
			'helpdesk_size',
			[
				'label'   => esc_html__( 'Icon Size', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 35,
						'max' => 100,
						'step' => 5,
					],
				],
				'default' => [
					'size' => 50,
				],
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-helpdesk .avt-helpdesk-icons-item, {{WRAPPER}} .avt-helpdesk .avt-helpdesk-icons-open-button' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'helpdesk_space',
			[
				'label'   => esc_html__( 'Icon Space', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-helpdesk-icons-open:checked ~ .avt-helpdesk-icons-item:nth-child(3)' => 'transform: translate3d(0, calc(-{{SIZE}}{{UNIT}} - {{helpdesk_size.SIZE}}{{UNIT}}), 0);',
					'{{WRAPPER}} .avt-helpdesk-icons-open:checked ~ .avt-helpdesk-icons-item:nth-child(4)' => 'transform: translate3d(0, calc(-{{SIZE}}{{UNIT}} * 2 - {{helpdesk_size.SIZE}}{{UNIT}} * 2), 0);',
					'{{WRAPPER}} .avt-helpdesk-icons-open:checked ~ .avt-helpdesk-icons-item:nth-child(5)' => 'transform: translate3d(0, calc(-{{SIZE}}{{UNIT}} * 3 - {{helpdesk_size.SIZE}}{{UNIT}} * 3), 0);',
					'{{WRAPPER}} .avt-helpdesk-icons-open:checked ~ .avt-helpdesk-icons-item:nth-child(6)' => 'transform: translate3d(0, calc(-{{SIZE}}{{UNIT}} * 4 - {{helpdesk_size.SIZE}}{{UNIT}} * 4), 0);',
					'{{WRAPPER}} .avt-helpdesk-icons-open:checked ~ .avt-helpdesk-icons-item:nth-child(7)' => 'transform: translate3d(0, calc(-{{SIZE}}{{UNIT}} * 5 - {{helpdesk_size.SIZE}}{{UNIT}} * 5), 0);',
					'{{WRAPPER}} .avt-helpdesk-icons-open:checked ~ .avt-helpdesk-icons-item:nth-child(8)' => 'transform: translate3d(0, calc(-{{SIZE}}{{UNIT}} * 6 - {{helpdesk_size.SIZE}}{{UNIT}} * 6), 0);',
					'{{WRAPPER}} .avt-helpdesk-icons-open:checked ~ .avt-helpdesk-icons-item:nth-child(9)' => 'transform: translate3d(0, calc(-{{SIZE}}{{UNIT}} * 7 - {{helpdesk_size.SIZE}}{{UNIT}} * 7), 0);',
				],
			]
		);

		$this->add_control(
			'helpdesk_title',
			[
				'label'       => esc_html__( 'Main Icon Title', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'render_type' => 'template',
				'default'     => 'Need help? Contact us with your favorite way.',
				'dynamic'     => [ 'active' => true ],
			]
		);

		$this->add_control(
			'messenger_show',
			[
				'label'   => esc_html__( 'Messenger', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'skype_show',
			[
				'label'   => esc_html__( 'Skype', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'viber_show',
			[
				'label'   => esc_html__( 'Viber', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'whatsapp_show',
			[
				'label'   => esc_html__( 'WhatsApp', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'telegram_show',
			[
				'label'   => esc_html__( 'Telegram', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
			]
		);


		$this->add_control(
			'custom_show',
			[
				'label'   => esc_html__( 'Custom', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'mailto_show',
			[
				'label'   => esc_html__( 'Email', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_helpdesk_messenger',
			[
				'label' => esc_html__( 'Messenger', 'avator-widget-pack' ),
				'condition' => [
					'messenger_show' => 'yes',
				],
			]
		);

		$this->add_control(
			'messenger_title',
			[
				'label'       => esc_html__( 'Title', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'render_type' => 'template',
				'default'     => 'Chat on messenger',
				'dynamic'     => [ 'active' => true ],
			]
		);

		$this->add_control(
			'messenger_link',
			[
				'label'       => esc_html__( 'Link/ID', 'avator-widget-pack' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => esc_html__( 'avator', 'avator-widget-pack' ),
				'default'     => [
					'url' => 'avator',
				],
			]
		);

		$this->add_control(
			'messenger_onclick',
			[
				'label'   => esc_html__( 'OnClick', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'messenger_onclick_event',
			[
				'label'       => esc_html__( 'OnClick Event', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => 'myFunction()',
				'description' => sprintf( __('For details please look <a href="%s" target="_blank">here</a>'), 'https://www.w3schools.com/jsref/event_onclick.asp' ),
				'condition' => [
					'messenger_onclick' => 'yes'
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_helpdesk_skype',
			[
				'label' => esc_html__( 'Skype', 'avator-widget-pack' ),
				'condition' => [
					'skype_show' => 'yes',
				],
			]
		);

		$this->add_control(
			'skype_title',
			[
				'label'       => esc_html__( 'Title', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'render_type' => 'template',
				'default'     => 'Chat on skype',
				'dynamic'     => [ 'active' => true ],
			]
		);

		$this->add_control(
			'skype_link',
			[
				'label'       => esc_html__( 'Link/ID', 'avator-widget-pack' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => esc_html__( 'avator', 'avator-widget-pack' ),
				'default'     => [
					'url' => 'avator',
				],
			]
		);

		$this->add_control(
			'skype_onclick',
			[
				'label'   => esc_html__( 'OnClick', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'skype_onclick_event',
			[
				'label'       => esc_html__( 'OnClick Event', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => 'myFunction()',
				'description' => sprintf( __('For details please look <a href="%s" target="_blank">here</a>'), 'https://www.w3schools.com/jsref/event_onclick.asp' ),
				'condition' => [
					'skype_onclick' => 'yes'
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_helpdesk_viber',
			[
				'label' => esc_html__( 'Viber', 'avator-widget-pack' ),
				'condition' => [
					'viber_show' => 'yes',
				],
			]
		);

		$this->add_control(
			'viber_title',
			[
				'label'       => esc_html__( 'Title', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'render_type' => 'template',
				'default'     => 'Chat on viber',
				'dynamic'     => [ 'active' => true ],
			]
		);

		$this->add_control(
			'viber_link',
			[
				'label'       => esc_html__( 'Link/ID', 'avator-widget-pack' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => esc_html__( 'avator', 'avator-widget-pack' ),
				'default'     => [
					'url' => 'avator',
				],
			]
		);

		$this->add_control(
			'viber_onclick',
			[
				'label'   => esc_html__( 'OnClick', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'viber_onclick_event',
			[
				'label'       => esc_html__( 'OnClick Event', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => 'myFunction()',
				'description' => sprintf( __('For details please look <a href="%s" target="_blank">here</a>'), 'https://www.w3schools.com/jsref/event_onclick.asp' ),
				'condition' => [
					'viber_onclick' => 'yes'
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_helpdesk_whatsapp',
			[
				'label' => esc_html__( 'WhatsApp', 'avator-widget-pack' ),
				'condition' => [
					'whatsapp_show' => 'yes',
				],
			]
		);

		$this->add_control(
			'whatsapp_title',
			[
				'label'       => esc_html__( 'Title', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'render_type' => 'template',
				'default'     => 'Call via whatsapp',
				'dynamic'     => [ 'active' => true ],
			]
		);

		$this->add_control(
			'whatsapp_link',
			[
				'label'       => esc_html__( 'Number', 'avator-widget-pack' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => esc_html__( '+8801718542596', 'avator-widget-pack' ),
				'default'     => [
					'url' => '+8801718542596',
				],
			]
		);

		$this->add_control(
			'whatsapp_onclick',
			[
				'label'   => esc_html__( 'OnClick', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'whatsapp_onclick_event',
			[
				'label'       => esc_html__( 'OnClick Event', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => 'myFunction()',
				'description' => sprintf( __('For details please look <a href="%s" target="_blank">here</a>'), 'https://www.w3schools.com/jsref/event_onclick.asp' ),
				'condition' => [
					'whatsapp_onclick' => 'yes'
				],
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'section_helpdesk_telegram',
			[
				'label' => esc_html__( 'Telegram', 'avator-widget-pack' ),
				'condition' => [
					'telegram_show' => 'yes',
				],
			]
		);

		$this->add_control(
			'telegram_title',
			[
				'label'       => esc_html__( 'Title', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'render_type' => 'template',
				'default'     => 'Chat on telegram',
				'dynamic'     => [ 'active' => true ],
			]
		);

		$this->add_control(
			'telegram_link',
			[
				'label'       => esc_html__( 'User ID', 'avator-widget-pack' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => esc_html__( 'avator', 'avator-widget-pack' ),
				'default'     => [
					'url' => 'avator',
				],
			]
		);

		$this->add_control(
			'telegram_onclick',
			[
				'label'   => esc_html__( 'OnClick', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'telegram_onclick_event',
			[
				'label'       => esc_html__( 'OnClick Event', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => 'myFunction()',
				'description' => sprintf( __('For details please look <a href="%s" target="_blank">here</a>'), 'https://www.w3schools.com/jsref/event_onclick.asp' ),
				'condition' => [
					'telegram_onclick' => 'yes'
				]
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'section_helpdesk_custom',
			[
				'label' => esc_html__( 'Custom', 'avator-widget-pack' ),
				'condition' => [
					'custom_show' => 'yes',
				],

			]
		);

		$this->add_control(
			'custom_title',
			[
				'label'       => esc_html__( 'Title', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'render_type' => 'template',
				'default'     => 'Chat with us',
				'dynamic'     => [ 'active' => true ],
			]
		);

		$this->add_control(
			'custom_link',
			[
				'label'       => esc_html__( 'Link', 'avator-widget-pack' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => esc_html__( 'https://sample.com', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'custom_onclick',
			[
				'label'   => esc_html__( 'OnClick', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'custom_onclick_event',
			[
				'label'       => esc_html__( 'OnClick Event', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => 'myFunction()',
				'default' => 'Intercom("show");',
				'description' => sprintf( __('For details please look <a href="%s" target="_blank">here</a>'), 'https://www.w3schools.com/jsref/event_onclick.asp' ),
				'condition' => [
					'custom_onclick' => 'yes'
				]
			]
		);

		$this->add_control(
			'helpdesk_custom_icon',
			[
				'label'       => esc_html__( 'Icon', 'avator-widget-pack' ),
				'type'             => Controls_Manager::ICONS,
				'fa4compatibility' => 'custom_icon',
				'default' => [
					'value' => 'fas fa-comment',
					'library' => 'fa-solid',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_helpdesk_mailto',
			[
				'label' => esc_html__( 'Email', 'avator-widget-pack' ),
				'condition' => [
					'mailto_show' => 'yes',
				],
			]
		);

		$this->add_control(
			'mailto_title',
			[
				'label'       => esc_html__( 'Title', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'render_type' => 'template',
				'default'     => 'Email Us',
				'dynamic'     => [ 'active' => true ],
			]
		);


		$default_email = get_bloginfo( 'admin_email' );

		$this->add_control(
			'mailto_link',
			[
				'label'       => esc_html__( 'Email Address', 'avator-widget-pack' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => $default_email,
				'default'     => [
					'url' => $default_email,
				],
			]
		);
		
		$this->add_control(
			'mailto_subject',
			[
				'label'   => esc_html__( 'Subject', 'avator-widget-pack' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Support related issue', 'avator-widget-pack'),
			]
		);

		$this->add_control(
			'mailto_body',
			[
				'label'   => esc_html__( 'Body Text', 'avator-widget-pack' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Hello, I am contact with you because ', 'avator-widget-pack'),
			]
		);

		$this->add_control(
			'mailto_onclick',
			[
				'label'   => esc_html__( 'OnClick', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
			]
		);


		$this->add_control(
			'mailto_onclick_event',
			[
				'label'       => esc_html__( 'OnClick Event', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => 'myFunction()',
				'description' => sprintf( __('For details please look <a href="%s" target="_blank">here</a>'), 'https://www.w3schools.com/jsref/event_onclick.asp' ),
				'condition' => [
					'mailto_onclick' => 'yes'
				]
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'section_helpdesk_additional',
			[
				'label' => esc_html__( 'Additional', 'avator-widget-pack' ),
			]
		);


		$this->add_control(
			'helpdesk_horizontal_offset',
			[
				'label'   => esc_html__( 'Horizontal Offset', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
						'step' => 5,
					],
				],
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-helpdesk .avt-helpdesk-icons-item, {{WRAPPER}} .avt-helpdesk .avt-helpdesk-icons-open-button' => '{{helpdesk_position.VALUE}}: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'helpdesk_vertical_offset',
			[
				'label'   => esc_html__( 'Vertical Offset', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
						'step' => 5,
					],
				],
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-helpdesk .avt-helpdesk-icons' => 'bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'helpdesk_tooltip',
			[
				'label'   => esc_html__( 'Title as Tooltip', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'helpdesk_tooltip_placement',
			[
				'label'   => esc_html__( 'Placement', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'left',
				'options' => [
					'top'          => esc_html__( 'Top', 'avator-widget-pack' ),
					'bottom'       => esc_html__( 'Bottom', 'avator-widget-pack' ),
					'left'         => esc_html__( 'Left', 'avator-widget-pack' ),
					'right'        => esc_html__( 'Right', 'avator-widget-pack' ),
				],
				'render_type'  => 'template',
				'condition' => [
					'helpdesk_tooltip' => 'yes'
				]
			]
		);

		$this->add_control(
			'helpdesk_tooltip_animation',
			[
				'label'   => esc_html__( 'Animation', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'shift-toward',
				'options' => [
					'shift-away'   => esc_html__( 'Shift-Away', 'avator-widget-pack' ),
					'shift-toward' => esc_html__( 'Shift-Toward', 'avator-widget-pack' ),
					'fade'         => esc_html__( 'Fade', 'avator-widget-pack' ),
					'scale'        => esc_html__( 'Scale', 'avator-widget-pack' ),
					'perspective'  => esc_html__( 'Perspective', 'avator-widget-pack' ),
				],
				'render_type'  => 'template',
				'condition' => [
					'helpdesk_tooltip' => 'yes'
				]
			]
		);

		$this->add_control(
			'helpdesk_tooltip_x_offset',
			[
				'label'   => esc_html__( 'Offset', 'avator-widget-pack' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 0,
				'min'     => -1000,
				'max'     => 1000,
				'step'    => 1,
				'condition' => [
					'helpdesk_tooltip' => 'yes'
				]
			]
		);

		$this->add_control(
			'helpdesk_tooltip_y_offset',
			[
				'label'   => esc_html__( 'Distance', 'avator-widget-pack' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 0,
				'min'     => -1000,
				'max'     => 1000,
				'step'    => 1,
				'condition' => [
					'helpdesk_tooltip' => 'yes'
				]
			]
		);

		$this->add_control(
			'helpdesk_tooltip_arrow',
			[
				'label'        => esc_html__( 'Arrow', 'avator-widget-pack' ),
				'type'         => Controls_Manager::SWITCHER,
				'condition' => [
					'helpdesk_tooltip' => 'yes'
				]
			]
		);

		$this->add_control(
			'helpdesk_tooltip_trigger',
			[
				'label'       => __( 'Trigger on Click', 'avator-widget-pack' ),
				'description' => __( 'Don\'t set yes when you set lightbox image with marker.', 'avator-widget-pack' ),
				'type'        => Controls_Manager::SWITCHER,
				'condition' => [
					'helpdesk_tooltip' => 'yes'
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_helpdesk_main_icon',
			[
				'label'     => esc_html__( 'Main Icons', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs('tabs_style_helpdesk');

		$this->start_controls_tab(
			'tab_style_helpdesk_normal',
			[
				'label' => esc_html__('Normal', 'avator-widget-pack')
			]
		);

		$this->add_control(
			'helpdesk_main_icon_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-helpdesk .avt-helpdesk-icons-open-button' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-helpdesk .avt-helpdesk-icons-open-button svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'helpdesk_main_icon_background',
				'selector' => '{{WRAPPER}} .avt-helpdesk .avt-helpdesk-icons-open-button'
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_style_helpdesk_main_icon_hover',
			[
				'label' => esc_html__('Hover', 'avator-widget-pack')
			]
		);

		$this->add_control(
			'helpdesk_main_icon_hover_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-helpdesk .avt-helpdesk-icons-open-button:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-helpdesk .avt-helpdesk-icons-open-button:hover svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'helpdesk_main_icon_hover_background',
				'selector' => '{{WRAPPER}} .avt-helpdesk .avt-helpdesk-icons-open-button:hover'
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();


		$this->start_controls_section(
			'section_style_helpdesk_icons',
			[
				'label'     => esc_html__( 'Icons Style', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs('tabs_style_helpdesk_icons');

		$this->start_controls_tab(
			'tab_style_helpdesk_icons_normal',
			[
				'label' => esc_html__('Normal', 'avator-widget-pack')
			]
		);

		$this->add_control(
			'helpdesk_icons_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-helpdesk .avt-helpdesk-icons-item' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-helpdesk .avt-helpdesk-icons-item svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'helpdesk_icons_background',
				'selector' => '{{WRAPPER}} .avt-helpdesk .avt-helpdesk-icons-item'
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_style_helpdesk_icons_hover',
			[
				'label' => esc_html__('Hover', 'avator-widget-pack')
			]
		);

		$this->add_control(
			'helpdesk_icons_hover_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-helpdesk .avt-helpdesk-icons-item:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-helpdesk .avt-helpdesk-icons-item:hover svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'helpdesk_icons_hover_background',
				'selector' => '{{WRAPPER}} .avt-helpdesk .avt-helpdesk-icons-item:hover'
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();


		$this->start_controls_section(
			'section_style_tooltip',
			[
				'label' => esc_html__( 'Tooltip', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'helpdesk_tooltip_width',
			[
				'label'      => esc_html__( 'Width', 'avator-widget-pack' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [
					'px', 'em',
				],
				'range' => [
					'px' => [
						'min' => 50,
						'max' => 500,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .tippy-tooltip' => 'width: {{SIZE}}{{UNIT}};',
				],
				'render_type' => 'template',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'helpdesk_tooltip_typography',
				'selector' => '{{WRAPPER}} .tippy-tooltip .tippy-content',
			]
		);

		$this->add_control(
			'helpdesk_tooltip_color',
			[
				'label'     => esc_html__( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tippy-tooltip' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'helpdesk_tooltip_text_align',
			[
				'label'   => esc_html__( 'Text Alignment', 'avator-widget-pack' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => [
					'left'    => [
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
					'{{WRAPPER}} .tippy-tooltip .tippy-content' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'helpdesk_tooltip_background',
				'selector' => '{{WRAPPER}} .tippy-tooltip, {{WRAPPER}} .tippy-tooltip .tippy-backdrop',
			]
		);

		$this->add_control(
			'helpdesk_tooltip_arrow_color',
			[
				'label'     => esc_html__( 'Arrow Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tippy-popper[x-placement^=left] .tippy-arrow'  => 'border-left-color: {{VALUE}}',
					'{{WRAPPER}} .tippy-popper[x-placement^=right] .tippy-arrow' => 'border-right-color: {{VALUE}}',
					'{{WRAPPER}} .tippy-popper[x-placement^=top] .tippy-arrow'   => 'border-top-color: {{VALUE}}',
					'{{WRAPPER}} .tippy-popper[x-placement^=bottom] .tippy-arrow'=> 'border-bottom-color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'helpdesk_tooltip_padding',
			[
				'label'      => __( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tippy-tooltip' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'render_type'  => 'template',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'helpdesk_tooltip_border',
				'label'       => esc_html__( 'Border', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .tippy-tooltip',
			]
		);

		$this->add_responsive_control(
			'helpdesk_tooltip_border_radius',
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
				'name'     => 'helpdesk_tooltip_box_shadow',
				'selector' => '{{WRAPPER}} .tippy-tooltip',
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

	}

	

	protected function render() {
		$settings = $this->get_settings();
		$id       = 'avt-helpdesk-icons-' . $this->get_id();

		if ( ! isset( $settings['helpdesk_icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
			// add old default
			$settings['helpdesk_icon'] = 'fas fa-life-ring';
		}

		$migrated  = isset( $settings['__fa4_migrated']['helpdesk_select_icon'] );
		$is_new    = empty( $settings['helpdesk_icon'] ) && Icons_Manager::is_migration_allowed();

		?>
		
		<div class="avt-helpdesk">
			<nav class="avt-helpdesk-icons">
				<input type="checkbox" href="#" class="avt-helpdesk-icons-open" name="avt-helpdesk-icons-open" id="<?php echo esc_attr($id); ?>"/>
				<label class="avt-helpdesk-icons-open-button" for="<?php echo esc_attr($id); ?>" title="<?php echo esc_html($settings['helpdesk_title']); ?>">

					<?php if ( $is_new || $migrated ) :
						Icons_Manager::render_icon( $settings['helpdesk_select_icon'], [ 'aria-hidden' => 'true', 'class' => 'fa-fw' ] );
					else : ?>
						<i class="<?php echo esc_attr( $settings['helpdesk_icon'] ); ?>" aria-hidden="true"></i>
					<?php endif; ?>

				</label>
				<?php $this->messenger(); ?>
				<?php $this->skype(); ?>
				<?php $this->viber(); ?>
				<?php $this->whatsapp(); ?>
				<?php $this->mailto(); ?>
				<?php $this->telegram(); ?>
				<?php $this->custom(); ?>
			</nav>
		</div>

		<?php
		
	}

	protected function messenger() {
		$settings = $this->get_settings();

		if ('yes' != $settings['messenger_show']) {
			return;
		}
		
		$this->add_render_attribute( 'messenger', 'class', ['avt-helpdesk-icons-item', 'avt-hdi-messenger'] );

		if ( ! empty( $settings['messenger_link']['url'] ) ) {

			$final_link = 'https://m.me/' . $settings['messenger_link']['url'];

			$this->add_render_attribute( 'messenger', 'href', $final_link );

			if ( $settings['messenger_link']['is_external'] ) {
				$this->add_render_attribute( 'messenger', 'target', '_blank' );
			}

			if ( $settings['messenger_link']['nofollow'] ) {
				$this->add_render_attribute( 'messenger', 'rel', 'nofollow' );
			}

		}

		if ( $settings['messenger_link']['nofollow'] ) {
			$this->add_render_attribute( 'messenger', 'rel', 'nofollow' );
		}

		if ($settings['messenger_onclick']) {
			$this->add_render_attribute( 'messenger', 'href', '#', true );
			$this->add_render_attribute( 'messenger', 'onclick', $settings['messenger_onclick_event'] );
		}
		
		$this->add_render_attribute( 'messenger', 'data-tippy-content', $settings['messenger_title'] );

		$this->tooltip('messenger');

		?>

		
		<a <?php echo $this->get_render_attribute_string( 'messenger' ); ?>>
			<i class="wipa-messenger" aria-hidden="true"></i>
		</a>

		<?php

	}

	protected function skype() {
		$settings = $this->get_settings();

		if ('yes' != $settings['skype_show']) {
			return;
		}
		
		$this->add_render_attribute( 'skype', 'class', ['avt-helpdesk-icons-item', 'avt-hdi-skype'] );

		if ( ! empty( $settings['skype_link']['url'] ) ) {

			$final_link = 'https://www.skype.com/' . $settings['skype_link']['url'];

			$this->add_render_attribute( 'skype', 'href', $final_link );

			if ( $settings['skype_link']['is_external'] ) {
				$this->add_render_attribute( 'skype', 'target', '_blank' );
			}

			if ( $settings['skype_link']['nofollow'] ) {
				$this->add_render_attribute( 'skype', 'rel', 'nofollow' );
			}

		}

		if ( $settings['skype_link']['nofollow'] ) {
			$this->add_render_attribute( 'skype', 'rel', 'nofollow' );
		}

		if ($settings['skype_onclick']) {
			$this->add_render_attribute( 'skype', 'href', '#', true );
			$this->add_render_attribute( 'skype', 'onclick', $settings['skype_onclick_event'] );
		}
		
		$this->add_render_attribute( 'skype', 'data-tippy-content', $settings['skype_title'] );

		$this->tooltip('skype');

		?>

		
		<a <?php echo $this->get_render_attribute_string( 'skype' ); ?>>
			<i class="wipa-skype" aria-hidden="true"></i>
		</a>		

		<?php

	}

	protected function viber() {
		$settings = $this->get_settings();

		if ('yes' != $settings['viber_show']) {
			return;
		}
		
		$this->add_render_attribute( 'viber', 'class', ['avt-helpdesk-icons-item', 'avt-hdi-viber'] );

		if ( ! empty( $settings['viber_link']['url'] ) ) {

			$final_link = 'https://www.viber.com/' . $settings['viber_link']['url'];

			$this->add_render_attribute( 'viber', 'href', $final_link );

			if ( $settings['viber_link']['is_external'] ) {
				$this->add_render_attribute( 'viber', 'target', '_blank' );
			}

			if ( $settings['viber_link']['nofollow'] ) {
				$this->add_render_attribute( 'viber', 'rel', 'nofollow' );
			}

		}

		if ( $settings['viber_link']['nofollow'] ) {
			$this->add_render_attribute( 'viber', 'rel', 'nofollow' );
		}

		if ($settings['viber_onclick']) {
			$this->add_render_attribute( 'viber', 'href', '#', true );
			$this->add_render_attribute( 'viber', 'onclick', $settings['viber_onclick_event'] );
		}
		
		$this->add_render_attribute( 'viber', 'data-tippy-content', $settings['viber_title'] );

		$this->tooltip('viber');

		?>

		
		<a <?php echo $this->get_render_attribute_string( 'viber' ); ?>>
			<i class="wipa-viber" aria-hidden="true"></i>
		</a>		

		<?php

	}

	protected function whatsapp() {
		$settings = $this->get_settings();

		if ('yes' != $settings['whatsapp_show']) {
			return;
		}
		
		$this->add_render_attribute( 'whatsapp', 'class', ['avt-helpdesk-icons-item', 'avt-hdi-whatsapp'] );

		if ( ! empty( $settings['whatsapp_link']['url'] ) ) {

			$final_link = 'https://wa.me/' . $settings['whatsapp_link']['url'];

			$this->add_render_attribute( 'whatsapp', 'href', $final_link );

			if ( $settings['whatsapp_link']['is_external'] ) {
				$this->add_render_attribute( 'whatsapp', 'target', '_blank' );
			}

			if ( $settings['whatsapp_link']['nofollow'] ) {
				$this->add_render_attribute( 'whatsapp', 'rel', 'nofollow' );
			}

		}

		if ( $settings['whatsapp_link']['nofollow'] ) {
			$this->add_render_attribute( 'whatsapp', 'rel', 'nofollow' );
		}

		if ($settings['whatsapp_onclick']) {
			$this->add_render_attribute( 'whatsapp', 'onclick', $settings['whatsapp_onclick_event'] );
		}

		$this->add_render_attribute( 'whatsapp', 'data-tippy-content', $settings['whatsapp_title'] );

		$this->tooltip('whatsapp');

		?>

		
		<a <?php echo $this->get_render_attribute_string( 'whatsapp' ); ?>>
			<i class="wipa-whatsapp" aria-hidden="true"></i>
		</a>
		

		<?php

	}


	protected function telegram() {
		$settings = $this->get_settings();

		if ('yes' != $settings['telegram_show']) {
			return;
		}
		
		$this->add_render_attribute( 'telegram', 'class', ['avt-helpdesk-icons-item', 'avt-hdi-telegram'] );

		if ( ! empty( $settings['telegram_link']['url'] ) ) {

			$final_link = 'https://telegram.me/' . $settings['telegram_link']['url'];

			$this->add_render_attribute( 'telegram', 'href', esc_url($final_link) );

			if ( $settings['telegram_link']['is_external'] ) {
				$this->add_render_attribute( 'telegram', 'target', '_blank' );
			}

			if ( $settings['telegram_link']['nofollow'] ) {
				$this->add_render_attribute( 'telegram', 'rel', 'nofollow' );
			}

		}

		if ( $settings['telegram_link']['nofollow'] ) {
			$this->add_render_attribute( 'telegram', 'rel', 'nofollow' );
		}

		if ($settings['telegram_onclick']) {
			$this->add_render_attribute( 'telegram', 'onclick', $settings['telegram_onclick_event'] );
		}

		$this->add_render_attribute( 'telegram', 'data-tippy-content', $settings['telegram_title'] );

		$this->tooltip('telegram');

		?>

		
		<a <?php echo $this->get_render_attribute_string( 'telegram' ); ?>>
			<i class="wipa-telegram" aria-hidden="true"></i>
		</a>
		

		<?php

	}

	protected function custom() {
		$settings = $this->get_settings();

		if ('yes' != $settings['custom_show']) {
			return;
		}
		
		$this->add_render_attribute( 'custom', 'class', ['avt-helpdesk-icons-item', 'avt-hdi-custom'] );

		if ( ! empty( $settings['custom_link']['url'] ) ) {

			$final_link = $settings['custom_link']['url'];

			$this->add_render_attribute( 'custom', 'href', esc_url($final_link) );

			if ( $settings['custom_link']['is_external'] ) {
				$this->add_render_attribute( 'custom', 'target', '_blank' );
			}

			if ( $settings['custom_link']['nofollow'] ) {
				$this->add_render_attribute( 'custom', 'rel', 'nofollow' );
			}

			$this->tooltip('custom');

		}

		if ( $settings['custom_link']['nofollow'] ) {
			$this->add_render_attribute( 'custom', 'rel', 'nofollow' );
		}

		if ($settings['custom_onclick']) {
			$this->add_render_attribute( 'custom', 'onclick', $settings['custom_onclick_event'] );
		}

		$this->add_render_attribute( 'custom', 'data-tippy-content', $settings['custom_title'] );

		$this->tooltip('custom');

		if ( ! isset( $settings['custom_icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
			// add old default
			$settings['custom_icon'] = 'fas fa-envelope';
		}

		$migrated  = isset( $settings['__fa4_migrated']['helpdesk_custom_icon'] );
		$is_new    = empty( $settings['custom_icon'] ) && Icons_Manager::is_migration_allowed();

		?>

		
		<a <?php echo $this->get_render_attribute_string( 'custom' ); ?>>

			<?php if ( $is_new || $migrated ) :
				Icons_Manager::render_icon( $settings['helpdesk_custom_icon'], [ 'aria-hidden' => 'true', 'class' => 'fa-fw' ] );
			else : ?>
				<i class="<?php echo esc_attr( $settings['custom_icon'] ); ?>" aria-hidden="true"></i>
			<?php endif; ?>

		</a>
		

		<?php

	}

	protected function mailto() {
		$settings = $this->get_settings();

		if ('yes' != $settings['mailto_show']) {
			return;
		}
		
		$this->add_render_attribute( 'mailto', 'class', ['avt-helpdesk-icons-item', 'avt-hdi-mailto'] );

		if ( ! empty( $settings['mailto_link']['url'] ) ) {

			$final_link = 'mailto:';
			$final_link .= $settings['mailto_link']['url'];

			if ($settings['mailto_subject']) {
				
				$final_link .= '?subject=' . $settings['mailto_subject'];
				
				if ($settings['mailto_body']) {
					$final_link .= '&amp;body=' . $settings['mailto_body'];
				}
			}

			$this->add_render_attribute( 'mailto', 'href', esc_url($final_link) );

			if ( $settings['mailto_link']['is_external'] ) {
				$this->add_render_attribute( 'mailto', 'target', '_blank' );
			}

			if ( $settings['mailto_link']['nofollow'] ) {
				$this->add_render_attribute( 'mailto', 'rel', 'nofollow' );
			}

		}

		if ( $settings['mailto_link']['nofollow'] ) {
			$this->add_render_attribute( 'mailto', 'rel', 'nofollow' );
		}

		if ($settings['mailto_onclick']) {
			$this->add_render_attribute( 'mailto', 'onclick', $settings['mailto_onclick_event'] );
		}

		$this->add_render_attribute( 'mailto', 'data-tippy-content', $settings['mailto_title'] );

		$this->tooltip('mailto');

		?>

		
		<a <?php echo $this->get_render_attribute_string( 'mailto' ); ?>>
			<i class="wipa-envelope" aria-hidden="true"></i>
		</a>
		

		<?php

	}


	public function tooltip($icon) {
		$settings = $this->get_settings();

		if ('yes' != $settings['helpdesk_tooltip']) {
			return;
		}

		// Tooltip settings
		$this->add_render_attribute( $icon, 'class', 'avt-tippy-tooltip' );
		$this->add_render_attribute( $icon, 'data-tippy', '', true );

		if ($settings['helpdesk_tooltip_placement']) {
			$this->add_render_attribute( $icon, 'data-tippy-placement', $settings['helpdesk_tooltip_placement'], true );
		}

		if ($settings['helpdesk_tooltip_animation']) {
			$this->add_render_attribute( $icon, 'data-tippy-animation', $settings['helpdesk_tooltip_animation'], true );
		}

		if ($settings['helpdesk_tooltip_x_offset']['size'] or $settings['helpdesk_tooltip_y_offset']['size']) {
			$this->add_render_attribute( $icon, 'data-tippy-offset', $settings['helpdesk_tooltip_x_offset']['size'] .','. $settings['helpdesk_tooltip_y_offset']['size'], true );
		}

		if ('yes' == $settings['helpdesk_tooltip_arrow']) {
			$this->add_render_attribute( $icon, 'data-tippy-arrow', 'true', true );
		}

		if ('yes' == $settings['helpdesk_tooltip_trigger']) {
			$this->add_render_attribute( $icon, 'data-tippy-trigger', 'click', true );
		}
	}

	
}
