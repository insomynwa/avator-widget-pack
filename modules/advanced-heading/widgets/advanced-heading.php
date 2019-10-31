<?php
namespace WidgetPack\Modules\AdvancedHeading\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class AdvancedHeading extends Widget_Base {

	public function get_name() {
		return 'avt-advanced-heading';
	}

	public function get_title() {
		return AWP . __( 'Advanced Heading', 'avator-widget-pack' );
	}

	public function get_icon() {
		return 'avt-wi-advanced-heading';
	}

	public function get_categories() {
		return [ 'widget-pack' ];
	}

	public function get_keywords() {
		return [ 'advanced', 'heading', 'title' ];
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_content_heading',
			[
				'label' => __( 'Heading', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'sub_heading',
			[
				'label'       => __( 'Sub Heading', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => __( 'Enter your prefix title', 'avator-widget-pack' ),
				'default'     => __( 'SUB HEADING HERE', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'main_heading',
			[
				'label'       => __( 'Main Heading', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXTAREA,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => __( 'Enter your main heading here', 'avator-widget-pack' ),
				'default'     => __( 'I am Advanced Heading', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'split_main_heading',
			[
				'label'     => __( 'Split Main Heading', 'avator-widget-pack' ),
				'separator' => 'before',
				'type'      => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'split_text',
			[
				'label'       => __( 'Split Text', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
                'placeholder' => __( 'Enter your split text', 'avator-widget-pack' ),
                'default'     => __( 'Split Text', 'avator-widget-pack' ),
                'condition'   => [
                    'split_main_heading' => 'yes'
				]
			]
		);

		$this->add_control(
			'link',
			[
				'label'       => __( 'Link', 'avator-widget-pack' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => 'http://your-link.com',
			]
		);

		$this->add_control(
			'header_size',
			[
				'label'   => __( 'HTML Tag', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'options' => widget_pack_title_tags(),
				'default' => 'h2',
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label'   => __( 'Alignment', 'avator-widget-pack' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
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
				],
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}}' => 'text-align: {{VALUE}};',
				],

			]
		);

		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_content_advanced_heading',
			[
				'label' => __( 'Advanced Heading', 'avator-widget-pack' ),
			]
		);
		$this->add_control(
			'advanced_heading',
			[
				'label'       => __( 'Advanced Heading', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXTAREA,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => __( 'Enter your advanced heading', 'avator-widget-pack' ),
				'description' => __( 'This heading will show as style as background and you can move and style many way.', 'avator-widget-pack' ),
				'default'     => esc_html__( 'Advanced Heading', 'avator-widget-pack' ),
			]
		);

		$this->add_responsive_control(
			'advanced_heading_align',
			[
				'label'   => __( 'Alignment', 'avator-widget-pack' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
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
				],
				'selectors' => [
					'{{WRAPPER}} .avt-advanced-heading-content' => 'text-align: {{VALUE}};',
				],
			]
		);


		$this->add_responsive_control(
			'advanced_heading_x_position',
			[
				'label'   => __( 'X Offset', 'avator-widget-pack' ),
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
						'min' => -800,
						'max' => 800,
					],
				],
			]
		);

		$this->add_responsive_control(
			'advanced_heading_y_position',
			[
				'label'   => __( 'Y Offset', 'avator-widget-pack' ),
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
						'min' => -800,
						'max' => 800,
					],
				],
			]
		);

		$this->add_control(
			'advanced_heading_origin',
			[
				'label'       => __( 'Rotate Origin', 'avator-widget-pack' ),
				'description' => __( 'Origin work when you set rotate value', 'avator-widget-pack' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'top-left',
				'options'     => widget_pack_position(),
			]
		);

		
		$this->add_responsive_control(
			'advanced_heading_rotate',
			[
				'label'   => __( 'Rotate', 'avator-widget-pack' ),
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
						'min'  => -180,
						'max'  => 180,
						'step' => 5,
					],
				],
				'selectors' => [
					'(desktop){{WRAPPER}} .avt-advanced-heading .avt-advanced-heading-content > div' => 'transform: translate({{advanced_heading_x_position.SIZE}}px, {{advanced_heading_y_position.SIZE}}px) rotate({{SIZE}}deg);',
					'(tablet){{WRAPPER}} .avt-advanced-heading .avt-advanced-heading-content > div' => 'transform: translate({{advanced_heading_x_position_tablet.SIZE}}px, {{advanced_heading_y_position_tablet.SIZE}}px) rotate({{SIZE}}deg);',
					'(mobile){{WRAPPER}} .avt-advanced-heading .avt-advanced-heading-content > div' => 'transform: translate({{advanced_heading_x_position_mobile.SIZE}}px, {{advanced_heading_y_position_mobile.SIZE}}px) rotate({{SIZE}}deg);',
				],
			]
		);



		$this->add_control(
			'advanced_heading_hide',
			[
				'label'       => __( 'Hide at', 'avator-widget-pack' ),
				'description' => __( 'Some cases you need to hide it because when you set heading at outer position mobile device can show wrong width in that case you can hide it at mobile or tablet device. if you set overflow hidden on section or body so you don\'t need it.', 'avator-widget-pack' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'm',
				'options'     => [
					''  => esc_html__('Nothing', 'avator-widget-pack'),
					'm' => esc_html__('Tablet and Mobile ', 'avator-widget-pack'),
					's' => esc_html__('Mobile', 'avator-widget-pack'),
				],
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_sub_heading',
			[
				'label'     => __( 'Sub Heading', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'sub_heading!' => '',
				]
			]
		);

		$this->add_control(
			'sub_heading_color',
			[
				'label'     => __( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-advanced-heading .avt-sub-heading' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'sub_heading_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .avt-advanced-heading .avt-sub-heading',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'     => 'sub_heading_text_shadow',
				'selector' => '{{WRAPPER}} .avt-advanced-heading .avt-sub-heading',
			]
		);

		$this->add_control(
			'sub_heading_style',
			[
				'label'   => __( 'Style', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					''     => esc_html__('None', 'avator-widget-pack'),
					'line' => esc_html__('Line', 'avator-widget-pack'),
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'sub_heading_style_color',
			[
				'label'     => __( 'Style Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-advanced-heading .avt-sub-heading .line:after' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'sub_heading_style' => 'line',
				],
			]
		);

		$this->add_responsive_control(
			'sub_heading_style_width',
			[
				'label' => __( 'Width', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min'  => 1,
						'max'  => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-advanced-heading .avt-sub-heading .line:after' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'sub_heading_style' => 'line',
				],
			]
		);

		$this->add_responsive_control(
			'sub_heading_style_height',
			[
				'label' => __( 'Height', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min'  => 1,
						'max'  => 48,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-advanced-heading .avt-sub-heading .line:after' => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'sub_heading_style' => 'line',
				],
			]
		);

		$this->add_control(
			'sub_heading_style_align',
			[
				'label'   => __( 'Style Position', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'right',
				'options' => [
					'right'      => __( 'After', 'avator-widget-pack' ),
					'left'       => __( 'Before', 'avator-widget-pack' ),
					'left-right' => __( 'After and Before', 'avator-widget-pack' ),
					'bottom'     => __( 'Bottom', 'avator-widget-pack' ),
				],
				'condition' => [
					'sub_heading_style' => 'line',
				],
			]
		);

		$this->add_responsive_control(
			'sub_heading_style_indent',
			[
				'label'   => __( 'Style Spacing', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 8,
				],
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'condition' => [
					'sub_heading_style' => 'line',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-advanced-heading .avt-button-icon-align-right'  => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .avt-advanced-heading .avt-button-icon-align-left'   => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .avt-advanced-heading .avt-button-icon-align-bottom' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_main_heading',
			[
				'label'     => __( 'Main Heading', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'main_heading!' => '',
				],
			]
		);

		$this->start_controls_tabs('tabs_style_main_heading');

		$this->start_controls_tab(
			'tab_style_normal',
			[
				'label' => esc_html__('Normal', 'avator-widget-pack')
			]
		);

		$this->add_control(
			'main_heading_color',
			[
				'label'     => __( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-advanced-heading .avt-main-heading > div' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_control(
			'main_heading_background',
			[
				'label'     => __( 'Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-advanced-heading .avt-main-heading > div' => 'background-color: {{VALUE}};',
				]
			]
		);

		$this->add_responsive_control(
			'main_heading_padding',
			[
				'label'      => esc_html__('Padding', 'avator-widget-pack'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-advanced-heading .avt-main-heading > div' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'main_heading_border',
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-advanced-heading .avt-main-heading > div'
			]
		);

		$this->add_control(
			'main_heading_radius',
			[
				'label'      => esc_html__('Radius', 'avator-widget-pack'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-advanced-heading .avt-main-heading > div' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'main_heading_shadow',
				'selector' => '{{WRAPPER}} .avt-advanced-heading .avt-main-heading > div'
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'     => 'main_heading_text_shadow',
				'selector' => '{{WRAPPER}} .avt-advanced-heading .avt-main-heading > div'
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'main_heading_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .avt-advanced-heading .avt-main-heading > div',
			]
		);

		$this->add_control(
			'heading_mainh_split_text',
			[
				'label'     => __( 'Split Text', 'avator-widget-pack' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => [
					'split_main_heading' => 'yes',
					'split_text!'        => ''
				]
			]
		);

		$this->add_control(
			'mainh_split_text_color',
			[
				'label'     => __( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .avt-advanced-heading .avt-main-heading .avt-mainh-split-text' => 'color: {{VALUE}};',
				],
				'condition' => [
					'split_main_heading' => 'yes',
					'split_text!'        => ''
				]
			]
		);

		$this->add_control(
			'mainh_split_text_background',
			[
				'label'     => __( 'Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-advanced-heading .avt-main-heading .avt-mainh-split-text' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'split_main_heading' => 'yes',
					'split_text!'        => ''
				]
			]
		);

        $this->add_responsive_control(
            'split_text_space',
            [
                'label'   => __( 'Split Space', 'avator-widget-pack' ),
                'type'    => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .avt-main-heading .avt-main-heading-inner' => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
                'condition'   => [
                    'split_main_heading' => 'yes'
                ],
                'separator'   => 'after',
            ]
        );

		$this->add_responsive_control(
			'mainh_split_text_padding',
			[
				'label'      => esc_html__('Padding', 'avator-widget-pack'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-advanced-heading .avt-main-heading .avt-mainh-split-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
				'condition' => [
					'split_main_heading' => 'yes',
					'split_text!'        => ''
				]
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'mainh_split_text_border',
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-advanced-heading .avt-main-heading .avt-mainh-split-text',
				'condition'   => [
					'split_main_heading' => 'yes',
					'split_text!'        => ''
				]
			]
		);

		$this->add_control(
			'mainh_split_text_radius',
			[
				'label'      => esc_html__('Radius', 'avator-widget-pack'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-advanced-heading .avt-main-heading .avt-mainh-split-text' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;'
				],
				'condition' => [
					'split_main_heading' => 'yes',
					'split_text!'        => ''
				]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'mainh_split_text_shadow',
				'selector'  => '{{WRAPPER}} .avt-advanced-heading .avt-main-heading .avt-mainh-split-text',
				'condition' => [
					'split_main_heading' => 'yes',
					'split_text!'        => ''
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'mainh_split_text_typography',
				'scheme'    => Scheme_Typography::TYPOGRAPHY_1,
				'selector'  => '{{WRAPPER}} .avt-advanced-heading .avt-main-heading .avt-mainh-split-text',
				'condition' => [
					'split_main_heading' => 'yes',
					'split_text!'        => ''
				]
			]
		);	

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_style_advanced',
			[
				'label' => esc_html__('Advanced', 'avator-widget-pack')
			]
		);

		$this->add_control(
			'main_heading_advanced_color',
			[
				'label'        => __( 'Advanced Style', 'avator-widget-pack' ),
				'type'         => Controls_Manager::SWITCHER,
				'prefix_class' => 'avt-wp-main-color-',
				'render_type'  => 'template',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'main_heading_advanced_color',
				'selector' => '{{WRAPPER}} .avt-advanced-heading .avt-main-heading > div'
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();		

		$this->add_control(
			'main_heading_style',
			[
				'label'   => __( 'Style', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					''     => esc_html__('None', 'avator-widget-pack'),
					'line' => esc_html__('Line', 'avator-widget-pack'),
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'main_heading_style_color',
			[
				'label'     => __( 'Style Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-advanced-heading .avt-main-heading .line:after' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'main_heading_style' => 'line',
				],
			]
		);

		$this->add_responsive_control(
			'main_heading_style_width',
			[
				'label' => __( 'Width', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min'  => 1,
						'max'  => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-advanced-heading .avt-main-heading .line:after' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'main_heading_style' => 'line',
				],
			]
		);

		$this->add_responsive_control(
			'main_heading_style_height',
			[
				'label' => __( 'Height', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min'  => 1,
						'max'  => 48,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-advanced-heading .avt-main-heading .line:after' => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'main_heading_style' => 'line',
				],
			]
		);

		$this->add_control(
			'main_heading_style_align',
			[
				'label'   => __( 'Style Position', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'bottom',
				'options' => [
					'right'      => __( 'After', 'avator-widget-pack' ),
					'left'       => __( 'Before', 'avator-widget-pack' ),
					'left-right' => __( 'After and Before', 'avator-widget-pack' ),
					'bottom'     => __( 'Bottom', 'avator-widget-pack' ),
				],
				'condition' => [
					'main_heading_style' => 'line',
				],
			]
		);

		$this->add_responsive_control(
			'main_heading_style_indent',
			[
				'label'   => __( 'Style Spacing', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 8,
				],
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'condition' => [
					'main_heading_style' => 'line',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-advanced-heading .avt-main-heading .avt-button-icon-align-right'  => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .avt-advanced-heading .avt-main-heading .avt-button-icon-align-left'   => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .avt-advanced-heading .avt-main-heading .avt-button-icon-align-bottom' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_advanced_heading',
			[
				'label'     => __( 'Advanced Heading', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'advanced_heading!' => '',
				],
			]
		);

		$this->add_control(
			'advanced_heading_advanced_color',
			[
				'label'        => __( 'Advanced Style', 'avator-widget-pack' ),
				'type'         => Controls_Manager::SWITCHER,
				'prefix_class' => 'avt-wp-advanced-color-',
				'render_type'  => 'template',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'advanced_heading_advanced_color',
				'selector'  => '{{WRAPPER}} .avt-advanced-heading .avt-advanced-heading-content > div',
				'condition' => [
					'advanced_heading_advanced_color' => 'yes',
				],
			]
		);

		$this->add_control(
			'advanced_heading_color',
			[
				'label'     => __( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-advanced-heading .avt-advanced-heading-content > div' => 'color: {{VALUE}};',
				],
				'condition' => [
					'advanced_heading_advanced_color!' => 'yes',
				],
			]
		);
		
		$this->add_control(
			'advanced_heading_background_color',
			[
				'label'     => __( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-advanced-heading .avt-advanced-heading-content > div' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'advanced_heading_advanced_color!' => 'yes',
				],
			]
		);

		$this->add_control(
			'advanced_heading_padding',
			[
				'label'      => __( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-advanced-heading .avt-advanced-heading-content > div' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'advanced_heading_typography',
				'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
				'selector'  => '{{WRAPPER}} .avt-advanced-heading .avt-advanced-heading-content > div',
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'     => 'advanced_heading_shadow',
				'selector' => '{{WRAPPER}} .avt-advanced-heading .avt-advanced-heading-content > div',
			]
		);


		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'advanced_heading_border',
				'label'       => __( 'Border', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-advanced-heading .avt-advanced-heading-content > div',
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'advanced_heading_border_radius',
			[
				'label'      => __( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-advanced-heading .avt-advanced-heading-content > div' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'advanced_heading_box_shadow',
				'selector' => '{{WRAPPER}} .avt-advanced-heading .avt-advanced-heading-content > div',
			]
		);

		$this->add_control(
			'advanced_heading_opacity',
			[
				'label' => __( 'Opacity', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min'  => 0.05,
						'max'  => 1,
						'step' => 0.05,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-advanced-heading .avt-advanced-heading-content > div' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings         = $this->get_settings_for_display();
		$id               = $this->get_id();
		$heading_html     = [];
		$advanced_heading = '';
		$sub_heading      = '';
		$main_heading     = '';
		$split_heading    = '';

		if ( empty( $settings['sub_heading'] ) and empty( $settings['advanced_heading'] ) and empty( $settings['main_heading'] ) ) {
			return;
		}

		$this->add_render_attribute( 'heading', 'class', 'avt-heading-title' );


		if ($settings['sub_heading']) {
			$subh_style = '';
			if ('line' === $settings['sub_heading_style']) {
				if ('left-right' === $settings['sub_heading_style_align']) {
					$subh_style = '<div class="line avt-button-icon-align-left"></div><div class="line avt-button-icon-align-right"></div>';
				} elseif ('bottom' === $settings['sub_heading_style_align']) {
					$subh_style = '<div class="line avt-button-icon-align-'.$settings['sub_heading_style_align'].'"></div>';
				} else {
					$subh_style = '<div class="line avt-button-icon-align-'.$settings['sub_heading_style_align'].'"></div>';
				}
			}

			$sub_heading = '<div class="avt-sub-heading"><div class="avt-sub-heading-content">'.$settings['sub_heading'].'</div>'.$subh_style.'</div> ';
		}

		if ($settings['advanced_heading']) {

			$this->add_render_attribute(
				[
					'avd-hclass' => [
						'class' => [
							'avt-advanced-heading-content',
							$settings['advanced_heading_hide'] ? 'avt-visible@'. $settings['advanced_heading_hide'] : '',
						],
					],
				]
			);

			$this->add_render_attribute(
				[
					'avd-hcclass' => [
						'class' => [
							$settings['advanced_heading_origin'] ? 'avt-transform-origin-'.$settings['advanced_heading_origin'] : '',
						],
					],
				]
			);

	   		$advanced_heading = '<div ' . $this->get_render_attribute_string( 'avd-hclass' ) . '><div ' . $this->get_render_attribute_string( 'avd-hcclass' ) . '>' .$settings['advanced_heading']. '</div></div>';
		}

		$this->add_render_attribute( 'main_heading', 'class', 'avt-main-heading-inner' );
		$this->add_inline_editing_attributes( 'main_heading' );

		$this->add_render_attribute( 'split_heading', 'class', 'avt-mainh-split-text' );

		if ($settings['main_heading']) :

			$mainh_style = '';

			if ('line' === $settings['main_heading_style']) {
				if ('left-right' === $settings['main_heading_style_align']) {
					$mainh_style = '<div class="line avt-button-icon-align-left"></div><div class="line avt-button-icon-align-right"></div>';
				} elseif ('bottom' === $settings['main_heading_style_align']) {
					$mainh_style = '<div class="line avt-button-icon-align-'.$settings['main_heading_style_align'].'"></div>';
				} else {
					$mainh_style = '<div class="line avt-button-icon-align-'.$settings['main_heading_style_align'].'"></div>';
				}
			}

			if ( ( 'yes' == $settings['split_main_heading'] ) and ( ! empty($settings['split_text']) ) ) {
				$split_heading = '<div '.$this->get_render_attribute_string( 'split_heading' ).'>' . $settings['split_text'] . '</div>';
			}

			$main_heading = '<div '.$this->get_render_attribute_string( 'main_heading' ).'>' . $settings['main_heading'] . '</div>';

			$main_heading = '<div class="avt-main-heading">' . $main_heading . $split_heading . $mainh_style . '</div>';

		endif;


		if ( ! empty( $settings['link']['url'] ) ) {
			$this->add_render_attribute( 'url', 'href', $settings['link']['url'] );

			if ( $settings['link']['is_external'] ) {
				$this->add_render_attribute( 'url', 'target', '_blank' );
			}

			if ( ! empty( $settings['link']['nofollow'] ) ) {
				$this->add_render_attribute( 'url', 'rel', 'nofollow' );
			}

			$main_heading = sprintf( '<a %1$s>%2$s</a>', $this->get_render_attribute_string( 'url' ), $main_heading );
		}

		$heading_html[] = '<div id ="'.$id.'" class="avt-advanced-heading">';
		
		
		$heading_html[] = $advanced_heading;
		$heading_html[] = $sub_heading;
		$heading_html[] = sprintf( '<%1$s %2$s>%3$s</%1$s>', $settings['header_size'], $this->get_render_attribute_string( 'heading' ), $main_heading );
		
		$heading_html[] = '</div>';

		echo implode("", $heading_html);

	}


	protected function _content_template() {
		?>
		<#
		var subh_style    = '';
		var mainh_style   = '';

		view.addRenderAttribute( 'main_heading', 'class', 'avt-main-heading-inner' );
		view.addInlineEditingAttributes( 'main_heading' );

		view.addRenderAttribute( 'split_text', 'class', 'avt-mainh-split-text' );
		view.addInlineEditingAttributes( 'split_text' );

		view.addRenderAttribute( 'main_heading_wrapper', 'class', [ 'avt-heading-title', 'elementor-size-' + settings.size ] );

		view.addRenderAttribute('advanced_heading_content', 'class', ['avt-advanced-heading-content'] );

		view.addRenderAttribute('advanced_heading', 'class', 'avt-transform-origin-' + settings.advanced_heading_origin );

		var avdh_content_print = view.getRenderAttributeString( 'advanced_heading_content' );
		var avdh_transform_print = view.getRenderAttributeString( 'advanced_heading' );

		if ( 'line' === settings.sub_heading_style ) {
			if ('left-right' === settings.sub_heading_style_align) {
				subh_style = '<div class="line avt-button-icon-align-left"></div><div class="line avt-button-icon-align-right"></div>';
			} else if ('bottom' === settings.sub_heading_style_align) {
				subh_style = '<div class="line avt-button-icon-align-' + settings.sub_heading_style_align + '"></div>';
			} else {
				subh_style = '<div class="line avt-button-icon-align-' + settings.sub_heading_style_align + '"></div>';
			}
		}

		if ( 'line' === settings.main_heading_style ) {
			if ('left-right' === settings.main_heading_style_align) {
				mainh_style = '<div class="line avt-button-icon-align-left"></div><div class="line avt-button-icon-align-right"></div>';
			} else if ('bottom' === settings.main_heading_style_align) {
				mainh_style = '<div class="line avt-button-icon-align-' + settings.main_heading_style_align + '"></div>';
			} else {
				mainh_style = '<div class="line avt-button-icon-align-' + settings.main_heading_style_align + '"></div>';
			}
		}

		#>
		<div class="avt-advanced-heading">
			<div <# print(avdh_content_print) #> >
				<div <# print(avdh_transform_print) #>>
					<# print(settings.advanced_heading) #>
				</div>
			</div>
			
			<# if ( settings.sub_heading != '' ) { #>
			<div class="avt-sub-heading">
				<div class="avt-sub-heading-content">
					<# print(settings.sub_heading); #>
				</div>
				<# print(subh_style); #>
			</div>
			<# } #>

			<{{settings.header_size}} <# print(view.getRenderAttributeString( 'main_heading_wrapper' )) #> >
				<div class="avt-main-heading">

					<# if ( '' !== settings.link.url ) { #>
						<a href="{{{settings.link.url}}}">
					<# } #>			

						
						<div {{{view.getRenderAttributeString( 'main_heading' )}}}><# print(settings.main_heading); #></div>		

						<# if ( ( 'yes' == settings.split_main_heading ) && ( '' !== (settings.split_text) ) ) { #>
							<div {{{view.getRenderAttributeString( 'split_text' )}}}><# print(settings.split_text); #></div>
						<# } #>

						<# print(mainh_style); #>
						

					<# if ( '' !== settings.link.url ) { #>
						</a>
					<# } #>	

				</div>

			</{{settings.header_size}}>

		</div>		
		<?php
	}


}
