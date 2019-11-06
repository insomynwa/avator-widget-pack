<?php
namespace WidgetPack\Modules\TableOfContent\Widgets;
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

class Table_Of_Content extends Widget_Base {
	public function get_name() {
		return 'avt-table-of-content';
	}

	public function get_title() {
		return AWP . esc_html__( 'Table of Content', 'avator-widget-pack' );
	}

	public function get_icon() {
		return 'avt-wi-table-of-content';
	}

	public function get_categories() {
		return [ 'widget-pack' ];
	}

	public function get_keywords() {
		return [ 'table', 'content', 'index' ];
	}

	public function get_style_depends() {
		return [ 'widget-pack-font', 'wipa-table-of-content' ];
	}

	public function get_script_depends() {
		return [ 'jquery-ui-widget', 'table-of-content', 'wipa-table-of-content' ];
	}

	public function get_custom_help_url() {
		return 'https://youtu.be/DbPrqUD8cOY';
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'section_content_table_of_content',
			[
				'label' => esc_html__( 'Table of Content', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'layout',
			[
				'label'    => __( 'Layout', 'avator-widget-pack' ),
				'type'     => Controls_Manager::SELECT,
				'default'  => 'offcanvas',
				'options'  => [
					'offcanvas' => esc_html__( 'Offcanvas', 'avator-widget-pack' ),
					'fixed'     => esc_html__( 'Fixed', 'avator-widget-pack' ),
					'dropdown'  => esc_html__( 'Dropdown', 'avator-widget-pack' ),
					'regular'   => esc_html__( 'Regular', 'avator-widget-pack' ),
				],
			]
		);

		$this->add_control(
			'index_align',
			[
				'label'    => __( 'Position', 'avator-widget-pack' ),
				'type'     => Controls_Manager::SELECT,
				'default'  => 'left',
				'options'  => [
					'left'     => esc_html__( 'Left', 'avator-widget-pack' ),
					'right'    => esc_html__( 'Right', 'avator-widget-pack' ),
				],
				'condition' => [
					'layout' => 'offcanvas',
				]
			]
		);

		$this->add_control(
			'fixed_position',
			[
				'label'    => __( 'Position', 'avator-widget-pack' ),
				'type'     => Controls_Manager::SELECT,
				'default'  => 'top-left',
				'options'  => [
					'top-left'     => esc_html__( 'Top-Left', 'avator-widget-pack' ),
					'top-right'    => esc_html__( 'Top-Right', 'avator-widget-pack' ),
					'bottom-left'  => esc_html__( 'Bottom-Left', 'avator-widget-pack' ),
					'bottom-right' => esc_html__( 'Bottom-Right', 'avator-widget-pack' ),
				],
				'condition' => [
					'layout' => 'fixed',
				]
			]
		);

		$this->add_control(
			'selectors',
			[
				'label'    => __( 'Index Tags', 'avator-widget-pack' ),
				'description'    => __( 'Want to ignore any specific heading? Go to that heading advanced tab and enter <b>ignore-this-tag</b> class in <a href="http://prntscr.com/lvw4iy" target="_blank">CSS Classes</a> input field.', 'avator-widget-pack' ),
				'type'     => Controls_Manager::SELECT2,
				'multiple' => true,
				'default'  => ['h2', 'h3', 'h4'],
				'options'  => widget_pack_heading_size(),
			]
		);

		$this->add_responsive_control(
			'fixed_index_horizontal_offset',
			[
				'label'     => __( 'Horizontal Offset', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SLIDER,
				'separator' => 'before',
				'default'   => [
					'size' => 0,
				],
				'tablet_default' => [
					'size' => 0,
				],
				'mobile_default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'min'  => -300,
						'step' => 2,
						'max'  => 300,
					],
				],
				'condition' => [
					'layout' => 'fixed'
				]
			]
		);

		$this->add_responsive_control(
			'fixed_index_vertical_offset',
			[
				'label'   => __( 'Vertical Offset', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
				'tablet_default' => [
					'size' => 0,
				],
				'mobile_default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'min'  => -300,
						'step' => 2,
						'max'  => 300,
					],
				],
				'selectors' => [
					'(desktop){{WRAPPER}} .avt-card-secondary' => 'transform: translate({{fixed_index_horizontal_offset.SIZE}}px, {{SIZE}}px);',
					'(tablet){{WRAPPER}} .avt-card-secondary'  => 'transform: translate({{fixed_index_horizontal_offset_tablet.SIZE}}px, {{SIZE}}px);',
					'(mobile){{WRAPPER}} .avt-card-secondary'  => 'transform: translate({{fixed_index_horizontal_offset_mobile.SIZE}}px, {{SIZE}}px);',
				],
				'condition' => [
					'layout' => 'fixed'
				]
			]
		);

		$this->add_control(
			'offset',
			[
				'label'     => __( 'Scroll Offset', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SLIDER,
				'separator' => 'before',
				'default'   => [
					'size' => 10,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 250,
					],
				],
			]
		);

		$this->add_responsive_control(
			'content_width',
			[
				'label'      => esc_html__( 'Width', 'avator-widget-pack' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vw' ],
				'range'      => [
					'px' => [
						'min' => 240,
						'max' => 1200,
					],
					'vw' => [
						'min' => 10,
						'max' => 100,
					]
				],
				'selectors' => [
					'#avt-toc-{{ID}} .avt-offcanvas-bar' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .avt-card-secondary'    => 'width: {{SIZE}}{{UNIT}};',
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_ofc_btn',
			[
				'label'     => esc_html__( 'Button', 'avator-widget-pack' ),
				'condition' => [
					'layout!' => ['fixed', 'regular']
				]
			]
		);

		$this->add_control(
			'button_text',
			[
				'label'       => __( 'Button Text', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'default'     => 'Table Of Index',
				'placeholder' => 'Table of Index',
			]
		);

		$this->add_control(
			'table_button_icon',
			[
				'label'       => __( 'Button Icon', 'avator-widget-pack' ),
				'type'        => Controls_Manager::ICONS,
				'fa4compatibility' => 'button_icon',
				'default' => [
					'value' => 'fas fa-book',
					'library' => 'fa-solid',
				],
			]
		);

		$this->add_control(
			'button_icon_align',
			[
				'label'   => __( 'Icon Position', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'right',
				'options' => [
					'left'   => __( 'Left', 'avator-widget-pack' ),
					'right'  => __( 'Right', 'avator-widget-pack' ),
				],
				'condition' => [
					'table_button_icon[value]!' => '',
				],
			]
		);

		$this->add_control(
			'button_icon_indent',
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
					'table_button_icon[value]!' => '',
					'button_text[value]!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-button-icon-align-right' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .avt-button-icon-align-left'  => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'button_position',
			[
				'label'   => esc_html__( 'Button Position', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'options' => widget_pack_position(),
				'default' => 'top-left',
				'condition' => [
					'layout' => ['offcanvas', 'dropdown'],
				]
			]
		);

		$this->add_responsive_control(
			'btn_horizontal_offset',
			[
				'label' => __( 'Horizontal Offset', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'min'  => -300,
						'step' => 2,
						'max'  => 300,
					],
				],
			]
		);

		$this->add_responsive_control(
			'btn_vertical_offset',
			[
				'label' => __( 'Vertical Offset', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'min'  => -300,
						'step' => 2,
						'max'  => 300,
					],
				],
			]
		);

		$this->add_responsive_control(
			'button_rotate',
			[
				'label'   => esc_html__( 'Rotate', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'min'  => -180,
						'max'  => 180,
						'step' => 5,
					],
				],
				'selectors' => [
					'(desktop){{WRAPPER}} .avt-toggle-button-wrapper' => 'transform: translate({{btn_horizontal_offset.SIZE}}px, {{btn_vertical_offset.SIZE}}px) rotate({{SIZE}}deg);',
					'(tablet){{WRAPPER}} .avt-toggle-button-wrapper' => 'transform: translate({{btn_horizontal_offset_tablet.SIZE}}px, {{btn_vertical_offset_tablet.SIZE}}px) rotate({{SIZE}}deg);',
					'(mobile){{WRAPPER}} .avt-toggle-button-wrapper' => 'transform: translate({{btn_horizontal_offset_mobile.SIZE}}px, {{btn_vertical_offset_mobile.SIZE}}px) rotate({{SIZE}}deg);',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_dropdown_option',
			[
				'label'     => esc_html__( 'Dropdown Options', 'avator-widget-pack' ),
				'condition' => [
					'layout' => 'dropdown',
				]
			]
		);

		$this->add_control(
			'drop_position',
			[
				'label'   => esc_html__( 'Position', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'bottom-left',
				'options' => widget_pack_drop_position(),
			]
		);

		$this->add_control(
			'drop_mode',
			[
				'label'   => esc_html__( 'Mode', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'hover',
				'options' => [
					'click'    => esc_html__('Click', 'avator-widget-pack'),
					'hover'  => esc_html__('Hover', 'avator-widget-pack'),
				],
			]
		);

		$this->add_control(
			'drop_flip',
			[
				'label' => esc_html__( 'Flip Dropbar', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);
		
		$this->add_control(
			'drop_offset',
			[
				'label'   => esc_html__( 'Dropbar Offset', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'max' => 100,
						'step' => 5,
					],
				],
			]
		);

		$this->add_control(
			'drop_animation',
			[
				'label'     => esc_html__( 'Animation', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'fade',
				'options'   => widget_pack_transition_options(),
				'separator' => 'before',
			]
		);

		$this->add_control(
			'drop_duration',
			[
				'label'   => esc_html__( 'Animation Duration', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 200,
				],
				'range' => [
					'px' => [
						'max' => 4000,
						'step' => 50,
					],
				],
				'condition' => [
					'drop_animation!' => '',
				],
			]
		);

		$this->add_control(
			'drop_show_delay',
			[
				'label'   => esc_html__( 'Show Delay', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'max' => 1000,
						'step' => 100,
					],
				],
			]
		);

		$this->add_control(
			'drop_hide_delay',
			[
				'label'   => esc_html__( 'Hide Delay', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 800,
				],
				'range' => [
					'px' => [
						'max' => 10000,
						'step' => 100,
					],
				],
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'section_additional_table_of_content',
			[
				'label' => esc_html__( 'Additional', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'context',
			[
				'label'       => __( 'Index Area (any class/id selector)', 'avator-widget-pack' ),
				'description'       => __( 'Any class or ID selector accept here for your table of content.', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'default'     => '.elementor',
				'placeholder' => '.elementor / #container',
			]
		);

		$this->add_control(
			'auto_collapse',
			[
				'label'     => esc_html__( 'Auto Collapse Sub Index', 'avator-widget-pack' ),
				'separator' => 'before',
				'type'      => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'history',
			[
				'label' => esc_html__( 'Index Click History', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

        $this->add_control(
            'toc_index_header',
            [
                'label'       => __( 'Index Header Text', 'avator-widget-pack' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'placeholder' => 'Table of Content',
                'separator'   => 'before',
            ]
        );

        $this->add_control(
            'toc_sticky_mode',
            [
                'label'   => esc_html__( 'Index Sticky', 'avator-widget-pack' ),
                'type'    => Controls_Manager::SWITCHER,
                'condition' => [
                    'layout' => 'regular',
                ],
                'separator'   => 'before',
            ]
        );

        $this->add_control(
            'toc_sticky_offset',
            [
                'label'   => esc_html__( 'Sticky Offset', 'avator-widget-pack' ),
                'type'    => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 0,
                ],
                'condition' => [
                    'toc_sticky_mode' => 'yes',
                    'layout' => 'regular',
                ],
            ]
        );

        $this->add_control(
            'toc_sticky_on_scroll_up',
            [
                'label'        => esc_html__( 'Sticky on Scroll Up', 'avator-widget-pack' ),
                'type'         => Controls_Manager::SWITCHER,
                'description'  => esc_html__( 'Set sticky options when you scroll up your mouse.', 'avator-widget-pack' ),
                'condition' => [
                    'toc_sticky_mode' => 'yes',
                    'layout' => 'regular',
                ],
            ]
        );

        $this->add_control(
            'toc_sticky_edge',
            [
                'label'       => __( 'Scroll Until', 'avator-widget-pack' ),
                'description' => __( 'Set the css class/ID scrolling edge point. usually it\'s parent section class/ID', 'avator-widget-pack' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'placeholder' => '#parent-section',
            ]
        );

		$this->end_controls_section();

        $this->start_controls_section(
            'section_style_offcanvas',
            [
                'label' => esc_html__( 'Index', 'avator-widget-pack' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'index_background',
            [
                'label'     => __( 'Background', 'avator-widget-pack' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '#avt-toc-{{ID}} > div' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'     => __( 'Title Color', 'avator-widget-pack' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '#avt-toc-{{ID}} .avt-nav li a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_active_color',
            [
                'label'     => __( 'Active Title Color', 'avator-widget-pack' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '#avt-toc-{{ID}} .avt-nav > li.avt-active > a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
        	'index_spacing',
        	[
        		'label'   => esc_html__( 'Spacing', 'avator-widget-pack' ),
        		'type'    => Controls_Manager::SLIDER,
        		'range' => [
        			'px' => [
        				'min' => 0,
        				'max' => 20,
        			],
        		],
        		'size_units' => [ 'px' ],
        		'selectors'  => [
        			'.avt-table-of-content .avt-nav>.avt-nav li a' => 'padding: {{SIZE}}{{UNIT}} 0;',
        		],
        	]
        );

        $this->add_responsive_control(
            'index_padding',
            [
                'label'      => __( 'Padding', 'avator-widget-pack' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '#avt-toc-{{ID}} > div' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'index_typography',
                'selector' => '#avt-toc-{{ID}} .avt-nav > li > a',
            ]
        );

        $this->end_controls_section();

		$this->start_controls_section(
			'section_style_ofc_btn',
			[
				'label'     => esc_html__( 'Button', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'layout!' => ['fixed', 'regular']
				]
			]
		);

		$this->start_controls_tabs( 'tabs_ofc_btn_style' );

		$this->start_controls_tab(
			'tab_ofc_btn_normal',
			[
				'label' => esc_html__( 'Normal', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'button_background',
			[
				'label'     => __( 'Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-toggle-button-wrapper a.avt-toggle-button' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_color',
			[
				'label'     => __( 'Text/Icon Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-toggle-button-wrapper a.avt-toggle-button' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-toggle-button-wrapper a.avt-toggle-button svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_shadow',
				'selector' => '{{WRAPPER}} .avt-toggle-button-wrapper a.avt-toggle-button'
			]
		);

		$this->add_responsive_control(
			'button_padding',
			[
				'label'      => __( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-toggle-button-wrapper a.avt-toggle-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'button_border',
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-toggle-button-wrapper a.avt-toggle-button'
			]
		);

		$this->add_control(
			'button_radius',
			[
				'label'      => __( 'Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-toggle-button-wrapper a.avt-toggle-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'button_typography',
				'selector' => '{{WRAPPER}} .avt-toggle-button-wrapper a.avt-toggle-button',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_ofc_btn_hover',
			[
				'label' => esc_html__( 'Hover', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'ofc_btn_hover_color',
			[
				'label'     => esc_html__( 'Text/Icon Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-toggle-button-wrapper a.avt-toggle-button:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-toggle-button-wrapper a.avt-toggle-button:hover svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'ofc_btn_hover_bg',
			[
				'label'     => esc_html__( 'Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-toggle-button-wrapper a.avt-toggle-button:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'ofc_btn_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'ofc_btn_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-toggle-button-wrapper a.avt-toggle-button:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		
		$this->end_controls_tabs();

		$this->end_controls_section();


	}	

	protected function render() {
		$settings = $this->get_settings_for_display();

		if ('dropdown' == $settings['layout']) {
			$this->layout_dropdown();
		} elseif ('fixed' == $settings['layout']) {
			$this->layout_fixed();
		} elseif ('regular' == $settings['layout']) {
			$this->layout_regular();
		} else {
			$this->layout_offcanvas();
		}
	}

	private function render_toggle_button_content() {
		$settings    = $this->get_settings_for_display();

		if ( ! isset( $settings['button_icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
			// add old default
			$settings['button_icon'] = 'fas fa-arrow-right';
		}
		
		$migrated  = isset( $settings['__fa4_migrated']['table_button_icon'] );
		$is_new    = empty( $settings['button_icon'] ) && Icons_Manager::is_migration_allowed();

		$settings['button_icon'] = 'fa fa-book';

		?>
		<span class="elementor-button-content-wrapper">

			<?php if ($settings['button_text']) : ?>
				<span class="avt-toggle-button-text">
					<?php echo esc_html( $settings['button_text'] ); ?>
				</span>
			<?php endif; ?>

			<?php if ( $is_new || $migrated || $settings['button_icon'] ) : ?>
				<span class="avt-toggle-button-icon elementor-button-icon avt-button-icon-align-<?php echo esc_attr($settings['button_icon_align']); ?>">

					<?php if ( $is_new || $migrated ) :
						Icons_Manager::render_icon( $settings['table_button_icon'], [ 'aria-hidden' => 'true', 'class' => 'fa-fw' ] );
					else : ?>
						<i class="<?php echo esc_attr( $settings['button_icon'] ); ?>" aria-hidden="true"></i>
					<?php endif; ?>

				</span>
			<?php endif; ?>

		</span>
		<?php
	}

	private function layout_fixed() {
		$settings    = $this->get_settings_for_display();
        $id       = 'avt-toc-' . $this->get_id();
		?>
		<div class="table-of-content-layout-fixed avt-position-<?php echo esc_attr( $settings['fixed_position'] ); ?>" id="<?php echo esc_attr($id); ?>">
			<div class="avt-card avt-card-secondary avt-card-body">
                <?php $this->table_of_content_header(); ?>
				<?php $this->table_of_content(); ?>
			</div>
		</div>
		<?php
	}

	private function layout_regular() {
		$settings    = $this->get_settings_for_display();
        $id       = 'avt-toc-' . $this->get_id();

        $this->add_render_attribute( 'toc-regular', 'class', 'table-of-content-layout-regular' );
        $this->add_render_attribute( 'toc-regular', 'id', esc_attr($id) );

        if ('yes' == $settings['toc_sticky_mode'] ) {

            $this->add_render_attribute( 'toc-regular', 'avt-sticky', '' );

            if ($settings[ 'toc_sticky_offset' ]['size']) {
                $this->add_render_attribute( 'toc-regular', 'avt-sticky', 'offset: ' . $settings[ 'toc_sticky_offset' ]['size'] . ';'  );
            }
            if ($settings['toc_sticky_on_scroll_up']) {
                $this->add_render_attribute( 'toc-regular', 'avt-sticky', 'show-on-up: true; animation: avt-animation-slide-top;'  );
            }
            if ($settings['toc_sticky_edge']) {
                $this->add_render_attribute( 'toc-regular', 'avt-sticky', 'bottom: ' . esc_attr($settings['toc_sticky_edge']) . ';' );
            }
        }

		?>
		<div <?php echo $this->get_render_attribute_string( 'toc-regular' ); ?>>
            <div>
                <?php $this->table_of_content_header(); ?>
                <?php $this->table_of_content(); ?>
            </div>
		</div>
		<?php
	}

	private function layout_dropdown() {
		$settings = $this->get_settings_for_display();
		$id       = 'avt-toc-' . $this->get_id();

		$this->add_render_attribute(
			[
				'drop-settings' => [
					'class'    => ['avt-drop', 'avt-card', 'avt-card-secondary'],
					'avt-drop' => [
						wp_json_encode([
							"toggle"     => "#" . $id,
							"pos"        => $settings["drop_position"],
							"mode"       => $settings["drop_mode"],
							"delay-show" => $settings["drop_show_delay"]["size"],
							"delay-hide" => $settings["drop_hide_delay"]["size"],
							"flip"       => $settings["drop_flip"] ? true : false,
							"offset"     => $settings["drop_offset"]["size"],
							"animation"  => $settings["drop_animation"] ? "avt-animation-" . $settings["drop_animation"] : false,
							"duration"   => ($settings["drop_duration"]["size"] and $settings["drop_animation"]) ? $settings["drop_duration"]["size"] : "0"
						]),
					],
				],
			]
		);


		?>
		<div class="table-of-content-layout-dropdown">
			<div class="avt-toggle-button-wrapper avt-position-fixed avt-position-<?php echo esc_attr($settings['button_position']); ?>">
				<a id="<?php echo esc_attr($id); ?>" class="avt-toggle-button elementor-button elementor-size-sm" href="#">
					<?php $this->render_toggle_button_content(); ?>
				</a>
			</div>
			<div <?php echo $this->get_render_attribute_string( 'drop-settings' ); ?>>
				<div class="avt-card-body">
					<?php $this->table_of_content_header(); ?>
					<?php $this->table_of_content(); ?>
				</div>
			</div>
		</div>
		<?php
	}

	private function table_of_content_header() {
        $settings    = $this->get_settings_for_display();

        if (empty($settings['toc_index_header'])) {
            return;
        }
        ?>
        <div class="avt-table-of-content-header">
            <h4><?php echo esc_html($settings['toc_index_header']); ?></h4>
        </div>
        <?php
    }

	private function layout_offcanvas() {

        $settings    = $this->get_settings_for_display();
		$id          = 'avt-toc-' . $this->get_id();
		$index_align = $settings['index_align'] ? : 'right';

		$this->add_render_attribute( 'offcanvas', 'id',  $id );
		$this->add_render_attribute( 'offcanvas', 'class',  [ 'avt-offcanvas', 'avt-ofc-table-of-content', 'avt-flex', 'avt-flex-middle' ] );

		if ( 'right' == $index_align ) {
			$this->add_render_attribute( 'offcanvas', 'avt-offcanvas',  'flip: true');
		} else {
			$this->add_render_attribute( 'offcanvas', 'avt-offcanvas',  '');
		}

		?>
		<div class="table-of-content-layout-offcanvas" >
			<div class="avt-toggle-button-wrapper avt-position-fixed avt-position-<?php echo esc_attr($settings['button_position']); ?>">
				<a class="avt-toggle-button elementor-button elementor-size-sm" avt-toggle="target: #<?php echo esc_attr($id); ?>" href="#">
					<?php $this->render_toggle_button_content(); ?>
				</a>
			</div>				

			<div <?php echo $this->get_render_attribute_string( 'offcanvas' ); ?>>
				<div class="avt-offcanvas-bar avt-offcanvas-push">
					<button class="avt-offcanvas-close" type="button" avt-close></button>
                    <?php $this->table_of_content_header(); ?>
					<?php $this->table_of_content(); ?>
				</div>
			</div>
		</div>
		<?php
	}

	private function table_of_content() {
		$settings    = $this->get_settings_for_display();

		$this->add_render_attribute(
			[
				'table-of-content' => [
					'data-settings' => [
						wp_json_encode(array_filter([
							"context"        => $settings["context"],
							"selectors"      => implode(",", $settings["selectors"]),
							"ignoreSelector" => ".ignore-this-tag [class*='-heading-title']",
							"showAndHide"    => $settings["auto_collapse"] ? true : false,
							"scrollTo"       => $settings["offset"]["size"],
							"history"        => $settings["history"] ? true : false,							
				        ]))
					]
				]
			]
		);

		?>
		<div class="avt-table-of-content" <?php echo $this->get_render_attribute_string( 'table-of-content' ); ?>></div>
		<?php
	}
}
