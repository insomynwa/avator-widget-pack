<?php
namespace WidgetPack\Modules\TrailerBox;

use WidgetPack\Base\Widget_Pack_Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Widget_Pack_Module_Base {

	public function get_name() {
		return 'trailer-box';
	}

	public function get_widgets() {

		$widgets = ['Trailer_Box'];

		return $widgets;
	}
}
