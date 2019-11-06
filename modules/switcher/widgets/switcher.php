<?php
namespace WidgetPack\Modules\Switcher\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Icons_Manager;
use Elementor\Core\Files\Assets\Svg\Svg_Handler;

use WidgetPack\Widget_Pack_Loader;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Switcher extends Widget_Base {

	public function get_name() {
		return 'avt-switcher';
	}

	public function get_title() {
		return AWP . esc_html__( 'Switcher', 'avator-widget-pack' );
	}

	public function get_icon() {
		return 'avt-wi-switcher';
	}

	public function get_categories() {
		return [ 'widget-pack' ];
	}

	public function get_keywords() {
		return [ 'switcher', 'tab', 'toggle' ];
	}

	public function get_style_depends() {
		return [ 'wipa-switcher' ];
	}

	public function get_script_depends() {
		return [ 'wipa-switcher' ];
	}

	public function get_custom_help_url() {
		return 'https://youtu.be/BIEFRxDF1UE';
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_switcher_a_layout',
			[
				'label' => __( 'Switch A', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'switch_a_title',
			[
				'label'   => __( 'Title', 'avator-widget-pack' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Switch A' , 'avator-widget-pack' ),
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->add_control(
			'switch_a_select_icon',
			[
				'label' => __( 'Icon', 'avator-widget-pack' ),
				'type'        => Controls_Manager::ICONS,
				'fa4compatibility' => 'switch_a_icon',
			]
		);

		$this->add_control(
			'source_a',
			[
				'label'   => esc_html__( 'Select Source', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'custom',
				'options' => [
					'custom'    => esc_html__( 'Custom', 'avator-widget-pack' ),
					'elementor' => esc_html__( 'Elementor Template', 'avator-widget-pack' ),
					'anywhere'  => esc_html__( 'AE Template', 'avator-widget-pack' ),
					'custom_section'  => esc_html__( 'Link Section', 'avator-widget-pack' ),
				],				
			]
		);

		$this->add_control(
			'template_id_a',
			[
				'label'       => __( 'Select Template', 'avator-widget-pack' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '0',
				'options'     => widget_pack_et_options(),
				'label_block' => 'true',
				'condition'   => ['source_a' => "elementor"],
			]
		);

		$this->add_control(
			'anywhere_id_a',
			[
				'label'       => esc_html__( 'Select Template', 'avator-widget-pack' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '0',
				'options'     => widget_pack_ae_options(),
				'label_block' => 'true',
				'condition'   => ['source_a' => 'anywhere'],
			]
		);


		$this->add_control(
			'switch_a_content',
			[
				'label'      => __( 'Content', 'avator-widget-pack' ),
				'type'       => Controls_Manager::WYSIWYG,
				'dynamic'    => [ 'active' => true ],
				'default'    => __( 'Switch Content A', 'avator-widget-pack' ),
				'show_label' => false,
				'condition'  => ['source_a' => 'custom'],
			]
		);

		$this->add_control(
			'switch_a_custom_section_id',
			[
				'label'       => __( 'Section ID', 'avator-widget-pack' ),
				'description' => __( 'Paste your section ID here. Don\'t need to add # before ID', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => 'section-a',
				'dynamic'     => [ 'active' => true ],
				'condition'  => ['source_a' => 'custom_section'],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_switcher_b_layout',
			[
				'label' => __( 'Switch B', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'switch_b_title',
			[
				'label'   => __( 'Title', 'avator-widget-pack' ),
				'type'    => Controls_Manager::TEXT,
				'dynamic' => [ 'active' => true ],
				'default' => __( 'Switch B' , 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'switch_b_select_icon',
			[
				'label' => __( 'Icon', 'avator-widget-pack' ),
				'type'        => Controls_Manager::ICONS,
				'fa4compatibility' => 'switch_b_icon',
			]
		);

		$this->add_control(
			'source_b',
			[
				'label'   => esc_html__( 'Select Source', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'custom',
				'options' => [
					'custom'    => esc_html__( 'Custom', 'avator-widget-pack' ),
					'elementor' => esc_html__( 'Elementor Template', 'avator-widget-pack' ),
					'anywhere'  => esc_html__( 'AE Template', 'avator-widget-pack' ),
					'custom_section'  => esc_html__( 'Link Section', 'avator-widget-pack' ),
				],				
			]
		);

		$this->add_control(
			'template_id_b',
			[
				'label'       => __( 'Select Template', 'avator-widget-pack' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '0',
				'options'     => widget_pack_et_options(),
				'label_block' => 'true',
				'condition'   => ['source_b' => 'elementor'],
			]
		);

		$this->add_control(
			'anywhere_id_b',
			[
				'label'       => esc_html__( 'Select Template', 'avator-widget-pack' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '0',
				'options'     => widget_pack_ae_options(),
				'label_block' => 'true',
				'condition'   => ['source_b' => 'anywhere'],
			]
		);

		$this->add_control(
			'switch_b_content',
			[
				'label'      => __( 'Content', 'avator-widget-pack' ),
				'type'       => Controls_Manager::WYSIWYG,
				'dynamic'    => [ 'active' => true ],
				'default'    => __( 'Switch Content B', 'avator-widget-pack' ),
				'show_label' => false,
				'condition'  => ['source_b' => 'custom'],
			]
		);

		$this->add_control(
			'switch_b_custom_section_id',
			[
				'label'       => __( 'Section ID', 'avator-widget-pack' ),
				'description' => __( 'Paste your section ID here. Don\'t need to add # before ID', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => 'section-a',
				'dynamic'     => [ 'active' => true ],
				'condition'  => ['source_b' => 'custom_section'],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_switcher_addtional',
			[
				'label' => __( 'Switch Settings', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'tab_layout',
			[
				'label'   => esc_html__( 'Layout', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default' => esc_html__( 'Default', 'avator-widget-pack' ),
					'bottom'  => esc_html__( 'Bottom', 'avator-widget-pack' ),
				],
			]
		);

		$this->add_control(
			'item_spacing',
			[
				'label' => __( 'Spacing', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-tab .avt-tabs-item + .avt-tabs-item' => 'margin-left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'tab_transition',
			[
				'label'   => esc_html__( 'Transition', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'options' => widget_pack_transition_options(),
				'default' => ''
			]
		);

		$this->add_control(
			'duration',
			[
				'label' => __( 'Animation Duration', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min'  => 1,
						'max'  => 2000,
						'step' => 50,
					],
				],
				'default' => [
					'size' => 200,
				],
                'condition' => [
                        'tab_transition!' => ''
                ]
			]
		);

		$this->add_control(
			'media',
			[
				'label'       => __( 'Turn On Horizontal mode', 'avator-widget-pack' ),
				'description' => __( 'It means that when switch to the horizontal tabs mode from vertical mode', 'avator-widget-pack' ),
				'type'        => Controls_Manager::CHOOSE,
				'options'     => [
					'960' => [
						'title' => __( 'On Tablet', 'avator-widget-pack' ),
						'icon'  => 'fas fa-tablet',
					],
					'768' => [
						'title' => __( 'On Mobile', 'avator-widget-pack' ),
						'icon'  => 'fas fa-mobile',
					],
				],
				'condition' => [
					'tab_layout' => ['left', 'right']
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_switcher_style',
			[
				'label' => __( 'Switcher Wrapper', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);


        $this->add_control(
			'switcher_background',
			[
				'label'     => __( 'Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-tabs-container .avt-tab' => 'background-color: {{VALUE}};',
				],
			]
		);

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'switcher_border',
                'placeholder' => '1px',
                'selector'    => '{{WRAPPER}} .avt-tabs-container .avt-tab',
            ]
        );

        $this->add_responsive_control(
            'switcher_padding',
            [
                'label'      => __( 'Padding', 'avator-widget-pack' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .avt-tabs-container .avt-tab' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'switcher_radius',
            [
                'label'      => __( 'Border Radius', 'avator-widget-pack' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .avt-tabs-container .avt-tab' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
                ],
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'section_switcher_a_title',
            [
                'label' => __( 'Switch A', 'avator-widget-pack' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs( 'switch_a_tabs_title_style' );

        $this->start_controls_tab(
            'switch_a_tab_title_normal',
            [
                'label' => __( 'Normal', 'avator-widget-pack' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'switch_a_title_background',
                'types'     => [ 'classic', 'gradient' ],
                'selector'  => '{{WRAPPER}} .avt-tabs-container .avt-tab .avt-tabs-item .avt-tabs-item-a-title',
                'separator' => 'after',
            ]
        );

        $this->add_control(
            'switch_a_title_color',
            [
                'label'     => __( 'Text Color', 'avator-widget-pack' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
					'{{WRAPPER}} .avt-tab .avt-tabs-item-a-title' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-tab .avt-tabs-item-a-title svg' => 'fill: {{VALUE}};',
				],
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'switch_a_title_shadow',
                'selector' => '{{WRAPPER}} .avt-tab .avt-tabs-item .avt-tabs-item-a-title',
            ]
        );

        $this->add_responsive_control(
            'switch_a_title_padding',
            [
                'label'      => __( 'Padding', 'avator-widget-pack' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .avt-tab .avt-tabs-item-a-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'switch_a_title_border',
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .avt-tab .avt-tabs-item .avt-tabs-item-a-title',
            ]
        );

        $this->add_control(
            'switch_a_title_radius',
            [
                'label'      => __( 'Border Radius', 'avator-widget-pack' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .avt-tab .avt-tabs-item .avt-tabs-item-a-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'switch_a_title_typography',
                'selector' => '{{WRAPPER}} .avt-tab .avt-tabs-item-a-title',
                'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_title_active',
            [
                'label' => __( 'Active', 'avator-widget-pack' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'switch_a_active_title_background',
                'types'     => [ 'classic', 'gradient' ],
                'selector'  => '{{WRAPPER}} .avt-tabs-container .avt-tab .avt-tabs-item.avt-active .avt-tabs-item-a-title:before',
                'separator' => 'after',
            ]
        );

        $this->add_control(
            'switch_a_active_title_color',
            [
                'label'     => __( 'Text Color', 'avator-widget-pack' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
					'{{WRAPPER}} .avt-tab .avt-tabs-item.avt-active .avt-tabs-item-a-title' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-tab .avt-tabs-item.avt-active .avt-tabs-item-a-title svg' => 'fill: {{VALUE}};',
				],
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'switch_a_active_title_shadow',
                'selector' => '{{WRAPPER}} .avt-tab .avt-tabs-item.avt-active .avt-tabs-item-a-title',
            ]
        );

        $this->add_control(
            'switch_a_active_border_color',
            [
                'label'     => __( 'Border Color', 'avator-widget-pack' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .avt-tab .avt-tabs-item.avt-active .avt-tabs-item-a-title' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'switch_a_active_title_radius',
            [
                'label'      => __( 'Border Radius', 'avator-widget-pack' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .avt-tab .avt-tabs-item.avt-active .avt-tabs-item-a-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'section_switcher_b_title',
            [
                'label' => __( 'Switch B', 'avator-widget-pack' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs( 'switch_b_tabs_title_style' );

        $this->start_controls_tab(
            'tab_title_normal',
            [
                'label' => __( 'Normal', 'avator-widget-pack' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'switch_b_title_background',
                'types'     => [ 'classic', 'gradient' ],
                'selector'  => '{{WRAPPER}} .avt-tabs-container .avt-tab .avt-tabs-item .avt-tabs-item-b-title',
                'separator' => 'after',
            ]
        );

        $this->add_control(
            'switch_b_title_color',
            [
                'label'     => __( 'Text Color', 'avator-widget-pack' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
					'{{WRAPPER}} .avt-tab .avt-tabs-item-b-title' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-tab .avt-tabs-item-b-title svg' => 'fill: {{VALUE}};',
				],
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'switch_b_title_shadow',
                'selector' => '{{WRAPPER}} .avt-tab .avt-tabs-item .avt-tabs-item-b-title',
            ]
        );

        $this->add_responsive_control(
            'switch_b_title_padding',
            [
                'label'      => __( 'Padding', 'avator-widget-pack' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .avt-tab .avt-tabs-item-b-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'switch_b_title_border',
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .avt-tab .avt-tabs-item .avt-tabs-item-b-title',
            ]
        );

        $this->add_control(
            'switch_b_title_radius',
            [
                'label'      => __( 'Border Radius', 'avator-widget-pack' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .avt-tab .avt-tabs-item .avt-tabs-item-b-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'switch_b_title_typography',
                'selector' => '{{WRAPPER}} .avt-tab .avt-tabs-item-b-title',
                'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'switch_b_tab_title_active',
            [
                'label' => __( 'Active', 'avator-widget-pack' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'switch_b_active_title_background',
                'types'     => [ 'classic', 'gradient' ],
                'selector'  => '{{WRAPPER}} .avt-tabs-container .avt-tab .avt-tabs-item.avt-active .avt-tabs-item-b-title:before',
                'separator' => 'after',
            ]
        );

        $this->add_control(
            'switch_b_active_title_color',
            [
                'label'     => __( 'Text Color', 'avator-widget-pack' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
					'{{WRAPPER}} .avt-tab .avt-tabs-item.avt-active .avt-tabs-item-b-title' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-tab .avt-tabs-item.avt-active .avt-tabs-item-b-title svg' => 'fill: {{VALUE}};',
				],
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'switch_b_active_title_shadow',
                'selector' => '{{WRAPPER}} .avt-tab .avt-tabs-item.avt-active .avt-tabs-item-b-title',
            ]
        );

        $this->add_control(
            'switch_b_active_border_color',
            [
                'label'     => __( 'Border Color', 'avator-widget-pack' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .avt-tab .avt-tabs-item.avt-active .avt-tabs-item-b-title' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'switch_b_active_title_radius',
            [
                'label'      => __( 'Border Radius', 'avator-widget-pack' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .avt-tab .avt-tabs-item.avt-active .avt-tabs-item-b-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_switch_icon',
            [
                'label' => __( 'Icon', 'avator-widget-pack' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'switch_a_select_icon[value]!' => '',
                    'switch_b_select_icon[value]!' => ''
                ]
            ]
        );

        $this->start_controls_tabs( 'switch_icon_style' );

        $this->start_controls_tab(
            'switch_icon_normal',
            [
                'label' => __( 'Normal', 'avator-widget-pack' ),
            ]
        );

        $this->add_control(
            'icon_align',
            [
                'label'   => __( 'Alignment', 'avator-widget-pack' ),
                'type'    => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __( 'Start', 'avator-widget-pack' ),
                        'icon'  => 'eicon-h-align-left',
                    ],
                    'right' => [
                        'title' => __( 'End', 'avator-widget-pack' ),
                        'icon'  => 'eicon-h-align-right',
                    ],
                ],
                'default' => is_rtl() ? 'right' : 'left',
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label'     => __( 'Color', 'avator-widget-pack' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
					'{{WRAPPER}} .avt-switchers .avt-tabs-item a i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-switchers .avt-tabs-item a svg' => 'fill: {{VALUE}};',
				],
            ]
        );

        $this->add_responsive_control(
            'icon_space',
            [
                'label' => __( 'Spacing', 'avator-widget-pack' ),
                'type'  => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'size' => 8,
                ],
                'selectors' => [
                    '{{WRAPPER}} .avt-switchers .avt-tabs-item a .avt-button-icon-align-left'  => 'margin-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .avt-switchers .avt-tabs-item a .avt-button-icon-align-right' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'switch_icon_active',
            [
                'label' => __( 'Active', 'avator-widget-pack' ),
            ]
        );

        $this->add_control(
            'icon_active_color',
            [
                'label'     => __( 'Color', 'avator-widget-pack' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
					'{{WRAPPER}} .avt-switchers .avt-tabs-item.avt-active a i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-switchers .avt-tabs-item.avt-active a svg' => 'fill: {{VALUE}};',
				],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
			'section_toggle_style_content',
			[
				'label' => __( 'Content', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

        $this->add_responsive_control(
			'align',
			[
				'label'   => esc_html__( 'Alignment', 'avator-widget-pack' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
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
					'justify' => [
						'title' => esc_html__( 'Justified', 'avator-widget-pack' ),
						'icon'  => 'fas fa-align-justify',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-switchers .avt-switcher-item-content-inner' => 'text-align: {{VALUE}};',
				],
			]
		);

        $this->add_control(
			'content_spacing',
			[
				'label' => __( 'Spacing', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'size' => 20,
				],
				'selectors' => [
					'{{WRAPPER}} .avt-switchers ul'                => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .avt-switchers ul.avt-tab-bottom' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'content_typography',
				'selector' => '{{WRAPPER}} .avt-switchers .avt-switcher-item-content',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
			]
		);

        $this->end_controls_section();


	}


	protected function render_switcher_templates() {
		$settings = $this->get_settings_for_display();
		$id       = $this->get_id();

		?>

			<div id="avt-switcher-<?php echo esc_attr($id); ?>" class="avt-switcher avt-switcher-item-content">

				<div class="avt-switcher-item-content-inner">
					<div>

						<?php 
			            	if ( 'custom' == $settings['source_a'] and !empty( $settings['switch_a_content'] ) ) {
			            		echo $this->parse_text_editor( $settings['switch_a_content'] );
			            	} elseif ("elementor" == $settings['source_a'] and !empty( $settings['template_id_a'] )) {
			            		echo Widget_Pack_Loader::elementor()->frontend->get_builder_content_for_display( $settings['template_id_a'] );
			            		echo widget_pack_template_edit_link( $settings['template_id_a'] );
			            	} elseif ('anywhere' == $settings['source_a'] and !empty( $settings['anywhere_id_a'] )) {
			            		echo Widget_Pack_Loader::elementor()->frontend->get_builder_content_for_display( $settings['anywhere_id_a'] );
			            		echo widget_pack_template_edit_link( $settings['anywhere_id_a'] );
			            	} elseif ( 'custom_section' == $settings['source_a'] and !empty( $settings['switch_a_custom_section_id'] ) ) {
								echo '<div class="avt-switcher-item-a"></div>';
							}
		            	?>

					</div>
				</div>

				<div class="avt-switcher-item-content-inner">
					<div>

						<?php 
			            	if ( 'custom' == $settings['source_b'] and !empty( $settings['switch_b_content'] ) ) {
			            		echo $this->parse_text_editor( $settings['switch_b_content'] );
			            	} elseif ("elementor" == $settings['source_b'] and !empty( $settings['template_id_b'] )) {
			            		echo Widget_Pack_Loader::elementor()->frontend->get_builder_content_for_display( $settings['template_id_b'] );
			            		echo widget_pack_template_edit_link( $settings['template_id_b'] );
			            	} elseif ('anywhere' == $settings['source_b'] and !empty( $settings['anywhere_id_b'] )) {
			            		echo Widget_Pack_Loader::elementor()->frontend->get_builder_content_for_display( $settings['anywhere_id_b'] );
			            		echo widget_pack_template_edit_link( $settings['anywhere_id_b'] );
			            	} elseif ( 'custom_section' == $settings['source_b'] and !empty( $settings['switch_b_custom_section_id'] ) ) {
								echo '<div class="avt-switcher-item-b"></div>';
							}
		            	?>

					</div>
				</div>
				
			</div>

		<?php
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$id       = $this->get_id();

		$tab_a_custom_section = ($settings['switch_a_custom_section_id']) ? $settings['switch_a_custom_section_id'] : '';
		$tab_b_custom_section = ($settings['switch_b_custom_section_id']) ? $settings['switch_b_custom_section_id'] : '';

		$this->add_render_attribute(
			[
				'switcher-settings' => [
					'id' => [
						'avt-tabs-' . esc_attr($id),
					],
					'class' => [
						'avt-switchers',
					],
				]
			]
		);


		if ( ( 'custom_section' == $settings['source_a'] and !empty( $settings['switch_a_custom_section_id'] ) ) or ( 'custom_section' == $settings['source_b'] and !empty( $settings['switch_b_custom_section_id'] ) ) ) {

			$this->add_render_attribute(
				[
					'switcher-settings' => [
						'data-settings' => [
							wp_json_encode([
								'switch-a-content' => $tab_a_custom_section,
								'switch-b-content' => $tab_b_custom_section,
							])
						],
					]
				]
			);
		}

		$this->add_render_attribute(
			[
				'tab-settings' => [
					'class' => [
						'avt-tab',
						( '' !== $settings['tab_layout'] ) ? 'avt-tab-' . $settings['tab_layout'] : '',
					],
					'avt-tab' => [
						wp_json_encode(array_filter([
							"connect"   => "#avt-switcher-" .  esc_attr($id),
							"animation" => $settings["tab_transition"] ? "avt-animation-". $settings["tab_transition"] : "",
							"duration"  => $settings["duration"] ? $settings["duration"]["size"] : "",
							"media"     => $settings["media"] ? $settings["media"] : "",
							"swiping"   => false
						]))
					],
				]
			]
		);

		if ( ! isset( $settings['switch_a_icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
			// add old default
			$settings['switch_a_icon'] = 'fas fa-arrow-right';
		}

		$a_migrated  = isset( $settings['__fa4_migrated']['switch_a_select_icon'] );
		$a_is_new    = empty( $settings['switch_a_icon'] ) && Icons_Manager::is_migration_allowed();

		if ( ! isset( $settings['switch_b_icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
			// add old default
			$settings['switch_b_icon'] = 'fas fa-arrow-right';
		}

		$b_migrated  = isset( $settings['__fa4_migrated']['switch_b_select_icon'] );
		$b_is_new    = empty( $settings['switch_b_icon'] ) && Icons_Manager::is_migration_allowed();

		?>
		<div <?php echo $this->get_render_attribute_string( 'switcher-settings' ); ?>>

			<?php if ( 'bottom' == $settings['tab_layout'] ) : ?>			
				<div class="avt-switcher-container">
					<?php $this->render_switcher_templates(); ?>
				</div>
			<?php endif; ?>

			<div class="avt-tabs-container">
				<div <?php echo $this->get_render_attribute_string( 'tab-settings' ); ?>>
					<?php 
						$tab_title_a = ($settings['switch_a_title']) ? '' : ' avt-has-no-title';
						$tab_title_b = ($settings['switch_b_title']) ? '' : ' avt-has-no-title';

						?>
						<div class="avt-tabs-item<?php echo esc_attr($tab_title_a); ?>">
							<a class="avt-tabs-item-a-title" href="#">
								<div class="avt-tab-text-wrapper">

									<?php if ('' != $settings['switch_a_select_icon']['value'] and 'left' == $settings['icon_align']) : ?>
										<span class="avt-button-icon-align-<?php echo esc_html($settings['icon_align']); ?>">

											<?php if ( $a_is_new || $a_migrated ) :
												Icons_Manager::render_icon( $settings['switch_a_select_icon'], [ 'aria-hidden' => 'true', 'class' => 'fa-fw' ] );
											else : ?>
												<i class="<?php echo esc_attr( $settings['switch_a_icon'] ); ?>" aria-hidden="true"></i>
											<?php endif; ?>

										</span>
									<?php endif; ?>

									<?php if ($settings['switch_a_title']) : ?>
										<span class="avt-tab-text"><?php echo esc_attr($settings['switch_a_title']); ?></span>
									<?php endif; ?>

									<?php if ('' != $settings['switch_a_select_icon']['value'] and 'right' == $settings['icon_align']) : ?>
										<span class="avt-button-icon-align-<?php echo esc_html($settings['icon_align']); ?>">

											<?php if ( $a_is_new || $a_migrated ) :
												Icons_Manager::render_icon( $settings['switch_a_select_icon'], [ 'aria-hidden' => 'true', 'class' => 'fa-fw' ] );
											else : ?>
												<i class="<?php echo esc_attr( $settings['switch_a_icon'] ); ?>" aria-hidden="true"></i>
											<?php endif; ?>

										</span>
									<?php endif; ?>

								</div>
							</a>
						</div>

						<div class="avt-tabs-item<?php echo esc_attr($tab_title_b); ?>">
							<a class="avt-tabs-item-b-title" href="#">
								<div class="avt-tab-text-wrapper">

									<?php if ('' != $settings['switch_b_select_icon']['value'] and 'left' == $settings['icon_align']) : ?>
										<span class="avt-button-icon-align-<?php echo esc_html($settings['icon_align']); ?>">

											<?php if ( $b_is_new || $b_migrated ) :
												Icons_Manager::render_icon( $settings['switch_b_select_icon'], [ 'aria-hidden' => 'true', 'class' => 'fa-fw' ] );
											else : ?>
												<i class="<?php echo esc_attr( $settings['switch_b_icon'] ); ?>" aria-hidden="true"></i>
											<?php endif; ?>

										</span>
									<?php endif; ?>

									<?php if ($settings['switch_b_title']) : ?>
										<span class="avt-tab-text"><?php echo esc_attr($settings['switch_b_title']); ?></span>
									<?php endif; ?>

									<?php if ('' != $settings['switch_b_select_icon']['value'] and 'right' == $settings['icon_align']) : ?>
										<span class="avt-button-icon-align-<?php echo esc_html($settings['icon_align']); ?>">

											<?php if ( $b_is_new || $b_migrated ) :
												Icons_Manager::render_icon( $settings['switch_b_select_icon'], [ 'aria-hidden' => 'true', 'class' => 'fa-fw' ] );
											else : ?>
												<i class="<?php echo esc_attr( $settings['switch_b_icon'] ); ?>" aria-hidden="true"></i>
											<?php endif; ?>

										</span>
									<?php endif; ?>

								</div>
							</a>
						</div>
					
				</div>
			</div>

			<?php if ( 'bottom' != $settings['tab_layout'] ) : ?>
				<div class="avt-switcher-wrapper">

					<?php $this->render_switcher_templates(); ?>

				</div>
			<?php endif; ?>

		</div>
		<?php
	}
}