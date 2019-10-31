<?php
namespace WidgetPack\Modules\WpForms;

use WidgetPack\Base\Widget_Pack_Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Widget_Pack_Module_Base {

	public function get_name() {
		return 'wp-forms';
	}

	public function get_widgets() {

		$widgets = ['Wp_Forms'];

		return $widgets;
	}
}
