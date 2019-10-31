<?php
namespace WidgetPack\Modules\ScrollImage;

use WidgetPack\Base\Widget_Pack_Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Widget_Pack_Module_Base {

	public function get_name() {
		return 'scroll-image';
	}

	public function get_widgets() {

		$widgets = [
			'Scroll_Image',
		];

		return $widgets;
	}
}
