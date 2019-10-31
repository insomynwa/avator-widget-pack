<?php
namespace WidgetPack\Modules\CalderaForms;

use WidgetPack\Base\Widget_Pack_Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Widget_Pack_Module_Base {

	public function get_name() {
		return 'caldera-forms';
	}

	public function get_widgets() {

		$widgets = ['Caldera_Forms'];

		return $widgets;
	}
}
