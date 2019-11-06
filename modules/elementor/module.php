<?php
namespace WidgetPack\Modules\Elementor;

use Elementor;
use Elementor\Elementor_Base;
use Elementor\Controls_Manager;
use Elementor\Element_Base;
use Elementor\Widget_Base;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use WidgetPack;
use WidgetPack\Plugin;
use WidgetPack\Base\Widget_Pack_Module_Base;
use WidgetPack\Widget_Pack_Loader;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Widget_Pack_Module_Base {

	public $sections_data = [];

	public function __construct() {
		parent::__construct();
		$this->add_actions();
	}

	public function get_name() {
		return 'avt-elementor';
	}


	protected function add_actions() {

		add_action( 'elementor/element/after_section_end', [$this, 'lightbox_settings'],10, 3);
		add_action( 'elementor/element/after_section_end', [$this, 'tooltip_settings'],10, 3);
		
	}

	public function lightbox_settings($section, $section_id) {

		static $layout_sections = [ 'section_page_style'];

		if ( ! in_array( $section_id, $layout_sections ) ) { return; }

		$section->start_controls_section(
			'widget_pack_lightbox_style',
			[
				'label' => AWP_CP . esc_html__( 'Lightbox Global Style', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$section->add_control(
			'widget_pack_lightbox_bg',
			[
				'label'     => esc_html__( 'Lightbox Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.avt-lightbox' => 'background-color: {{VALUE}};',
				],
			]
		);


		$section->add_control(
			'widget_pack_cb_color',
			[
				'label'     => esc_html__( 'Close Button Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.avt-lightbox .avt-close.avt-icon' => 'color: {{VALUE}};',
				],
			]
		);
		
		$section->add_control(
			'widget_pack_cb_bg',
			[
				'label'     => esc_html__( 'Close Button Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.avt-lightbox .avt-close.avt-icon' => 'background-color: {{VALUE}};',
				],
			]
		);

		$section->add_group_control(
			Group_Control_Border::get_type(), [
				'name'        => 'widget_pack_cb_border',
				'label'       => esc_html__( 'Close Button Border', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '.avt-lightbox .avt-close.avt-icon',
			]
		);

		$section->add_control(
			'widget_pack_cb_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'.avt-lightbox .avt-close.avt-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$section->add_control(
			'widget_pack_cb_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'.avt-lightbox .avt-close.avt-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


		$section->add_control(
			'widget_pack_toolbar_color',
			[
				'label'     => esc_html__( 'Toolbar Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.avt-lightbox .avt-lightbox-toolbar' => 'color: {{VALUE}};',
				],
			]
		);
		
		$section->add_control(
			'widget_pack_toolbar_bg',
			[
				'label'     => esc_html__( 'Toolbar Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.avt-lightbox .avt-lightbox-toolbar' => 'background-color: {{VALUE}};',
				],
			]
		);

		$section->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'widget_pack_toolbar_typography',
				'label'    => esc_html__( 'Typography', 'avator-widget-pack' ),
				'selector' => '.avt-lightbox .avt-lightbox-toolbar',
			]
		);



		$section->add_control(
			'widget_pack_lightbox_max_height',
			[
				'label'      => esc_html__( 'Max Height (vh)', 'avator-widget-pack' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [
					'vh',
				],
				'range'      => [
					'vh' => [
						'min' => 10,
						'max' => 100,
					],
				],
				'selectors'  => [
					'.avt-lightbox .avt-lightbox-items>*>*' => 'max-height: {{SIZE}}vh;',
				],
				'render_type'=> 'template',
				'separator'  => 'before',
			]
		);


		$section->end_controls_section();
	}

	public function tooltip_settings($section, $section_id) {
		
		static $layout_sections = [ 'section_page_style'];

		if ( ! in_array( $section_id, $layout_sections ) ) { return; }


		$section->start_controls_section(
			'widget_pack_global_tooltip_style',
			[
				'label' => AWP_CP . esc_html__( 'Tooltip Global Style', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$section->add_responsive_control(
			'widget_pack_global_tooltip_width',
			[
				'label'      => esc_html__( 'Width', 'avator-widget-pack' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [
					'px', 'em',
				],
				'range'      => [
					'px' => [
						'min' => 50,
						'max' => 500,
					],
				],
				'selectors'  => [
					'.elementor-widget .tippy-tooltip' => 'width: {{SIZE}}{{UNIT}};',
				],
				'render_type'  => 'template',
			]
		);

		$section->add_control(
			'widget_pack_global_tooltip_color',
			[
				'label'  => esc_html__( 'Text Color', 'avator-widget-pack' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => [
					'.elementor-widget .tippy-tooltip' => 'color: {{VALUE}}',
				],
			]
		);

		$section->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'widget_pack_global_tooltip_background',
				'selector' => '.elementor-widget .tippy-tooltip, .elementor-widget .tippy-tooltip .tippy-backdrop',
			]
		);

		$section->add_control(
			'widget_pack_global_tooltip_arrow_color',
			[
				'label'  => esc_html__( 'Arrow Color', 'avator-widget-pack' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => [
					'.elementor-widget .tippy-popper[x-placement^=left] .tippy-arrow'  => 'border-left-color: {{VALUE}}',
					'.elementor-widget .tippy-popper[x-placement^=right] .tippy-arrow' => 'border-right-color: {{VALUE}}',
					'.elementor-widget .tippy-popper[x-placement^=top] .tippy-arrow'   => 'border-top-color: {{VALUE}}',
					'.elementor-widget .tippy-popper[x-placement^=bottom] .tippy-arrow'=> 'border-bottom-color: {{VALUE}}',
				],
				'condition' => [
					'widget_pack_global_tooltip'       => 'yes',
				],
			]
		);

		$section->add_responsive_control(
			'widget_pack_global_tooltip_padding',
			[
				'label'      => __( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'.elementor-widget .tippy-tooltip' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'render_type'  => 'template',
				'separator' => 'before',
			]
		);

		$section->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'widget_pack_global_tooltip_border',
				'label'       => esc_html__( 'Border', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '.elementor-widget .tippy-tooltip',
			]
		);

		$section->add_responsive_control(
			'widget_pack_global_tooltip_border_radius',
			[
				'label'      => __( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'.elementor-widget .tippy-tooltip' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$section->add_control(
			'widget_pack_global_tooltip_text_align',
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
					'.elementor-widget .tippy-tooltip .tippy-content' => 'text-align: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);


		$section->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'widget_pack_global_tooltip_box_shadow',
				'selector' => '.elementor-widget .tippy-tooltip',
			]
		);
		
		$section->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'widget_pack_global_tooltip_typography',
				'selector' => '.elementor-widget .tippy-tooltip .tippy-content',
			]
		);

		$section->end_controls_section();

	}

}
