<?php
namespace WidgetPack\Modules\Wpdatatable;

use WidgetPack\Base\Widget_Pack_Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Widget_Pack_Module_Base {

	public function get_name() {
		return 'wpdatatable';
	}

	public function get_widgets() {

		$widgets = ['wpdatatable'];

		return $widgets;
	}
}
