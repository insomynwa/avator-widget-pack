<?php
namespace WidgetPack\Modules\Chart;

use WidgetPack\Base\Widget_Pack_Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Widget_Pack_Module_Base {

	public function get_name() {
		return 'chart';
	}

	public function get_widgets() {

		$widgets = [
			'Chart',
		];

		return $widgets;
	}
}
