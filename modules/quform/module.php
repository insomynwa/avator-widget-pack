<?php
namespace WidgetPack\Modules\Quform;

use WidgetPack\Base\Widget_Pack_Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Widget_Pack_Module_Base {

	public function get_name() {
		return 'quform';
	}

	public function get_widgets() {

		$widgets = ['Quform'];

		return $widgets;
	}
}
