<?php
namespace WidgetPack\Modules\TransformEffects;

use Elementor\Elementor_Base;
use Elementor\Controls_Manager;
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
		return 'avt-transform-effects';
	}

	public function register_controls_widget_transform_effect($widget, $widget_id, $args) {
		static $widgets = [
			'section_effects', /* Section */
		];

		if ( ! in_array( $widget_id, $widgets ) ) {
			return;
		}

		$widget->add_control(
			'widget_pack_widget_transform',
			[
				'label'        => AWP_CP . esc_html__( 'Use Transform?', 'avator-widget-pack' ),
				'description'  => esc_html__( 'Don\'t use with others addon effect so it will work abnormal.' , 'avator-widget-pack' ),
				'type'         => Controls_Manager::SWITCHER,
				'prefix_class' => 'avt-motion-effect-',
				'separator'    => 'before',
			]
		);


		$widget->start_controls_tabs( 'widget_pack_widget_motion_effect_tabs' );

		$widget->start_controls_tab(
			'widget_pack_widget_motion_effect_tab_normal',
			[
				'label' => esc_html__( 'Normal', 'avator-widget-pack' ),
				'condition' => [
					'widget_pack_widget_transform' => 'yes',
				],
			]
		);


		$widget->add_control(
			'widget_pack_translate_toggle_normal',
			[
				'label' 		=> __( 'Translate', 'avator-widget-pack' ),
				'type' 			=> Controls_Manager::POPOVER_TOGGLE,
				'return_value' 	=> 'yes',
				'condition' 	=> [
					'widget_pack_widget_transform' => 'yes',
				],
			]
		);

		$widget->start_popover();


		$widget->add_responsive_control(
			'widget_pack_widget_effect_transx_normal',
			[
				'label'      => esc_html__( 'Translate X', 'avator-widget-pack' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range'      => [
					'px' => [
						'min' => -100,
						'max' => 100,
					],
				],
				'condition' => [
					'widget_pack_translate_toggle_normal' => 'yes',
					'widget_pack_widget_transform' => 'yes',
				],
			]
		);

		$widget->add_responsive_control(
			'widget_pack_widget_effect_transy_normal',
			[
				'label'      => esc_html__( 'Translate Y', 'avator-widget-pack' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range'      => [
					'px' => [
						'min' => -100,
						'max' => 100,
					],
				],
				'selectors' => [
					'(desktop){{WRAPPER}}.avt-motion-effect-yes.elementor-widget' => 'transform: translate({{widget_pack_widget_effect_transx_normal.SIZE || 0}}px, {{widget_pack_widget_effect_transy_normal.SIZE || 0}}px);',
					'(tablet){{WRAPPER}}.avt-motion-effect-yes.elementor-widget' => 'transform: translate({{widget_pack_widget_effect_transx_normal_tablet.SIZE || 0}}px, {{widget_pack_widget_effect_transy_normal_tablet.SIZE || 0}}px);',
					'(mobile){{WRAPPER}}.avt-motion-effect-yes.elementor-widget' => 'transform: translate({{widget_pack_widget_effect_transx_normal_mobile.SIZE || 0}}px, {{widget_pack_widget_effect_transy_normal_mobile.SIZE || 0}}px);',
				],
				'condition' => [
					'widget_pack_translate_toggle_normal' => 'yes',
					'widget_pack_widget_transform' => 'yes',
				],
			]
		);


		$widget->end_popover();



		$widget->add_control(
			'widget_pack_rotate_toggle_normal',
			[
				'label' 		=> __( 'Rotate', 'avator-widget-pack' ),
				'type' 			=> Controls_Manager::POPOVER_TOGGLE,
				'return_value' 	=> 'yes',
				'condition' 	=> [
					'widget_pack_widget_transform' => 'yes',
				],
			]
		);

		$widget->start_popover();


		$widget->add_responsive_control(
			'widget_pack_widget_effect_rotatex_normal',
			[
				'label'      => esc_html__( 'Rotate X', 'avator-widget-pack' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range'      => [
					'px' => [
						'min'  => -180,
						'max'  => 180,
					],
				],
				'condition' => [
					'widget_pack_rotate_toggle_normal' => 'yes',
					'widget_pack_widget_transform' => 'yes',
				],
			]
		);

		$widget->add_responsive_control(
			'widget_pack_widget_effect_rotatey_normal',
			[
				'label'      => esc_html__( 'Rotate Y', 'avator-widget-pack' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range'      => [
					'px' => [
						'min'  => -180,
						'max'  => 180,
					],
				],
				'condition' => [
					'widget_pack_rotate_toggle_normal' => 'yes',
					'widget_pack_widget_transform' => 'yes',
				],
			]
		);


		$widget->add_responsive_control(
			'widget_pack_widget_effect_rotatez_normal',
			[
				'label'   => __( 'Rotate Z', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min'  => -180,
						'max'  => 180,
					],
				],
				'selectors' => [
					'(desktop){{WRAPPER}}.avt-motion-effect-yes.elementor-widget' => 'transform: translate( {{widget_pack_widget_effect_transx_normal.SIZE || 0}}px, {{widget_pack_widget_effect_transy_normal.SIZE || 0}}px) rotateX({{widget_pack_widget_effect_rotatex_normal.SIZE || 0}}deg) rotateY({{widget_pack_widget_effect_rotatey_normal.SIZE || 0}}deg) rotateZ({{widget_pack_widget_effect_rotatez_normal.SIZE || 0}}deg);',
					'(tablet){{WRAPPER}}.avt-motion-effect-yes.elementor-widget' => 'transform: translate( {{widget_pack_widget_effect_transx_normal_tablet.SIZE || 0}}px, {{widget_pack_widget_effect_transy_normal_tablet.SIZE || 0}}px) rotateX({{widget_pack_widget_effect_rotatex_normal.SIZE || 0}}deg) rotateY({{widget_pack_widget_effect_rotatey_normal.SIZE || 0}}deg) rotateZ({{widget_pack_widget_effect_rotatez_normal.SIZE || 0}}deg);',
					'(mobile){{WRAPPER}}.avt-motion-effect-yes.elementor-widget' => 'transform: translate( {{widget_pack_widget_effect_transx_normal_mobile.SIZE || 0}}px, {{widget_pack_widget_effect_transy_normal_mobile.SIZE || 0}}px) rotateX({{widget_pack_widget_effect_rotatex_normal.SIZE || 0}}deg) rotateY({{widget_pack_widget_effect_rotatey_normal.SIZE || 0}}deg) rotateZ({{widget_pack_widget_effect_rotatez_normal.SIZE || 0}}deg);',
				],
				'condition' => [
					'widget_pack_rotate_toggle_normal' => 'yes',
					'widget_pack_widget_transform' => 'yes',
				],
			]
		);


		$widget->end_popover();

		$widget->end_controls_tab();

		$widget->start_controls_tab(
			'widget_pack_widget_motion_effect_tab_hover',
			[
				'label' => esc_html__( 'Hover', 'avator-widget-pack' ),
				'condition' => [
					'widget_pack_widget_transform' => 'yes',
				],
			]
		);

		$widget->add_control(
			'widget_pack_translate_toggle_hover',
			[
				'label' 		=> __( 'Translate', 'avator-widget-pack' ),
				'type' 			=> Controls_Manager::POPOVER_TOGGLE,
				'return_value' 	=> 'yes',
				'condition' 	=> [
					'widget_pack_widget_transform' => 'yes',
				],
			]
		);

		$widget->start_popover();


		$widget->add_responsive_control(
			'widget_pack_widget_effect_transx_hover',
			[
				'label'      => esc_html__( 'Translate X', 'avator-widget-pack' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range'      => [
					'px' => [
						'min' => -100,
						'max' => 100,
					],
				],
				'condition' => [
					'widget_pack_translate_toggle_hover' => 'yes',
					'widget_pack_widget_transform' => 'yes',
				],
			]
		);

		$widget->add_responsive_control(
			'widget_pack_widget_effect_transy_hover',
			[
				'label'      => esc_html__( 'Translate Y', 'avator-widget-pack' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range'      => [
					'px' => [
						'min' => -100,
						'max' => 100,
					],
				],
				'selectors' => [
					'(desktop){{WRAPPER}}.avt-motion-effect-yes.elementor-widget:hover' => 'transform: translate({{widget_pack_widget_effect_transx_hover.SIZE || 0}}px, {{widget_pack_widget_effect_transy_hover.SIZE || 0}}px);',
					'(tablet){{WRAPPER}}.avt-motion-effect-yes.elementor-widget:hover' => 'transform: translate({{widget_pack_widget_effect_transx_hover_tablet.SIZE || 0}}px, {{widget_pack_widget_effect_transy_hover_tablet.SIZE || 0}}px);',
					'(mobile){{WRAPPER}}.avt-motion-effect-yes.elementor-widget:hover' => 'transform: translate({{widget_pack_widget_effect_transx_hover_mobile.SIZE || 0}}px, {{widget_pack_widget_effect_transy_hover_mobile.SIZE || 0}}px);',
				],
				'condition' => [
					'widget_pack_translate_toggle_hover' => 'yes',
					'widget_pack_widget_transform' => 'yes',
				],
			]
		);


		$widget->end_popover();



		$widget->add_control(
			'widget_pack_rotate_toggle_hover',
			[
				'label' 		=> __( 'Rotate', 'avator-widget-pack' ),
				'type' 			=> Controls_Manager::POPOVER_TOGGLE,
				'return_value' 	=> 'yes',
				'condition' 	=> [
					'widget_pack_widget_transform' => 'yes',
				],
			]
		);

		$widget->start_popover();


		$widget->add_responsive_control(
			'widget_pack_widget_effect_rotatex_hover',
			[
				'label'      => esc_html__( 'Rotate X', 'avator-widget-pack' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range'      => [
					'px' => [
						'min'  => -180,
						'max'  => 180,
					],
				],
				'condition' => [
					'widget_pack_rotate_toggle_hover' => 'yes',
					'widget_pack_widget_transform' => 'yes',
				],
			]
		);

		$widget->add_responsive_control(
			'widget_pack_widget_effect_rotatey_hover',
			[
				'label'      => esc_html__( 'Rotate Y', 'avator-widget-pack' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range'      => [
					'px' => [
						'min'  => -180,
						'max'  => 180,
					],
				],
				'condition' => [
					'widget_pack_rotate_toggle_hover' => 'yes',
					'widget_pack_widget_transform' => 'yes',
				],
			]
		);


		$widget->add_responsive_control(
			'widget_pack_widget_effect_rotatez_hover',
			[
				'label'   => __( 'Rotate Z', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min'  => -180,
						'max'  => 180,
					],
				],
				'selectors' => [
					'(desktop){{WRAPPER}}.avt-motion-effect-yes.elementor-widget:hover' => 'transform: translate( {{widget_pack_widget_effect_transx_hover.SIZE || 0}}px, {{widget_pack_widget_effect_transy_hover.SIZE || 0}}px) rotateX({{widget_pack_widget_effect_rotatex_hover.SIZE || 0}}deg) rotateY({{widget_pack_widget_effect_rotatey_hover.SIZE || 0}}deg) rotateZ({{widget_pack_widget_effect_rotatez_hover.SIZE || 0}}deg);',
					'(tablet){{WRAPPER}}.avt-motion-effect-yes.elementor-widget:hover' => 'transform: translate( {{widget_pack_widget_effect_transx_hover_tablet.SIZE || 0}}px, {{widget_pack_widget_effect_transy_hover_tablet.SIZE || 0}}px) rotateX({{widget_pack_widget_effect_rotatex_hover.SIZE || 0}}deg) rotateY({{widget_pack_widget_effect_rotatey_hover.SIZE || 0}}deg) rotateZ({{widget_pack_widget_effect_rotatez_hover.SIZE || 0}}deg);',
					'(mobile){{WRAPPER}}.avt-motion-effect-yes.elementor-widget:hover' => 'transform: translate( {{widget_pack_widget_effect_transx_hover_mobile.SIZE || 0}}px, {{widget_pack_widget_effect_transy_hover_mobile.SIZE || 0}}px) rotateX({{widget_pack_widget_effect_rotatex_hover.SIZE || 0}}deg) rotateY({{widget_pack_widget_effect_rotatey_hover.SIZE || 0}}deg) rotateZ({{widget_pack_widget_effect_rotatez_hover.SIZE || 0}}deg);',
				],
				'condition' => [
					'widget_pack_rotate_toggle_hover' => 'yes',
					'widget_pack_widget_transform' => 'yes',
				],
			]
		);


		$widget->end_popover();


		$widget->end_controls_tab();

		$widget->end_controls_tabs();


	}


	public function widget_transform_effect_before_render($widget) {    		
		$settings = $widget->get_settings();

		// if( $settings['widget_pack_widget_tooltip'] == 'yes' ) {
		// 	$element_id = $widget->get_settings( '_element_id' );
		// 	if (empty($element_id)) {
		// 		$id = 'avt-widget-tooltip-'.$widget->get_id();
		// 		$widget->add_render_attribute( '_wrapper', 'id', $id, true );
		// 	} else {
		// 		$id = $widget->get_settings( '_element_id' );
		// 	}
			
		// 	$widget->add_render_attribute( '_wrapper', 'class', 'avt-tippy-tooltip' );
		// 	$widget->add_render_attribute( '_wrapper', 'data-tippy', '', true );
		// }
	}

	protected function add_actions() {

		add_action( 'elementor/element/before_section_end', [ $this, 'register_controls_widget_transform_effect' ], 10, 3 );
		add_action( 'elementor/frontend/widget/before_render', [ $this, 'widget_transform_effect_before_render' ], 10, 1 );

	}
}