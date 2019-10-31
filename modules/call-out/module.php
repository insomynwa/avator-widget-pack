<?php
namespace WidgetPack\Modules\CallOut;

use WidgetPack\Base\Widget_Pack_Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Widget_Pack_Module_Base {

	public function get_name() {
		return 'call-out';
	}

	public function get_widgets() {

		$widgets = [
			'Call_Out',
		];

		return $widgets;
	}
}
