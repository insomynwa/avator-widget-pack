<?php
namespace WidgetPack\Modules\DeviceSlider;

use WidgetPack\Base\Widget_Pack_Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Widget_Pack_Module_Base {

	public function get_name() {
		return 'device-slider';
	}

	public function get_widgets() {
		$widgets = [
			'Device_Slider',
		];

		return $widgets;
	}
}
