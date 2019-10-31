<?php
namespace WidgetPack\Modules\AdvancedGmap;

use WidgetPack\Base\Widget_Pack_Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Widget_Pack_Module_Base {

	public function get_name() {
		return 'advanced-gmap';
	}

	public function get_widgets() {

		$widgets = [
			'Advanced_Gmap'
		];

		return $widgets;
	}
}
