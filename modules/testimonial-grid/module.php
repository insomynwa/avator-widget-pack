<?php
namespace WidgetPack\Modules\TestimonialGrid;

use WidgetPack\Base\Widget_Pack_Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Widget_Pack_Module_Base {

	public function get_name() {
		return 'testimonial-grid';
	}

	public function get_widgets() {

		$widgets = [
			'Testimonial_Grid',
		];

		return $widgets;
	}
}
