<?php
namespace WidgetPack\Modules\Qrcode;

use WidgetPack\Base\Widget_Pack_Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Widget_Pack_Module_Base {

	public function get_name() {
		return 'qrcode';
	}

	public function get_widgets() {

		$widgets = [
			'Qrcode',
		];

		return $widgets;
	}
}
