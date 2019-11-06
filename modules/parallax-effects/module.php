<?php
namespace WidgetPack\Modules\ParallaxEffects;

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
		return 'avt-parallax-effects';
	}

	public function register_controls_widget_parallax($widget, $args) {

		$widget->add_control(
			'wipa_parallax_effects_show',
			[
				'label'        => AWP_CP . esc_html__( 'Parallax Effects', 'avator-widget-pack' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => '',
				'return_value' => 'yes',
				'separator'    => 'after',
			]
		);



		$widget->add_control(
			'wipa_parallax_effects_y',
			[
				'label' => __( 'Vertical Parallax', 'avator-widget-pack' ),
				'type' => Controls_Manager::POPOVER_TOGGLE,
				'condition' => [
					'wipa_parallax_effects_show' => 'yes',
				],
				'render_type' => 'none',
			]
		);

		$widget->start_popover();

		$widget->add_control(
			'wipa_parallax_effects_y_start',
			[
				'label'       => esc_html__( 'Start', 'avator-widget-pack' ),
				'type'        => Controls_Manager::SLIDER,
				'range'       => [
					'px' => [
						'min'   => -500,
						'max'   => 500,
						'step' => 10,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 50,
				],
				'condition'    => [
					'wipa_parallax_effects_show' => 'yes',
				],
			]
		);

		$widget->add_control(
			'wipa_parallax_effects_y_end',
			[
				'label'       => esc_html__( 'End', 'avator-widget-pack' ),
				'type'        => Controls_Manager::SLIDER,
				'range'       => [
					'px' => [
						'min'   => -500,
						'max'   => 500,
						'step' => 10,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 0,
				],
				'condition'    => [
					'wipa_parallax_effects_show' => 'yes',
				],
			]
		);



		$widget->end_popover();



		$widget->add_control(
			'wipa_parallax_effects_x',
			[
				'label' => __( 'Horizontal Parallax', 'avator-widget-pack' ),
				'type' => Controls_Manager::POPOVER_TOGGLE,
				'condition' => [
					'wipa_parallax_effects_show' => 'yes',
				],
				'render_type' => 'none',
			]
		);

		$widget->start_popover();

		$widget->add_control(
			'wipa_parallax_effects_x_start',
			[
				'label'       => esc_html__( 'Start', 'avator-widget-pack' ),
				'type'        => Controls_Manager::SLIDER,
				'range'       => [
					'px' => [
						'min'   => -500,
						'max'   => 500,
						'step' => 10,
					],
				],

				'condition'    => [
					'wipa_parallax_effects_show' => 'yes',
				],
			]
		);

		$widget->add_control(
			'wipa_parallax_effects_x_end',
			[
				'label'       => esc_html__( 'End', 'avator-widget-pack' ),
				'type'        => Controls_Manager::SLIDER,
				'range'       => [
					'px' => [
						'min'   => -500,
						'max'   => 500,
						'step' => 10,
					],
				],
				'condition'    => [
					'wipa_parallax_effects_show' => 'yes',
				],
			]
		);

		$widget->end_popover();


		$widget->add_control(
			'wipa_parallax_effects_viewport',
			[
				'label' => __( 'Animation Viewport', 'avator-widget-pack' ),
				'type' => Controls_Manager::POPOVER_TOGGLE,
				'condition' => [
					'wipa_parallax_effects_show' => 'yes',
				],
				'render_type' => 'none',
			]
		);

		$widget->start_popover();

		$widget->add_control(
			'wipa_parallax_effects_viewport_value',
			[
				'label'       => esc_html__( 'Value', 'avator-widget-pack' ),
				'type'        => Controls_Manager::SLIDER,
				'range'       => [
					'px' => [
						'min'  => 0.1,
						'max'  => 1,
						'step' => 0.1,
					],
				],
				'condition'    => [
					'wipa_parallax_effects_show' => 'yes',
				],
			]
		);

		$widget->end_popover();


		$widget->add_control(
			'wipa_parallax_effects_opacity',
			[
				'label'   => __( 'Opacity', 'avator-widget-pack' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'htov' => [
						'title' => __( 'Hidden to Visible', 'avator-widget-pack' ),
						'icon'  => 'eicon-v-align-bottom',
					],
					'vtoh' => [
						'title' => __( 'Visible to Hidden', 'avator-widget-pack' ),
						'icon'  => 'eicon-v-align-top',
					],
				],
				'toggle'      => true,
				'condition'    => [
					'wipa_parallax_effects_show' => 'yes',
				],
			]
		);



		$widget->add_control(
			'wipa_parallax_effects_blur',
			[
				'label' => __( 'Blur', 'avator-widget-pack' ),
				'type' => Controls_Manager::POPOVER_TOGGLE,
				'condition' => [
					'wipa_parallax_effects_show' => 'yes',
				],
				'render_type' => 'none',
			]
		);

		$widget->start_popover();

		$widget->add_control(
			'wipa_parallax_effects_blur_start',
			[
				'label'       => esc_html__( 'Start', 'avator-widget-pack' ),
				'type'        => Controls_Manager::SLIDER,
				'range'       => [
					'px' => [
						'min'   => 0,
						'max'   => 20,
						'step' => 1,
					],
				],
				'condition'    => [
					'wipa_parallax_effects_show' => 'yes',
				],
			]
		);

		$widget->add_control(
			'wipa_parallax_effects_blur_end',
			[
				'label'       => esc_html__( 'End', 'avator-widget-pack' ),
				'type'        => Controls_Manager::SLIDER,
				'range'       => [
					'px' => [
						'min'   => 0,
						'max'   => 20,
						'step' => 1,
					],
				],
				'condition'    => [
					'wipa_parallax_effects_show' => 'yes',
				],
			]
		);

		$widget->end_popover();


		$widget->add_control(
			'wipa_parallax_effects_rotate',
			[
				'label' => __( 'Rotate', 'avator-widget-pack' ),
				'type' => Controls_Manager::POPOVER_TOGGLE,
				'condition' => [
					'wipa_parallax_effects_show' => 'yes',
				],
				'render_type' => 'none',
			]
		);

		$widget->start_popover();

		$widget->add_control(
			'wipa_parallax_effects_rotate_value',
			[
				'label'       => esc_html__( 'Value', 'avator-widget-pack' ),
				'type'        => Controls_Manager::SLIDER,
				'range'       => [
					'deg' => [
						'min'  => 0,
						'max'  => 360,
						'step' => 1,
					],
				],
				'condition'    => [
					'wipa_parallax_effects_show' => 'yes',
				],
			]
		);

		$widget->end_popover();

		$widget->add_control(
			'wipa_parallax_effects_scale',
			[
				'label' => __( 'Scale', 'avator-widget-pack' ),
				'type' => Controls_Manager::POPOVER_TOGGLE,
				'condition' => [
					'wipa_parallax_effects_show' => 'yes',
				],
				'render_type' => 'none',
			]
		);

		$widget->start_popover();

		$widget->add_control(
			'wipa_parallax_effects_scale_value',
			[
				'label'       => esc_html__( 'Value', 'avator-widget-pack' ),
				'type'        => Controls_Manager::SLIDER,
				'range'       => [
					'' => [
						'min'  => -10,
						'max'  => 10,
						'step' => 0.1,
					],
				],
				'condition'    => [
					'wipa_parallax_effects_show' => 'yes',
				],
			]
		);

		$widget->end_popover();

		$widget->add_control(
			'wipa_parallax_effects_hue',
			[
				'label' => __( 'Hue', 'avator-widget-pack' ),
				'type' => Controls_Manager::POPOVER_TOGGLE,
				'condition' => [
					'wipa_parallax_effects_show' => 'yes',
				],
				'render_type' => 'none',
			]
		);

		$widget->start_popover();

		$widget->add_control(
			'wipa_parallax_effects_hue_value',
			[
				'label'       => esc_html__( 'Value', 'avator-widget-pack' ),
				'type'        => Controls_Manager::SLIDER,
				'range'       => [
					'deg' => [
						'min'  => 0,
						'max'  => 360,
						'step' => 1,
					],
				],
				'condition'    => [
					'wipa_parallax_effects_show' => 'yes',
				],
			]
		);

		$widget->end_popover();


		$widget->add_control(
			'wipa_parallax_effects_sepia',
			[
				'label' => __( 'Sepia', 'avator-widget-pack' ),
				'type' => Controls_Manager::POPOVER_TOGGLE,
				'condition' => [
					'wipa_parallax_effects_show' => 'yes',
				],
				'render_type' => 'none',
			]
		);

		$widget->start_popover();

		$widget->add_control(
			'wipa_parallax_effects_sepia_value',
			[
				'label'       => esc_html__( 'Value', 'avator-widget-pack' ),
				'type'        => Controls_Manager::SLIDER,
				'range'       => [
					'%' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
				],
				'condition'    => [
					'wipa_parallax_effects_show' => 'yes',
				],
			]
		);


		$widget->end_popover();

		$widget->add_control(
			'wipa_parallax_effects_media_query',
			[
				'label'       => __( 'Parallax Start From', 'avator-widget-pack' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					''    => __( 'All Device', 'avator-widget-pack' ),
					'@xl' => __( 'Retina to Larger', 'avator-widget-pack' ),
					'@l'  => __( 'Desktop to Larger', 'avator-widget-pack' ),
					'@m'  => __( 'Tablet to Larger', 'avator-widget-pack' ),
					'@s'  => __( 'Mobile to Larger', 'avator-widget-pack' ),
				],
				'condition' => [
					'wipa_parallax_effects_show' => 'yes',
				],
				'render_type' => 'none',
				'separator'    => 'after',
			]
		);

	}


	public function widget_parallax_before_render($widget) {
		$settings = $widget->get_settings();

		if( $settings['wipa_parallax_effects_show'] == 'yes' ) {

			$parallax_y_start    = ($settings['wipa_parallax_effects_y_start']['size']) ? $settings['wipa_parallax_effects_y_start']['size'] : 0;
			$parallax_y_end      = ($settings['wipa_parallax_effects_y_end']['size']) ? $settings['wipa_parallax_effects_y_end']['size'] : 0;

			$parallax_x_start    = $settings['wipa_parallax_effects_x_start']['size'];
			$parallax_x_end      = $settings['wipa_parallax_effects_x_end']['size'];

			$parallax_viewport   = $settings['wipa_parallax_effects_viewport_value']['size'];

			$parallax_opacity    = $settings['wipa_parallax_effects_opacity'];

			$parallax_blur_start = ($settings['wipa_parallax_effects_blur_start']['size']) ? $settings['wipa_parallax_effects_blur_start']['size'] : 0;
			$parallax_blur_end   = ($settings['wipa_parallax_effects_blur_end']['size']) ? $settings['wipa_parallax_effects_blur_end']['size'] : 0;

			$parallax_rotate     = $settings['wipa_parallax_effects_rotate_value']['size'];

			$parallax_scale      = $settings['wipa_parallax_effects_scale_value']['size'];

			$parallax_hue        = $settings['wipa_parallax_effects_hue_value']['size'];

			$parallax_sepia      = $settings['wipa_parallax_effects_sepia_value']['size'];

			$parallax_media_query      = ($settings['wipa_parallax_effects_media_query']) ? $settings['wipa_parallax_effects_media_query'] : '';

			if ( $settings['wipa_parallax_effects_y'] ) {
				$widget->add_render_attribute( '_wrapper', 'avt-parallax', 'y: ' . $parallax_y_start . ',' . $parallax_y_end . ';' );
			}

			if ( $settings['wipa_parallax_effects_x'] ) {
				$widget->add_render_attribute( '_wrapper', 'avt-parallax', 'x: ' . $parallax_x_start . ',' . $parallax_x_end . ';' );
			}


			if ( $settings['wipa_parallax_effects_viewport'] ) {
				$widget->add_render_attribute( '_wrapper', 'avt-parallax', 'viewport: ' . $parallax_viewport . ';' );
			}

			if ( !empty($parallax_opacity) ) {
				if ($parallax_opacity == 'htov') {
					$widget->add_render_attribute( '_wrapper', 'avt-parallax', 'opacity: 0,1;' );
				} elseif ( $parallax_opacity == 'vtoh' ){
					$widget->add_render_attribute( '_wrapper', 'avt-parallax', 'opacity: 1,0;' );
				}
			}

			if ( $settings['wipa_parallax_effects_blur'] ) {
				$widget->add_render_attribute( '_wrapper', 'avt-parallax', 'blur: ' . $parallax_blur_start . ',' . $parallax_blur_end . ';' );
			}

			if ( $settings['wipa_parallax_effects_rotate'] ) {
				$widget->add_render_attribute( '_wrapper', 'avt-parallax', 'rotate: ' . $parallax_rotate . ';' );
			}

			if ( $settings['wipa_parallax_effects_scale'] ) {
				$widget->add_render_attribute( '_wrapper', 'avt-parallax', 'scale: ' . $parallax_scale . ';' );
			}

			if ( $settings['wipa_parallax_effects_hue'] ) {
				$widget->add_render_attribute( '_wrapper', 'avt-parallax', 'hue: ' . $parallax_hue . ';' );
			}

			if ( $settings['wipa_parallax_effects_sepia'] ) {
				$widget->add_render_attribute( '_wrapper', 'avt-parallax', 'sepia: ' . $parallax_sepia . ';' );
			}

			if ( !empty($parallax_media_query) ) {
				$widget->add_render_attribute( '_wrapper', 'avt-parallax', 'media: ' . $parallax_media_query . ';' );
			}

		}
	}

	protected function add_actions() {

		add_action( 'elementor/element/common/section_effects/after_section_start', [ $this, 'register_controls_widget_parallax'], 10, 2 );
		add_action( 'elementor/frontend/widget/before_render', [ $this, 'widget_parallax_before_render' ], 10, 1 );

	}
}