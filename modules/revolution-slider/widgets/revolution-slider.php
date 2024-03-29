<?php
namespace WidgetPack\Modules\RevolutionSlider\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Revolution_Slider extends Widget_Base {

	public function get_name() {
		return 'avt-revolution-slider';
	}

	public function get_title() {
		return AWP . esc_html__( 'Revolution Slider', 'avator-widget-pack' );
	}

	public function get_icon() {
		return 'avt-wi-revolution-slider';
	}

	public function get_categories() {
		return [ 'widget-pack' ];
	}

	public function get_keywords() {
		return [ 'revolution', 'slider', 'magenta', 'responsive', 'slideshow' ];
	}

	public function get_custom_help_url() {
		return 'https://youtu.be/S3bs8FfTBsI';
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_content_layout',
			[
				'label' => esc_html__( 'Layout', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'slider_name',
			[
				'label'   => esc_html__( 'Select Slider', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '0',
				'options' => widget_pack_rev_slider_options(),
			]
		);

		$this->end_controls_section();
	}

	private function get_shortcode() {
		$settings = $this->get_settings();
		$slider_alias = $settings['slider_name'];

		if ($slider_alias) {
			$attributes = [
				'alias' => $settings['slider_name'],
			];

			$this->add_render_attribute( 'shortcode', $attributes );

			$shortcode   = [];
			$shortcode[] = sprintf( '[rev_slider %s]', $this->get_render_attribute_string( 'shortcode' ) );

			return implode("", $shortcode);
		} else {
			return widget_pack_alert( esc_html('Slider not found! Please select correct slider from option.', 'avator-widget-pack') );
		}
	}

	public function render() {
		echo do_shortcode( $this->get_shortcode() );
	}

	public function render_plain_content() {
		echo $this->get_shortcode();
	}
}
