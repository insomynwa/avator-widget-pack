<?php
namespace WidgetPack\Modules\LayerSlider\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Layer_Slider extends Widget_Base {

	public function get_name() {
		return 'avt-layer-slider';
	}

	public function get_title() {
		return AWP . esc_html__( 'Layer Slider', 'avator-widget-pack' );
	}

	public function get_icon() {
		return 'avt-wi-layer-slider';
	}

	public function get_categories() {
		return [ 'widget-pack' ];
	}

	public function get_keywords() {
		return [ 'layer', 'slider', 'animation', 'effects', 'parallax', 'popup', 'showcase', 'slideshow' ];
	}

	public function get_custom_help_url() {
		return 'https://youtu.be/I2xpXLyCkkE';
	}

	protected function layer_slider_list() {
        if(shortcode_exists("layerslider")){
			$output  = '';
			$sliders = \LS_Sliders::find(array('limit' => 100));

            foreach($sliders as $item) {
				$name                = empty($item['name']) ? 'Unnamed' : htmlspecialchars($item['name']);
				$output[$item['id']] = $name;
            }

            return $output;
        }
    }

	protected function _register_controls() {
		$this->start_controls_section(
			'section_content_layout',
			[
				'label' => esc_html__( 'Layout', 'avator-widget-pack' ),
			]
		);

		$slider_list = $this->layer_slider_list();

		$this->add_control(
			'slider_name',
			[
				'label'   => esc_html__( 'Select Slider', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'options' => $slider_list,
			]
		);

		$this->add_control(
			'firstslide',
			[
				'label'       => esc_html__( 'First Slide', 'avator-widget-pack' ),
				'description' => esc_html__( 'Which slide you want to show first?', 'avator-widget-pack' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 1,
				
			]
		);
		
		$this->end_controls_section();
	}

	private function get_shortcode() {
		$settings = $this->get_settings();

		$attributes = [
			'id'         => $settings['slider_name'],
			'firstslide' => $settings['firstslide'],
		];

		$this->add_render_attribute( 'shortcode', $attributes );

		$shortcode   = [];
		$shortcode[] = sprintf( '[layerslider %s]', $this->get_render_attribute_string( 'shortcode' ) );

		return implode("", $shortcode);
	}

	public function render() {
		echo do_shortcode( $this->get_shortcode() );
	}

	public function render_plain_content() {
		echo $this->get_shortcode();
	}
}
