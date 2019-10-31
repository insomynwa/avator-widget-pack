<?php
namespace WidgetPack\Modules\ProgressPie;

use WidgetPack\Base\Widget_Pack_Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Widget_Pack_Module_Base {

	public function get_name() {
		return 'progress-pie';
	}

	public function get_widgets() {

		$widgets = [
			'Progress_Pie',
		];

		return $widgets;
	}
}
