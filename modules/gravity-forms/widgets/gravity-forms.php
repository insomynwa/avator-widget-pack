<?php
namespace WidgetPack\Modules\GravityForms\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Box_Shadow;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Gravity_Forms extends Widget_Base {

	public function get_name() {
		return 'avt-gravity-form';
	}

	public function get_title() {
		return AWP . esc_html__( 'Gravity Forms', 'avator-widget-pack' );
	}

	public function get_icon() {
		return 'avt-wi-gravity-form';
	}

	public function get_categories() {
		return [ 'widget-pack' ];
	}

	public function get_keywords() {
		return [ 'gravity', 'form', 'contact', 'community' ];
	}

	public function get_style_depends() {
		return [ 'avt-gravity-form' ];
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_content_layout',
			[
				'label' => esc_html__( 'Layout', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'gravity_form',
			[
				'label'   => esc_html__( 'Select Form', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '0',
				'options' => widget_pack_gravity_forms_options(),
			]
		);


		$this->add_control(
		    'title_hide',
		    [
				'label'   => __( 'Title', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
		    ]
		);
		
		$this->add_control(
		    'description_hide',
		    [
				'label'   => __( 'Description', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
		    ]
		);
		
		$this->add_control(
		    'form_ajax',
		    [
				'label'       => __( 'Use Ajax', 'avator-widget-pack' ),
				'type'        => Controls_Manager::SWITCHER,
				'description' => __( 'Use ajax to submit the form', 'avator-widget-pack' ),
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
		    'text_color_label',
		    [
				'label'     => __( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
		            '{{WRAPPER}} .avt-gravity-forms .gfield label' => 'color: {{VALUE}}',
		        ],
		    ]
		);
		
		$this->add_group_control(
		    Group_Control_Typography::get_type(),
		    [
				'name'     => 'typography_label',
				'label'    => __( 'Typography', 'avator-widget-pack' ),
				'selector' => '{{WRAPPER}} .avt-gravity-forms .gfield label',
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

        $this->add_responsive_control(
            'input_alignment',
            [
				'label'   => __( 'Alignment', 'avator-widget-pack' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'left'      => [
						'title' => __( 'Left', 'avator-widget-pack' ),
						'icon'  => 'fas fa-align-left',
					],
					'center'    => [
						'title' => __( 'Center', 'avator-widget-pack' ),
						'icon'  => 'fas fa-align-center',
					],
					'right'     => [
						'title' => __( 'Right', 'avator-widget-pack' ),
						'icon'  => 'fas fa-align-right',
					],
				],
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .avt-gravity-forms .gfield input[type="text"], 
					 {{WRAPPER}} .avt-gravity-forms .gfield textarea' => 'text-align: {{VALUE}};',
				],
			]
		);

        $this->start_controls_tabs( 'tabs_fields_style' );

        $this->start_controls_tab(
            'tab_fields_normal',
            [
				'label' => __( 'Normal', 'avator-widget-pack' ),
            ]
        );

        $this->add_control(
            'field_bg_color',
            [
				'label'     => __( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
                    '{{WRAPPER}} .avt-gravity-forms .gfield input[type="text"], 
                     {{WRAPPER}} .avt-gravity-forms .gfield textarea, {{WRAPPER}} .avt-gravity-forms .gfield select' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'field_text_color',
            [
				'label'     => __( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
                    '{{WRAPPER}} .avt-gravity-forms .gfield input[type="text"], 
                     {{WRAPPER}} .avt-gravity-forms .gfield textarea, {{WRAPPER}} .avt-gravity-forms .gfield select' => 'color: {{VALUE}}',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'field_spacing',
            [
				'label' => __( 'Spacing', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
                    ],
                ],
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
                    '{{WRAPPER}} .avt-gravity-forms .gfield' => 'margin-bottom: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

		$this->add_responsive_control(
			'field_padding',
			[
				'label'      => __( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-gravity-forms .gform_wrapper input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file]), 
					 {{WRAPPER}} .avt-gravity-forms .gfield textarea' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
        
        $this->add_responsive_control(
            'text_indent',
            [
				'label' => __( 'Text Indent', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min'  => 0,
						'max'  => 60,
                    ],
					'%' => [
						'min'  => 0,
						'max'  => 30,
                    ],
                ],
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
                    '{{WRAPPER}} .avt-gravity-forms .gfield input[type="text"], 
                     {{WRAPPER}} .avt-gravity-forms .gfield textarea, {{WRAPPER}} .avt-gravity-forms .gfield select' => 'text-indent: {{SIZE}}{{UNIT}}',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'input_width',
            [
				'label' => __( 'Input Width', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
                    'px' => [
						'min'  => 0,
						'max'  => 1200,
                    ],
                ],
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
                    '{{WRAPPER}} .avt-gravity-forms .gfield input[type="text"], 
                     {{WRAPPER}} .avt-gravity-forms .gfield select' => 'width: {{SIZE}}{{UNIT}}',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'input_height',
            [
				'label' => __( 'Input Height', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
                    'px' => [
						'min'  => 0,
						'max'  => 80,
                    ],
                ],
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
                    '{{WRAPPER}} .avt-gravity-forms .gfield input[type="text"], 
                     {{WRAPPER}} .avt-gravity-forms .gfield input[type="email"], 
                     {{WRAPPER}} .avt-gravity-forms .gfield input[type="url"], 
                     {{WRAPPER}} .avt-gravity-forms .gfield select' => 'height: {{SIZE}}{{UNIT}}',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'textarea_width',
            [
				'label' => __( 'Textarea Width', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
                    'px' => [
						'min'  => 0,
						'max'  => 1200,
                    ],
                ],
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
                    '{{WRAPPER}} .avt-gravity-forms .gfield textarea' => 'width: {{SIZE}}{{UNIT}}',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'textarea_height',
            [
				'label' => __( 'Textarea Height', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
                    'px' => [
						'min'  => 0,
						'max'  => 400,
                    ],
                ],
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
                    '{{WRAPPER}} .avt-gravity-forms .gfield textarea' => 'height: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'field_border',
				'label'       => __( 'Border', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-gravity-forms .gfield input[type="text"], 
								  {{WRAPPER}} .avt-gravity-forms .gfield textarea, {{WRAPPER}} .avt-gravity-forms .gfield select',
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'field_radius',
			[
				'label'      => __( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-gravity-forms .gfield input[type="text"], 
					 {{WRAPPER}} .avt-gravity-forms .gfield textarea' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
				'name'      => 'field_typography',
				'label'     => __( 'Typography', 'avator-widget-pack' ),
				'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
				'selector'  => '{{WRAPPER}} .avt-gravity-forms .gfield input[type="text"], 
								{{WRAPPER}} .avt-gravity-forms .gfield textarea, {{WRAPPER}} .avt-gravity-forms .gfield select',
				'separator' => 'before',
            ]
        );

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'field_box_shadow',
				'selector'  => '{{WRAPPER}} .avt-gravity-forms .gfield input[type="text"], 
								{{WRAPPER}} .avt-gravity-forms .gfield textarea, {{WRAPPER}} .avt-gravity-forms .gfield select',
				'separator' => 'before',
			]
		);

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_fields_focus',
            [
				'label' => __( 'Focus', 'avator-widget-pack' ),
            ]
        );

        $this->add_control(
            'field_bg_color_focus',
            [
				'label'     => __( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
                    '{{WRAPPER}} .avt-gravity-forms .gfield input:focus, 
    				 {{WRAPPER}} .avt-gravity-forms .gfield textarea:focus' => 'background-color: {{VALUE}}',
                ],
            ]
        );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'focus_input_border',
				'label'       => __( 'Border', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-gravity-forms .gfield input:focus, 
								  {{WRAPPER}} .avt-gravity-forms .gfield textarea:focus',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'focus_box_shadow',
				'selector'  => '{{WRAPPER}} .avt-gravity-forms .gfield input:focus, 
				 				{{WRAPPER}} .avt-gravity-forms .gfield textarea:focus',
				'separator' => 'before',
			]
		);

        $this->end_controls_tab();

        $this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
		    'section_field_description_style',
		    [
				'label' => __( 'Field Description', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
		    ]
		);

		$this->add_control(
		    'field_description_text_color',
		    [
				'label'     => __( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
		            '{{WRAPPER}} .avt-gravity-forms .gfield .gfield_description' => 'color: {{VALUE}}',
		        ],
		    ]
		);
		
		$this->add_group_control(
		    Group_Control_Typography::get_type(),
		    [
				'name'     => 'field_description_typography',
				'label'    => __( 'Typography', 'avator-widget-pack' ),
				'selector' => '{{WRAPPER}} .avt-gravity-forms .gfield .gfield_description',
		    ]
		);
		
		$this->add_responsive_control(
		    'field_description_spacing',
		    [
				'label' => __( 'Spacing', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
		            ],
		        ],
		        'size_units'            => [ 'px', 'em', '%' ],
		        'selectors'             => [
		            '{{WRAPPER}} .avt-gravity-forms .gfield .gfield_description' => 'padding-top: {{SIZE}}{{UNIT}}',
		        ],
		    ]
		);
		
		$this->end_controls_section();

        $this->start_controls_section(
            'section_field_style',
            [
				'label' => __( 'Section Field', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'section_field_text_color',
            [
				'label'     => __( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
                    '{{WRAPPER}} .avt-gravity-forms .gfield.gsection .gsection_title' => 'color: {{VALUE}}',
                ],
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
				'name'      => 'section_field_typography',
				'label'     => __( 'Typography', 'avator-widget-pack' ),
				'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
				'selector'  => '{{WRAPPER}} .avt-gravity-forms .gfield.gsection .gsection_title',
				'separator' => 'before',
            ]
        );
        
        $this->add_control(
            'section_field_border_type',
            [
				'label'   => __( 'Border Type', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'solid',
				'options' => [
					'none'   => __( 'None', 'avator-widget-pack' ),
					'solid'  => __( 'Solid', 'avator-widget-pack' ),
					'double' => __( 'Double', 'avator-widget-pack' ),
					'dotted' => __( 'Dotted', 'avator-widget-pack' ),
					'dashed' => __( 'Dashed', 'avator-widget-pack' ),
                ],
				'selectors' => [
                    '{{WRAPPER}} .avt-gravity-forms .gfield.gsection' => 'border-bottom-style: {{VALUE}}',
                ],
				'separator' => 'before',
            ]
        );
        
        $this->add_responsive_control(
            'section_field_border_height',
            [
				'label'   => __( 'Border Height', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 1,
                ],
				'range' => [
                    'px' => [
						'min'  => 1,
						'max'  => 20,
                    ],
                ],
				'size_units' => [ 'px' ],
				'selectors'  => [
                    '{{WRAPPER}} .avt-gravity-forms .gfield.gsection' => 'border-bottom-width: {{SIZE}}{{UNIT}}',
                ],
				'condition' => [
					'section_field_border_type!' => 'none',
                ],
            ]
        );

        $this->add_control(
            'section_field_border_color',
            [
				'label'     => __( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
                    '{{WRAPPER}} .avt-gravity-forms .gfield.gsection' => 'border-bottom-color: {{VALUE}}',
                ],
				'condition' => [
                    'section_field_border_type!'   => 'none',
                ],
            ]
        );

		$this->add_responsive_control(
			'section_field_margin',
			[
				'label'      => __( 'Margin', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-gravity-forms .gfield.gsection' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);
        
        $this->end_controls_section();

        $this->start_controls_section(
            'section_price_style',
            [
				'label' => __( 'Price', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'price_label_color',
            [
				'label'     => __( 'Price Label Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
                    '{{WRAPPER}} .avt-gravity-forms .gform_wrapper .ginput_product_price_label' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'price_text_color',
            [
				'label'     => __( 'Price Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
                    '{{WRAPPER}} .avt-gravity-forms .gform_wrapper .ginput_product_price' => 'color: {{VALUE}}',
                ],
            ]
        );
        
        $this->end_controls_section();

        $this->start_controls_section(
            'section_placeholder_style',
            [
				'label' => __( 'Placeholder', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'text_color_placeholder',
            [
				'label'     => __( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
                    '{{WRAPPER}} .avt-gravity-forms .gfield input::-webkit-input-placeholder, 
                     {{WRAPPER}} .avt-gravity-forms .gfield textarea::-webkit-input-placeholder' => 'color: {{VALUE}}',
                ],
            ]
        );
        
        $this->end_controls_section();

        $this->start_controls_section(
            'section_radio_checkbox_style',
            [
				'label' => __( 'Radio & Checkbox', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_control(
            'custom_radio_checkbox',
            [
				'label' => __( 'Custom Styles', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SWITCHER,
				'prefix_class' => 'avt-custom-rc-',
            ]
        );
        
        $this->add_responsive_control(
            'radio_checkbox_size',
            [
				'label'   => __( 'Size', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem' ],
				'default'    => [
					'unit' => 'px',
					'size' => 20,
				],
				'range'      => [
					'px' => [
						'min' => 15,
						'max' => 50,
					],
				],
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
                     '{{WRAPPER}}.avt-custom-rc-yes .avt-gravity-forms .gform_wrapper .gfield_checkbox input[type=checkbox], 
                      {{WRAPPER}}.avt-custom-rc-yes .avt-gravity-forms .gform_wrapper .gfield_radio input[type=radio]' => 'width: {{SIZE}}{{UNIT}} !important; height:{{SIZE}}{{UNIT}};',
                ],
				'condition' => [
					'custom_radio_checkbox' => 'yes',
                ],
            ]
        );

        $this->start_controls_tabs( 'tabs_radio_checkbox_style' );

        $this->start_controls_tab(
            'radio_checkbox_normal',
            [
				'label'     => __( 'Normal', 'avator-widget-pack' ),
				'condition' => [
					'custom_radio_checkbox' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'radio_checkbox_color',
            [
				'label'     => __( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
                    '{{WRAPPER}}.avt-custom-rc-yes .avt-gravity-forms .gform_wrapper .gfield_checkbox input[type=checkbox], 
                      {{WRAPPER}}.avt-custom-rc-yes .avt-gravity-forms .gform_wrapper .gfield_radio input[type=radio]' => 'background-color: {{VALUE}}',
                ],
				'condition' => [
                    'custom_radio_checkbox' => 'yes',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'radio_checkbox_border_width',
            [
				'label' => __( 'Border Width', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min'  => 0,
						'max'  => 15,
                    ],
                ],
				'size_units' => [ 'px' ],
				'selectors'  => [
                    '{{WRAPPER}}.avt-custom-rc-yes .avt-gravity-forms .gform_wrapper ul.gfield_checkbox li input[type=checkbox], {{WRAPPER}}.avt-custom-rc-yes .avt-gravity-forms .gform_wrapper ul.gfield_radio li input[type=radio]' => 'border-width: {{SIZE}}{{UNIT}}',
                ],
				'condition' => [
                    'custom_radio_checkbox' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'radio_checkbox_border_color',
            [
				'label'     => __( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
                    '{{WRAPPER}}.avt-custom-rc-yes .avt-gravity-forms .gform_wrapper ul.gfield_checkbox li input[type=checkbox], {{WRAPPER}}.avt-custom-rc-yes .avt-gravity-forms .gform_wrapper ul.gfield_radio li input[type=radio]' => 'border-color: {{VALUE}}',
                ],
				'condition' => [
                    'custom_radio_checkbox' => 'yes',
                ],
            ]
        );
        
        $this->add_control(
            'checkbox_heading',
            [
				'label'     => __( 'Checkbox', 'avator-widget-pack' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => [
					'custom_radio_checkbox' => 'yes',
				],
            ]
        );

		$this->add_control(
			'checkbox_border_radius',
			[
				'label'      => __( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}}.avt-custom-rc-yes input[type="checkbox"], 
					 {{WRAPPER}}.avt-custom-rc-yes input[type="checkbox"]:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'condition'             => [
                    'custom_radio_checkbox' => 'yes',
                ],
			]
		);
        
        $this->add_control(
            'radio_heading',
            [
				'label'     => __( 'Radio Buttons', 'avator-widget-pack' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => [
					'custom_radio_checkbox' => 'yes',
				],
            ]
        );

		$this->add_control(
			'radio_border_radius',
			[
				'label'      => __( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}}.avt-custom-rc-yes input[type="radio"], 
					 {{WRAPPER}}.avt-custom-rc-yes input[type="radio"]:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'condition'             => [
                    'custom_radio_checkbox' => 'yes',
                ],
			]
		);

        $this->end_controls_tab();

        $this->start_controls_tab(
            'radio_checkbox_checked',
            [
				'label'     => __( 'Checked', 'avator-widget-pack' ),
				'condition' => [
                    'custom_radio_checkbox' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'radio_checkbox_color_checked',
            [
				'label'     => __( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
                    '{{WRAPPER}}.avt-custom-rc-yes .avt-gravity-forms .gform_wrapper .gfield_radio input[type=radio]:checked, 
                     {{WRAPPER}}.avt-custom-rc-yes .avt-gravity-forms .gform_wrapper .gfield_checkbox input[type=checkbox]:checked, 
                     {{WRAPPER}}.avt-custom-rc-yes .avt-gravity-forms .gform_wrapper .gfield_checkbox input[type=checkbox]:indeterminate' => 'background-color: {{VALUE}}',
                ],
                'condition'             => [
                    'custom_radio_checkbox' => 'yes',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();
        
        $this->end_controls_section();

		$this->start_controls_section(
			'section_style_submit_button',
			[
				'label' => esc_html__( 'Submit Button', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

        $this->add_responsive_control(
			'button_align',
			[
				'label'   => __( 'Alignment', 'avator-widget-pack' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'left'        => [
						'title'   => __( 'Left', 'avator-widget-pack' ),
						'icon'    => 'eicon-h-align-left',
					],
					'center'      => [
						'title'   => __( 'Center', 'avator-widget-pack' ),
						'icon'    => 'eicon-h-align-center',
					],
					'right'       => [
						'title'   => __( 'Right', 'avator-widget-pack' ),
						'icon'    => 'eicon-h-align-right',
					],
				],
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .avt-gravity-forms .gform_footer'   => 'text-align: {{VALUE}};',
                    '{{WRAPPER}} .avt-gravity-forms .gform_footer input[type="submit"]' => 'display:inline-block;'
				],
                'condition'             => [
                    'button_width_type' => 'custom',
                ],
			]
		);
        
        $this->add_control(
            'button_width_type',
            [
				'label'   => __( 'Width', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'custom',
				'options' => [
					'full-width' => __( 'Full Width', 'avator-widget-pack' ),
					'custom'     => __( 'Custom', 'avator-widget-pack' ),
                ],
				'prefix_class' => 'avt-gravity-form-button-',
            ]
        );
        
        $this->add_responsive_control(
            'button_width',
            [
				'label'   => __( 'Width', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => '100',
					'unit' => 'px'
                ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1200,
                    ],
                ],
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
                    '{{WRAPPER}} .avt-gravity-forms .gform_footer input[type="submit"]' => 'width: {{SIZE}}{{UNIT}}',
                ],
                'condition'             => [
                    'button_width_type' => 'custom',
                ],
            ]
        );

        $this->start_controls_tabs( 'tabs_button_style' );

        $this->start_controls_tab(
            'tab_button_normal',
            [
				'label' => __( 'Normal', 'avator-widget-pack' ),
            ]
        );

        $this->add_control(
            'button_bg_color_normal',
            [
				'label'     => __( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
                    '{{WRAPPER}} .avt-gravity-forms .gform_footer input[type="submit"]' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'button_text_color_normal',
            [
				'label'     => __( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
                    '{{WRAPPER}} .avt-gravity-forms .gform_footer input[type="submit"]' => 'color: {{VALUE}}',
                ],
            ]
        );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'button_border_normal',
				'label'       => __( 'Border', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-gravity-forms .gform_footer input[type="submit"]',
			]
		);

		$this->add_control(
			'button_border_radius',
			[
				'label'      => __( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-gravity-forms .gform_footer input[type="submit"]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'button_padding',
			[
				'label'      => __( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-gravity-forms .gform_footer input[type="submit"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
        
        $this->add_responsive_control(
            'button_margin',
            [
				'label' => __( 'Margin Top', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
                    ],
                ],
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
                    '{{WRAPPER}} .avt-gravity-forms .gform_footer input[type="submit"]' => 'margin-top: {{SIZE}}{{UNIT}}',
                ],
            ]
        );
        
        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_button_hover',
            [
				'label' => __( 'Hover', 'avator-widget-pack' ),
            ]
        );

        $this->add_control(
            'button_bg_color_hover',
            [
				'label'     => __( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
                    '{{WRAPPER}} .avt-gravity-forms .gform_footer input[type="submit"]:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'button_text_color_hover',
            [
				'label'     => __( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
                    '{{WRAPPER}} .avt-gravity-forms .gform_footer input[type="submit"]:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'button_border_color_hover',
            [
				'label'     => __( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
                    '{{WRAPPER}} .avt-gravity-forms .gform_footer input[type="submit"]:hover' => 'border-color: {{VALUE}}',
                ],
            ]
        );
        
        $this->end_controls_tab();
        
        $this->end_controls_tabs();
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
				'name'      => 'button_typography',
				'label'     => __( 'Typography', 'avator-widget-pack' ),
				'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
				'selector'  => '{{WRAPPER}} .avt-gravity-forms .gform_footer input[type="submit"]',
				'separator' => 'before',
            ]
        );

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'button_box_shadow',
				'selector'  => '{{WRAPPER}} .avt-gravity-forms .gform_footer input[type="submit"]',
				'separator' => 'before',
			]
		);
        

		$this->end_controls_section();

        $this->start_controls_section(
            'section_error_style',
            [
				'label' => __( 'Errors', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_control(
            'error_messages_heading',
            [
				'label'     => __( 'Error Messages', 'avator-widget-pack' ),
				'type'      => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'error_message_text_color',
            [
				'label'     => __( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
                    '{{WRAPPER}} .avt-gravity-forms .gfield .validation_message' => 'color: {{VALUE}}',
                ],
            ]
        );
        
        $this->add_control(
            'validation_errors_heading',
            [
				'label'     => __( 'Validation Errors', 'avator-widget-pack' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
            ]
        );

        $this->add_control(
            'validation_error_description_color',
            [
				'label'     => __( 'Error Description Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
                    '{{WRAPPER}} .avt-gravity-forms .gform_wrapper .validation_error' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'validation_error_border_color',
            [
				'label'     => __( 'Error Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
                    '{{WRAPPER}} .avt-gravity-forms .gform_wrapper .validation_error' => 'border-top-color: {{VALUE}}; border-bottom-color: {{VALUE}}',
                    '{{WRAPPER}} .avt-gravity-forms .gfield_error' => 'border-top-color: {{VALUE}}; border-bottom-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'validation_errors_bg_color',
            [
				'label'     => __( 'Error Field Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
                    '{{WRAPPER}} .avt-gravity-forms .gfield_error' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'validation_error_field_label_color',
            [
				'label'     => __( 'Error Field Label Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
                    '{{WRAPPER}} .avt-gravity-forms .gfield_error .gfield_label' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'validation_error_field_input_border_color',
            [
				'label'     => __( 'Error Field Input Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
                    '{{WRAPPER}} .avt-gravity-forms .gform_wrapper li.gfield_error input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file]), 
                    {{WRAPPER}} .gform_wrapper li.gfield_error textarea' => 'border-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'validation_error_field_input_border_width',
            [
				'label'     => __( 'Error Field Input Border Width', 'avator-widget-pack' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 1,
				'min'       => 1,
				'max'       => 10,
				'selectors' => [
                    '{{WRAPPER}} .avt-gravity-forms .gform_wrapper li.gfield_error input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file]), 
                    {{WRAPPER}} .gform_wrapper li.gfield_error textarea' => 'border-width: {{VALUE}}px',
                ],
            ]
        );
        
        $this->end_controls_section();

		$this->start_controls_section(
			'section_style_additional_option',
			[
				'label' => esc_html__( 'Additional Option', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_control(
			'fullwidth_input',
			[
				'label'     => esc_html__( 'Fullwidth Input', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'selectors' => [
					'{{WRAPPER}} .field-wrap>div input:not([type*="button"])' => 'width: 100%;',
					'{{WRAPPER}} .field-wrap select'                        => 'width: 100%;',
				],
			]
		);
		
		$this->add_control(
			'fullwidth_textarea',
			[
				'label'     => esc_html__( 'Fullwidth Texarea', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'selectors' => [
					'{{WRAPPER}} .field-wrap textarea' => 'width: 100%;',
				],
			]
		);
		
		$this->add_control(
			'fullwidth_button',
			[
				'label'     => esc_html__( 'Fullwidth Button', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'selectors' => [
					'{{WRAPPER}} .field-wrap>div input[type*="button"]' => 'width: 100%;',
				],
			]
		);

		$this->end_controls_section();
	}

	private function get_shortcode() {
		$settings = $this->get_settings();

		if (!$settings['gravity_form']) {
			return '<div class="avt-alert avt-alert-warning">'.__('Please select a Contact Form From Setting!', 'avator-widget-pack').'</div>';
		}

		$attributes = [
			'id'          => $settings['gravity_form'],
			'ajax'        => $settings['form_ajax'] ? 'true' : 'false',
			'title'       => $settings['title_hide'] ? 'true' : 'false',
			'description' => $settings['description_hide'] ? 'true' : 'false',
		];

		$this->add_render_attribute( 'shortcode', $attributes );

		$shortcode   = [];
		$shortcode[] = sprintf( '[gravityform %s]', $this->get_render_attribute_string( 'shortcode' ) );

		return implode("", $shortcode);
	}

	public function render() {

		$this->add_render_attribute( 'contact-form', 'class', [ 'avt-gravity-forms' ] );

		?>
		<div <?php echo $this->get_render_attribute_string( 'contact-form' ); ?>>
			<?php echo do_shortcode( $this->get_shortcode() ); ?>
		</div>
		<?php
	}

	public function render_plain_content() {
		echo $this->get_shortcode();
	}
}
