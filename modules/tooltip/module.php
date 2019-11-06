<?php
namespace WidgetPack\Modules\Tooltip;

use Elementor\Elementor_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use WidgetPack;
use WidgetPack\Plugin;
use WidgetPack\Base\Widget_Pack_Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Widget_Pack_Module_Base {

	public function __construct() {
		parent::__construct();
		$this->add_actions();
	}

	public function get_name() {
		return 'avt-tooltip';
	}

	public function register_controls_widget_tooltip($widget, $widget_id, $args) {
		static $widgets = [
			'_section_style', /* Section */
		];

		if ( ! in_array( $widget_id, $widgets ) ) {
			return;
		}

		$widget->add_control(
			'widget_pack_widget_tooltip',
			[
				'label'        => AWP_CP . esc_html__( 'Use Tooltip?', 'avator-widget-pack' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'avator-widget-pack' ),
				'label_off'    => esc_html__( 'No', 'avator-widget-pack' ),
				'render_type'  => 'template',
				'separator'    => 'before',
			]
		);

		$widget->start_controls_tabs( 'widget_pack_widget_tooltip_tabs' );

		$widget->start_controls_tab(
			'widget_pack_widget_tooltip_settings_tab',
			[
				'label' => esc_html__( 'Settings', 'avator-widget-pack' ),
				'condition' => [
					'widget_pack_widget_tooltip' => 'yes',
				],
			]
		);

		$widget->add_control(
			'widget_pack_widget_tooltip_text',
			[
				'label'       => esc_html__( 'Description', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXTAREA,
				'render_type' => 'template',
				'default'     => 'This is Tooltip',
				'dynamic'     => [ 'active' => true ],
				'condition'   => [
					'widget_pack_widget_tooltip' => 'yes',
				],
			]
		);

		$widget->add_control(
			'widget_pack_widget_tooltip_placement',
			[
				'label'   => esc_html__( 'Placement', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'top',
				'options' => [
					'top-start'    => esc_html__( 'Top Left', 'avator-widget-pack' ),
					'top'          => esc_html__( 'Top', 'avator-widget-pack' ),
					'top-end'      => esc_html__( 'Top Right', 'avator-widget-pack' ),
					'bottom-start' => esc_html__( 'Bottom Left', 'avator-widget-pack' ),
					'bottom'       => esc_html__( 'Bottom', 'avator-widget-pack' ),
					'bottom-end'   => esc_html__( 'Bottom Right', 'avator-widget-pack' ),
					'left'         => esc_html__( 'Left', 'avator-widget-pack' ),
					'right'        => esc_html__( 'Right', 'avator-widget-pack' ),
				],
				'render_type'  => 'template',
				'condition' => [
					'widget_pack_widget_tooltip' => 'yes',
				],
			]
		);

		$widget->add_control(
			'widget_pack_widget_tooltip_animation',
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
					'widget_pack_widget_tooltip' => 'yes',
				],
			]
		);

		$widget->add_control(
			'widget_pack_widget_tooltip_x_offset',
			[
				'label'   => esc_html__( 'Offset', 'avator-widget-pack' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 0,
				'min'     => -1000,
				'max'     => 1000,
				'step'    => 1,
				'condition' => [
					'widget_pack_widget_tooltip' => 'yes',
				],
			]
		);

		$widget->add_control(
			'widget_pack_widget_tooltip_y_offset',
			[
				'label'   => esc_html__( 'Distance', 'avator-widget-pack' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 0,
				'min'     => -1000,
				'max'     => 1000,
				'step'    => 1,
				'condition' => [
					'widget_pack_widget_tooltip' => 'yes',
				],
			]
		);

		$widget->add_control(
			'widget_pack_widget_tooltip_arrow',
			[
				'label'        => esc_html__( 'Arrow', 'avator-widget-pack' ),
				'type'         => Controls_Manager::SWITCHER,
				'condition'    => [
					'widget_pack_widget_tooltip' => 'yes',
				],
			]
		);

		$widget->end_controls_tab();

		$widget->start_controls_tab(
			'widget_pack_widget_tooltip_styles_tab',
			[
				'label' => esc_html__( 'Style', 'avator-widget-pack' ),
				'condition' => [
					'widget_pack_widget_tooltip' => 'yes',
				],
			]
		);

		$widget->add_responsive_control(
			'widget_pack_widget_tooltip_width',
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
					'{{WRAPPER}} .tippy-tooltip' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'widget_pack_widget_tooltip' => 'yes',
				],
				'render_type'  => 'template',
			]
		);

		
		$widget->add_control(
			'widget_pack_widget_tooltip_color',
			[
				'label'  => esc_html__( 'Text Color', 'avator-widget-pack' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tippy-tooltip' => 'color: {{VALUE}}',
				],
				'condition' => [
					'widget_pack_widget_tooltip' => 'yes',
				],
			]
		);
		
		$widget->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'widget_pack_widget_tooltip_background',
				'selector' => '{{WRAPPER}} .tippy-tooltip, {{WRAPPER}} .tippy-tooltip .tippy-backdrop',
				'condition' => [
					'widget_pack_widget_tooltip' => 'yes',
				],
			]
		);

		$widget->add_control(
			'widget_pack_widget_tooltip_arrow_color',
			[
				'label'  => esc_html__( 'Arrow Color', 'avator-widget-pack' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tippy-popper[x-placement^=left] .tippy-arrow'  => 'border-left-color: {{VALUE}}',
					'{{WRAPPER}} .tippy-popper[x-placement^=right] .tippy-arrow' => 'border-right-color: {{VALUE}}',
					'{{WRAPPER}} .tippy-popper[x-placement^=top] .tippy-arrow'   => 'border-top-color: {{VALUE}}',
					'{{WRAPPER}} .tippy-popper[x-placement^=bottom] .tippy-arrow'=> 'border-bottom-color: {{VALUE}}',
				],
				'condition' => [
					'widget_pack_widget_tooltip'       => 'yes',
				],
				'separator' => 'after',
			]
		);

		$widget->add_responsive_control(
			'widget_pack_widget_tooltip_padding',
			[
				'label'      => __( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tippy-tooltip' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'render_type'  => 'template',
				'condition' => [
					'widget_pack_widget_tooltip' => 'yes',
				],
			]
		);

		$widget->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'widget_pack_widget_tooltip_border',
				'label'       => esc_html__( 'Border', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .tippy-tooltip',
				'condition' => [
					'widget_pack_widget_tooltip' => 'yes',
				],
			]
		);

		$widget->add_responsive_control(
			'widget_pack_widget_tooltip_border_radius',
			[
				'label'      => __( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tippy-tooltip' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'widget_pack_widget_tooltip' => 'yes',
				],
			]
		);

		$widget->add_control(
			'widget_pack_widget_tooltip_text_align',
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
				'condition' => [
					'widget_pack_widget_tooltip' => 'yes',
				],
				'separator' => 'before',
			]
		);

		$widget->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'widget_pack_widget_tooltip_box_shadow',
				'selector' => '{{WRAPPER}} .tippy-tooltip',
				'condition' => [
					'widget_pack_widget_tooltip' => 'yes',
				],
			]
		);

		$widget->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'widget_pack_widget_tooltip_typography',
				'selector' => '{{WRAPPER}} .tippy-tooltip .tippy-content',
				'condition' => [
					'widget_pack_widget_tooltip' => 'yes',
				],
			]
		);

		$widget->end_controls_tab();

		$widget->end_controls_tabs();



	}


	public function widget_tooltip_before_render($widget) {    		
		$settings = $widget->get_settings();

		if( $settings['widget_pack_widget_tooltip'] == 'yes' ) {
			$element_id = $widget->get_settings( '_element_id' );
			if (empty($element_id)) {
				$id = 'avt-widget-tooltip-'.$widget->get_id();
				$widget->add_render_attribute( '_wrapper', 'id', $id, true );
			} else {
				$id = $widget->get_settings( '_element_id' );
			}
			
			$widget->add_render_attribute( '_wrapper', 'class', 'avt-tippy-tooltip' );
			$widget->add_render_attribute( '_wrapper', 'data-tippy', '', true );

			if (!empty($settings['widget_pack_widget_tooltip_text'])) {
				$widget->add_render_attribute( '_wrapper', 'data-tippy-content', $settings['widget_pack_widget_tooltip_text'], true );
			}
			if (!empty($settings['widget_pack_widget_tooltip_placement'])) {
				$widget->add_render_attribute( '_wrapper', 'data-tippy-placement', $settings['widget_pack_widget_tooltip_placement'], true );
			}
			if (!empty($settings['widget_pack_widget_tooltip_arrow'])) {
				$widget->add_render_attribute( '_wrapper', 'data-tippy-arrow', 'true', true );
			}
			if (!empty($settings['widget_pack_widget_tooltip_animation'])) {
				$widget->add_render_attribute( '_wrapper', 'data-tippy-animation', $settings['widget_pack_widget_tooltip_animation'], true );
			}
			
			if (!empty($settings['widget_pack_widget_tooltip_x_offset']) or !empty($settings['widget_pack_widget_tooltip_y_offset']) ) {
				$xoffset = ( !empty($settings['widget_pack_widget_tooltip_x_offset'] ) ? $settings['widget_pack_widget_tooltip_x_offset'] : '0' ) ;
				$yoffset = ( !empty($settings['widget_pack_widget_tooltip_y_offset'] ) ? $settings['widget_pack_widget_tooltip_y_offset'] : '0' ) ;
				$offset  = $xoffset .','. $yoffset;
				$widget->add_render_attribute( '_wrapper', 'data-tippy-offset', $offset, true );
			}
			

			// tooltip javascript need to load
			wp_enqueue_script( 'popper' );
			wp_enqueue_script( 'tippyjs' );

			

		}
	}

	protected function add_actions() {

		add_action( 'elementor/element/before_section_end', [ $this, 'register_controls_widget_tooltip' ], 10, 3 );
		add_action( 'elementor/frontend/widget/before_render', [ $this, 'widget_tooltip_before_render' ], 10, 1 );

	}
}