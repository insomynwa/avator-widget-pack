<?php
namespace WidgetPack\Modules\RevolutionSlider;

use WidgetPack\Base\Widget_Pack_Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Widget_Pack_Module_Base {

	public function get_name() {
		return 'revolution-slider';
	}

	public function get_widgets() {

		$widgets = ['Revolution_Slider'];

		return $widgets;
	}
}
