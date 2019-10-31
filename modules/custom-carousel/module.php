<?php
namespace WidgetPack\Modules\CustomCarousel;

use WidgetPack\Base\Widget_Pack_Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Widget_Pack_Module_Base {

	public function get_name() {
		return 'custom-carousel';
	}

	public function get_widgets() {
		$widgets = [
			'Custom_Carousel'
		];

		return $widgets;
	}
}
