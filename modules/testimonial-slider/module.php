<?php
namespace WidgetPack\Modules\TestimonialSlider;

use WidgetPack\Base\Widget_Pack_Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Widget_Pack_Module_Base {

	public function get_name() {
		return 'testimonial-slider';
	}

	public function get_widgets() {
		$widgets = ['Testimonial_Slider'];

		return $widgets;
	}
}
