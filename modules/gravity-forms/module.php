<?php
namespace WidgetPack\Modules\GravityForms;

use WidgetPack\Base\Widget_Pack_Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Widget_Pack_Module_Base {

	public function get_name() {
		return 'gravity-forms';
	}

	public function get_widgets() {

		$widgets = ['Gravity_Forms'];

		return $widgets;
	}
}
