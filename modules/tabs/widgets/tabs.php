<?php
namespace WidgetPack\Modules\Tabs\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Icons_Manager;
use Elementor\Core\Files\Assets\Svg\Svg_Handler;
use WidgetPack\Modules\QueryControl\Module as QueryControlModule;
use WidgetPack\Widget_Pack_Loader;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Tabs extends Widget_Base {

	public function get_name() {
		return 'avt-tabs';
	}

	public function get_title() {
		return AWP . esc_html__( 'Tabs', 'avator-widget-pack' );
	}

	public function get_icon() {
		return 'avt-wi-tabs';
	}

	public function get_categories() {
		return [ 'widget-pack' ];
	}

	public function get_keywords() {
		return [ 'tabs', 'toggle', 'accordion' ];
	}

	public function is_reload_preview_required() {
		return false;
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_title',
			[
				'label' => __( 'Tabs', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'tab_layout',
			[
				'label'   => esc_html__( 'Layout', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default' => esc_html__( 'Top (Default)', 'avator-widget-pack' ),
					'bottom'  => esc_html__( 'Bottom', 'avator-widget-pack' ),
					'left'    => esc_html__( 'Left', 'avator-widget-pack' ),
					'right'   => esc_html__( 'Right', 'avator-widget-pack' ),
				],
			]
		);

		$this->add_control(
			'tabs',
			[
				'label'   => __( 'Tab Items', 'avator-widget-pack' ),
				'type'    => Controls_Manager::REPEATER,
				'default' => [
					[
						'tab_title'   => __( 'Tab #1', 'avator-widget-pack' ),
						'tab_content' => __( 'I am tab #1 content. Click edit button to change this text. One morning, when Gregor Samsa woke from troubled dreams, he found himself transformed in his bed into a horrible vermin.', 'avator-widget-pack' ),
					],
					[
						'tab_title'   => __( 'Tab #2', 'avator-widget-pack' ),
						'tab_content' => __( 'I am tab #2 content. Click edit button to change this text. A collection of textile samples lay spread out on the table - Samsa was a travelling salesman.', 'avator-widget-pack' ),
					],
					[
						'tab_title'   => __( 'Tab #3', 'avator-widget-pack' ),
						'tab_content' => __( 'I am tab #3 content. Click edit button to change this text. Drops of rain could be heard hitting the pane, which made him feel quite sad. How about if I sleep a little bit longer and forget all this nonsense.', 'avator-widget-pack' ),
					],
				],
				'fields' => [
					[
						'name'        => 'tab_title',
						'label'       => __( 'Title', 'avator-widget-pack' ),
						'type'        => Controls_Manager::TEXT,
						'dynamic'     => [ 'active' => true ],
						'default'     => __( 'Tab Title' , 'avator-widget-pack' ),
						'label_block' => true,
					],
					[
						'name'        => 'tab_sub_title',
						'label'       => __( 'Sub Title', 'avator-widget-pack' ),
						'type'        => Controls_Manager::TEXT,
						'dynamic'     => [ 'active' => true ],
						'label_block' => true,
					],
					[
						'name'             => 'tab_select_icon',
						'label'            => __( 'Icon', 'avator-widget-pack' ),
						'type'             => Controls_Manager::ICONS,
						'fa4compatibility' => 'tab_icon',
					],
					[
						'name'    => 'source',
						'label'   => esc_html__( 'Select Source', 'avator-widget-pack' ),
						'type'    => Controls_Manager::SELECT,
						'default' => 'custom',
						'options' => [
							'custom'    => esc_html__( 'Custom', 'avator-widget-pack' ),
							"elementor" => esc_html__( 'Elementor Template', 'avator-widget-pack' ),
							'anywhere'  => esc_html__( 'AE Template', 'avator-widget-pack' ),
						],
					],
					[
						'name'       => 'tab_content',
						'type'       => Controls_Manager::WYSIWYG,
						'dynamic'    => [ 'active' => true ],
						'default'    => __( 'Tab Content', 'avator-widget-pack' ),
						'condition'  => ['source' => 'custom'],
					],
					[
						'name'        => 'template_id',
						'label'       => __( 'Select Template', 'avator-widget-pack' ),
						'type'        => Controls_Manager::SELECT,
						'default'     => '0',
						'options'     => widget_pack_et_options(),
						'label_block' => 'true',
						'condition'   => ['source' => "elementor"],
					],
					[
						'name'        => 'anywhere_id',
						'label'       => esc_html__( 'Select Template', 'avator-widget-pack' ),
						'type'        => Controls_Manager::SELECT,
						'default'     => '0',
						'options'     => widget_pack_ae_options(),
						'label_block' => 'true',
						'condition'   => ['source' => 'anywhere'],
					],
				],
				'title_field' => '{{{ tab_title }}}',
			]
		);

		$this->add_control(
			'align',
			[
				'label'   => __( 'Alignment', 'avator-widget-pack' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					''    => [
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
					'justify' => [
						'title' => __( 'Justified', 'avator-widget-pack' ),
						'icon'  => 'fas fa-align-justify',
					],
				],
				'condition' => [
					'tab_layout' => ['default', 'bottom']
				],
			]
		);

		$this->add_responsive_control(
			'item_spacing',
			[
				'label' => __( 'Nav Spacing', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-tab .avt-tabs-item'                                                                 => 'padding-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .avt-tab'                                                                                => 'margin-left: -{{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .avt-tab.avt-tab-left .avt-tabs-item, {{WRAPPER}} .avt-tab.avt-tab-right .avt-tabs-item' => 'padding-top: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .avt-tab.avt-tab-left, {{WRAPPER}} .avt-tab.avt-tab-right'                               => 'margin-top: -{{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->add_responsive_control(
			'nav_spacing',
			[
				'label' => __( 'Nav Width', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 50,
						'max' => 500,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-grid:not(.avt-grid-stack) .avt-tab-wrapper' => 'width: {{SIZE}}{{UNIT}};',
				],
                'condition' => [
                    'tab_layout' => ['left', 'right']
                ],
			]
		);

		$this->add_responsive_control(
			'content_spacing',
			[
				'label' => __( 'Content Spacing', 'avator-widget-pack' ),
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
					'{{WRAPPER}} .avt-tabs-default .avt-switcher-wrapper'=> 'margin-top: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .avt-tabs-bottom .avt-switcher-wrapper' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .avt-tabs-left .avt-grid:not(.avt-grid-stack) .avt-switcher-wrapper'   => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .avt-tabs-right .avt-grid:not(.avt-grid-stack) .avt-switcher-wrapper'  => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .avt-tabs-left .avt-grid-stack .avt-switcher-wrapper,
					 {{WRAPPER}} .avt-tabs-right .avt-grid-stack .avt-switcher-wrapper'  => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_additional',
			[
				'label' => __( 'Additional', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'active_item',
			[
				'label' => __( 'Active Item No', 'avator-widget-pack' ),
				'type'  => Controls_Manager::NUMBER,
				'min'   => 1,
				'max'   => 20,
			]
		);

		$this->add_control(
			'tab_transition',
			[
				'label'   => esc_html__( 'Transition', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'options' => widget_pack_transition_options(),
				'default' => '',
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
						'max'  => 501,
						'step' => 50,
					],
				],
				'default' => [
					'size' => 200,
				],
                'condition' => [
                    'tab_transition!' => ''
                ],
			]
		);

		$this->add_control(
			'media',
			[
				'label'       => __( 'Turn On Horizontal mode', 'avator-widget-pack' ),
				'description' => __( 'It means that tabs nav will switch vertical to horizontal on mobile mode', 'avator-widget-pack' ),
				'type'        => Controls_Manager::CHOOSE,
				'options'     => [
					960 => [
						'title' => __( 'On Tablet', 'avator-widget-pack' ),
						'icon'  => 'fas fa-tablet',
					],
					768 => [
						'title' => __( 'On Mobile', 'avator-widget-pack' ),
						'icon'  => 'fas fa-mobile',
					],
				],
				'default' => 960,
				'condition' => [
					'tab_layout' => ['left', 'right']
				],
			]
		);

		$this->add_control(
			'nav_sticky_mode',
			[
				'label'   => esc_html__( 'Tabs Nav Sticky', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
                'condition' => [
                    'tab_layout!' => 'bottom',
                ],
			]
		);

		$this->add_control(
			'nav_sticky_offset',
			[
				'label'   => esc_html__( 'Offset', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
				'condition' => [
					'nav_sticky_mode' => 'yes',
                    'tab_layout!' => 'bottom',
				],
			]
		);

		$this->add_control(
			'nav_sticky_on_scroll_up',
			[
				'label'        => esc_html__( 'Sticky on Scroll Up', 'avator-widget-pack' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__( 'Set sticky options when you scroll up your mouse.', 'avator-widget-pack' ),
				'condition' => [
					'nav_sticky_mode' => 'yes',
                    'tab_layout!' => 'bottom',
				],
			]
		);

		$this->add_control(
			'fullwidth_on_mobile',
			[
				'label'        => esc_html__( 'Fullwidth Nav on Mobile', 'avator-widget-pack' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__( 'If you have long test tab so this can help design issue', 'avator-widget-pack' )
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_toggle_style_title',
			[
				'label' => __( 'Tab', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'tabs_title_style' );

		$this->start_controls_tab(
			'tab_title_normal',
			[
				'label' => __( 'Normal', 'avator-widget-pack' ),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'title_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .avt-tab .avt-tabs-item-title',
				'separator' => 'after',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => __( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-tab .avt-tabs-item-title' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-tab .avt-tabs-item-title svg' => 'fill: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'title_shadow',
				'selector' => '{{WRAPPER}} .avt-tab .avt-tabs-item .avt-tabs-item-title',
			]
		);

		$this->add_responsive_control(
			'title_padding',
			[
				'label'      => __( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-tab .avt-tabs-item-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'title_border',
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-tab .avt-tabs-item .avt-tabs-item-title',
			]
		);

		$this->add_control(
			'title_radius',
			[
				'label'      => __( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-tab .avt-tabs-item .avt-tabs-item-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .avt-tab .avt-tabs-item-title',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_title_hover',
			[
				'label' => __( 'Hover', 'avator-widget-pack' ),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'hover_title_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .avt-tab .avt-tabs-item:hover .avt-tabs-item-title',
				'separator' => 'after',
			]
		);

		$this->add_control(
			'hover_title_color',
			[
				'label'     => __( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-tab .avt-tabs-item:hover .avt-tabs-item-title' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-tab .avt-tabs-item:hover .avt-tabs-item-title svg' => 'fill: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_title_active',
			[
				'label' => __( 'Active', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'active_style_color',
			[
				'label'     => __( 'Style Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-tab .avt-tabs-item.avt-active .avt-tabs-item-title:after' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'active_title_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .avt-tab .avt-tabs-item.avt-active .avt-tabs-item-title',
				'separator' => 'after',
			]
		);

		$this->add_control(
			'active_title_color',
			[
				'label'     => __( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-tab .avt-tabs-item.avt-active .avt-tabs-item-title' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-tab .avt-tabs-item.avt-active .avt-tabs-item-title svg' => 'fill: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'active_title_shadow',
				'selector' => '{{WRAPPER}} .avt-tab .avt-tabs-item.avt-active .avt-tabs-item-title',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'active_title_border',
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-tab .avt-tabs-item.avt-active .avt-tabs-item-title',
			]
		);

		$this->add_control(
			'active_title_radius',
			[
				'label'      => __( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-tab .avt-tabs-item.avt-active .avt-tabs-item-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_sub_title',
			[
				'label' => __( 'Sub Title', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'tabs_sub_title_style' );

		$this->start_controls_tab(
			'tab_sub_title_normal',
			[
				'label' => __( 'Normal', 'avator-widget-pack' ),
			]
		);


		$this->add_control(
			'sub_title_color',
			[
				'label'     => __( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-tab .avt-tab-sub-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'sub_title_spacing',
			[
				'label'     => __( 'Spacing', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .avt-tab .avt-tab-sub-title' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'sub_title_typography',
				'selector' => '{{WRAPPER}} .avt-tab .avt-tab-sub-title',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_sub_title_hover',
			[
				'label' => __( 'Hover', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'hover_sub_title_color',
			[
				'label'     => __( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-tab .avt-tabs-item:hover .avt-tab-sub-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_sub_title_active',
			[
				'label' => __( 'Active', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'active_sub_title_color',
			[
				'label'     => __( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-tab .avt-tabs-item .avt-active .avt-tab-sub-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'active_sub_title_typography',
				'selector' => '{{WRAPPER}} .avt-tab .avt-tabs-item .avt-active .avt-tab-sub-title',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
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

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'content_background_color',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .avt-tabs .avt-switcher-item-content',
				'separator' => 'after',
			]
		);

		$this->add_control(
			'content_color',
			[
				'label'     => __( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .avt-tabs .avt-switcher-item-content' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'content_border',
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-tabs .avt-switcher-item-content',
			]
		);

		$this->add_control(
			'content_radius',
			[
				'label'      => __( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-tabs .avt-switcher-item-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
				],
			]
		);

		$this->add_responsive_control(
			'content_padding',
			[
				'label'      => __( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-tabs .avt-switcher-item-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'content_typography',
				'selector' => '{{WRAPPER}} .avt-tabs .avt-switcher-item-content',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_icon',
			[
				'label' => __( 'Icon', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'tabs_icon_style' );

		$this->start_controls_tab(
			'tab_icon_normal',
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
					'{{WRAPPER}} .avt-tab .avt-tabs-item-title i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-tab .avt-tabs-item-title svg' => 'fill: {{VALUE}};',
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
					'{{WRAPPER}} .avt-tabs .avt-tabs-item-title .avt-button-icon-align-left'  => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .avt-tabs .avt-tabs-item-title .avt-button-icon-align-right' => 'margin-left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_icon_hover',
			[
				'label' => __( 'Hover', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'icon_hover_color',
			[
				'label'     => __( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-tabs .avt-tabs-item:hover .avt-tabs-item-title i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-tabs .avt-tabs-item:hover .avt-tabs-item-title svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_icon_active',
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
					'{{WRAPPER}} .avt-tabs .avt-tabs-item.avt-active .avt-tabs-item-title i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-tabs .avt-tabs-item.avt-active .avt-tabs-item-title svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();











		$this->start_controls_section(
			'section_tabs_sticky_style',
			[
				'label' => __( 'Sticky', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'sticky_background',
			[
				'label'     => __( 'Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-tabs > div > .avt-sticky.avt-active' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'sticky_shadow',
				'selector' => '{{WRAPPER}} .avt-tabs > div > .avt-sticky.avt-active',
			]
		);

		$this->add_control(
			'sticky_border_radius',
			[
				'label'      => __( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-tabs > div > .avt-sticky.avt-active' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$id       = $this->get_id();

		$this->add_render_attribute( 'tabs',  'id',  'avt-tabs-' . esc_attr($id) );
		$this->add_render_attribute( 'tabs',  'class',  'avt-tabs' );
		$this->add_render_attribute( 'tabs',  'class',  'avt-tabs-' . $settings['tab_layout'] );

		if ($settings['fullwidth_on_mobile']) {
            $this->add_render_attribute( 'tabs',  'class',  'fullwidth-on-mobile' );
        }

		?>
		<div <?php echo $this->get_render_attribute_string( 'tabs' ); ?>>
			<?php
			if ( 'left' == $settings['tab_layout'] or 'right' == $settings['tab_layout'] ) {
				echo '<div class="avt-grid-collapse"  avt-grid>';				
			}
			?>

			<?php if ( 'bottom' == $settings['tab_layout'] ) : ?>			
				<?php $this->tabs_content(); ?>
			<?php endif; ?>

			<?php $this->desktop_tab_items(); ?>
			

			<?php if ( 'bottom' != $settings['tab_layout'] ) : ?>
					<?php $this->tabs_content(); ?>
			<?php endif; ?>

			<?php
			if ( 'left' == $settings['tab_layout'] or 'right' == $settings['tab_layout'] ) {
				echo "</div>";
			}
			?>
			<a href="#" id="bottom-anchor-<?php echo esc_attr($id); ?>" avt-hidden></a>
		</div>

		<?php
	}

	public function tabs_content() {
		$settings = $this->get_settings_for_display();
		$id       = $this->get_id();

        $this->add_render_attribute( 'switcher-width',  'class',  'avt-switcher-wrapper');

        if ( 'left' == $settings['tab_layout'] or 'right' == $settings['tab_layout'] ) {

            if ( 768 == $settings['media'] ) {
                $this->add_render_attribute( 'switcher-width',  'class', 'avt-width-expand@s' );
            } else {
                $this->add_render_attribute( 'switcher-width',  'class', 'avt-width-expand@m' );
            }
        }

		?>

		<div <?php echo $this->get_render_attribute_string( 'switcher-width' ); ?>>
			<div id="avt-tab-content-<?php echo esc_attr($id); ?>" class="avt-switcher avt-switcher-item-content">
				<?php foreach ( $settings['tabs'] as $index => $item ) : ?>
					<div>
						<div>
							<?php 
				            	if ( 'custom' == $item['source'] and !empty( $item['tab_content'] ) ) {
				            		echo $this->parse_text_editor( $item['tab_content'] );
				            	} elseif ("elementor" == $item['source'] and !empty( $item['template_id'] )) {
				            		echo Widget_Pack_Loader::elementor()->frontend->get_builder_content_for_display( $item['template_id'] );
				            		echo widget_pack_template_edit_link( $item['template_id'] );
				            	} elseif ('anywhere' == $item['source'] and !empty( $item['anywhere_id'] )) {
				            		echo Widget_Pack_Loader::elementor()->frontend->get_builder_content_for_display( $item['anywhere_id'] );
				            		echo widget_pack_template_edit_link( $item['anywhere_id'] );
				            	}
				            ?>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
		<?php
	}

	public function desktop_tab_items() {
		$settings = $this->get_settings_for_display();
		$id       = $this->get_id();

		if ( 'left' == $settings['tab_layout'] or 'right' == $settings['tab_layout'] ) {

			$this->add_render_attribute( 'tabs-width',  'class',  'avt-tab-wrapper');

			if ( 'right' == $settings['tab_layout'] ) {
				$this->add_render_attribute( 'tabs-width',  'class', 'avt-flex-last@m' );
			}

			if (768 == $settings['media']) {
				$this->add_render_attribute( 'tabs-width',  'class', 'avt-width-auto@s' );
				if ( 'right' == $settings['tab_layout'] ) {
					$this->add_render_attribute( 'tabs-width',  'class', 'avt-flex-last' );
				}
			} else {
                $this->add_render_attribute( 'tabs-width',  'class', 'avt-width-auto@m' );
            }
		}

		$this->add_render_attribute(
			[
				'tab-settings' => [
					'class' => [
						'avt-tab',
						( '' !== $settings['tab_layout'] ) ? 'avt-tab-' . $settings['tab_layout'] : '',
						('' != $settings['align'] and 'left' != $settings['tab_layout'] and 'right' != $settings['tab_layout']) ? ('justify' != $settings['align']) ? 'avt-flex-' . $settings['align'] : 'avt-child-width-expand' : ''
					]
				]
			]
		);
        $this->add_render_attribute( 'tab-settings', 'avt-tab', 'connect: #avt-tab-content-' .  esc_attr($id) . ';' );

        if ($settings['tab_transition']) {
            $this->add_render_attribute( 'tab-settings', 'avt-tab', 'animation: avt-animation-'. $settings['tab_transition'] . ';' );
        }
        if ($settings['duration']['size']) {
            $this->add_render_attribute('tab-settings', 'avt-tab', 'duration: ' . $settings['duration']['size'] . ';');
        }
        if ($settings['media']) {
            $this->add_render_attribute('tab-settings', 'avt-tab', 'media: ' . intval($settings['media']) . ';');
        }

        if ( 'left' != $settings['tab_layout'] and 'right' != $settings['tab_layout'] ) {
            $this->add_render_attribute('tab-settings', 'avt-height-match', 'target: > .avt-tabs-item > .avt-tabs-item-title');
        }

        if ('yes' == $settings['nav_sticky_mode'] ) {
            $this->add_render_attribute( 'tabs-sticky', 'avt-sticky', 'bottom: #bottom-anchor-' . $id . ';' );

			if ($settings[ 'nav_sticky_offset' ]['size']) {
				$this->add_render_attribute( 'tabs-sticky', 'avt-sticky', 'offset: ' . $settings[ 'nav_sticky_offset' ]['size'] . ';'  );
			}
			if ($settings['nav_sticky_on_scroll_up']) {
				$this->add_render_attribute( 'tabs-sticky', 'avt-sticky', 'show-on-up: true; animation: avt-animation-slide-top'  );
			}
		}

		?>
		<div <?php echo ( $this->get_render_attribute_string( 'tabs-width' ) ); ?>>
			<div <?php echo ( $this->get_render_attribute_string( 'tabs-sticky' ) ); ?>>
				<div <?php echo ( $this->get_render_attribute_string( 'tab-settings' ) ); ?>>
					<?php foreach ( $settings['tabs'] as $index => $item ) :
						
						$tab_count = $index + 1;
						$tab_id    = ($item['tab_title']) ? widget_pack_string_id($item['tab_title']) : $id . $tab_count;
						$tab_id    = 'avt-tab-'. $tab_id;

						$this->add_render_attribute( 'tabs-item', 'class', 'avt-tabs-item', true );
						if (empty($item['tab_title'])) {
							$this->add_render_attribute( 'tabs-item', 'class', 'avt-has-no-title' );
						}
						if ($tab_count === $settings['active_item']) {
							$this->add_render_attribute( 'tabs-item', 'class', 'avt-active' );
						}
						
						if ( ! isset( $item['tab_icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
							// add old default
							$item['tab_icon'] = 'fas fa-book';
						}
				
						$migrated  = isset( $item['__fa4_migrated']['tab_select_icon'] );
						$is_new    = empty( $item['tab_icon'] ) && Icons_Manager::is_migration_allowed();

                        ?>
						<div <?php echo ( $this->get_render_attribute_string( 'tabs-item' ) ); ?>>
							<a class="avt-tabs-item-title" href="#" id="<?php echo esc_attr($tab_id); ?>" data-tab-index="<?php echo esc_attr($index); ?>">
								<div class="avt-tab-text-wrapper avt-flex-column">

									<div class="avt-tab-title-icon-wrapper">

										<?php if ('' != $item['tab_select_icon']['value'] and 'left' == $settings['icon_align']) : ?>
											<span class="avt-button-icon-align-<?php echo esc_html($settings['icon_align']); ?>">

												<?php if ( $is_new || $migrated ) :
													Icons_Manager::render_icon( $item['tab_select_icon'], [ 'aria-hidden' => 'true', 'class' => 'fa-fw' ] );
												else : ?>
													<i class="<?php echo esc_attr( $item['tab_icon'] ); ?>" aria-hidden="true"></i>
												<?php endif; ?>

											</span>
										<?php endif; ?>

										<?php if ($item['tab_title']) : ?>
											<span class="avt-tab-text">
												<?php echo wp_kses( $item['tab_title'], widget_pack_allow_tags('title') ); ?>
											</span>
										<?php endif; ?>

										<?php if ('' != $item['tab_select_icon']['value'] and 'right' == $settings['icon_align']) : ?>
											<span class="avt-button-icon-align-<?php echo esc_html($settings['icon_align']); ?>">

												<?php if ( $is_new || $migrated ) :
													Icons_Manager::render_icon( $item['tab_select_icon'], [ 'aria-hidden' => 'true', 'class' => 'fa-fw' ] );
												else : ?>
													<i class="<?php echo esc_attr( $item['tab_icon'] ); ?>" aria-hidden="true"></i>
												<?php endif; ?>

											</span>
										<?php endif; ?>

									</div>

									<?php if ($item['tab_sub_title'] and $item['tab_title']) : ?>
										<span class="avt-tab-sub-title avt-text-small">
											<?php echo wp_kses( $item['tab_sub_title'], widget_pack_allow_tags('title') ); ?>
										</span>
									<?php endif; ?>

								</div>
							</a>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
		<?php
	}
	
}