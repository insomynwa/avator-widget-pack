<?php
namespace WidgetPack\Modules\Offcanvas;

use WidgetPack\Base\Widget_Pack_Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Widget_Pack_Module_Base {

	public function get_name() {
		return 'offcanvas';
	}

	public function get_widgets() {

		$widgets = [
			'Offcanvas',
		];

		return $widgets;
	}
}