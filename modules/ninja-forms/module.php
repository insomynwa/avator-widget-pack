<?php
namespace WidgetPack\Modules\NinjaForms;

use WidgetPack\Base\Widget_Pack_Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Widget_Pack_Module_Base {

	public function get_name() {
		return 'ninja-forms';
	}

	public function get_widgets() {

		$widgets = ['Ninja_Forms'];

		return $widgets;
	}
}
