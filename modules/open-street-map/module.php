<?php
namespace WidgetPack\Modules\OpenStreetMap;

use WidgetPack\Base\Widget_Pack_Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Widget_Pack_Module_Base {

	public function get_name() {
		return 'open-street-map';
	}

	public function get_widgets() {

		$widgets = [
			'Open_Street_Map'
		];

		return $widgets;
	}
}
