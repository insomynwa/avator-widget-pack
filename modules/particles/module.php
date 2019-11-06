<?php
namespace WidgetPack\Modules\Particles;

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
		return 'avt-particles';
	}

	public function register_controls_particles($section, $section_id, $args) {

		static $bg_sections = [ 'section_background' ];

		if ( !in_array( $section_id, $bg_sections ) ) { return; }

		$section->add_control(
			'section_particles_on',
			[
				'label'        => AWP_CP . esc_html__( 'Enable Particles?', 'avator-widget-pack' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => '',
				'return_value' => 'yes',
				'description'  => __( 'Switch on to enable Particles options! Note that currently particles are not visible in edit/preview mode for better elementor performance. It\'s only can viewed on the frontend. <b>Z-Index Problem: set column z-index 1 so particles will set behind the content.</b>', 'avator-widget-pack' ),
				'prefix_class' => 'avt-particles-',
				//'render_type'  => 'template',
			]
		);
		
		$section->add_control(
			'section_particles_js',
			[
				'label'     => esc_html__( 'Particles JSON', 'avator-widget-pack' ),
				'type'      => Controls_Manager::TEXTAREA,
				'condition' => [
					'section_particles_on' => 'yes',
				],
				'description'   => __( 'Paste your particles JSON code here - Generate it from <a href="http://vincentgarreau.com/particles.js/#default" target="_blank">Here</a>.', 'avator-widget-pack' ),
				'default'       => '',
				'dynamic'       => [ 'active' => true ],
				//'render_type' => 'template',
			]
		);

	}


	public function particles_before_render($section) {    		
		$settings = $section->get_settings();
		$id       = $section->get_id();
		
		if( $settings['section_particles_on'] == 'yes' ) {

			$particle_js = $settings['section_particles_js'];
			
			if (empty($particle_js)) {
				$particle_js = '{"particles":{"number":{"value":80,"density":{"enable":true,"value_area":800}},"color":{"value":"#ffffff"},"shape":{"type":"circle","stroke":{"width":0,"color":"#000000"},"polygon":{"nb_sides":5},"image":{"src":"img/github.svg","width":100,"height":100}},"opacity":{"value":0.5,"random":false,"anim":{"enable":false,"speed":1,"opacity_min":0.1,"sync":false}},"size":{"value":3,"random":true,"anim":{"enable":false,"speed":40,"size_min":0.1,"sync":false}},"line_linked":{"enable":true,"distance":150,"color":"#ffffff","opacity":0.4,"width":1},"move":{"enable":true,"speed":6,"direction":"none","random":false,"straight":false,"out_mode":"out","bounce":false,"attract":{"enable":false,"rotateX":600,"rotateY":1200}}},"interactivity":{"detect_on":"canvas","events":{"onhover":{"enable":false,"mode":"repulse"},"onclick":{"enable":true,"mode":"push"},"resize":true},"modes":{"grab":{"distance":400,"line_linked":{"opacity":1}},"bubble":{"distance":400,"size":40,"duration":2,"opacity":8,"speed":3},"repulse":{"distance":200,"duration":0.4},"push":{"particles_nb":4},"remove":{"particles_nb":2}}},"retina_detect":true}';
			}

			$this->sections_data[$id] = [ 'particles_js' => $particle_js ];
			
			WidgetPack\widget_pack_config()->elements_data['sections'] = $this->sections_data;
		}

		
					

	}

	public function particles_after_render($section) {

		if ( $section->get_settings( 'section_particles_on' ) == 'yes' ) {
			wp_enqueue_script( 'particles' );
			wp_enqueue_script( 'wipa-particles' );
		}

	}


	protected function add_actions() {

			add_action( 'elementor/element/before_section_end', [ $this, 'register_controls_particles' ], 10, 3 );		
			add_action( 'elementor/frontend/section/before_render', [ $this, 'particles_before_render' ], 10, 1 );
			add_action( 'elementor/frontend/section/after_render', [ $this, 'particles_after_render' ], 10, 1 );

	}
}