<?php
namespace WidgetPack\Modules\BusinessHours;

use WidgetPack\Base\Widget_Pack_Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Widget_Pack_Module_Base {

	public function get_name() {
		return 'business-hours';
	}

	public function get_widgets() {

		$widgets = [
			'Business_Hours',
		];

		return $widgets;
	}
}
